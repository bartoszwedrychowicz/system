<?php
session_start();
require_once "../config.php";
$klucz = isset($_POST['NumerZlecenia']) ? intval($_POST['NumerZlecenia']) : 0;
if ($klucz > 0){

$sql = "DELETE FROM zlecenia WHERE NumerZlecenia = ?";  

$stmt = $link->prepare($sql);

if ($stmt) {
    $stmt->bind_param(
        "i",
        $klucz
    );

    $stmt->execute();
    $stmt->close();
} else {
    die("SQL Error: " . $link->error);
}
}else {
    $_SESSION['err'] = "Invalid order ID.";
}

$link->close();
header("Location: ../zlecenia");
exit;
?>