<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // Start session if not already started
if (!isset($_SESSION['initiatorId'])) {
    echo '<script>window.location.href ="html/login.phtml";</script>';
    exit();
} // Redirect to login page if user is not logged in
else {
    echo '<script>window.location.href ="html/accueil.phtml";</script>';
    exit();
} // Redirect to index page if user is logged in

?>
