<div>
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
    <script defer type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script defer nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="/system/pages/header/style.css">
    <link rel="stylesheet" href="/system/pages/header/header.css">
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
