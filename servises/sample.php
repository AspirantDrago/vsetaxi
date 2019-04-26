<?php
include 'rutaxi.php';
include 'TaxiMaxim.php';
include 'YandexTaxi.php';

$street1 = 'Шафиева';
$home1 = '11';
$entrance1 = '';
$street2 = 'Косяковская';
$home2 = '9';
$entrance2 = '';
$comment = '';

function getCosts($street1, $home1, $entrance1, $street2, $home2, $entrance2) {
    $dict = array();
    $rutaxi = new Rutaxi;
    $taximaxim = new TaxiMaxim;
    $yandextaxi = new YandexTaxi;

    $rutaxi_street1 = $rutaxi->getStreet($street1);
    $rutaxi_street2 = $rutaxi->getStreet($street2);
    $rutaxi_cost = 0;
    $taximaxim_cost = 0;
    $yandextaxi_cost = 999;
    if(count($rutaxi_street1) and count($rutaxi_street2)) {
        $temp = $yandextaxi->getCost($street1, $home1, $entrance1, $street2, $home2, $entrance2);
        print_r($temp);

        if($yandextaxi_cost) {
            $dict[] = array('name' => 'Яндекс.Такси',
                'image' => 'img/yandextaxi.png',
                'link' => '#',
                'cost' => $yandextaxi_cost);
        }
    }
    function taxicmp($a, $b) {
        if ($a['cost'] == $b['cost']) {
            return 0;
        }
        return ($a['cost'] < $b['cost']) ? -1 : 1;
    }
    uasort($dict, 'taxicmp');
    return $dict;
}

$costs = getCosts($street1, $home1, $entrance1, $street2, $home2, $entrance2);
print_r($costs);
