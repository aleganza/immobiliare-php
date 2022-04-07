<?php
    require 'config/functions.php';
    if(!isset($_COOKIE['logged']) || $_COOKIE['logged'] == "false"){
        http_response_code(401);
        header('Location: index.php');
        exit;
    }
?>