<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    header("location: logowanie.php");
    exit;
}
require_once "config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {




$_SESSION['blad'] = "";
$stare_haslo = $_POST['old_password'];
$nowe_haslo = $_POST['new_password'];
$nowe_hash = password_hash($nowe_haslo,PASSWORD_DEFAULT);
$id = $_SESSION["id"];



if ($rezultat = $link->query(
    sprintf("SELECT * FROM uzytkownicy WHERE idElektronika ='%s'",
    $link -> real_escape_string($id))
)){
    $ilu_userow = $rezultat-> num_rows;
    
    if($ilu_userow>0){


        $wiersz = $rezultat->fetch_assoc();
        
        print(password_verify("haslomaslo",$wiersz['haslo']));
        if((password_verify($stare_haslo,$wiersz['haslo'])))
        {
            $sql = "UPDATE uzytkownicy SET haslo = '$nowe_hash' WHERE idElektronika = '$id'";
            if($link -> query($sql)){
                echo "yay";
            };
            

        }else{
            $_SESSION['blad'] = "Błędne hasło";
               
        }
    }else{
        $S_SESSION['blad'] = "Błędny login";
    }

}
echo $_SESSION['blad'];
}








// $login_err = $old_password = $new_password = "";

// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     $old_password = $_POST["old_password"];
//     $id = $_SESSION["id"] + 0;
//     $new_password = $_POST["new_password"];

//     $sql = "SELECT * FROM uzytkownicy WHERE idElektronika = ? ";
//     $stmt = $link -> prepare($sql);
//     $stmt -> bind_param("i",$id);
    
//     $stmt -> execute();
//             // Store result
//     $stmt -> store_result();
//     if($stmt -> num_rows > 0){
//         echo "udało sie zalowogwać";
//         $sql = "UPDATE uzytkownicy SET haslo= ? WHERE idElektronika = ?";
//         $stmt = $link -> prepare($sql);
//         $haslo_hash = password_hash($new_password, PASSWORD_DEFAULT);
//         echo $haslo_hash;
//         $stmt -> bind_param("si",$haslo_hash,$id);
//         $stmt -> execute();
        
//         $stmt -> close();
//         session_start();
//         $_SESSION["loggedin"] = false;
//     }
           
            
// }
$link -> close();

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Zmiana hasła</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="zmianaHasla.css">
</head>
<div class="panel-container">
    <main class="panel">
        <?php include 'header.php' ?>
        <div class="changePass-container">
            <h1>Zmiana hasła<h1>
                    <form autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                        method="post">
                        <div class="form__group field">
                            <input type='password' class='form__field' placeholder='Hasło' name='old_password' required
                                <?php echo (!empty($login_err)) ? 'is-invalid' : ''; ?> />
                            <label for="name" class="form__label">Wpisz stare hasło:</label>
                        </div>
                        <div class="form__group field">
                            <input type='password' class='form__field' placeholder='Hasło' name='new_password' required
                                <?php echo (!empty($login_err)) ? 'is-invalid' : ''; ?> />
                            <label for="name" class="form__label">Wpisz nowe hasło:</label>
                        </div>
                        <div class="button-container">
                            <button type="submit" class="guzik" style="left:30%;">Zmiana hasła</button>
                        </div>
                    </form>
        </div>
    </main>
</div>
</body>
</html>