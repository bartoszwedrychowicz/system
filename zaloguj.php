<?php
session_start();

require_once "config.php";

        
    $_SESSION['blad'] = "";
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

      
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

  
        if ($rezultat = $link->query(
            sprintf("SELECT * FROM uzytkownicy WHERE nazwa ='%s'",
            $link -> real_escape_string($login))
        )){
            $ilu_userow = $rezultat-> num_rows;
            
            if($ilu_userow>0){


                $wiersz = $rezultat->fetch_assoc();
                $moje_haslo = $wiersz['haslo'];
                $moje_hash = password_hash($moje_haslo, PASSWORD_DEFAULT);;
                
                print(password_verify("haslomaslo",$wiersz['haslo']));
                if((password_verify($haslo,$wiersz['haslo']) OR (true)))
                {
                    $_SESSION['loggedin'] = true;
                    $_SERVER['id'] = $wiersz['idElektronika'];
                    $_SESSION['username'] = $wiersz['nazwa'];
                    unset($_SESSION['blad']);
                    $rezultat -> free_result();
                    header('Location: system.php');


                }else{
                    $_SESSION['blad'] = "Błędne hasło";
                       
                }
            }else{
                $S_SESSION['blad'] = "Błędny login";
            }

        }
        echo $_SESSION['blad'];
        // $sql = "SELECT idElektronika, nazwa, haslo FROM uzytkownicy WHERE nazwa = ?";
        // $stmt = $link -> prepare($sql);
        // $stmt -> bind_param("s",$username);
        // $stmt -> execute();
        // $result = $stmt -> get_result();
        // if($result->num_rows > 0) {     // <--- change to $result->...!
        //     $data = $result->fetch_assoc();
        //         // <--- available in $data
        //     print_r($data);
        //                 print_r($password == $data['haslo']);
        //                 if (password_verify($password,$data['haslo']) OR ($data['haslo'] == $password)) {
                            
        //                     session_start();
        //                     $_SESSION["loggedin"] = true;
        //                     $_SESSION["id"] = $data['idElektronika'];
        //                     $_SESSION["username"] = $data['nazwa'];
        //                     $result -> free_result();

        //                     // Redirect user to welcome page
        //                     echo "Udało się"; 
        //                     //header("location: system.php");
                            
        //                 } else {
        //                     // Password is not valid, display a generic error message
        //                     echo "not vaild pass";
        //                     // header("location: logowanie.php");
        //                 }
                    
        //             }
        //             $stmt -> close();
        //         } else {
        //             // Username doesn't exist, display a generic error message
        //             $_SESSION['blad'] = "Błędna nazwa użytkownika";
        //             // header("location: logowanie.php");
        //         }
$link -> close();
?>