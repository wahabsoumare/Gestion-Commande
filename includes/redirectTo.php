<?php
    if(!isset($_SESSION['connected'])) {
        header("Location: /gestionStockFLD/auth/login.php");
        exit();
    }
?>