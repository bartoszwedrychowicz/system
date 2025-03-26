<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Edycja zlecenia</title>
    <link rel="stylesheet" href="edycja_zlecenia.css">
</head>

<body>
    <div class="background"></div>
    <div class="main-container panel-container">
        <main class="panel">
            <?php
            session_start();
            if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
                header("location: ../logowanie");
                exit;
            }

            if ($_SESSION['uprawnienia'] != 'admin') {

                $allowed_pages = ['/system/pages/zlecenia/', '/system/pages/header/zmiana_hasla/', '/system/pages/zlecenia/edytuj.php'];
                $current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                if (!in_array($current_page, $allowed_pages)) {

                    header("Location: ../zlecenia");
                    exit();
                }
            }

            ?>
        </main>
        <?php

        require_once "../config.php";
        $klucz = isset($_POST['NumerZlecenia']) ? intval($_POST['NumerZlecenia']) : 0;
        if ($klucz > 0) {
            $sql = "SELECT * FROM zlecenia WHERE NumerZlecenia =  ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param('i', $klucz);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "  <h1><label> Edytujesz zlecenie numer " . $klucz . "</label> </h1>
           <form action='edit_order.php' method='post'>
            <input type='hidden' name='NumerZlecenia' value='" . intval($row["NumerZlecenia"]) . "'>
             <div class='form-container'>";
                if ($_SESSION['uprawnienia'] != 'admin') {
                    echo "
        <div class='left-form'>
          <div class='form-group'><label for='uwagi'>Uwagi</label>
            <textarea type='textarea' name='uwagi'>" . htmlspecialchars($row['Uwagi'], ENT_QUOTES, 'UTF-8') . "</textarea>
           </div>
           </div>
          ";
                } else {
                    echo "
             <div class='left-form'>
              <div class='form-group'>
            <label for='firma'>Firma</label>
            <textarea name='firma'>" . htmlspecialchars($row['NazwaFirma'], ENT_QUOTES, 'UTF-8') . "</textarea>
            </div>
            <div class='form-group'>
           <label for='osoba'>Osoba</label>
            <input type='text' name='osoba' value='" . htmlspecialchars($row['Osoba'], ENT_QUOTES, 'UTF-8') . "'>
            </div>
            <div class='form-group'>
            <label for='telefon'>Telefon</label>
          <input type='tel' name='telefon' value='" . htmlspecialchars($row['NumerTelefonu'], ENT_QUOTES, 'UTF-8') . "'></input>
          </div>
            <div class='form-group'>
           <label for='urzadzenie'>Urządzenie</label>
            <textarea name='urzadzenie'>" . htmlspecialchars($row['Urzadzenie'], ENT_QUOTES, 'UTF-8') . "</textarea>
            </div>
            <div class='form-group'>
            <label for='gwarancja'>Gwarancja</label>
              <select name='gwarancja'>";
                    $sql = "SELECT * FROM gwarancje";
                    $stmt = $link->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {

                        while ($Grow = $result->fetch_assoc()) {
                            echo "<option  " . ($Grow['idGwarancji'] == $row['idGwarancji'] ? "selected" : "") . "  value='" . $Grow["idGwarancji"] . "'>" . $Grow["nazwa"] . "</option>";
                        }
                        echo "</select>";
                    }

                    echo "
            </div>
            <div class='form-group'><label for='elektronik'>Elektronik</label>
            <select name='elektronik'>";
                    $sql = "SELECT idElektronika,nazwa FROM uzytkownicy WHERE uprawnienia = 'elektronik'";
                    $stmt = $link->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {

                        while ($Erow = $result->fetch_assoc()) {
                            echo "<option  " . ($Erow['idElektronika'] == $row['idElektronika'] ? "selected" : "") . "  value='" . $Erow["idElektronika"] . "'>" . $Erow["nazwa"] . "</option>";
                        }
                        echo "</select>";
                    }
                    echo "
      </div>
            <div class='form-group'>
            <label for='status'>Status</label>
            <select name='status'>";
                    $sql = "SELECT * FROM statusZlecenia";
                    $stmt = $link->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {

                        while ($Srow = $result->fetch_assoc()) {
                            echo "<option  " . ($Srow['idStatus'] == $row['idStatus'] ? "selected" : "") . "  value='" . $Srow["idStatus"] . "'>" . $Srow["nazwa"] . "</option>";
                        }
                        echo "</select>";
                        echo "";
                    }
                    echo "

            </div>
             <a href='.' class='cancel-button'><button>Anuluj</button></a>
         </div>
         <div class='right-form'>
            <div class='form-group'><label for='uwagi'>Uwagi</label>
            <textarea type='textarea' name='uwagi'>" . htmlspecialchars($row['Uwagi'], ENT_QUOTES, 'UTF-8') . "</textarea>
           </div>
            <div class='form-group'><label for='dataZgody'>Data zgody</label>
          <input type='date'  name='dataZgody' value='" . $row['DataZgody'] . "'>
        </div>
            <div class='form-group'><label for='numerFaktury'>Numer Faktury</label>
          <input type='text' name='numerFaktury' value='" . $row['NumerFaktury'] . "'>

          </div>
            <div class='form-group'><label for='kurier'>Kurier</label>
          </div>
            <div class='form-group'><input type='text' name='kurier' value='" . $row['Kurier'] . "'>
          </div>
            <div class='form-group'><label for='nrListu'>Numer listu</label>
          <input type='numer' name='nrListu' value='" . $row['NrListu'] . "'>
          </div>
            <div class='form-group'><label for='kosztCz'>Koszt częśći</label>
          <input type='number' name='kosztCz' value='" . $row['KosztCz'] . "'>
          </div>

      ";
                }
            }



            $stmt->close();
            $link->close();
        } else {
            $_SESSION['err'] = "Invalid order ID.";
        }
        ?>

        <button type="submit">Edytuj zlecenie</button>

    </div>
    </div>
    </form>

</body>

</html>
