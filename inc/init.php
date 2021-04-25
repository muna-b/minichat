<?php
//Définition du fuseau horraire
date_default_timezone_set('Europe/Paris');

//Ouverture de session
session_start();

//Connexion à la BDD
$pdo = new PDO(
    'mysql:host=localhost;charset=utf8;dbname=tchat',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    )
);

//Définition de constante
define('URLSITE', '/ajax/C-projet-tchat/');

//Inclusion du fichier de fonctions
require_once('functions.php');
