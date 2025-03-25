<?php
session_start();
require_once "../config.php";
if ($_SESSION['uprawnienia'] === 'admin'){
$elektronik = isset($_POST["elektronik"]) ? (int) $_POST["elektronik"] : 0;
$gwarancja = isset($_POST["gwarancja"]) ? (int) $_POST["gwarancja"] : 0;
$status = isset($_POST["status"]) ? (int) $_POST["status"] : 0;
$kosztCz = isset($_POST["kosztCz"]) ? (float) $_POST["kosztCz"] : 0;
$id = isset($_POST['NumerZlecenia']) ? (int) $_POST['NumerZlecenia'] : 0;

$sql = "UPDATE zlecenia SET 
NazwaFirma = ?,
Osoba = ?,
NumerTelefonu = ?,
Urzadzenie = ?,
idGwarancji = ?,
idElektronika = ?,
idStatus = ?,
Uwagi = ?,
DataZgody = ?,
NumerFaktury = ?,
Kurier = ?,
NrListu = ?,
KosztCz = ?
WHERE NumerZlecenia = ?";  

$stmt = $link->prepare($sql);

if ($stmt) {
    $stmt->bind_param(
        "ssssiiissssssi",
        $_POST["firma"],
        $_POST["osoba"],
        $_POST["telefon"],
        $_POST["urzadzenie"],
        $gwarancja,
        $elektronik,
        $status,
        $_POST["uwagi"],
        $_POST["dataZgody"],
        $_POST["numerFaktury"],
        $_POST["kurier"],
        $_POST["nrListu"],
        $kosztCz,
        $id
    );

    $stmt->execute();
    $stmt->close();
} else {
    die("SQL Error: " . $link->error);
}

$link->close();
header("Location: ../zlecenia");
exit;}else{
    $id = isset($_POST['NumerZlecenia']) ? (int) $_POST['NumerZlecenia'] : 0;
$sql = "UPDATE zlecenia SET 
Uwagi = ?
WHERE NumerZlecenia = ?";  

$stmt = $link->prepare($sql);

if ($stmt) {
    $stmt->bind_param(
        "si",
        $_POST["uwagi"],
        $id
    );

    $stmt->execute();
    $stmt->close();
} else {
    die("SQL Error: " . $link->error);
}

$link->close();
header("Location: ../zlecenia");
exit;
}

?>