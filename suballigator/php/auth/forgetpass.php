<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // Start session if not already started

echo'
    <form method="post" action="">
        <div class="card">
            <div class="card-body">
                <div class="form-control">
                    <p>
                        Veuillez entrer votre adresse email ci-dessous pour recevoir un lien de réinitialisation de mot de passe.
                    </p>
                    <label class="label">
                        <span class="label-text">Adresse courriel</span>
                    </label>
                    <input type="email" name="email" placeholder="Adresse courriel" class="input input-bordered" required>
                </div>
                <div class="form-control">
                    <button type="submit" name="forgetsubmit" class="btn btn-primary">Réinitialiser mon mot de passe</button>
                </div>
            </div>
        </div>
    </form>
    ';



if (isset($_POST['forgetsubmit'])){
    include_once '../php/util/conn.php';
    include_once '../php/util/pdo_oracle.php';

    // On récupère l'adresse mail
    $email = $_POST['email'];

    // On vérifie si l'adresse mail existe dans la base de données
    $sql = "SELECT initiatorEmail FROM Initiator WHERE initiatorEmail ='" . $email . "'";
    $sqlStatement = $mysqlConnection->prepare($sql);
    $sqlStatement->execute();
    $reqResult = $sqlStatement->fetchAll();



    if ( count($reqResult) > 0 ){
        // On envoie un mail à l'utilisateur avec un lien pour réinitialiser son mot de passe

        $from = "Sub'Alligators";
        $to = $email;
        $subject = "Réinitialisation de votre mot de passe";
        $message = "Bonjour, \n\nVous avez demandé à réinitialiser votre mot de passe. \n\nPour ce faire, veuillez cliquer sur le lien suivant : \n\nhttps://dev-sae301grp1.users.info.unicaen.fr/romaindev/html/resetpass.phtml?email=$email \n\nCordialement, \n\nL'équipe de SAE301";
        $headers = "From:" . $from;

        mail($to,$subject,$message, $headers);

        addNotif("success", "Réinitialisation", "Un email vous a été envoyé pour réinitialiser votre mot de passe.");

        echo '<script>window.location.href ="login.phtml";</script>'; //redirect to login
    } else {

        addNotif("danger", "$reqResult", "L'email : $email n'est pas enregistré dans la base de données.");
        echo '<script>window.location.href ="forgetpass.phtml";</script>'; //redirect to login
    }
}




?>



