<?php 

if ( ! function_exists('castToArray') )
{
    function castToArray($parameter) 
    {
        return is_object($parameter) ? array($parameter) : $parameter;
    }
}

if ( ! function_exists('tp_random_string') )
{
    function tp_random_string($length = 4) 
    {
        $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($x, ceil($length / strlen($x)) )), 1, $length);
    }
}
