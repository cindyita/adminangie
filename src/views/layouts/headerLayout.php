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
        var themeDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

        function applyTheme(dark) {
            if (dark) {
                document.documentElement.setAttribute("data-theme", "dark");
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.removeAttribute("data-theme");
                localStorage.setItem('theme', 'light');
            }
        }

        function toggleTheme() {
            const currentTheme = localStorage.getItem("theme");
            if (currentTheme === 'dark') {
                applyTheme(false);
            } else {
                applyTheme(true);
            }
        }

        if (localStorage.getItem("theme") === 'dark') {
            themeDark = true;
        } else if (localStorage.getItem("theme") === 'light') {
            themeDark = false;
        }
        
        applyTheme(themeDark);
        
    </script>

    <script src="./node_modules/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/required/dataTables/datatables.min.css">

    <link rel="stylesheet" href="./assets/required/metisMenu/metisMenu.css">
    <link rel="stylesheet" href="./assets/required/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="./assets/required/fontawesome/css/brands.min.css">
    <link rel="stylesheet" href="./assets/required/fontawesome/css/solid.min.css">

    <link rel="stylesheet" href="./assets/css/app.css?version=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="./assets/css/theme.css?version=<?php echo VERSION; ?>">

    <?php 
        if($styles){
            foreach ($styles as $value) {
                echo '<link href="'.$value.'?version='.VERSION.'" rel="stylesheet">';
            }
        }
    ?>

</head>
<body>

<div class="page-overlay">
    <div class="content">  
        <div class="loaderpage"></div>
        <div>Cargando..</div> 
    </div>
</div>

<div class="main page-container">
