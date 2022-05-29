<?php
class Controller {
    protected static $controllers = ['bills', 'consumers', 'groups', 'group_user', 'roles', 'role_user', 'tokens', 'auth'];
    public static $id = null;
    public static $queryStr = null;

    public static function getControllersList(){
        return self::$controllers;
    }
}