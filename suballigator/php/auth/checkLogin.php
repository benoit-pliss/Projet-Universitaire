<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if(!isset($_SESSION['initiatorId'])){
    echo '<script>window.location.href ="security/login.php";</script>';
    exit();
}
?>