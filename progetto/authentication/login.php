<?php
    require 'config/functions.php';

    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    
    if(USERNAME == $username && PASSWORD == $password){
        // attivazione cookie
        setcookie("logged", "true", time() + 60*30, "/");
        // da loggato, vai alla pagina
        header('Location: index.php?scelta=home');
    }
    else{
        // altrimenti rifai login
        header('Location: index.php');
    }
?>