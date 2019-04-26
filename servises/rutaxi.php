<?php


class Rutaxi
{
    function getStreet($name) {
        $name = urlencode($name);
        $info = file_get_contents('http://www.sterl.rutaxi.ru/ajax_street.html?lang=ru&type=1&term='.$name);
        $info = json_decode($info, true);
        return $info;
    }

    function getUrlArray($arr) {
        $url = '';
        foreach ($arr as $key => $value) {
            if($url != '') {
                $url .= '&';
            }
            if (strstr($key, 'p[]')) {
                $key = 'p[]';
            }
            $url .= urlencode($key).'='.urlencode($value);
        }
        return $url;
    }

    function getCost($street1='', $home1='', $entrance1='', $street2='', $home2='', $entrance2='') {
        try {
            $street1 = $this->getStreet($street1);
            $street2 = $this->getStreet($street2);
            if(count($street1) == 0 or count($street2) == 0) {
                return;
            }
            $street1 = str_replace('|', '-', $street1[0]['id']);
            $street2 = str_replace('|', '-', $street2[0]['id']);
            $arr = array(
                'p[]0' => '1',
                'p[]1' => '0',
                'p[]2' => '',
                'p[]3' => '',
                'p[]4' => '0',
                'p[]5' => '1',
                'p[]6' => '',
                'p[]7' => '',
                'p[]8' => '',
                'p[]9' => '',
                'p[]10' => $street1,
                'p[]11' => $home1,
                'p[]12' => '20',
                'p[]13' => '',
                'p[]14' => $street2.'#$'.$home2.'#$40',
                'p[]15' => '',
                'p[]16' => '',
                'p[]17' => '',
                'p[]18' => '',
                'p[]19' => '',
                'p[]20' => '',
                'p[]21' => '',
                'p[]22' => '',
                'p[]23' => '',
                'p[]24' => '0',
                'p[]25' => '0',
                'p[]26' => '0',
                'p[]27' => '0',
                'p[]28' => '0',
                'p[]29' => '0',
                'p[]30' => '0',
                'p[]31' => '0',
                'p[]32' => '',
                'p[]33' => '0',
                'p[]34' => '0',
                'use_payment_card' => '0',
                'sms' => '0',
                'iphone' => '',
                'predvtsms' => '',
                'java' => '0'
            );
            $url_arr = $this->getUrlArray($arr);
            $options = array(
                'http' => array(
                    'method'  => 'POST',  // метод передачи данных
                    'header'  => 'Accept: application/json, text/javascript, */*; q=0.01
Accept-Encoding: gzip, deflate
Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7
Cache-Control: no-cache
Connection: keep-alive
Content-Length: 408
Content-Type: application/x-www-form-urlencoded; charset=UTF-8
Cookie: PHPSESSID=82508e3086177515f12c39fc52b3b6da; _ym_uid=1556198017231989389; _ym_d=1556198017; _ym_isad=2; _ym_visorc_955468=w
DNT: 1
Host: www.sterl.rutaxi.ru
Origin: http://www.sterl.rutaxi.ru
Pragma: no-cache
Referer: http://www.sterl.rutaxi.ru/index.html?router[0][obj]=295|3&router[0][h]=10&router[0][e]=20&router[1][obj]=93|3&router[1][h]=30&router[1][e]=40
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36 OPR/58.0.3135.132
X-Requested-With: XMLHttpRequest',  // заголовок
                    'content' => $url_arr,  // переменные
                )
            );
            $context  = stream_context_create($options);  // создаём контекст потока
            $result = file_get_contents('http://www.sterl.rutaxi.ru/ajax_order.html?qip=335938469619991000&lang=ru&source=0', false, $context);
            $result = json_decode($result, true);
            return (float)$result['cost'];
        }catch (Exception $error) {
            return 0;
        }
    }
}
