<?php

/**
 * Created by PhpStorm.
 * User: Timothy Vanderaerden
 * Date: 7/10/16
 * Time: 15:52
 */
class Database
{
    private static $dbName = '3habits';
    private static $dbHost = '149.210.145.131';
    private static $dbUsername = 'pxlstudent';
    private static $dbUserPassword = 'd92VLSdByYerXRsq';

    private static $connection = null;

    public function __construct()
    {
        exit('Init function is not allowed');
    }

    public static function connect()
    {
        if (null == self::$connection) {
            try {
                self::$connection = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$connection;
    }

    public static function disconnect()
    {
        self::$connection = null;
    }
}