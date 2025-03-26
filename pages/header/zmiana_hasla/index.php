<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Zmiana hasła</title>
    <link rel="stylesheet" href="zmianaHasla.css">
</head>
<div class="panel-container">
    <main class="panel">


        <?php include '../header.php' ?>

        <div class="changePass-container">
            <h1>Zmiana hasła<h1>
                    <form autocomplete="off" action="password_change.php"
                        method="post">
                        <div class="form__group field">
                            <label for="name" class="form__label">Wpisz stare hasło:</label>
                            <input type='password' class='form__field' placeholder='Hasło' name='old_password' required

                                </div>
                            <div class="form__group field">
                                <label for="name" class="form__label">Wpisz nowe hasło:</label>
                                <input type='password' class='form__field' placeholder='Hasło' name='new_password' required

                                    </div>
                                <p class="error"> <?php echo isset($_SESSION['err']) ? $_SESSION['err'] : "";
                                                    $_SESSION['err'] = ""; ?>
                                </p>
                                <div class="button-container">
                                    <button type="submit" class="guzik" style="left:30%;">Zmiana hasła</button>
                                </div>
                    </form>
        </div>
    </main>
</div>
</body>

</html>
