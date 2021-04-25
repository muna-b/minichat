<?php

require_once('inc/init.php');

//Gérer la déconnexion
if(isset($_GET['action']) && $_GET['action'] == 'deco'){

    goSQL("UPDATE users SET date_activite = '2000-01-01 00:00:00' WHERE id_user=:id_user", array(
        'id_user' => $_SESSION['user']['id_user']
    ));

    session_destroy();//détruit la session(cela prend effet à la fin du script)
    header('location:'.URLSITE.'connexion.php');
    exit();
}

//si je suis deja connecté
if(isConnected()){
    header('location:'.URLSITE);
    exit();
}

//Traitements PHP
if(!empty($_POST)){
    $errors = array();
    if(empty($_POST['login'])){
        $errors[] = 'Merci de saisir un login';
    }

    if(empty($_POST['password'])){
        $errors[] = 'Merci de saisir un mot de passe';
    }
    if(empty($errors)){
        //tout est ok
        if ($user = getUserByLogin($_POST['login'])){
            //User trouvé en DB
            if(password_verify($_POST['password'], $user['password'])){
                //mot de passe correct
                goSQL("UPDATE users SET date_activite=NOW() WHERE id_user=:id_user", array(
                    'id_user' => $user['id_user']
                ));
                $_SESSION['user'] = $user;
                header('location:'.URLSITE);
                exit();
                
            }else{
                $errors[] = 'Erreur sur les identifiants 2';//mauvais password
            }
        }else{
            $errors[] = 'Erreur sur les identifiants 1';//mauvais login
        }
    }
}
$title = 'Connexion';
require_once('inc/header.php');

//Coeur de page
?>

<div class="row">
    <div class="col-md-6 offset-md-3 mt-5 text-light">
        <h1>Se connecter au tchat</h1>
        <?php if(!empty($errors)) : ?>
            <div class="alert alert-danger"><?php echo implode('<br>', $errors) ?></div>
        <?php endif; ?>
        <form method="post" class="my-3">
            <div class="form-group">
                <input type="text" name="login" class="form-control" placeholder="login" value="<?php echo $_POST['login'] ?? '' ?>">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe">
            </div>
            <button type="submit" class="btn btn-primary d-block mx-auto">Se connecter</button>
        </form>
    </div>
</div>

<?php
require_once('inc/footer.php');