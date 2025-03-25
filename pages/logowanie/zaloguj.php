<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../panel");
    exit;
}

require_once "../config.php";

$_SESSION['err'] = "";
$password = $_POST['haslo'];
$username = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");

// Prepare SQL statement
$sql = "SELECT * FROM uzytkownicy WHERE nazwa = ?";
$stmt = $link->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // ✅ SECURE PASSWORD CHECK
        if (password_verify($password, $data['haslo'])) {

            // Regenerate session ID for security
            session_regenerate_id(true);

            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $data['idElektronika'];
            $_SESSION["username"] = $data['nazwa'];
            $_SESSION['uprawnienia'] = $data['uprawnienia'];

            $result->free_result();
            $stmt->close();
            $link->close();

            // Redirect based on user role
            header("location: " . ($_SESSION['uprawnienia'] == 'admin' ? "../panel" : "../zlecenia"));
            exit;

        } else {
            $_SESSION['err'] = "Błędne hasło";
        }
    } else {
        $_SESSION['err'] = "Błędna nazwa użytkownika";
    }

    // Close DB connections
    $result->free_result();
    $stmt->close();
} else {
    $_SESSION['err'] = "SQL error:" . $link->error;
}
$link->close();

// Redirect back to login
header("location: .");
exit;
?>