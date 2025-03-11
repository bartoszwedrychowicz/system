<?php 



$klucz = 0;
foreach ($_POST as $key => $value) {
    $klucz = $key;
}

require_once "config.php";


$data = date("Y-d-m");
$sql = "UPDATE zlecenia SET DataWydania= '$data'  WHERE NumerZlecenia = ? ";
$stmt = $link -> prepare($sql);
$stmt -> bind_param("i",$klucz);
$stmt -> execute();
$stmt -> close();

  mysqli_close($link);

  header("location: zlecenia.php");

?>