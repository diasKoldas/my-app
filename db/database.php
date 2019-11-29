<?php

namespace DB;

use PDO;

class DataBase
{
    public static function getPDO()
    {
        return new PDO('mysql:host=localhost;dbname=app2;charset=utf8;','root','');
    }
}
