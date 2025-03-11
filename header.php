<div>
<script defer type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script defer nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<link rel="stylesheet" href="header.css">
<link rel="shortcut icon" href="assets/FAVICON.svg" type="image/x-icon">
        <div class="navbar-container">
            <span>
                <ion-icon name="person"></ion-icon>
                <span><?php echo $_SESSION["username"];?></span>              
            </span>
            <nav>
            <span>
                    <a href="system.php">
                        <ion-icon name="home"></ion-icon>
                        <span class="hover">Strona główna</span>
                    </a>
                </span>
                <span>
                    <a href="password_change.php">
                        <ion-icon name="key"></ion-icon>
                        <span class="hover">Zmiana hasła</span>
                    </a>
                </span>
                <span style="margin-right:1rem;">
                    <a href="logout.php">
                        <ion-icon name="exit"></ion-icon>
                        <span class="hover">Wyloguj</span>
                    </a>
                </span>
            </nav>
        </div>
</div>