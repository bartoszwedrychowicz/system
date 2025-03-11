<?php

require_once "config.php";
$login = $_POST['login'];
$uprawnienia = $_POST['uprawnienia'];
$password = password_hash($_POST['haslo'], PASSWORD_DEFAULT);
$sql = "INSERT INTO `uzytkownicy` (`idElektronika`, `nazwa`, `haslo`, `uprawnienia`, `czyPracuje`) VALUES (NULL, '$login', '$haslo', '$uprawnienia', '1')";
//$stmt = $link -> prepare($sql);
//$stmt -> bind_param("sss",$_POST['login'],$password,$_POST["uprawnienia"]);
if($link -> query($sql)){
  header("location: uzytkownicy.php");
}
// $stmt -> execute();
// $stmt -> close();
$link -> close();

  
?>
                        