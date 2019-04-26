<?php


class TaxiMaxim
{
    function getStreet($name) {
        $name = urlencode($name);
        $options = array(
            'http' => array(
                'method'  => 'GET',  // метод передачи данных
                'header'  => 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8
Accept-Encoding: gzip, deflate, br
Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7
Cache-Control: no-cache
Connection: keep-alive
Cookie: TAXSEE_V2MAXIM=riae29qu7k6apirmmq8hrv1ft7; _ym_uid=1556260078801569128; _ym_d=1556260078; _ym_isad=2; _ym_visorc_21363226=w; __taxsee_geo_az=468ce7dcc6630adf598373aa5952db95ecacd30c8f6ab7fda6de94856091cee1a%3A2%3A%7Bi%3A0%3Bs%3A15%3A%22__taxsee_geo_az%22%3Bi%3A1%3Ba%3A4%3A%7Bs%3A6%3A%22BaseId%22%3BN%3Bs%3A4%3A%22City%22%3BN%3Bs%3A7%3A%22PlaceId%22%3Bi%3A0%3Bs%3A6%3A%22Region%22%3BN%3B%7D%7D; __taxsee__cc_analitics_maxim=41dfeb4e239d0fe460338e571c2dc7e54264e75be60c0347a19f46ab3dd64176a%3A2%3A%7Bi%3A0%3Bs%3A28%3A%22__taxsee__cc_analitics_maxim%22%3Bi%3A1%3Bs%3A36%3A%22E5DD2E18-8BB3-4F31-A636-90C5F5CF4404%22%3B%7D; TAXSEE_V2ALL=rqmmc5qelbfp97jbm72fq4hsmb; __identity_v2_all=01252caabd487c6fe050b9cab6e6cf28f8e0ab6a3f8f330bfd0af34153cc3c69a%3A2%3A%7Bi%3A0%3Bs%3A17%3A%22__identity_v2_all%22%3Bi%3A1%3Bs%3A63%3A%22%5B%2279174794425%22%2C%22E5DD2E18-8BB3-4F31-A636-90C5F5CF4404%22%2C31536000%5D%22%3B%7D; _csrf=29fc46a55d21faa958411faf0aa9fbc5d3a20d6d8f32db4d9fc7283124bcb2a4a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22da9ffgJuFLjOggYssCJZxyPDT_qvzb16%22%3B%7D; __taxsee_org=3001944c15e03a734bd4297eb04b96309245bf346dceeed2303ca47ec20c779ea%3A2%3A%7Bi%3A0%3Bs%3A12%3A%22__taxsee_org%22%3Bi%3A1%3Bs%3A5%3A%22maxim%22%3B%7D; __taxsee_country=cba0a9b0f4661ec015d33701e42304eee8213c5bc594156d01b6a19e3de5da2ea%3A2%3A%7Bi%3A0%3Bs%3A16%3A%22__taxsee_country%22%3Bi%3A1%3Bs%3A2%3A%22ru%22%3B%7D; __taxsee_base=69d4cbb40ca14972035e1ffe478ef70bd103c88ec2de0b8cfdcab1b563193a89a%3A2%3A%7Bi%3A0%3Bs%3A13%3A%22__taxsee_base%22%3Bi%3A1%3Bs%3A4%3A%221068%22%3B%7D; cookie-policy=1; _ym_visorc_40968014=w; _ym_visorc_40823389=w; __taxsee_geo_ru=6c0d24e5c05b4ab76f5077b05b31a1e5bf4a8f79eb5ae4cc8b7e39fb1efe07f3a%3A2%3A%7Bi%3A0%3Bs%3A15%3A%22__taxsee_geo_ru%22%3Bi%3A1%3Ba%3A4%3A%7Bs%3A6%3A%22BaseId%22%3BN%3Bs%3A4%3A%22City%22%3BN%3Bs%3A7%3A%22PlaceId%22%3Bi%3A0%3Bs%3A6%3A%22Region%22%3BN%3B%7D%7D
DNT: 1
Host: client.taxsee.com
Pragma: no-cache
Upgrade-Insecure-Requests: 1
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36 OPR/58.0.3135.132',  // заголовок
            )
        );
        $context  = stream_context_create($options);  // создаём контекст потока
        $info = file_get_contents("https://client.taxsee.com/service/search-address/?q=$name&placeId=&org=maxim&baseId=1068&tax-id=SrvMpYHWr%2FWymRmBUdoa6isCaQcmnFtb0xmL4kP74iIgk8vmpGZoL%2BOsQU0m3lMOMwpCkSyA%2FU4qVJmAQaXbTw%3D%3D", false, $context);
        $info = json_decode($info, true);
        return $info;
    }

