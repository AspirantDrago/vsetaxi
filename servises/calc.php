<?php
include 'rutaxi.php';
include 'TaxiMaxim.php';;

$street1 = $_SESSION['street1'];
$home1 = $_SESSION['home1'];
$entrance1 = $_SESSION['entrance1'];
$street2 = $_SESSION['street2'];
$home2 = $_SESSION['home2'];
$entrance2 = $_SESSION['entrance2'];
$comment = '';

function getCosts($street1, $home1, $entrance1, $street2, $home2, $entrance2) {
    $dict = array();
    $rutaxi = new Rutaxi;
    $taximaxim = new TaxiMaxim;
    try {
        $rutaxi_street1 = $rutaxi->getStreet($street1);
        $rutaxi_street2 = $rutaxi->getStreet($street2);
    }catch (Exception $error) {
        $rutaxi_street1 = array();
        $rutaxi_street2 = array();
    }
    $rutaxi_cost = 0;
    $taximaxim_cost = 0;
    $yandextaxi_cost = 999;
    if(count($rutaxi_street1) and count($rutaxi_street2)) {
        try {
            $rutaxi_street1 = $rutaxi_street1[0];
            $rutaxi_street2 = $rutaxi_street2[0];
            $rutaxi_cost = $rutaxi->getCost($street1, $home1, $entrance1, $street2, $home2, $entrance2);
            $street1 = $rutaxi_street1['label'];
            $street2 = $rutaxi_street2['label'];
        }catch (Exception $error) {
            $rutaxi_cost = 0;
        }finally {
            if($rutaxi_cost) {
                $dict[] = array('name' => 'Такси Лидер',
                    'image' => 'img/leader.png',
                    'link' => '#',
                    'cost' => $rutaxi_cost);
            }
        }

        try {
            $taximaxim_cost = $taximaxim->getCost($street1, $home1, $entrance1, $street2, $home2, $entrance2);
        }catch (Exception $error) {
            $taximaxim_cost = 0;
        }finally {
            if($taximaxim_cost) {
                $dict[] = array('name' => 'Такси Максим',
                    'image' => 'img/maxim.png',
                    'link' => '#',
                    'cost' => $taximaxim_cost);
            }
        }

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
