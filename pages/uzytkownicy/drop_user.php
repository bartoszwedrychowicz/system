<?php
session_start();
require_once "../config.php";  // Secure DB connection

// ✅ Ensure user is logged in and has admin rights
if (!isset($_SESSION["loggedin"]) || $_SESSION["uprawnienia"] !== "admin") {
    $_SESSION['err'] = "Brak uprawnień do usunięcia użytkownika.";
    header("Location: .");
    exit;
}

// ✅ Validate & sanitize input
if (!isset($_POST['idElektronika']) || !is_numeric($_POST['idElektronika'])) {
    $_SESSION['err'] = "Nieprawidłowe ID użytkownika.";
    header("Location: .");
    exit;
}

$klucz = intval($_POST['idElektronika']); // Convert input to integer (prevents SQL injection)

// ✅ Check if the user exists before deleting
$sql = "SELECT COUNT(*) FROM uzytkownicy WHERE idElektronika = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $klucz);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count == 0) {
    $_SESSION['err'] = "Użytkownik nie istnieje.";
    header("Location: .");
    exit;
}

// ✅ Ensure user has no existing "zlecenia" (tasks) before deleting
$sql = "SELECT COUNT(*) FROM zlecenia WHERE idElektronika = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $klucz);
$stmt->execute();
$stmt->bind_result($zlecenia_count);
$stmt->fetch();
$stmt->close();

if ($zlecenia_count > 0) {
    $_SESSION['err'] = "Ten użytkownik ma zlecenia, nie można go usunąć.";
    header("Location: .");
    exit;
}

// ✅ Safe deletion using prepared statement
$sql = "DELETE FROM uzytkownicy WHERE idElektronika = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $klucz);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['success'] = "Użytkownik został usunięty.";
} else {
    $_SESSION['err'] = "Błąd podczas usuwania użytkownika.";
}

$stmt->close();
$link->close();

header("Location: .");
exit;
