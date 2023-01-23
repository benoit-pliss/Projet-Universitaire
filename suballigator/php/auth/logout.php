<?php
session_start();
unset($_SESSION);
session_destroy();
include_once('../util/notifs.php');
addNotif("success", "Déconnexion", "Vous avez été déconnecté avec succès.");
?>

<script>
    setTimeout(function() {
        window.location.href = '../../html/login.phtml'
    }, 500);
</script>