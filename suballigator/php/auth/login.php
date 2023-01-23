<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // Start session if not already started
/**
 * @param $data : data to check
 * @return $data : data checked
 */
function checkData($data)
{ // Function to avoid sql injection
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
echo '
    <form method="post" class="flex flex-col items-center justify-center">
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Mail</span>
            </label>
            <input type="mail" class="input input-bordered w-full max-w-xs" placeholder="Mail" name="mail" id="mail" value="fabienne.jort@unicaen.fr" required /><br/>
        </div>
        <div class="form-control w-full max-w-xs">
            <label class="label">
                <span class="label-text">Mot de passe</span>
            </label>
            <input type="password" class="input input-bordered w-full max-w-xs" placeholder="Mot de passe" name="pass" id="pass" value="aVeryGood_PassW0rd" required /><br/>
        </div>
        <div id="forgetpass">
            <button type="submit" name="forgetpass">Mot de passe oublié ?</button>
        </div>
            <span id="errorconn" style="color: darkred" class="t-error"></span><br/>
            <button class="btn btn-active btn-primary" type="submit" name="submit">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
            Se connecter
            </button>
    </form>';

if (isset($_POST['submit'])) {
    if (!empty($_POST['mail']) && !empty($_POST['pass'])) {
        try {
            $pdo = new PDO('mysql:host=localhost;port=54800;dbname=sae301grp1_bd', $mysql_user, $mysql_pass); // Database connection
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
        $mail = checkData($_POST['mail']);
        $pass = checkData($_POST['pass']);
        $sql = "SELECT * FROM Initiator where initiatorEmail = '$mail' and initiatorPassword = '$pass'";
        $ps = $pdo->prepare($sql);
        $ps->execute();
        $nbLine = $ps->rowCount();
        $reqResult = $ps->fetchAll(); //Data extraction
        $validID = false;
        if (!($nbLine != 1)) {
            print_r($reqResult[0]);
            if ($reqResult[0]['initiatorEmail'] == $mail && $reqResult[0]['initiatorPassword'] == $pass) { // checks if the identifiers of the user extracted from the database are the same as those entered
                if ($reqResult[0]['initiatorDeleted'] == 0) { // Checks if the user is active

                    $_SESSION['initiatorId'] = $reqResult[0]['initiatorId'];
                    $_SESSION['initiatorName'] = $reqResult[0]['initiatorName'];
                    $_SESSION['initiatorEmail'] = $reqResult[0]['initiatorEmail'];
                    $_SESSION['initiatorIsDirector'] = $reqResult[0]['initiatorIsDirector'];
                    $_SESSION['levelId'] = $reqResult[0]['levelId'];

                    $sql = "select InitiatorId from TrainingManager where InitiatorId = :initiatorId";
                    $sqlStatement = $pdo->prepare($sql);
                    $sqlStatement->bindParam(':initiatorId', $_SESSION['initiatorId']);
                    $sqlStatement->execute();
                    $all = $sqlStatement->fetchAll();

                    if (count($all) == 0) {
                        $_SESSION['initiatorIsManager'] = 0;
                    } else {
                        $_SESSION['initiatorIsManager'] = 1;
                    }

                    echo '<script>window.location.href ="../index.php";</script>'; //redirect to index
                    exit();
                } else {
                    echo '<script>
                        document.getElementById("errorconn").innerHTML="Utilisateur supprimé";
                      </script>';
                }
            } else {
                echo '<script>
                        document.getElementById("errorconn").innerHTML="Identifiant ou mot de passe incorrect";
                      </script>';
            }
        } else {
            echo '<script>
                        document.getElementById("errorconn").innerHTML="Identifiant ou mot de passe incorrect";
                      </script>';
        }
    }
}  else if(isset($_POST['forgetpass'])){
    echo '<script>window.location.href ="forgetpass.phtml";</script>';
}
