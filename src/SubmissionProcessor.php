<?php
class SubmissionProcessor
{
    const RATE_SOUND = 900;
    const RATE_LIGHT = 700;
    const RATE_STAGE = 1500;
    const DISCOUNT_PERCENT = 7;
    const DISCOUNT_FROM = 5;
    const STAGE_ASSEMBLY = 800;
    const MIN_SETS = 1;
    const MAX_SETS = 20;
    const MIN_DESCRIPTION = 10;
    const MAX_DESCRIPTION = 600;
    public $errors = array();
    public $data = array();
    public $result = null;

    public function getRate($type)
    {
        if ($type == 'sound') {
            return self::RATE_SOUND;
        }
        if ($type == 'light') {
            return self::RATE_LIGHT;
        }
        if ($type == 'stage') {
            return self::RATE_STAGE;
        }
        return 0;
    }
    public function calculatePrice($type, $sets)
    {
        $rate = $this->getRate($type);
        $base = $sets * $rate;

        $discountPercent = 0;
        $discountSum = 0;
        if ($sets >= self::DISCOUNT_FROM) {
            $discountPercent = self::DISCOUNT_PERCENT;
            $discountSum = $base * $discountPercent / 100;
        }
        $afterDiscount = $base - $discountSum;
        $assembly = 0;
        if ($type == 'stage') {
            $assembly = self::STAGE_ASSEMBLY;
        }

        $total = $afterDiscount + $assembly;

        return array(
            'rate' => $rate,
            'base' => $base,
            'discountPercent' => $discountPercent,
            'discountSum' => $discountSum,
            'assembly' => $assembly,
            'total' => $total
        );
    }
    public function validate($post)
    {
        $this->errors = array();

        $customer = isset($post['customer']) ? trim($post['customer']) : '';
        $sets = isset($post['sets']) ? trim($post['sets']) : '';
        $type = isset($post['type']) ? trim($post['type']) : '';
        $date = isset($post['date']) ? trim($post['date']) : '';
        $description = isset($post['description']) ? trim($post['description']) : '';

        $this->data = array(
            'customer' => $customer,
            'sets' => $sets,
            'type' => $type,
            'date' => $date,
            'description' => $description
        );


        if ($customer === '') {
            $this->errors['customer'] = 'Вкажіть замовника';
        }

        if ($sets === '') {
            $this->errors['sets'] = 'Вкажіть кількість комплектів';
        } elseif (!ctype_digit($sets)) {
            $this->errors['sets'] = 'Кількість має бути цілим числом';
        } elseif ((int)$sets < self::MIN_SETS || (int)$sets > self::MAX_SETS) {
            $this->errors['sets'] = 'Кількість комплектів має бути від 1 до 20';
        }
        if ($type !== 'sound' && $type !== 'light' && $type !== 'stage') {
            $this->errors['type'] = 'Оберіть тип комплекту';
        }
        if ($date === '') {
            $this->errors['date'] = 'Вкажіть дату події';
        } else {
            $eventDay = strtotime($date);
            $tomorrow = strtotime('+1 day', strtotime(date('Y-m-d')));
            if ($eventDay === false) {
                $this->errors['date'] = 'Невірний формат дати';
            } elseif ($eventDay < $tomorrow) {
                $this->errors['date'] = 'Дата не може бути раніше завтрашнього дня';
            }
        }
        $length = strlen($description);
        if ($description === '') {
            $this->errors['description'] = 'Вкажіть опис події';
        } elseif ($length < self::MIN_DESCRIPTION) {
            $this->errors['description'] = 'Опис закороткий, мінімум 10 байтів';
        } elseif ($length > self::MAX_DESCRIPTION) {
            $this->errors['description'] = 'Опис задовгий, максимум 600 байтів';
        }

        return count($this->errors) == 0;
    }
    public function process($post)
    {
        if (!$this->validate($post)) {
            return false;
        }

        $this->result = $this->calculatePrice($this->data['type'], (int)$this->data['sets']);

        $order = array(
            'customer' => $this->data['customer'],
            'sets' => (int)$this->data['sets'],
            'type' => $this->data['type'],
            'date' => $this->data['date'],
            'description' => $this->data['description'],
            'total' => $this->result['total'],
            'createdAt' => date('Y-m-d H:i:s')
        );

        $this->saveOrder($order);
        return true;
    }
    public function getStorageFile()
    {
        return __DIR__ . '/orders.json';
    }
    public function saveOrder($order)
    {
        $orders = $this->loadOrders();
        $orders[] = $order;
        file_put_contents(
            $this->getStorageFile(),
            json_encode($orders, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }
    public function loadOrders()
    {
        $file = $this->getStorageFile();
        if (!file_exists($file)) {
            return array();
        }
        $text = file_get_contents($file);
        if ($text === false || $text === '') {
            return array();
        }
        $orders = json_decode($text, true);
        if ($orders === null) {
            return array();
        }
        return $orders;
    }
    public function getHistory($filterType = '')
    {
        $orders = $this->loadOrders();
        if ($filterType === '') {
            return $orders;
        }

        $filtered = array();
        foreach ($orders as $order) {
            if ($order['type'] == $filterType) {
                $filtered[] = $order;
            }
        }
        return $filtered;
    }
}
