<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="description" content="" />
    <meta property="locale" content="en_EN" />
	<meta property="title" content="" />
    <meta property="site_name" content="" />
    <title>admin ANGIE</title>
    <link rel="shortcut icon" href="./assets/img/system/favicon.png" type="image/PNG">

    <!-- Dark/light theme -->
    <script defer>
        // DARK/LIGHT THEME
        var themeDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    
        if (localStorage.getItem("theme") === 'dark') {
            themeDark = true;
        } else if (localStorage.getItem("theme") === 'light') {
            themeDark = false;
        }
        
        function toggleTheme() {
            if (themeDark) {
                localStorage.setItem('theme', 'dark');
                document.documentElement.setAttribute("data-theme", "dark");
                themeDark = false;
            } else {
                localStorage.setItem('theme', 'light');
                document.documentElement.setAttribute("data-theme", "light");
                themeDark = true;
            }
        }
        toggleTheme();
        // OPEN/CLOSE PANEL
        var openPanel = true;
        if (localStorage.getItem("panel") === 'open') {
            openPanel = true;
        } else if (localStorage.getItem("panel") === 'close') {
            openPanel = false;
        }
    </script>

    <script src="node_modules/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="./assets/css/app.css?version=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="./assets/css/theme.css?version=<?php echo VERSION; ?>">

    <?php 
        if($styles){
            foreach ($styles as $value) {
                echo '<link href="'.$value.'?version='.VERSION.'" rel="stylesheet">';
            }
        }
    ?>

    <link rel="stylesheet" href="node_modules/bulma/css/bulma.min.css">

</head>
<body>

<div class="page-overlay">
    <div class="content">  
        <div class="loaderpage"></div>
        <div>Cargando..</div> 
    </div>
</div>

<div class="main">
