<?php

require_once "config.php";
            $gwarancja = $_POST["gwarancja"] + 0; 
            $data = date("Y-d-m");           
$sql = "
INSERT INTO `zlecenia` (
`NumerZlecenia`,
`NazwaFirma`,
`Osoba`,
`NumerTelefonu`,
`Urzadzenie`,
`DataPrzyjecia`,
`DataWydania`,
`idGwarancji`,
`idElektronika`,
`idStatus`,
`Uwagi`,
`DataZgody`,
`NumerFaktury`,
`Kurier`,
`NrListu`,
`KosztCz`
) VALUES (NULL, ?, ?, ?, ?, ?, NULL, ?, ?, '1', NULL, 0000-00-00, NULL, NULL, NULL, 0)";

$stmt = $link -> prepare($sql);
$stmt -> bind_param("sssssii",
$_POST["firma"],
$_POST["osoba"],
$_POST["telefon"],
$_POST["urzadzenie"],
$data,

$gwarancja,
$_POST["elektronik"],

);

$stmt -> execute();
$stmt -> close();
$link -> close();
header("location: nowe_zlecenie.php");

 
?>
                        