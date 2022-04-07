<?php
    // logout, disattiva la variabile logged in session e riprota al login
    setcookie("logged", "false", time() + 60*30, "/");

    header('Location: ../index.php');
?>