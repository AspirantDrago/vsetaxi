<?php


class YandexTaxi
{
    function getStreet($name) {
        $name = urlencode($name);
        $options = array(
            'http' => array(
                'method'  => 'GET',  // метод передачи данных
                'header'  => 'Accept: */*
Accept-Encoding: gzip, deflate, br
Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7
Cache-Control: no-cache
Connection: keep-alive
Cookie: _ym_uid=1554294811772335404; mda=0; my=YwA=; yandexuid=563683461552280906; fuid01=5cae2d6e0e645fdf.DXsk86DlpWCsnhMTpL5JArWeaDks8HDmFKeYcF69xaJTQ6rEhA-Rh2wUnZpQoRdJfDdEhFPkFA6g7VuIwdruHE8-zFQftikn3kl1j3tt-hPP0CYiBICJfg4Z1sf8VwwA; zm=m-white_bender.webp.css-https%3Awww_KErVjVYrie5ZE9onA_-9_aOgzPU%3Al; yandex_gid=172; yc=1556476516.zen.cach%3A1556220913; _ym_d=1556219040; cycada=dyaqfU4hS0gXlAPnw5Uh9a1JkJ3xRqHNOdG7M31BJZA=; _ym_isad=2; Session_id=3:1556253555.5.0.1554294815676:oVNpXw:1c.1|1130000028304687.0.2|163250462.1922497.2.2:1922497|198312.992364.0LmKkvMJxtqhOAES57mmW27P6Q4; sessionid2=3:1556253555.5.0.1554294815676:oVNpXw:1c.1|1130000028304687.0.2|163250462.-1.0|198312.813200.6kd5oQzqs3BW_Nb0_Qmtn9_d2E0; L=WixRVGRHfH8AfmVcCnZSV1xvd3kAYk9QBRJQBwEmdSEUBQgPSQYjDxw6PFk0Qg==.1556253555.13847.381375.4545703a9c8a23e401d85f1eea84de8e; yandex_login=ivanov@yandexlyceum.ru; i=cemq+dJAStDSZSQgPHelE+vq1cyu9Cvp3N8jPIKq31obwRxvMSpdb43mD2XgyngpPZ+8uv9jEgKwfFyiDd6KBGsRSPM=; yabs-frequency=/4/0G0500tzmLnyUi5S/trMmS2Wr8Hg-FMqWDMVnJR1mA3L0mTBYRYWrO0PKi70eDI3eLR1mA3KWx5MmS2WrGBHKi70fDI02VLEmS2WrG000/; yp=1558897450.csc.1#1586242438.p_sw.1554706437#1558858635.shlos.1#1571706862.szm.1_25%3A1536x864%3A1496x723#1871613555.udn.cDrQkNC70LXQutGB0LDQvdC00YAg0JjQstCw0L3QvtCy#1587744601.ygu.1#1869654136.yrts.1554294136#1870065857.yrtsi.1554705857#1870438575.sad.1555078575%3A1555078575%3A1#1556776263.zmblt.1210#1556776263.zmbbr.opera%3A58_0_3135_132#1587717279.stltp.serp_bk-map_1_1556181279#1871577312.multib.1#1556478223.clh.9403; ys=udn.cDrQkNC70LXQutGB0LDQvdC00YAg0JjQstCw0L3QvtCy#wprid.1556266633798047-1703263290186771417300035-man1-3576#c_chck.739706678
DNT: 1
Host: suggest-maps.yandex.ru
Pragma: no-cache
Referer: https://taxi.yandex.ru/
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36 OPR/58.0.3135.132',  // заголовок
            )
        );
        $context  = stream_context_create($options);  // создаём контекст потока
        $info = file_get_contents("https://suggest-maps.yandex.ru/suggest-geo?part=$name&ll=55.947336%2C53.621923&lang=ru_RU&v=9&search_type=taxi&highlight=0&spn=0.1%2C0.1&local_only=1&filter_uri=1&add_coords=1", false, $context);
        $info = str_replace('suggest.apply(', '', $info);
        $info = substr($info,0,-1);
        $info = json_decode($info, true);
        return $info['results'];
    }

    function getUrlArray($arr) {
        return "{\"id\":\"a9457d9517978ed7e60322bf676680a0\",\"zone_name\":\"sterlitamak\",\"supports_forced_surge\":true,\"parks\":[],\"requirements\":{},\"route\":[${arr['addr1']},${arr['addr2']}],\"skip_estimated_waiting\":true}";
    }

