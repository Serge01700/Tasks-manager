<?php
session_start();

if (isset($_SESSION['id_user'])) {
    session_unset();
    session_destroy();
}

header("Location: login.php"); // Redirigez vers la page de connexion
exit();
?>