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
                            <button type="submit" class="guzik" style="left:15%;">Zmiana hasła</button>
                        </div>
                    </form>
        </div>