<?php
session_start();
if (isset($_SESSION['connected'])) {
    session_destroy(); // déconnecte proprement
    header("Location: /gestionStockFLD/");
    exit(); // très important après un header
}
?>