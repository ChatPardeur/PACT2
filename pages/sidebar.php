<?php
include('../php/connection_params.php');
    
// Inclue la fonction qui verifie la catégorie d'une offre
// connexion a la BdD
$dbh = new PDO("$driver:host=$server;dbname=$dbname", $user, $pass);
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // force l'utilisation unique d'un tableau associat
?>

<html>
    <head>
        <link rel="stylesheet" href="/style/pages/sidebar.css">
    </head>
    <body>
        <aside>
            <div class="button-exit">
                <span>x</span>
            </div>
            <div class="content-aside">
                <fieldset class="status">
                    <legend>Ouverture du site</legend>
                    <label class="toggle-button">
                        <input type="checkbox" name="ouverture" value="ferme">
                        <span>Ouvert</span>
                    </label>
                    <label class="toggle-button">
                        <input type="checkbox" name="ouverture" value="ferme">
                        <span>Fermer</span>
                    </label>
                </fieldset>

                <fieldset class="categorie">
                    <legend>Categorie</legend>
                    <?php 
                    $cat = ["Restauration", "Parc", "Spectacle", "Activités", "Visite"];
                    foreach ($cat as $categorie) {?>
                        <label class="toggle-button">
                            <input type="checkbox" name="ouverture" value="ferme">
                            <span><?php echo $categorie; ?></span>
                        </label>
                    <?php }
                    ?>
                </fieldset>

                <fieldset class="prix">
                    <legend>Prix</legend>
                    <span class="price-value">0 €</span>
                    <input type="range" id="price" name="price" min="0" max="100" value="50" step="1">
                    <span class="price-value">100 €</span>
                </fieldset>

                <fieldset class="status">
                    <legend>Lieu</legend>
                    <div class="input-group">
                        <input id="lieu" type="text" name="lieu" placeholder="Commune / Lieu-dit">
                    </div>
                </fieldset>

                <fieldset class="categorie">
                    <legend>Categorie</legend>
                    <?php 
                    $stmt2 = $dbh->prepare("select DISTINCT tripskell._tags.nomTag from tripskell._tags");

                    $stmt2->execute();
                    $tags = $stmt2->fetchAll();
                    $tags = array_column($tags, 'nomtag');
                    foreach ($tags as $tag) {?>
                        <label class="toggle-button">
                            <input type="checkbox" name="ouverture" value="ferme">
                            <span><?php echo $tag; ?></span>
                        </label>
                    <?php }
                    ?>
                </fieldset>
            </div>
            


        </aside>
        <main>

        </main>
    </body>
</html>