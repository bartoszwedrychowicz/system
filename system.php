<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: logowanie.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>System</title>
    <link rel="stylesheet" href="style.css">
</head>
<div class="panel-container">
    <main>
        <?php include 'header.php'; ?>
        <div class="main-menu-container">
            <a href="zlecenia.php">
                <div class="all menu-button">
                    <span class="menu-text">Wszystkie zlecenia</span>
                </div>
            </a> <a href="nowe_zlecenie.php">
                <div class="add menu-button">
                    <span class="menu-text">Dodaj nowe zlecenie</span>
                </div>
            </a>
            <a href="uzytkownicy.php">
                <div class="users menu-button">
                    <span class="menu-text"> Użytkownicy</span>
                </div>
            </a>
        </div>


    </main>

</div>


</body>

</html>