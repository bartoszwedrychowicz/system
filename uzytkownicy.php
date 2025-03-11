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
    <title>Panel logowania</title>
    <link rel="stylesheet" href="style.css">
    <script defer type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script defer nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
    <div class="main-container panel-container">
        <main class="panel">
        <?php include 'header.php'?>
            <div class="main-menu-container">
            <table border="1" cellspacing="2" cellpadding="2"> 
      
            <?php 
                        require_once "config.php";
                        
                    
                        $sql = "SELECT * FROM uzytkownicy";
                        $result = mysqli_query($link, $sql);
                        
                        if (mysqli_num_rows($result) > 0) {
                          // output data of each row
                          while($row = mysqli_fetch_assoc($result)) {
                            echo "
                             <form action='drop_user.php' method='post'>
                            <tr> 
                            <td>".$row["nazwa"]."</td>
                            <td>".$row["uprawnienia"]."</td>
                            <td>".($row["czyPracuje"] == 1 ? 'Tak' : 'Nie')."</td>
                            <td><button name=".$row["idElektronika"]." type='submit'>Zablokuj dostęp</button> </td>
                            </tr>
                            </form>";
                          }
                        
                        } else {
                          echo "0 results";
                        }
                          mysqli_close($link);
                        ?>
            </table>
            
           
            <form action="new_user.php" method="post">
                 Login: <input name="login"></input>
                 Haslo: <input name="haslo"></input>
                 Uprawnienia: <select name="uprawnienia">


                        <option>elektronik</option>
                        <option>admin</option>
                 </select>
            <button type="submit">Dodaj użytkownika</button>
        </table>

            </div>


        </main>

    </div>


</body>
</html>