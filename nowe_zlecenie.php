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
    <title>Dodawanie zlecenia</title>
    <link rel="stylesheet" href="style.css">
    <script defer type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script defer nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
    <div class="main-container panel-container">
        <main class="panel">
            <?php include 'header.php'?>
            <div class="main-menu-container">
                <form action="new_order.php" method="post">
                    Firma: <textarea name="firma"></textarea> </br>
                    Osoba: <input type="text" name="osoba"></input>
                    Telefon: <input type="tel" name="telefon"></input>
                    Urządzenie: <input type="textarea" name="urzadzenie"></input>
                    Gwarancja: <select name="gwarancja" >
                        <?php 
                        require_once "config.php";
                        
                        $sql = "SELECT * FROM gwarancje";
                        $result = mysqli_query($link, $sql);
                        
                        if (mysqli_num_rows($result) > 0) {
                          // output data of each row
                          while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value=".$row["idGwarancji"].">" . $row["nazwa"]. "</option>";
                          }
                        } else {
                          echo "0 results";
                        }
                        echo "</select>";

                        echo "Elektronik: <select name='elektronik'>";
                        
                        $sql = "SELECT idElektronika,nazwa FROM uzytkownicy WHERE uprawnienia = 'elektronik'";
                        $result = mysqli_query($link, $sql);
                        
                        if (mysqli_num_rows($result) > 0) {
                          // output data of each row
                          while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value=".$row["idElektronika"].">" . $row["nazwa"]. "</option>";
                          }
                        } else {
                          echo "0 results";
                        }
                        echo "</select>";
                          mysqli_close($link);
                        ?>
                        <button type="submit">Dodaj zlecenia</button>
                </form>
            </div>
        </main>

    </div>


</body>
</html>