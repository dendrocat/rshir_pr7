<?php

class DatabaseSQL {
    public static function getConnection() {
        $mysql = new mysqli(Consts::sql_host, 
                            Consts::sql_user, 
                            Consts::sql_pass, 
                            Consts::sql_db_name);
        return $mysql;
    }

    public static function query($q) {
        $mysql = self::getConnection();
        if (!$mysql) {
            echo "Connection failed";
            return "";
        }

        $res = $mysql->query($q);
        $mysql->close();
        return $res;
    }
}

?>