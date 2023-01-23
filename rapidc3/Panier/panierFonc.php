<?php

function creerPanier(){
    if (!isset($_SESSION['panier'])){
        $_SESSION['panier']=array();
        $_SESSION['panier']['code'] = array();
        $_SESSION['panier']['prix'] = array();
        $_SESSION['panier']['qte'] = array();
        $_SESSION['panier']['modif'] = true;
    }
    return true;
}

function supprimePanier(){
    unset($_SESSION['panier']);
}


function supprimerArticle($code, $qte){
    modifierQuantite($code, $qte);
}



function ajouterArticle($code, $prix, $qte){

    if (creerPanier() && peutModif())
    {

        $position = array_search($code, $_SESSION['panier']['code']);

        if ($position !== false)
        {
            $_SESSION['panier']['qte'][$position] += $qte;
        }
        else
        {
            array_push( $_SESSION['panier']['code'],$code);
            array_push( $_SESSION['panier']['qte'],$qte);
            array_push( $_SESSION['panier']['prix'], $prix);
        }
    }
}


function ajouterQte($code){

    for ($i = 0; $i < count( $_SESSION['panier']['code']); $i++){
        if ( $code == $_SESSION['panier']['code'][$i]){
            return  $_SESSION['panier']['qte'][$i] += 1;
        }
    }
}

function enleveQte($code){

    for ($i = 0; $i < count( $_SESSION['panier']['code']); $i++){
        if ( $code == $_SESSION['panier']['code'][$i]){
            $qte =  $_SESSION['panier']['qte'][$i] -= 1;
            if ($qte == 0){
                supprimerArticle($code, $qte);
            }
            else{
                return $qte;
            }
        }
    }

}

function modifierQuantite($code,$qte){

    if (creerPanier() && peutModif())
    {

        if ($qte >= 1)
        {
            $position = array_search($code,  $_SESSION['panier']['code']);

            if ($positionProduit !== false)
            {
                $_SESSION['panier']['qte'][$position] = $qte ;
            }
        }
        else {
            $tmp=array();
            $tmp['code'] = array();
            $tmp['qte'] = array();
            $tmp['prix'] = array();
            $tmp['modif'] = $_SESSION['panier']['modif'];

            for($i = 0; $i < count($_SESSION['panier']['code']); $i++)
            {
                if ($_SESSION['panier']['code'][$i] !== $code)
                {
                    array_push( $tmp['code'],$_SESSION['panier']['code'][$i]);
                    array_push( $tmp['qte'],$_SESSION['panier']['qte'][$i]);
                    array_push( $tmp['prix'],$_SESSION['panier']['prix'][$i]);
                }

            }
            $_SESSION['panier'] =  $tmp;
            unset($tmp);
        }
    }
}


function somme(){
    $total = 0.0;
    if (isset($_SESSION['panier'])){
        for($i = 0; $i < count($_SESSION['panier']['code']); $i++)
        {
            $total += ((float) $_SESSION['panier']['qte'][$i]) * (floatval(str_replace(',','.',substr($_SESSION['panier']['prix'][$i], 0, strlen($_SESSION['panier']['prix'][$i])-4)))); //€ -> strlen = 3	
		}
		
    }
    return (float) $total;
}

function peutModif(){
    if (isset($_SESSION['panier']) && $_SESSION['panier']['modif']) return true;
    else return false;
}

?>