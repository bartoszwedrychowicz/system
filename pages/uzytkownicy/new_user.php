<?php
session_start();
require_once "../config.php";  // Secure DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    if (empty($_POST['login']) || empty($_POST['uprawnienia'])) {
        $_SESSION['err'] = "Wypełnij wszystkie pola";
        header("location: .");
        exit;
    }

    // Retrieve and sanitize inputs
    $login = trim($_POST['login']);
    $uprawnienia = trim($_POST['uprawnienia']);

    // ✅ Ensure username is properly sanitized
    $login = filter_var($login, FILTER_SANITIZE_STRING);

    // ✅ Check if login already exists
    $check_sql = "SELECT idElektronika FROM uzytkownicy WHERE nazwa = ?";
    $check_stmt = $link->prepare($check_sql);
    $check_stmt->bind_param("s", $login);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $_SESSION['err'] = "Użytkownik o tej nazwie już istnieje!";
        $check_stmt->close();
        header("location: .");
        exit;
    }
    $check_stmt->close();

    // ✅ Secure default password hashing
    $hashedPassword = password_hash($default_password, PASSWORD_DEFAULT);

    // ✅ Insert new user using prepared statement
    $sql = "INSERT INTO `uzytkownicy` (`nazwa`, `haslo`, `uprawnienia`) VALUES (?, ?, ?)";
    $stmt = $link->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $login, $hashedPassword, $uprawnienia);

        if ($stmt->execute()) {
            $_SESSION['err'] = "Użytkownik został dodany! Domyślne hasło: $default_password";
        } else {
            $_SESSION['err'] = "Błąd: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['err'] = "Błąd SQL: " . $link->error;
    }

    $link->close();
    header("location: .");
    exit;
} else {
    echo $_SESSION['err'];
    die("Nieprawidłowe żądanie.");
}
?>
