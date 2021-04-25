<?php

//fonction qui permets d'entrer en session si la connexion est réussi
function isConnected(){

    return (isset($_SESSION['user']));
}

//Fonction qui traite les requetes SQL
function goSQL($sql, $params = array()){
    //rendre la variable globale pdo accessible
    global $pdo;

    if(!empty($params)){
        foreach($params as $key => $value){
            $params[$key] = htmlspecialchars($value);
        }
    }
    $requete = $pdo->prepare($sql);
    $requete->execute($params);

    return $requete;
}

//Fonction qui renvoie les infos d'un user a partir de son login
function getUserByLogin($login){
    $user = goSQL("SELECT * FROM users WHERE login=:login",array('login'=>$login));
    if($user->rowCount() == 1){
        return $user->fetch();
    }else{
        return false;
    }
}