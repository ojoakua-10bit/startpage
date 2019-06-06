<?php
/**
 * Created by PhpStorm.
 * User: anon
 * Date: 6/6/19
 * Time: 4:19 AM
 */

define('CONFIG_FILE', 'config.json');
define('DEFAULT_CONFIG_FILE', 'config.example.json');
define('BACKGROUND_DIR', 'img/backgrounds/');

if (file_exists(CONFIG_FILE)) {
    $jsonConfig = file_get_contents(CONFIG_FILE);
} else {
    $jsonConfig = file_get_contents(DEFAULT_CONFIG_FILE);
}

$config = json_decode($jsonConfig);
$title = $config->title;
$backend = $config->background_backend;
$engine = $config->default_search_engine;
$favorites = $config->favorites;

$backgrounds = scandir(BACKGROUND_DIR);
if (count($backgrounds) <= 2) {
    $background = '#1b1b1b';
} else {
    $data = array_slice($backgrounds, 2);
    if (count($data) > 1) {
        $background = $data[rand(0, count($data) - 1)];
    } else {
        $background = $data[0];
    }
}

if ($background[0] !== '#') {
    $background = 'url(\''.BACKGROUND_DIR.rawurlencode($background).'\')';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ojoakua | Start Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Kosugi+Maru&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body style="background: <?=$background?>">
<div class="header-wrapper">
    <h1 class="main-header japanese-text"><?=$title?></h1>
</div>
<form id="search" action="https://www.google.com/search">
    <input placeholder="Search" id="search-box" type="search" name="q">
</form>
<div>
    <?php
    foreach ($favorites as $favitem) {
        echo "<h3>$favitem->name</h3>";
        if (isset($favitem->base_url)) {
            $base_url = $favitem->base_url;
        } else {
            $base_url = '';
        }
        echo "<div>";
        foreach ($favitem->links as $link) {
            echo "<div><a href='".$base_url.$link->url."'>$link->name</a></div>";
        }
        echo "</div>";
    }
    ?>
</div>
<footer>
    <div id="time"></div>
</footer>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>