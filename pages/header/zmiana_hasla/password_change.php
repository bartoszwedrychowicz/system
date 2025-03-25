
<?php
session_start();
require_once "../../config.php";

$_SESSION['err'] = "";
$old_password = $_POST["old_password"] ?? '';
$new_password = $_POST["new_password"] ?? '';
$id = isset($_SESSION['id']) ? (int) $_SESSION['id'] : 0;

// Validate inputs
if (empty($old_password) || empty($new_password) || $id <= 0) {
    $_SESSION['err'] = "Nieprawidłowe dane";
    header("Location: .");
    exit;
}

// Get user data
$sql = "SELECT haslo FROM uzytkownicy WHERE idElektronika = ?";
$stmt = $link->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $link->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // ✅ Secure password check
    if (password_verify($old_password, $row['haslo'])) {
        // ✅ Hash new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $sql = "UPDATE uzytkownicy SET haslo = ? WHERE idElektronika = ?";
        $stmt = $link->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $hashed_password, $id);
            if ($stmt->execute()) {
                // ✅ Logout user after password change
                session_unset();
                session_destroy();
                session_start();
                $_SESSION['err'] = "Udało się zmienić hasło";
                header("Location: ../../logowanie");
                exit;
            } else {
                $_SESSION['err'] = "Błąd podczas aktualizacji hasła";
            }
        }
    } else {
        $_SESSION['err'] = "Błędne hasło";
    }
} else {
    $_SESSION['err'] = "Brak użytkownika w bazie";
}

// Cleanup
$stmt->close();
$link->close();

// Redirect back
header("Location: .");
exit;
?>
