<?php

if ( !function_exists('validate_domain') )
{
    function validate_domain($domain) {
        if(!preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $domain)) {
            return false;
        }
        return true;
    }
}