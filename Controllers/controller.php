<?php
class Controller {
    private static array $controllers = ['auth'];
    public static $id = null;
    public static $queryStr = null;

    public static function getControllersList(){
        return self::$controllers;
    }
}