<?php

class jwt_helper extends CI_Controller
{
    const CONSUMER_KEY = 'huiduoduokey2019'; // please replace YOUR_XX
    const CONSUMER_SECRET = 'huiduoduosecret2019'; // please replace YOUR_XX
    const CONSUMER_TTL = 432000; // second | 5 day

    // create token
    public static function create($userid)
    {
        $CI =& get_instance();
        $CI->load->library('JWT');
        $token = $CI->jwt->encode(array(
            'consumerKey' => self::CONSUMER_KEY,
            'userId' => $userid,
            'issuedAt' => date(DATE_ISO8601, strtotime("now")),
            'ttl' => self::CONSUMER_TTL
        ), self::CONSUMER_SECRET);
        return $token;
    }

    // validate token
    public static function validate($token)
    {
        $CI =& get_instance();
        $CI->load->library('JWT');
        try {
            $decodeToken = $CI->jwt->decode($token, self::CONSUMER_SECRET);
            // validate token is not expired
            $ttl_time = strtotime($decodeToken->issuedAt);
            $now_time = strtotime(date(DATE_ISO8601, strtotime("now")));
            if(($now_time - $ttl_time) > $decodeToken->ttl) {
                throw new Exception('Expired');
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }

    }

    // decode token
    public static function decode($token)
    {
        $CI =& get_instance();
        $CI->load->library('JWT');
        try {
            $decodeToken = $CI->jwt->decode($token, self::CONSUMER_SECRET);
            return $decodeToken;
        } catch (Exception $e) {
            return false;
        }
    }
}
