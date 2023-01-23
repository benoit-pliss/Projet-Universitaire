<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // Start session if not already started

if (isset($_GET)){
    echo '
        <form method="post" action="">
            <div class="card">
                <div class="card-body">
                    <div class="form-control">
                         <label class="label">Nouveau mot de passe</label>
                         <input class="input input-bordered" type="password" name="newpass" id="newpass" placeholder="Nouveau Mot de passe" required>
                        
                         <label class="label">Confirmer le nouveau mot de passe</label>
                         <input class="input input-bordered" type="password" name="confirmpass" id="confirmpass" placeholder="Confirmer le Mot de passe" required>
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit" name="resetpass">Modifier mon mot de passe</button>
                    </div>
                </div>
            </div>
        </form>
    ';

    if (isset($_POST['resetpass'])){
        include_once '../php/util/conn.php';
        include_once '../php/util/pdo_oracle.php';

        // On récupère l'adresse mail
        $email = $_GET['email'];

        // On vérifie si l'adresse mail existe dans la base de données
        $sql = "SELECT initiatorEmail FROM Initiator WHERE initiatorEmail =':email'";
        $sqlStatement = $mysqlConnection->prepare($sql);
        $sqlStatement->bindParam(':email', $email);
        $sqlStatement->execute();
        $reqResult = $sqlStatement->fetchAll();

        if ( count($reqResult) == 0 ){
            // on verifie que les deux mots de passe sont identiques
            if ($_POST['newpass'] == $_POST['confirmpass']){

                $email = $_GET['email'];
                $newpass = $_POST['newpass'];


                // On met à jour le mot de passe dans la base de données
                $sql = "UPDATE Initiator SET initiatorPassword ='" . $newpass . "' WHERE initiatorEmail ='" . $email . "'";
                $sqlStatement = $mysqlConnection->prepare($sql);
                $res = $sqlStatement->execute();




                if ($res){
                    addNotif("success", "Réinitialisation", "Votre mot de passe a bien été modifié. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.");
                    echo '<script>window.location.href = "login.phtml";</script>';
                } else {
                    addNotif("error", "Réinitialisation", "Une erreur est survenue lors de la modification de votre mot de passe. Veuillez réessayer.");
                    echo '<script>window.location.href = "resetpass.phtml?email='. $email . '";</script>';
                }
            } else {
                addNotif("error", "Mot de passe", "Attention les mots de passe ne sont pas identiques");
                echo '<script>window.location.href = "resetpass.phtml?email='. $email . '";</script>';
            }
        } else {
            addNotif("danger", "Réinitialisation", "L'adresse email n'existe pas.");
            echo '<script>window.location.href = "resetpass.phtml?email='. $email . '";</script>';
        }

    }


} else {
    addNotif("error", "Lien invalide", "Le lien que vous avez utilisé n'est pas valide.");
    echo '<script>window.location.href ="index.phtml";</script>'; //redirect to index
    exit();
}

