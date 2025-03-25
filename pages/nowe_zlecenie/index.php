<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <title>Dodawanie zlecenia</title>
  <link rel="stylesheet" href="nowe_zlecenie.css">
</head>

<body>
  <div class="main-container panel-container">
    <main class="panel">
      <?php include '../header/header.php' ?>
      <div class="main-menu-container">
        <div class="form-container">
          <form action="new_order.php" method="post">
            <div class="group-one">
              <textarea name="firma" placeholder="  Firma"></textarea> </br>
            </div>
            <div class="group-two">
              <input type="text" name="osoba" placeholder="  Osoba"></input>
              <textarea type="textarea" name="urzadzenie" placeholder="  Urządzenie"></textarea>
            </div>
            <div class="group-three">
              <input type="tel" name="telefon" placeholder="Telefon"></input><br />
              <?php
              require_once "../config.php";

              // Fetch "gwarancje" options securely
              $sql = "SELECT idGwarancji, nazwa FROM gwarancje";
              $stmt = $link->prepare($sql);
              $stmt->execute();
              $result = $stmt->get_result();
              ?>
              <label for="gwarancja">Gwarancja</label>
              <select name="gwarancja">
                <?php while ($row = $result->fetch_assoc()): ?>
                  <option value="<?= htmlspecialchars($row["idGwarancji"], ENT_QUOTES, 'UTF-8'); ?>">
                    <?= htmlspecialchars($row["nazwa"], ENT_QUOTES, 'UTF-8'); ?>
                  </option>
                <?php endwhile; ?>
              </select>

              <?php
              $stmt->close();

              // Fetch "elektronik" options securely
              $sql = "SELECT idElektronika, nazwa FROM uzytkownicy WHERE uprawnienia = 'elektronik'";
              $stmt = $link->prepare($sql);
              $stmt->execute();
              $result = $stmt->get_result();
              ?>
              <label for="elektronik">Elektronik</label>
              <select name="elektronik"><?php if(!$result->fetch_assoc()){
                echo "<option>Brak elektroników</option>";
              }?>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <option value="<?= htmlspecialchars($row["idElektronika"], ENT_QUOTES, 'UTF-8'); ?>">
                    <?= htmlspecialchars($row["nazwa"], ENT_QUOTES, 'UTF-8'); ?>
                  </option>
                <?php endwhile; ?>
              </select>

              <?php
              $stmt->close();
              $link->close();
              ?>

            </div>


        </div>
        <button type="submit">Dodaj zlecenia <br> <p style="color:red;"> <?php echo isset($_SESSION['err']) ? $_SESSION['err'] : "" ;
          $_SESSION['err']= "";?>
          </p></button>
        
        </form>
        
    </main>
    
  </div>
  
</body>

</html>