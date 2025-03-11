<?php 

$klucz = "";
foreach ($_POST as $key => $value) {
    $klucz = $key;
}
require_once "config.php";
                        
$sql = "DELETE FROM uzytkownicy WHERE idElektronika = ?";
$stmt = $link -> prepare($sql);
$stmt -> bind_param("i",$klucz);
$stmt -> execute();
$stmt -> close();
$link -> close();
header("location: uzytkownicy.php");
?>