<?php
require_once('init.php');

$tab = array();

//arrive en $_POST les paramètres envoyés par JS
switch($_POST['action']){
    case 'getUsers':
            $expiration = date('Y-m-d H:i:s',time()-(30*60));
            $users = goSQL("SELECT * FROM users WHERE date_activite >=:expiration",array(
                'expiration' => $expiration
            ));
            $tab['nbUsers'] = $users->rowCount();
            if($users->rowCount() > 0){
                $tab['users'] = $users->fetchAll();
            }
            goSQL("UPDATE users SET date_activite = NOW() WHERE id_user=:id_user", array(
                'id_user' => $_SESSION['user']['id_user']
            ));
        break;

    case 'getLastId':
            $requete = goSQL("SELECT MAX(id_message) AS maxID FROM messages");
            $lastid = $requete->fetch();

            if(!isset($_SESSION['lastID'])) $_SESSION['lastID'] = $tab['lastID'];

            $tab['lastID'] = (is_null($lastid['maxID'])) ? 0 : $lastid['maxID'];
        break;

    case 'getMessages':
            $messages = goSQL("SELECT m.*,u.login,u.avatar FROM messages m
            INNER JOIN users u ON u.id_user = m.id_user
            WHERE id_message > :lastID",array(
                'lastID' => $_POST['lastID']
            ));
            $tab['nbMessages'] = $messages->rowCount();
            if($tab['nbMessages'] > 0){
                $tab['messages'] = $messages->fetchAll();
            }
        break;
    
    case 'addMessage':
            goSQL("INSERT INTO messages VALUES(NULL, :id_user, :message, NOW())", array(
                'id_user' => $_SESSION['user']['id_user'],
                'message' =>$_POST['message']
            ));
        break;

    case 'getIdMemoire':
            $tab['idMemoire'] = $_SESSION['lastID'];
        break;

        case 'userProfile':
            
            $user = goSQL("SELECT * FROM users WHERE id_user=:id_user", array(
                'id_user' => $_SESSION['user']['id_user']
            ));
            $tab['nbUsers'] = $user->rowCount();
            if($user->rowCount() == 1){
                $tab['user'] = $user->fetchAll();

            }
        break;

    case 'update':

        break;

}


echo json_encode($tab);//ce qui va arriver dans datas coté js+