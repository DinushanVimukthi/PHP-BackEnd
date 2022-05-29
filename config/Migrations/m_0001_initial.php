<?php

//namespace app\config\Migrations;

class m_0001_initial
{
    public function up()
    {
        $db=\app\core\Application::$app->db;
        $stm='SHOW TABLES';
        $stmt=$db->prepare($stm);
        $stmt->execute();
        $tables=$stmt->fetchAll(\PDO::FETCH_COLUMN);
        if(!in_array('users',$tables))
        {
        $SQL="CREATE TABLE users (
            id VARCHAR(100) PRIMARY KEY NOT NULL ,
            email VARCHAR(255) NOT NULL,
            modified_at TIMESTAMP NOT NULL,
            authenticated TINYINT(1) NOT NULL,
            password VARCHAR(255) NOT NULL,
            disabled TINYINT(1) NOT NULL DEFAULT 0,
            active TINYINT(1) NOT NULL DEFAULT 0,
            status TINYINT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
        ENGINE=InnoDB";
        $db->pdo->exec($SQL);
        }
    }

    public function down()
    {
        $db=\app\core\Application::$app->db;
        $SQL="DROP TABLE `users`";
        $db->pdo->exec($SQL);

    }
}