    function getCost($street1, $home1, $entrance1, $street2, $home2, $entrance2)
    {
        $addr1 = "$street1 $home1";
        if ($entrance1) {
            $addr1 .= "подъезд $entrance1";
        }
        $addr2 = "$street2 $home2";
        if ($entrance2) {
            $addr1 .= "подъезд $entrance2";
        }
        $streetid1 = $this->getStreet($addr1);
        $streetid2 = $this->getStreet($addr2);
        if (count($streetid1) == 0 or count($streetid2) == 0) {
            return;
        }
        $streetid1 = $streetid1[0]['pos'];
        $streetid1 = str_replace(',', ', ', $streetid1);
        $streetid1 = '['.$streetid1.']';
        $streetid2 = $streetid2[0]['pos'];
        $streetid2 = str_replace(',', ', ', $streetid2);
        $streetid2 = '['.$streetid2.']';
        $arr = array('addr1' => $streetid1, 'addr2' => $streetid2);

        $url_arr = $this->getUrlArray($arr);
        print_r($url_arr);
        $options = array(
            'http' => array(
                'method'  => 'POST',  // метод передачи данных
                'header'  => ':authority: taxi.yandex.ru
:method: POST
:path: /3.0/routestats/
:scheme: https
accept: application/json, text/javascript, */*; q=0.01
accept-encoding: gzip, deflate, br
accept-language: ru_RU
cache-control: no-cache
content-length: 209
content-type: application/json
cookie: _ym_uid=1554294811772335404; mda=0; my=YwA=; yandexuid=563683461552280906; fuid01=5cae2d6e0e645fdf.DXsk86DlpWCsnhMTpL5JArWeaDks8HDmFKeYcF69xaJTQ6rEhA-Rh2wUnZpQoRdJfDdEhFPkFA6g7VuIwdruHE8-zFQftikn3kl1j3tt-hPP0CYiBICJfg4Z1sf8VwwA; _id=a9457d9517978ed7e60322bf676680a0; zm=m-white_bender.webp.css-https%3Awww_KErVjVYrie5ZE9onA_-9_aOgzPU%3Al; yandex_gid=172; yc=1556476516.zen.cach%3A1556220913; _ym_d=1556219040; cycada=dyaqfU4hS0gXlAPnw5Uh9a1JkJ3xRqHNOdG7M31BJZA=; _ym_isad=2; Session_id=3:1556253555.5.0.1554294815676:oVNpXw:1c.1|1130000028304687.0.2|163250462.1922497.2.2:1922497|198312.992364.0LmKkvMJxtqhOAES57mmW27P6Q4; sessionid2=3:1556253555.5.0.1554294815676:oVNpXw:1c.1|1130000028304687.0.2|163250462.-1.0|198312.813200.6kd5oQzqs3BW_Nb0_Qmtn9_d2E0; L=WixRVGRHfH8AfmVcCnZSV1xvd3kAYk9QBRJQBwEmdSEUBQgPSQYjDxw6PFk0Qg==.1556253555.13847.381375.4545703a9c8a23e401d85f1eea84de8e; yandex_login=ivanov@yandexlyceum.ru; i=cemq+dJAStDSZSQgPHelE+vq1cyu9Cvp3N8jPIKq31obwRxvMSpdb43mD2XgyngpPZ+8uv9jEgKwfFyiDd6KBGsRSPM=; yabs-frequency=/4/0G0500tzmLnyUi5S/trMmS2Wr8Hg-FMqWDMVnJR1mA3L0mTBYRYWrO0PKi70eDI3eLR1mA3KWx5MmS2WrGBHKi70fDI02VLEmS2WrG000/; yp=1558897450.csc.1#1586242438.p_sw.1554706437#1558858635.shlos.1#1571706862.szm.1_25%3A1536x864%3A1496x723#1871613555.udn.cDrQkNC70LXQutGB0LDQvdC00YAg0JjQstCw0L3QvtCy#1587744601.ygu.1#1869654136.yrts.1554294136#1870065857.yrtsi.1554705857#1870438575.sad.1555078575%3A1555078575%3A1#1556776263.zmblt.1210#1556776263.zmbbr.opera%3A58_0_3135_132#1587717279.stltp.serp_bk-map_1_1556181279#1871577312.multib.1#1556478223.clh.9403; ys=udn.cDrQkNC70LXQutGB0LDQvdC00YAg0JjQstCw0L3QvtCy#wprid.1556266633798047-1703263290186771417300035-man1-3576#c_chck.739706678
dnt: 1
origin: https://taxi.yandex.ru
pragma: no-cache
referer: https://taxi.yandex.ru/
user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36 OPR/58.0.3135.132
x-requested-uri: https://taxi.yandex.ru/
x-requested-with: XMLHttpRequest',  // заголовок
                'content' => $url_arr,  // переменные
            )
        );
        $context  = stream_context_create($options);  // создаём контекст потока
        $result = file_get_contents('https://taxi.yandex.ru/3.0/routestats/', false, $context);
        $result = json_decode($result, true);
        return $result;
    }
}