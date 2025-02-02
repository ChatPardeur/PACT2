<?php
    session_start(); // recuperation de la sessions

    // recuperation des parametre de connection a la BdD
    include('../php/connection_params.php');
    
    // connexion a la BdD
    $dbh = new PDO("$driver:host=$server;dbname=$dbname", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // force l'utilisation unique d'un tableau associat

    // cree $comptePro qui est true quand on est sur un compte pro et false sinon
    include('../php/verif_compte_pro.php');
    include('../php/verif_compte_membre.php');

    include('../php/verif_categorie.php');
    

    $user = null;
    if(key_exists("idOffre", $_GET))
    {
        // recuperation de id de l offre
        $idOffre =$_GET["idOffre"];
        
        // recuperation du contenu de l offre
        $contentOffre   = $dbh->query("select * from tripskell.offre_visiteur where idoffre='" . $idOffre . "';")->fetchAll()[0];
        $ouverture      = $dbh->query("select * from tripskell._ouverture where idoffre='" . $idOffre . "';")->fetchAll();
        $avis           = $dbh->query("select * from tripskell.avis where idoffre='" . $idOffre . "';")->fetchAll();
        $tags           = $dbh->query("select * from tripskell._possede where idoffre='" . $idOffre . "';")->fetchAll();

        $categorie = categorie($idOffre);
        
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>détail offre</title>

    <!-- Favicon -->
    <link rel="icon" href="../icones/favicon.svg" type="image/svg+xml">

    <link rel="stylesheet" href="/style/pages/detailOffre.css">
</head>
    <body  class=<?php                          //met le bon fond en fonction de l'utilisateur
                if ($comptePro)
                {
                    echo "fondPro";
                }
                else
                {
                    echo "fondVisiteur";
                }
        ?>>
        <?php
            // ajout du header
            include "../composants/header/header.php";
        ?>
        <div class="titrePortable">

            <svg width="401" height="158" viewBox="0 0 401 158" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_169_4380)">
            <ellipse cx="169.5" cy="61" rx="231.5" ry="89" fill="white"/>
            </g>
            <defs>
            <filter id="filter0_d_169_4380" x="-66" y="-28" width="471" height="186" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
            <feOffset dy="4"/>
            <feGaussianBlur stdDeviation="2"/>
            <feComposite in2="hardAlpha" operator="out"/>
            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_169_4380"/>
            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_169_4380" result="shape"/>
            </filter>
            </defs>
            </svg>

            <div>
                <img src="/images/logo/logo_grand.png" alt="logo grand" id="logoTitreMobile">
            </div>
        </div>
        <main class="mainDetail">
            <section class="conteneurOffreAvis">
                <section class="conteneurOffre">
                    <article class="offre">
                        <h1><?php echo $contentOffre["titreoffre"];?></h1>
                        <!-- <p>Visite</p> future categorie -->
                        <div class="conteneurSpaceBetween">
                            <div class="noteDetailOffre">
                                <div class="etoiles">
                                    <p><?php echo $contentOffre["note"];?></p> <!-- affichage de la note -->
                                    <?php
                                    //
                                    //  affichage de la note avec des etoiles
                                    //
                                        include "../php/etoiles.php";
                                    ?>
                                </div>
                                <!-- <p>38 avis</p> -->
                                <p> Catégorie : <span id="nomCat"><?php echo $categorie ; ?></span></p>
                            </div>
                            <div class="conteneurSVGtexte">
                                <img src="/icones/logoUserSVG.svg" alt="pro">
                                <p><?php echo $dbh->query("select raison_social from tripskell._professionnel as p where p.id_c='" . $contentOffre["id_c"] . "';")->fetchAll()[0]["raison_social"]; ?></p>
                            </div>
                        </div>
                        <div class="imgChg">
                            <!-- image de l'offre -->
                            <img src="/images/imagesOffres/<?php echo $contentOffre["img1"]; ?>" alt="" id="imageChangeante">
                        </div>
                        <div class="resumePrixDetailOffre">
                            <!-- Resume -->
                            <p><?php echo $contentOffre["resume"];?></p>
                            <hr>
                            <!-- Tarif minimal -->
                            <p>À partir de <?php echo $contentOffre["tarifminimal"];?>€/pers</p>
                        </div>

                        <!-- Offre detaille -->
                        <p id="descriptionOffre"><?php echo $contentOffre["description_detaille"]; ?></p>
                    
                        <div class="conteneurSpaceBetween" id="conteneurTagsHoraires">
                            <div id="partieTags">

                            <!-- tag -->

                                <div class="conteneurSVGtexte">
                                    <img src="/icones/tagSVG.svg" alt="icone tag">
                                    <h4>Tags</h4>
                                </div>
                                <hr> 
                                <div id="conteneurTagsOffre">
                                    <?php
                                    foreach($tags as $key => $tag){
                                        echo "<p class='tagOffre'>" . $tag["nomtag"] . "</p>";
                                    }
                                    ?>
                                </div>
                            </div> 
                            <div id="partieHoraires">
                                <div class="conteneurSVGtexte">
                                    <img src="/icones/horairesSVG.svg" alt="icone horaires">
                                    <h4>Horaires</h4>
                                </div>
                                <hr>
                                <!-- affichage horaires et jours d'ouverture -->
                                <div id="conteneurJoursOffre">
                                    <table>
                                    <tbody>
                                    <?php
                                        foreach($ouverture as $key => $value){
                                            $horaire = $dbh -> query("select * from tripskell._horaire as h join tripskell._ouverture as o on h.id_hor=". $ouverture[$key]["id_hor"] ." where o.idOffre=". $idOffre." and o.id_hor=". $ouverture[$key]["id_hor"] ." and o.id_jour='". $ouverture[$key]["id_jour"] ."';")->fetchAll();
                                    ?>
                                    <tr>
                                        <th><?php echo $ouverture[$key]["id_jour"]; ?></th>
                                        <td><?php echo $horaire[0]['horaire_matin_debut']; ?></td>
                                        <td><?php echo $horaire[0]['horaire_matin_fin']; ?></td>
                                        <?php
                                        if(($horaire[0]['horaire_aprem_debut'] != NULL)&&($horaire[0]['horaire_aprem_fin'] != NULL)){
                                        ?>
                                        <td><?php echo $horaire[0]['horaire_aprem_debut']; ?></td>
                                        <td><?php echo $horaire[0]['horaire_aprem_fin']; ?></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                    </table>
                                </div>
                                <div id="partieCategorie">
                                    <div class="conteneurSVGtexte">
                                        <!--<img src="/icones/.svg" alt="icone tag">-->
                                        <h4>Information supplémentaire</h4>
                                    </div>
                                    <hr>
                                    <?php //print_r($contentOffre); ?>
                                    <section id="secRestaurant" class="displayNone">
                                        <p>Gamme de prix :<span class="boldArchivo"> <?php echo $contentOffre['gammeprix']; ?></span></p>
                                        <a href="../images/imagesCarte/<?php echo $contentOffre['carte']; ?>" target="_blank"><img src="../images/imagesCarte/<?php echo $contentOffre['carte']; ?>" alt="Menu"></a>
                                    </section>

                                    <section id="secParcAttr" class="displayNone">
                                        <p>Nombre d'attraction : <span class="boldArchivo"><?php echo $contentOffre['nbattraction']; ?></span></p>
                                        <p>Âge minimal : <span class="boldArchivo"><?php echo $contentOffre['agemin']; ?> ans</span></p>
                                        <a href="../images/imagesPlan/<?php echo $contentOffre['plans']; ?>" target="_blank"><img src="../images/imagesPlan/<?php echo $contentOffre['plans']; ?>" alt="Plan"></a>
                                    </section>

                                    <section id="secSpec" class="displayNone">
                                        <p>Nombre de places maximum : <span class="boldArchivo"><?php echo $contentOffre['capacite']; ?></span></p>
                                        <?php
                                            $parts = explode(':', $contentOffre['duree_s']); // Divise en parties (hh, mm, ss)
                                            $formattedTime = $parts[0] . 'h ' . $parts[1] . 'm'; // Reformate
                                        ?>
                                        <p>Durée du spectacle : <span class="boldArchivo"><?php echo $formattedTime; ?></span></p>
                                    </section>

<?php

                                    $stmt = $dbh->prepare("select * from tripskell._possedeLangue where idoffre='" . $idOffre . "';");
                                    $stmt->execute();
                                    $result = $stmt->fetchAll();

                                    // Extraire les valeurs de la colonne "nomlangue"
                                    $langues = array_column($result, 'nomlangue');

                                    // Combiner les éléments en une seule chaîne séparée par des virgules
                                    $languesStr = implode(', ', $langues);


?>

                                    <section id="secVisite" class="displayNone">
                                        <p>Langue(s) de la visite :<br><span class="boldArchivo"><?php echo $languesStr; ?></span></p>
                                        <p>La visite <span class="boldArchivo"><?php ($contentOffre['guidee']) ? "" : "n'" ?>est <?php ($contentOffre['guidee']) ? "" : "pas" ?><?php echo $contentOffre['capacite']; ?> guidée</span>.</p>
                                        <?php
                                            $parts = explode(':', $contentOffre['duree_v']); // Divise en parties (hh, mm, ss)
                                            $formattedTime = $parts[0] . 'h ' . $parts[1] . 'm'; // Reformate
                                        ?>
                                        <p>Durée de la visite : <span class="boldArchivo"><?php echo $formattedTime; ?></span></p>
                                    </section>

                                    <section id="secAct" class="displayNone">
                                        <p><span class="boldArchivo">Prestation(s) proposée(s) :</span><br><?php echo $contentOffre['prestation']; ?></p>
                                        <p>Âge minimal : <span class="boldArchivo"><?php echo $contentOffre['ageminimum']; ?> ans</span></p>
                                        <?php
                                            $parts = explode(':', $contentOffre['duree_a']); // Divise en parties (hh, mm, ss)
                                            $formattedTime = $parts[0] . 'h ' . $parts[1] . 'm'; // Reformate
                                        ?>
                                        <p>Durée de l'activité : <span class="boldArchivo"><?php echo $formattedTime; ?></span></p>
                                    </section>

                                </div>
                            </div>
                        </div>
                        <div id="partieAdresse">
                            <div class="conteneurSVGtexte">
                                <img src="/icones/adresseSVG.svg" alt="icone tag">
                                <h4>Adresse</h4>
                            </div>
                            <hr>
                            <a href="https://www.google.fr/maps/place/<?php 
                                $adresse = $contentOffre["numero"] . " rue " . $contentOffre["rue"] . ", " . $contentOffre["ville"];

                                echo $adresse;
                            ?>"
                            class="conteneurSVGtexte" id="itineraire" target="_blank">
                                <p><?php
                                    echo($adresse);
                                ?></p>
                            </a>
                        </div>
                
                        
                    </article>
                </section>
                <h1>Avis</h1>
                <!-- Avis -->
                <section class="conteneurAvis">
                    <section class="conteneurBtn">
                        <div id="btnTrieDate" class="grossisQuandHover" onclick="trierDate()">
                            <img src="/icones/trierSVG.svg" alt="iconeDate" id="iconeTrieDate">
                            <img src="/icones/trier1SVG.svg" alt="iconeTrie" id="iconeTrieDate1" class="displayNone">
                            <img src="/icones/trier2SVG.svg" alt="iconeTrie" id="iconeTrieDate2" class="displayNone">
                            <p id="txtBtnDate">date</p>
                        </div> 
                    </section>
                    <?php
                        if(isset($_SESSION["idCompte"]) && $_SESSION["idCompte"] !== null && $compteMembre)
                        {   
                            //reagrde si le membre a déjà publié un avis pour l'offre
                            $avisDejaAjoute = false;
                            $stmt = $dbh->prepare("select * from tripskell._avis where id_c = " . $_SESSION["idCompte"] . 
                            " and idOffre = " . $_GET["idOffre"]);
                            $stmt->execute();
                            $result = $stmt->fetchAll();

                            if(sizeof($result) > 0)
                            {
                                $avisDejaAjoute = true;
                            }

                            ?>
                            <a <?php 
                                if(!$avisDejaAjoute)
                                {
                                    ?>
                                    href="creaAvis.php?idOffre=<?php echo $idOffre;?>";
                                    <?php
                                }
                            ?> id="btnAjouterAvis" 
                            class="grossisQuandHover <?php       //ajoute la classe btnAvisGrisé quand le memebre a déjà ajouté un avis
                                    if($avisDejaAjoute)
                                    {
                                        echo ("btnAjouterAvisGrise");
                                    }
                                ?>">
                                <img src="../icones/ajouterSVG.svg" alt="ajouter">
                                <h3>Ajouter un avis</h3>
                            </a>
                            <?php
                        }
                    ?>
                    <!-- Code pour un avis -->
                    <?php
                    $i=0;
                    foreach ($avis as $key => $avisM) {
                        $membre = $dbh->query("select * from tripskell.membre where id_c=" . $avis[$key]['id_c'] . ";")->fetchAll()[0];
                    ?>
                    <article id="Avis<?php echo $i?>" class="avis">
                        <!-- Date de publication-->
                        <p class="datePublication"><?php echo $avis[$key]['datepublication']?></p>
                        <!-- Information du membre -->
                         <div class="conteneurSpaceBetween">
                            <div class="conteneurMembreAvis">
                                    <img class="circular-image" src="../images/pdp/<?php echo $membre['pdp'] ?>" alt="Photo de profil" title="Photo de profil">
                                    <div class="infoMembreAvis">
                                        <h3><?php echo $membre['login'] ?></h3>
                                        <p>Visité le : <?php echo $avis[$key]['dateexperience']?></p>
                                        <p>Posté le : <?php echo $avis[$key]['datepublication']?></p>
                                        <p>Contexte : <?php echo $avis[$key]['cadreexperience']?></p>
                                    </div>
                            </div>
                            <div class="conteneurBtnGestionAvis">
                                <?php
                                    if(array_key_exists("idCompte", $_SESSION))
                                    {
                                        $idCompteConnecte = $_SESSION["idCompte"];
                                    }
                                    else
                                    {
                                        $idCompteConnecte = null;
                                    }
                                    
                                    if($avis[$key]["id_c"] == $idCompteConnecte)            //si cet avis a été publié par l'utilisateur connecté
                                    {
                                        ?>
                                            <div id="btnSupprimerAvis">
                                                <img src="../icones/supprimerSVG.svg" alt="icone supprimer">
                                                <p>Supprimer</p>
                                                <p hidden><?php echo $avis[$key]["id_avis"]?></p>
                                            </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- Titre de l'avis -->
                        <h3 class="titreAvis"><?php echo $avis[$key]['titreavis'] ?></h3>
                        <!-- Commentaire -->
                        <div class="conteneurAvisTexte">
                            <p class="texteAvis"><?php echo $avis[$key]['commentaire'] ?></p>
                        </div>
                        <!-- Image de l'avis -->
                        <?php
                        if($avis[$key]["imageavis"] != null){
                        ?>
                        <hr>
                        <div class="conteneurAvisImage">
                            <img src="/images/imagesAvis/<?php echo $avis[$key]['imageavis'] ?>" alt="image de l'avis">
                        </div>
                        <?php
                        }
                        ?>
                    </article>
                    <?php
                    $i++;
                    }
                    ?>
                </section>
            </section>
        </main>
        <?php                                                   
            // ajout du footer
            include "../composants/footer/footer.php";
        ?>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/detailOffre.js"></script>
    <!-- <script src="/js/scriptImageChangeante.js"></script> future carrousel d'image -->
</html>

<?php $dbh = null; // on ferme la connexion  ?>