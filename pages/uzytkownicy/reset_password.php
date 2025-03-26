

<?php
session_start();
require_once "../config.php";

if (empty($_POST['idElektronika'])) {
    $_SESSION['err'] = "Błąd: Brak ID użytkownika.";
    header("location: .");
    exit;
}

// ✅ SECURE PASSWORD HASHING
$hashedPassword = password_hash($default_passoword, PASSWORD_DEFAULT);

// ✅ PREPARED STATEMENT
$sql = "UPDATE uzytkownicy SET haslo = ? WHERE idElektronika = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("si", $hashedPassword, $klucz);

if ($stmt->execute()) {
    $_SESSION['err'] = "Zresetowano hasło.";
    $stmt->close();
} else {
    $_SESSION['err'] = "Błąd podczas resetowania hasła." + $link->error;
}

// Cleanup
$link->close();
header("location: .");
exit;
?>
