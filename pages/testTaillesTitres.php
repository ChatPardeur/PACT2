<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test tailles titres</title>
    <link rel="stylesheet" href="/style/pages/detailOffre.css">
    <link rel="icon" href="../icones/favicon.svg" type="image/svg+xml">

</head>
<body class=<?php if ($comptePro)
            {
                echo "fondPro";
            }
            else
            {
                echo "fondVisiteur";
            } ?>>
    <h1>Titre de niveau 1 </h1>
    <h2>Titre de niveau 2</h2>
    <h3>Titre de niveau 3</h3>
    <h4>Titre de nivrau 4</h4>
    <h5>Titre de niveau 5</h5>

    <p id="lt">Large text</p>
    <p id="mt">Medium text</p>
    <p id="st">small text</p>

    <style>
        h2{
            font-size: var(--typescale-h2);
        }
        #lt{
            font-size: var(--typescale-large-text);
        }
        #mt{
            font-size: var(--typescale-medium-text);
        }
        #st{
            font-size: var(--typescale-small-text);
        }
    </style>


</body>
</html>