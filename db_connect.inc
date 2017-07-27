<?php
/**
 * Created by PhpStorm.
 * User: Ken
 * Date: 6/05/2017
 * Time: 6:18 PM
 */

    // php file
    /* $db_name = "mysql:host=fastapps04.qut.edu.au"*/

    // Fastapps database connection

    $db_name  = "mysql:host=fastapps04.qut.edu.au;dbname=n9532897";
    $db_user = 'n9532897';
    $db_pwd = 'Noob950314075937@@';

    // Localhost database connection
    /*
    * $db_name = "mysql:host=localhost;dbname=parks";
    * $db_user = 'root123';
    * $db_pwd = '123456';
    */
    try{
        $db = new PDO($db_name,$db_user,$db_pwd);
    } catch (PDOException $e) {
        die('connection fails.' . $e -> getMessage());
    }
?>