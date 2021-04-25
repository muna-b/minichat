<?php

require_once('inc/init.php');

//si je suis deja connecté
if(isConnected()){
    header('location:'.URLSITE);
    exit();
}

//Traitements PHP
if(!empty($_POST)){
    // var_dump($_POST);
    // var_dump($_FILES);

    $errors = array();
    if(empty($_POST['login'])){
        $errors[] = 'Merci de saisir un login';
    }else{
        //controler l'unicité du login
        if(getUserByLogin($_POST['login']))
        {
            $errors[] = "Login déja utilisé, merci d'en choisir un autre";
        }
        $pattern ='#^(?=.*[a-z])(?=.*[0-9])[a-zA-Z0-9][\w]{8,20}$#';
        //[\w]minuscule majuscule chiffre + underscore
        //#^ouverture et $#fermeture de l'expression reguliere
        if(!preg_match($pattern, $_POST['password'])){
            $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une lettre et un chiffre.";
        }
       
    }
    if(empty($_POST['password'])){
        $errors[] = 'Merci de saisir un mot de passe';
    }
    if(empty($_POST['email'])){
        $errors[] = 'Merci de saisir une adresse email';
    }
    else{
        if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Adresse mail incorrecte';
        }
    }
    if(empty($_FILES['avatar']['name'])){
        $errors[]= "Merci de choisir un avatar";
    }
    if(empty($errors)){
        //Aucune erreur recontrée jusque la 

        //Controle du type du fichier
        $mime_autorises = ['image/jpeg', 'image/png'];
        if(!in_array($_FILES['avatar']['type'], $mime_autorises)){
            $errors[] = 'Format de fichier incorrect. JPEG ou PNG uniquement';
        }else
        //copie physique du fichier dansle repertoire des avatars
        $nomfichier = $_POST['login']. '_'.$_FILES['avatar']['name'];
        $chemin = $_SERVER['DOCUMENT_ROOT'] . URLSITE . 'avatars/';
        move_uploaded_file($_FILES['avatar']['tmp_name'],$chemin.$nomfichier);

        //Insersion de l'utilisateur en DB
        goSQL("INSERT INTO users VALUES (NULL, :login, :password, :email, :avatar, NOW())", array(
            'login' => $_POST['login'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'email' => $_POST['email'],
            'avatar' => $nomfichier,
        ));

        //Redirection vers la connexion OU auto connexion
        header('location:'.URLSITE.'connexion.php');
        exit();//stopper le script php

    }
}

$title = 'Inscription';
require_once('inc/header.php');
//Coeur de page
?>
<div class="row">
    <div class="col-md-6 offset-md-3 mt-5 text-light">
        <h1>S'inscrire au au tchat</h1>
        <?php if(!empty($errors)) : ?>
            <div class="alert alert-danger"><?php echo implode('<br>', $errors) ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="my-3" action="">
            <div class="form-group">
                <input type="text" name="login" class="form-control" placeholder="login" value="<?php echo $_POST['login'] ?? '' ?>">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="email@dm.me" value="<?php echo $_POST['email'] ?? '' ?>">
            </div>
            <div class="form-group text-center">
                <input type="file" id="avatar" name="avatar" class="d-none" accept="image/jpeg,image/png">
                <label for="avatar"> <img id="preview" alt="avatar" src="https://dummyimage.com/300x300&text=Choisir un avatar" class="img-fluid"> </label>
            </div>

            <button type="submit" class="btn btn-primary d-block mx-auto">S'inscrire</button>

        </form>
    </div>

</div>

<?php

require_once('inc/footer.php');