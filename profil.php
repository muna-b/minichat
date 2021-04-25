<?php

require_once('inc/init.php');

//si je ne suis pas connecté, je suis invité a le faire en étant redirigé vers la page de connexion
if(!isConnected()){
    header('location:'.URLSITE.'connexion.php');
    exit();
}

//Traitements PHP
$title = 'Profil';
require_once('inc/header.php');

//Coeur de page
?>
<div class="row">
    <div class="col-md-6 offset-md-3 my-5 text-light" id="profile">
        <h1 class="text-center">[<?php echo ucfirst($_SESSION['user']['login']) ?>]</h1>
        
        <div class="card text-light bg-dark" id="cardProfile" style="width: 30rem;">
           
        </div>

    </div>
</div>
<?php
require_once('inc/footer.php');