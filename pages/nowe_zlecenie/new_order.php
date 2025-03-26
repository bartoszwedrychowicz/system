<?php
session_start();
require_once "../config.php";  // Secure DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (empty($_POST["firma"]) || empty($_POST["osoba"]) || empty($_POST["telefon"]) || empty($_POST["urzadzenie"]) || empty($_POST["elektronik"]) || empty($_POST["gwarancja"])) {
        $_SESSION['err'] = "Wszystkie pola są wymagane!";
        header("Location: .");
        exit;
    }

    // Sanitize and validate input
    $firma = htmlspecialchars(trim($_POST["firma"]), ENT_QUOTES, 'UTF-8');
    $osoba = htmlspecialchars(trim($_POST["osoba"]), ENT_QUOTES, 'UTF-8');
    $telefon = htmlspecialchars(trim($_POST["telefon"]), ENT_QUOTES, 'UTF-8');
    $urzadzenie = htmlspecialchars(trim($_POST["urzadzenie"]), ENT_QUOTES, 'UTF-8');

    // Ensure IDs are integers
    $elektronik = intval($_POST["elektronik"]);
    $gwarancja = intval($_POST["gwarancja"]);

    // Get current date
    $data = date("Y-m-d");

    // ✅ Secure SQL query with proper values
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
    ) VALUES (NULL, ?, ?, ?, ?, ?, NULL, ?, ?, '1', NULL, NULL, NULL, NULL, NULL, 0)";

    $stmt = $link->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssii", $firma, $osoba, $telefon, $urzadzenie, $data, $gwarancja, $elektronik);

        if ($stmt->execute()) {
            $_SESSION['err'] = "Zlecenie dodane pomyślnie!";
        } else {
            $_SESSION['err'] = "Błąd bazy danych: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['err'] = "Błąd SQL: " . $link->error;
    }

    $link->close();
    header("Location: ../zlecenia");
    exit;
} else {
    $_SESSION['err'] = "Nieprawidłowe żądanie.";
    header("Location: .");
    exit;
}
