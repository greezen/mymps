<?php

class Sms
{
    public static function send($phone, $content)
    {
        $url = 'http://106.ihuyi.com/webservice/sms.php?method=Submit';
        $data = array(
            'account' => 'cf_kempin',
            'password' => '9ad5b9ec833613b52138502815c6b879',
            'mobile' => $phone,
            'content' => $content,
            'time' => time(),
            'format' => 'json',
        );
        $res = self::post($url, $data);
        if (empty($res) || $res->code != 2) {
            return false;
        }
        return true;
    }

    public static function post($url, $data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return json_decode($return_str);
    }
}