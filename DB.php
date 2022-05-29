<?php

class DB
{
    private static function connect()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=new_tally_api', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public static function query($query, $params = [])
    {
        $stmt = self::connect()->prepare($query);
        $stmt->execute($params);
        if (strtolower(explode(' ', $query)[0]) == 'select') {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }

    public static function createTables(){
        $stmt = self::connect();
        $stmt->exec("CREATE TABLE users (
        id int(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_name varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
        first_name varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL,
        last_name varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL,
        email varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL,
        mobile varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL,
        password varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
        gender tinyint(2) DEFAULT NULL,
        avatar text CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci DEFAULT NULL,
        auth_mode varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
        deleted_at datetime DEFAULT NULL,
        created_at datetime NOT NULL DEFAULT current_timestamp
        )
        COMMENT = 'Table ''new_tally_api.users'' doesn''t exist in engine';");
    }
}