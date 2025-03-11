<?php 
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: logowanie.php");
    exit;
}
?>              

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wszystkie zlecenia</title>
    <link rel="stylesheet" href="style.css">
<style>

.main-menu-container{
  min-height: 20vh;
}

input {
  background-image: url('/css/searchicon.png'); /* Add a search icon to input */
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}

table { 
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 1.25rem;
}

table th, table td {
  text-align: left; /* Left-align text */
  padding: 12px; /* Add padding */
}

table tr {
  /* Add a bottom border to all table rows */
  border-bottom: 1px solid #ddd;
}

table tr.header, table tr:hover {
  /* Add a grey background color to the table header and on hover */
  background-color: #f1f1f1;
}</style>
</head>
    <div class="main-container panel-container">
        <main class="panel">
        <?php include 'header.php'?>
            <div class="main-menu-container">
            <input type="text" id="myInput" onkeyup="filterTable()" placeholder="Search for names..">
            <select></select>    
<table>
    <tr class="header">
    </tr>

    <?php 
                        require_once "config.php";
                        
                        
                        $sql = "SELECT * FROM zlecenia";
                        $result = mysqli_query($link, $sql);
                        
                        if (mysqli_num_rows($result) > 0) {
                          // output data of each row
                          while($row = mysqli_fetch_assoc($result)) {


                            echo 
                            "
                             
                            <tr>
                            
                            <td> ".$row["NumerZlecenia"]." </td>
                            <td>".$row["NazwaFirma"]."</td>
                            <td>".$row["Osoba"]."</td>
                               <td>".$row["NumerTelefonu"]."</td>
                               <td>".$row["Urzadzenie"]."</td>
                               <td>".$row["DataPrzyjecia"]."</td>
                               <td> "
                               .($row["DataWydania"] == "" ? "
                               <form action='wydaj.php' method='post' >
                               <button name=".$row["NumerZlecenia"]." type='submit'>Wydaj</button>
                               </form>
                               ": $row["DataWydania"])."</td>
                               <td>".$row["idGwarancji"]."</td>
                               <td>".$row["idElektronika"]."</td>
                               <td>".$row["idStatus"]."</td>
                               <td>".$row["Uwagi"]."</td>
                               <td>".$row["DataZgody"]."</td>
                               <td>".$row["NumerFaktury"]."</td>
                             <td>".$row["Kurier"]."</td>
                               <td>".$row["NrListu"]."</td>
                               <td>".$row["KosztCz"]."</td>
                               <td>
                               <form action='edytuj.php' method='post' >
                               <button name=".$row["NumerZlecenia"]." type='submit'>Edytuj</button> </td>
                               </form>
                               </tr>
                               "
                            ;
                          }
                        } else {
                          echo "0 results";
                        }
                        
                          mysqli_close($link);
                        ?>
</table>


<script>
  const headers = [
    "Numer Zlecenia",
    "Nazwa Firmy",
        "Osoba",
        "Numer Telefonu",
        "Urządzenie",
        "Data przyjęcia",
        "Data Wydania",
        "Gwarancja",
        "Elektronik",
        "Status",
        "Uwagi",
        "Data zgody",
        "Numer Faktury",
        "Kurier",
        "Nr Listu",
        "Koszt Części"
  ];
  const table = document.getElementsByTagName("table")[0];
  const select = document.getElementsByTagName("select")[0];
  const tr = document.getElementsByTagName("tr");
  headers.forEach((value,index) => {
  let optionElement = document.createElement("option");
  optionElement.value = index;
  optionElement.innerText = value;
  select.appendChild(optionElement);

  let thElement = document.createElement("th");
  thElement.addEventListener("click",() => {sortTable(index)});
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
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
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
      switchcount ++;
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
            </div>


        </main>

    </div>


</body>
</html>