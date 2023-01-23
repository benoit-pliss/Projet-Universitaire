<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET["themeSet"])){
    if (!isset($_SESSION)) {
        session_start();
        $_SESSION["themeSet"] = $_GET["themeSet"];
    }else{
        
        $_SESSION["themeSet"] = $_GET["themeSet"];
    }
}


?>