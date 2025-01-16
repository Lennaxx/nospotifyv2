<?php
session_start();

if (isset($_SESSION['email'])) {
    session_destroy();
    header('Location: index.php?message=vous+vous+etes+bien+deconnecte');
    exit;
} else {
    header('Location: index.php?message=aucun+utilisateur+connecte');
    exit;
}
?>
