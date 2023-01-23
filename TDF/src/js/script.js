function addArrayErrorMessage(id, message){
    //Passage du bloc en erreur
    document.getElementById(id).classList.add("error");

    //Ajoute du message d'erreur
    var errMessage = document.createElement("div");
    errMessage.classList.add("ui");
    errMessage.classList.add("error");
    errMessage.classList.add("message");
    errMessage.innerHTML = '<ul class="list">';
    for (var i = 0; i < message.length; i++){
        errMessage.innerHTML += '<li>'+message[i]+'</li>';
    }
    errMessage.innerHTML += '</ul>';
    document.getElementById(id).appendChild(errMessage);
}

function changement(evt){
    subButton = document.getElementById("subButton");
    subButton.value = "Envoyer";
    subButton.innerHTML = "Insérer le coureur";
    subButton.classList.remove("positive");
    evt.parentElement.classList.remove("error");
}

function erreurDoublon() {
    document.getElementById("nom_field").classList.add("error");
    document.getElementById("prenom_field").classList.add("error");
}

function getCoureurs(annee){
    const requete = new XMLHttpRequest();
    requete.open("GET", "src/php/ajax_participation.php?annee="+annee+"&val=coureur", true);
    requete.send();
    requete.onreadystatechange = function(){
        if (requete.readyState === 4 && requete.status === 200){
            document.getElementById("menuCoureur").innerHTML = requete.responseText;
            document.getElementById("coureur_field").hidden = false;
        }
    }
}

function getEquipes(annee){
    const requete = new XMLHttpRequest();
    requete.open("GET", "src/php/ajax_participation.php?annee="+annee+"&val=equipe", true);
    requete.send();
    requete.onreadystatechange = function(){
        if (requete.readyState === 4 && requete.status === 200){
            document.getElementById("menuEquipe").innerHTML = requete.responseText;
            document.getElementById("equipe_field").hidden = false;
        }
    }
}