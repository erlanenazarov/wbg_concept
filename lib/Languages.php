<?php

/**
 * Created by PhpStorm.
 * User: Эрлан
 * Date: 20.04.2017
 * Time: 20:27
 */
class Languages {
    /**
     * Set language for us
     * @param $lg - ru/en
     * @param $time - day expire
     * @return bool
     */

    function setLanguage($lg, $time) {
        //$_COOKIE['language'] = $lg;
        setcookie("language", $lg, time()+$time);
        return true;
    }

    function getLanguage() {
        return isset($_COOKIE['language']) ? $_COOKIE['language'] : 'en';
    }
}