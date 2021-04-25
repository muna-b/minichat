<?php

require_once('inc/init.php');

//Traitements PHP
$title = 'Accueil';
require_once('inc/header.php');

//Coeur de page
?>
<div class="row">
    <div class="col text-light">
        <h1 class="text-center">Simple Tchat</h1>
        <hr>
        <?php if(isConnected()) : ?>
            <!-- fenetre du tchat -->
            <div class="row">
                <div class="col-md-9 border border-light p-3" id="conversation"></div>
                <div class="col-md-3 border border-light p-3" id="users"></div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <form method="post" id="formulaire">
                        <div class="form-group">
                        <input type="text" class="form-control" id="phrase">
                        </div>
                    </form>
                </div>
            </div>

        <?php else : ?>
            <p class="display-1">Pour acceder a ce tchat vous devez être connecté. Merci de vous <a href="<?php echo URLSITE ?>inscription.php">inscrire </a> ou vous <a href="<?php echo URLSITE ?>inscription.php">connecter </a> si vous avez deja un compte.</p>
        <?php endif; ?>
    </div>
</div>

<?php

require_once('inc/footer.php');