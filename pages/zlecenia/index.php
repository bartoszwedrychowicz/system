<?php
$_SESSION['zlecenia'] = true;
?>
<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <title>Wszystkie zlecenia</title>
  <link rel="stylesheet" href="/system/pages/zlecenia/zlecenia.css">
</head>

<body>
  <div>
    <?php
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
      header("location: ../logowanie");
      exit;
    }



    ?>
    <script defer type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script defer nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="shortcut icon" href="/system/assets/FAVICON.svg" type="image/x-icon">
    <div class="navbar-container">
      <span>
        <ion-icon name="person"></ion-icon>
        <span><?php echo $_SESSION["username"]; ?></span>
      </span>
      <nav>
        <span>
          <a href="/system/pages/panel/">
            <ion-icon name="home"></ion-icon>
            <span class="hover">Strona główna</span>
          </a>
        </span>
        <span>
          <a href="/system/pages/header/zmiana_hasla">
            <ion-icon name="key"></ion-icon>
            <span class="hover">Zmiana hasła</span>
          </a>
        </span>
        <span style="margin-right:1rem;">
          <a href="/system/pages/header/logout.php">
            <ion-icon name="exit"></ion-icon>
            <span class="hover">Wyloguj</span>
          </a>
        </span>
      </nav>
    </div>
  </div>
  <div class="sort">
    <input type="text" id="myInput" onkeyup="filterTable()" placeholder="Filtruj zlecenia">
    <select></select>
  </div>
  <table>
    <tr class="header"></tr>

    <?php
    require_once "../config.php";
    $sql = "SELECT * FROM statusZlecenia";
    $zlecenia = array();

    $stmt = $link->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

      while ($row = $result->fetch_assoc()) {
        $zlecenia[$row['idStatus'] + 0] = $row['nazwa'];
      }

    }
    $sql = "SELECT * FROM gwarancje";
    $gwarancje = array();

    $stmt = $link->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

      while ($row = $result->fetch_assoc()) {
        $gwarancje[$row['idGwarancji'] + 0] = $row['nazwa'];
      }

    }
    $sql = "SELECT idElektronika,nazwa FROM uzytkownicy WHERE uprawnienia = 'elektronik'";
    $elektronicy = array();

    $stmt = $link->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

      while ($row = $result->fetch_assoc()) {
        $elektronicy[$row['idElektronika'] + 0] = $row['nazwa'];
      }
    }

    $sql = "SELECT * FROM zlecenia";
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $prawa = $_SESSION['uprawnienia'];

    if ($result->num_rows > 0) {
      $date2 = new DateTime(date("Y-m-d"));
      while ($row = $result->fetch_assoc()) {
        $date1 = new DateTime($row['DataPrzyjecia']);

        $diff = $date1->diff($date2)->format("%d");
        if ($_SESSION['id'] === $row['idElektronika']) {

          echo
            "
                    <tr " . ($row['idStatus'] == 13 ? "style='background-color:green;'" : "") . " 
                     " . (
              (
                ($diff > 14)
                and
                ($row['idStatus'] !== 13)) ? "style='background-color:red;'" : "") .
            ">
                    
                    <td> " . $row["NumerZlecenia"] . " </td>
                    <td> ***** </td>
                    <td>*****</td>
                       <td>*****</td>
                       <td>" . $row["Urzadzenie"] . "</td>
                       <td>" . $row["DataPrzyjecia"] . "</td>
                       <td> "
            . ($row["DataWydania"] == "" ? "
                   
                       Nie wydano
                
                       " : $row["DataWydania"]) . "</td>
                       <td>" . $gwarancje[$row["idGwarancji"] + 0] . "</td>
                       <td>" . $elektronicy[$row["idElektronika"] + 0] . "</td>
                       <td>" . $zlecenia[$row["idStatus"] + 0] . "</td>
                       <td>" . $row["Uwagi"] . "</td>
                       <td>" . $row["DataZgody"] . "</td>
                       <td>" . $row["NumerFaktury"] . "</td>
                     <td>" . $row["Kurier"] . "</td>
                       <td>" . $row["NrListu"] . "</td>
                       <td>" . $row["KosztCz"] . "</td>
                       <td>
                       <form action='edytuj.php' method='post' >
                        <input type='hidden' name='NumerZlecenia' value='" . intval($row["NumerZlecenia"]) . "'>
                       <button type='submit'><ion-icon name='create-outline'></ion-icon></button> 
                       </form></td>
                       </tr>
                       ";
        } else if ($prawa == 'admin') {
          echo
            "
                   
                  <tr " . ($row['idStatus'] == 13 ? "style='background-color:green;'" : "") . " 
                   " . (
              (
                ($diff > 14)
                and
                ($row['idStatus'] !== 13)) ? "style='background-color:red;'" : "") .
            ">
                  
                  <td> " . $row["NumerZlecenia"] . " </td>
                  <td>" . $row["NazwaFirma"] . "</td>
                  <td>" . $row["Osoba"] . "</td>
                     <td>" . $row["NumerTelefonu"] . "</td>
                     <td>" . $row["Urzadzenie"] . "</td>
                     <td>" . $row["DataPrzyjecia"] . "</td>
                     <td> "
            . ($row["DataWydania"] == "" ? "
                     <form action='wydaj.php' method='post' >
                     Nie wydano
                     <input type='hidden' name='NumerZlecenia' value='" . intval($row["NumerZlecenia"]) . "'>
                     <button type='submit'>Wydaj</button>
                     </form>
                     " : $row["DataWydania"]) . "</td>
                     <td>" . $gwarancje[$row["idGwarancji"] + 0] . "</td>
                     <td>" . $elektronicy[$row["idElektronika"] + 0] . "</td>
                     <td>" . $zlecenia[$row["idStatus"] + 0] . "</td>
                     <td>" . $row["Uwagi"] . "</td>
                     <td>" . $row["DataZgody"] . "</td>
                     <td>" . $row["NumerFaktury"] . "</td>
                   <td>" . $row["Kurier"] . "</td>
                     <td>" . $row["NrListu"] . "</td>
                     <td>" . $row["KosztCz"] . "</td>
                     <td>
                     <form action='edytuj.php' method='post' >
                     <input type='hidden' name='NumerZlecenia' value='" . intval($row["NumerZlecenia"]) . "'>
                     <button  type='submit'><ion-icon name='create-outline'></ion-icon></button> 
                     </form><br>
                     <form action='drop_order.php' method='post' >
                     <input type='hidden' name='NumerZlecenia' value='" . intval($row["NumerZlecenia"]) . "'>
                     <button type='submit'><ion-icon name='trash-outline' style='color:red;'></ion-icon></button> </td>
                     </form>
                     </tr>
                     "
          ;
        }

      }
    }
    $stmt->close();
    $link->close();

    ?>
  </table>


  <script>

    const headers = [
      "Numer Zlecenia",
      "Nazwa Firmy",
      "Osoba",
      "Telefon",
      "Urządzenie",
      "Data przyjęcia",
      "Data Wydania",
      "Gwarancja",
      "Elektronik",
      "Status",
      "Uwagi",
      "Data zgody",
      "Nr Faktury",
      "Kurier",
      "Nr Listu",
      "Koszt Części"
    ];
    const table = document.getElementsByTagName("table")[0];
    const select = document.getElementsByTagName("select")[0];
    const tr = document.getElementsByTagName("tr");
    headers.forEach((value, index) => {
      let optionElement = document.createElement("option");
      optionElement.value = index;
      optionElement.innerText = value;
      select.appendChild(optionElement);

      let thElement = document.createElement("th");
      thElement.addEventListener("click", () => { sortTable(index) });
      thElement.innerText = value;
      tr[0].appendChild(thElement);
    })

    let thElement = document.createElement("th");

    thElement.innerText = "Edytuj";
    tr[0].appendChild(thElement);
    function filterTable() {
      // Declare variables
      var input, filter, td, i, txtValue;
      input = document.getElementsByTagName("input")[0];
      filter = input.value.toUpperCase();


      filterColumn = select.value;
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[filterColumn];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    function sortTable(n) {
      var rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      switching = true;
      // Set the sorting direction to ascending:
      dir = "asc";
      /* Make a loop that will continue until
      no switching has been done: */
      while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
          // Start by saying there should be no switching:
          shouldSwitch = false;

          let x, y;
          let cell1 = rows[i].getElementsByTagName("TD")[n].innerText.trim().toUpperCase();
          let cell2 = rows[i + 1].getElementsByTagName("TD")[n].innerText.trim().toUpperCase();

          if (!isNaN(cell1) && !isNaN(cell2)) {
            x = Number(cell1);
            y = Number(cell2);
          } else {
            x = cell1;
            y = cell2;
          }

          /* Check if the two rows should switch place,
          based on the direction, asc or desc: */
          if (dir == "asc") {
            if (x > y) {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          } else if (dir == "desc") {
            if (x < y) {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          }
        }
        if (shouldSwitch) {
          /* If a switch has been marked, make the switch
          and mark that a switch has been done: */
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          // Each time a switch is done, increase this count by 1:
          switchcount++;
        } else {
          /* If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again. */
          if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
          }
        }
      }
    }


    sortTable(0);
  </script>


</body>

</html>