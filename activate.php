<?php
require_once("./classes/LoginClass.php");

if (isset($_GET['idKlant']) && isset($_GET['email']) && isset($_GET['password'])) {
    if (LoginClass::check_if_activated($_GET['email'], $_GET['password'])) {
        $action = "index.php?content=activate&idKlant=" . $_GET['idKlant'] . "&email=" . $_GET['email'] . "&password=" . $_GET['password'];

        if (LoginClass::check_if_email_password_exists($_GET['email'], $_GET['password'], '0')) {
            if (isset($_POST['submit'])) {
                // 1. Check of de twee ingevoerde passwords correct zijn.
                if (!strcmp($_POST['password_1'], $_POST['password_2'])) {
                    // 2. Activeer het account en update het oude password naar het nieuwe password.
                    LoginClass::activate_account_by_id($_GET['idKlant']);

                    LoginClass::insert_betaal_methode($_GET['idKlant'], $_POST['betaalMethodeKiezen']);
                    LoginClass::insert_actie_keuze($_GET['idKlant'], $_POST['actieKeuzeKiezen']);

                    header("refresh:4;url=index.php?content=inloggen_Registreren");
                    echo "<h3 style='text-align: center;' >Uw wachtwoord is succesvol gewijzigd.</h3>";
                    LoginClass::update_password($_GET['idKlant'], $_POST['password_1']);
                } else {
                    header("refresh:4;url=" . $action);
                    echo "<h3 style='text-align: center;' >Wachtwoorden komen niet overeen, probeer het nog een keer.</h3>";
                }
            } else {
                echo "<h3 style='text-align: center;' >Uw account wordt geactiveerd.<br>
								Kies een nieuw password</h3><br>";
                ?>
                <div class="section">
                    <div class="container">
                        <form action="<?php echo $action; ?>" method='post' style="width: 50%;">
                            <div class="form-group"><label class="control-label" for="password_1">Typ hier uw nieuwe
                                    wachtwoord</label>
                                <input class="form-control" id="password_1" placeholder="Wachtwoord" type="password"
                                       name="password_1" required></div>

                            <div class="form-group"><label class="control-label" for="password_2">Typ nogmaals uw
                                    wachtwoord (controle)</label>
                                <input class="form-control" id="password_2" placeholder="Wachtwoord" type="password"
                                       name="password_2" required></div>
                            <input type='hidden' name='idKlant' value='<?php echo $_GET['idKlant']; ?>'/>
                            <br>
                            <div class="form-group"><label class="control-label" for="betaalMethodeKiezen">Betaalmethode:</label>
                                <select name="betaalMethodeKiezen" class='form-control' required>
                                    <option value="iDeal">iDeal</option>
                                    <option value="PayPal">PayPal</option>
                                    <option value="Creditcard">Creditcard</option>
                                </select>
                            </div>
                            <div class="form-group"><label class="control-label" for="actieKeuzeKiezen">Wilt u meedoen aan speciale acties?</label>
                                <br><input type="radio" name="actieKeuzeKiezen" value="1"> Ja
                                <br><input type="radio" name="actieKeuzeKiezen" value="0"> Nee
                            </div>
                            <button type="submit" name="submit" style="float: none;" class="btn btn-primary">Verstuur</button>
                    </div>
                    <br>

                    </form>
                </div>
                </div>
                <?php
            }
        } else {
            header("refresh:4;url=index.php?content=inloggen_Registreren");
            echo "<h3 style='text-align: center;' >U heeft geen rechten op deze pagina. Uw email/password combi is niet correct of uw account is al geactiveerd. U wordt doorgestuurd naar de registratiepagina</h3>";
        }
    } else {
        header("refresh:4;url=index.php?content=inloggen_Registreren");
        echo "<h3 style='text-align: center;' >Uw account is all geactiveerd of uw email/password combi is niet correct u heeft daarom geen rechten op deze pagina. U wordt doorgestuurd naar de registratiepagina</h3>";
    }
} else {
    header("refresh:4;url=index.php?content=inloggen_Registreren");
    echo "<h3 style='text-align: center;' >Uw url is niet correct en daarom heeft u geen rechten op deze pagina. U wordt doorgestuurd naar de registratiepagina</h3>";
}
?>