<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="description" content="" />
    <meta property="locale" content="en_EN" />
	<meta property="title" content="" />
    <meta property="site_name" content="" />
    <title>página by cindyita</title>

    <link rel="stylesheet" href="./assets/css/app.css?version=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="./assets/css/theme.css?version=<?php echo VERSION; ?>">

    <?php 
        if($styles){
            foreach ($styles as $value) {
                echo '<link href="'.$value.'?version='.VERSION.'" rel="stylesheet">';
            }
        }
    ?>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="node_modules/bulma/css/bulma.min.css">

</head>
<body>

<div class="page-overlay">
    <div class="content">
        <div class="loader"></div>
    </div>
</div>

<div class="main">
