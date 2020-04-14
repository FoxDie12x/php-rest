<?php
/**
 * Author: seef
 * Date: 14-04-20
 * Time: 09:40
 */

$test = new Config();

class Config {
    private const IS_PRODUCTION = false;
    private const DISPLAY_ERRORS = true;

    public function __construct() {
        if (self::DISPLAY_ERRORS) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }
}