    function getUrlArray($arr) {
        $url = '';
        foreach ($arr as $key => $value) {
            if($url != '') {
                $url .= '&';
            }
            if (strstr($key, 'OrderForm[preOrder]')) {
                $key = 'OrderForm[preOrder]';
            }
            $url .= urlencode($key).'='.urlencode($value);
        }
        return $url;
    }

    function getCost($street1, $home1, $entrance1, $street2, $home2, $entrance2) {
        $streetid1 = $this->getStreet($street1);
        $streetid2 = $this->getStreet($street2);
        if(count($streetid1) == 0 or count($streetid2) == 0) {
            return;
        }
        $streetid1 = $streetid1[0]['id'];
        $streetid2 = $streetid2[0]['id'];
        $arr = array(
            '_csrf' => 'IgEhxUiZG-7uDAskIerKaGMuX2tga9C19DkviTXXn4FGYBijLv5Rm6hAYWtGjZMbEG0VMRgSgPGgZl7_T7Wutw==',
            'OrderForm[baseId]' => '1068',
            'AddressForm[0][point]' => $streetid1,
            'AddressForm[0][placeName]' => 'Стерлитамак',
            'AddressForm[0][pointField]' => $street1,
            'AddressForm[0][house]' => $home1,
            'AddressForm[0][rem]' => $entrance1,
            'AddressForm[0][latitude]' => '',
            'AddressForm[0][longitude]' => '',
            'AddressForm[0][addressName]' => '',
            'AddressForm[1][point]' => $streetid2,
            'AddressForm[1][placeName]' => 'Стерлитамак',
            'AddressForm[1][pointField]' => $street2,
            'AddressForm[1][house]' => $home2,
            'AddressForm[1][rem]' => $entrance2,
            'AddressForm[1][latitude]' => '',
            'AddressForm[1][longitude]' => '',
            'AddressForm[1][addressName]' => '',
            'OrderForm[preOrder]0' => '',
            'OrderForm[preOrder]1' => '0',
            'OrderForm[dateField]' => '26.04.2019',
            'OrderForm[hourField]' => '00',
            'OrderForm[minuteField]' => '00',
            'OrderForm[tariffId]' => '1',
            'OrderForm[account]' => '0',
            'ServiceForm[0][id]' => '322',
            'ServiceForm[0][param]' => '',
            'ServiceForm[1][id]' => '274',
            'ServiceForm[1][param]' => '',
            'ServiceForm[2][id]' => '448',
            'ServiceForm[2][param]' => '',
            'ServiceForm[3][id]' => '394',
            'ServiceForm[3][param]' => '',
            'ServiceForm[4][id]' => '196',
            'ServiceForm[5][id]' => '223',
            'ServiceForm[6][id]' => '288',
            'ServiceForm[7][id]' => '228',
            'OrderForm[phone2]' => '+7(___)___-__-__',
            'OrderForm[comment]' => '',
            'OrderForm[socialNetwork]' => '0'
        );

        $url_arr = $this->getUrlArray($arr);
        $options = array(
            'http' => array(
                'method'  => 'POST',  // метод передачи данных
                'header'  => 'Accept: application/json, text/javascript, */*; q=0.01
Accept-Encoding: gzip, deflate, br
Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7
Cache-Control: no-cache
Connection: keep-alive
Content-Length: 1616
Content-Type: application/x-www-form-urlencoded; charset=UTF-8
Cookie: TAXSEE_V2MAXIM=riae29qu7k6apirmmq8hrv1ft7; _ym_uid=1556260078801569128; _ym_d=1556260078; _ym_isad=2; _ym_visorc_21363226=w; __taxsee_geo_az=468ce7dcc6630adf598373aa5952db95ecacd30c8f6ab7fda6de94856091cee1a%3A2%3A%7Bi%3A0%3Bs%3A15%3A%22__taxsee_geo_az%22%3Bi%3A1%3Ba%3A4%3A%7Bs%3A6%3A%22BaseId%22%3BN%3Bs%3A4%3A%22City%22%3BN%3Bs%3A7%3A%22PlaceId%22%3Bi%3A0%3Bs%3A6%3A%22Region%22%3BN%3B%7D%7D; __taxsee__cc_analitics_maxim=41dfeb4e239d0fe460338e571c2dc7e54264e75be60c0347a19f46ab3dd64176a%3A2%3A%7Bi%3A0%3Bs%3A28%3A%22__taxsee__cc_analitics_maxim%22%3Bi%3A1%3Bs%3A36%3A%22E5DD2E18-8BB3-4F31-A636-90C5F5CF4404%22%3B%7D; TAXSEE_V2ALL=rqmmc5qelbfp97jbm72fq4hsmb; __identity_v2_all=01252caabd487c6fe050b9cab6e6cf28f8e0ab6a3f8f330bfd0af34153cc3c69a%3A2%3A%7Bi%3A0%3Bs%3A17%3A%22__identity_v2_all%22%3Bi%3A1%3Bs%3A63%3A%22%5B%2279174794425%22%2C%22E5DD2E18-8BB3-4F31-A636-90C5F5CF4404%22%2C31536000%5D%22%3B%7D; _csrf=29fc46a55d21faa958411faf0aa9fbc5d3a20d6d8f32db4d9fc7283124bcb2a4a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22da9ffgJuFLjOggYssCJZxyPDT_qvzb16%22%3B%7D; __taxsee_org=3001944c15e03a734bd4297eb04b96309245bf346dceeed2303ca47ec20c779ea%3A2%3A%7Bi%3A0%3Bs%3A12%3A%22__taxsee_org%22%3Bi%3A1%3Bs%3A5%3A%22maxim%22%3B%7D; __taxsee_country=cba0a9b0f4661ec015d33701e42304eee8213c5bc594156d01b6a19e3de5da2ea%3A2%3A%7Bi%3A0%3Bs%3A16%3A%22__taxsee_country%22%3Bi%3A1%3Bs%3A2%3A%22ru%22%3B%7D; __taxsee_base=69d4cbb40ca14972035e1ffe478ef70bd103c88ec2de0b8cfdcab1b563193a89a%3A2%3A%7Bi%3A0%3Bs%3A13%3A%22__taxsee_base%22%3Bi%3A1%3Bs%3A4%3A%221068%22%3B%7D; cookie-policy=1; _ym_visorc_40968014=w; _ym_visorc_40823389=w; __taxsee_geo_ru=6c0d24e5c05b4ab76f5077b05b31a1e5bf4a8f79eb5ae4cc8b7e39fb1efe07f3a%3A2%3A%7Bi%3A0%3Bs%3A15%3A%22__taxsee_geo_ru%22%3Bi%3A1%3Ba%3A4%3A%7Bs%3A6%3A%22BaseId%22%3BN%3Bs%3A4%3A%22City%22%3BN%3Bs%3A7%3A%22PlaceId%22%3Bi%3A0%3Bs%3A6%3A%22Region%22%3BN%3B%7D%7D
DNT: 1
Host: client.taxsee.com
Origin: https://client.taxsee.com
Pragma: no-cache
Referer: https://client.taxsee.com/frame/?tax-id=SrvMpYHWr%2FWymRmBUdoa6isCaQcmnFtb0xmL4kP74iIgk8vmpGZoL%2BOsQU0m3lMOMwpCkSyA%2FU4qVJmAQaXbTw%3D%3D&fp=10c3ad45c7e347d89996886bafeac3c1&c=ru&l=ru&b=1068&p=1&theme=maximV2
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36 OPR/58.0.3135.132
X-CSRF-Token: IgEhxUiZG-7uDAskIerKaGMuX2tga9C19DkviTXXn4FGYBijLv5Rm6hAYWtGjZMbEG0VMRgSgPGgZl7_T7Wutw==
X-Requested-With: XMLHttpRequest',  // заголовок
                'content' => $url_arr,  // переменные
            )
        );
        $context  = stream_context_create($options);  // создаём контекст потока
        $result = file_get_contents('https://client.taxsee.com/service/calculate/?org=maxim&baseId=1068&tax-id=SrvMpYHWr%2FWymRmBUdoa6isCaQcmnFtb0xmL4kP74iIgk8vmpGZoL%2BOsQU0m3lMOMwpCkSyA%2FU4qVJmAQaXbTw%3D%3D', false, $context);
        $result = json_decode($result, true);
        return (float)$result['price'];
    }
}