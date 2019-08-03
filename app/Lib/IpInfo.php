<?php

namespace App\Lib;

class IpInfo 
{

    private $ip_address;
    private $response;


    private function __construct()
    {
    }


    public static function make()
    {
        $ip_info = new IpInfo();
        return $ip_info;
    }

    //@todo use guzzle/http for http requests
    private function process()
    {
        $response = file_get_contents("http://ipinfo.io/$this->ip_address/?token=" .env('IPINFO_TOKEN'));
        $this->response = json_decode($response, true);
    }


    public function ip_address($ip_address)
    {
        $this->ip_address = $ip_address;
        $this->process();
        return $this;
    }


    public function get($key)
    {
        if ( array_key_exists($key, $this->response) )
        {
            return $this->response[$key];
        }
    }
}