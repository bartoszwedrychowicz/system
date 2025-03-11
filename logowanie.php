<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: system.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Panel logowania</title>
    <link rel="stylesheet" href="logowanie.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-container">
        <main>
            <div class="panel-logowania">
                <h1>Panel logowania<h1>

                        <form autocomplete="off" action="zaloguj.php"
                            method="post">
                            <div class="form__group field">
                                <input type="input" class="form__field" placeholder="Name" name="login" id='name'
                                    required "
                                     />
                                <label for="name" class="form__label">Login</label>

                            </div>
                            <div class="form__group field">
                                <input type="password" class="form__field" placeholder="Hasło" name="haslo" required>
                                    
                                <span></span>
                                <label for="name" class="form__label">Hasło</label>
                            </div>
                            <div class="button-container">
                                <button type="submit" class="guzik">Zaloguj się</button>
                            </div>
                        </form>
            </div>
        </main>

    </div>


</body>

</html>