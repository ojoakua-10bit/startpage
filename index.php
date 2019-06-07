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

$files = scandir(BACKGROUND_DIR);
$backgrounds = [];
foreach ($files as $file) {
    $token = explode('.', $file);
    $ext = $token[count($token) - 1];
    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
        array_push($backgrounds, $file);
    }
}

if (count($backgrounds) == 0) {
    $background = '#1b1b1b';
} else {
    if (count($backgrounds) > 1) {
        $background = $backgrounds[rand(0, count($backgrounds) - 1)];
    } else {
        $background = $backgrounds[0];
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
    <style>
        body {
            background: linear-gradient(to bottom, #80808080 0%, #202020a0 75%, #1b1b1b 100%), <?=$background?>;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="header-wrapper">
    <h1 class="main-header text-center"><?=$title?></h1>
</div>
<form id="search" action="https://www.google.com/search">
    <input placeholder="Search" class="lg-12 text-center" id="search-box" type="text" name="q">
</form>
<div class="favorites content-center">
    <?php
    foreach ($favorites as $favitem) {
        echo "<div class='fav-group lg-3 content-center'>";
        echo "<h3>$favitem->name</h3>";
        if (isset($favitem->base_url)) {
            $base_url = $favitem->base_url;
        } else {
            $base_url = '';
        }
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