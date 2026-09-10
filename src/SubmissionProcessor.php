<?php

require_once __DIR__ . '/validate.php';
require_once __DIR__ . '/calc.php';
require_once __DIR__ . '/storage.php';

class SubmissionProcessor {


    public $pomylky = array();


    public $rezultat_rozrahunku = null;


    public $zamovnyk;
    public $kilkist;
    public $tip;
    public $data_podiyi;
    public $opys;

    public function obrobyty($post) {

        $this->zamovnyk = isset($post['zamovnyk']) ? trim($post['zamovnyk']) : '';
        $this->kilkist = isset($post['kilkist']) ? $post['kilkist'] : '';
        $this->tip = isset($post['tip']) ? $post['tip'] : '';
        $this->data_podiyi = isset($post['data_podiyi']) ? $post['data_podiyi'] : '';
        $this->opys = isset($post['opys']) ? trim($post['opys']) : '';

        // перевіряємо кожне поле по черзі
        $pomylka1 = perevirka_zamovnyka($this->zamovnyk);
        if ($pomylka1 != '') {
            $this->pomylky[] = $pomylka1;
        }

        $pomylka2 = perevirka_kilkist($this->kilkist);
        if ($pomylka2 != '') {
            $this->pomylky[] = $pomylka2;
        }

        $pomylka3 = perevirka_typu($this->tip);
        if ($pomylka3 != '') {
            $this->pomylky[] = $pomylka3;
        }

        $pomylka4 = perevirka_daty($this->data_podiyi);
        if ($pomylka4 != '') {
            $this->pomylky[] = $pomylka4;
        }

        $pomylka5 = perevirka_opysu($this->opys);
        if ($pomylka5 != '') {
            $this->pomylky[] = $pomylka5;
        }

        if (count($this->pomylky) == 0) {
            $this->rezultat_rozrahunku = rozrahuvaty_vartist($this->tip, (int)$this->kilkist);

            $zapys = array(
                'zamovnyk' => $this->zamovnyk,
                'kilkist' => (int)$this->kilkist,
                'tip' => $this->tip,
                'data_podiyi' => $this->data_podiyi,
                'opys' => $this->opys,
                'vartist' => $this->rezultat_rozrahunku['razom'],
                'data_stvorennya' => date('Y-m-d H:i:s')
            );

            zberegty_zamovlennya($zapys);

            return true;
        }

        return false;
    }
}
