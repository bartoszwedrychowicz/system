<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Użytkownicy</title>
    <link rel="stylesheet" href="users.css">
</head>

<body>
    <div class="main-container panel-container">
        <main class="panel">
            <?php include '../header/header.php' ?>

            <div class="users-container">
                <table>
                    <tr>
                        <th>Nazwa</th>
                        <th>Uprawnienia</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                    require_once "../config.php";

                    // ✅ Fetch users securely
                    $sql = "SELECT idElektronika, nazwa, uprawnienia FROM uzytkownicy";
                    $result = $link->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "
        <tr>
            <td>" . htmlspecialchars($row["nazwa"]) . "</td>
            <td>" . htmlspecialchars($row["uprawnienia"]) . "</td>
            <td>
                <form action='reset_password.php' method='post'>
                    <input type='hidden' name='idElektronika' value='" . intval($row["idElektronika"]) . "'>
                    <button type='submit' class='guzik'>Resetuj hasło</button>
                </form>
            </td>
            <td>
                <form action='drop_user.php' method='post' onsubmit='return confirm(\"Czy na pewno chcesz usunąć tego użytkownika?\")'>
                    <input type='hidden' name='idElektronika' value='" . intval($row["idElektronika"]) . "'>
                    <button type='submit' class='guzik'>Usuń użytkownika</button>
                </form>
            </td>
        </tr>
        ";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Brak użytkowników</td></tr>";
                    }

                    mysqli_close($link);
                    ?>
                </table>

                <form action="new_user.php" method="post" class="add-user" autocomplete="off">
                    Login: <input name="login"></input>
                    Uprawnienia: <select name="uprawnienia">


                        <option>elektronik</option>
                        <option>admin</option>
                    </select>
                    <button type="submit" class="guzik">Dodaj użytkownika</button>
                    <p class="error"> <?php echo isset($_SESSION['err']) ? $_SESSION['err'] : "";
                                        $_SESSION['err'] = ""; ?>
                    </p>

                </form>

            </div>


        </main>

    </div>


</body>

</html>
