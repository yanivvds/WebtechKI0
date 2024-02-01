<?php
    require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scraped Articles</title>
    <link rel="stylesheet" href="/css/stylesheet.css"> 
    <link rel="icon" type="image/x-icon" href="/fotos/favicon.ico">
</head>
<body style="background: #f6ede3;">
    <div>
        <?php require_once("navbar.php"); ?>
    </div>
    <div class="title">
        <h1 style="text-align: center; color: #986e43 margin: 0em 1em; padding: 0 1em; font-size: 49px;">Scraped Articles</h1>
    </div>
    <div class="articles">
        <?php
            // Read the scraped data from the file
            $filePath = 'artikel_data.txt';
            $fileContent = file_get_contents($filePath);

            // Explode the content into an array
            $articles = explode("\n", $fileContent);

            // Loop through the articles and display them
            for ($i = 0; $i < count($articles); $i += 3) {
                $title = $articles[$i];
                $link = $articles[$i + 1];
                $imageUrl = $articles[$i + 2];

                echo '<a href="' . $link . '" target="_blank">';
                echo '<div class="article">';
                echo '<img src="' . $imageUrl . '" alt="' . $title . '">';
                echo '<p>' . $title . '</p>';
                echo '</div>';
                echo '</a>';
            }
        ?>
    </div>
    <div style="z-index: 10;min-height: 0%;margin-top: 42%;position: absolute;bottom: 0;left: 0;width: 100%;position: relative;flex: 1;">
        <?php require_once("footer.php"); ?>
    </div>
</body>
</html>