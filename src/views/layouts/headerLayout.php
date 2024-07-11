<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="description" content="" />
    <meta property="locale" content="en_EN" />
	<meta property="title" content="" />
    <meta property="site_name" content="" />
    <title><?php echo $_SESSION['MYSESSION']['company']['app_title'] ?? "Admin"; ?></title>

    <link rel="shortcut icon" href="<?php echo $_SESSION && isset($_SESSION['MYSESSION']) && $_SESSION['MYSESSION']['company']['img_favicon'] ? './assets/img/company/'.$_SESSION['MYSESSION']['company']['id'].'/'.$_SESSION['MYSESSION']['company']['img_favicon'] : "./assets/img/system/favicon.png"; ?>" type="image/PNG">
    <!-- <link rel="shortcut icon" href="./assets/img/system/favicon.png" type="image/PNG"> -->

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
    <?php if(isset($_SESSION['MYSESSION']) && $_SESSION['MYSESSION']['company']){ ?>
    <style>
        :root {
            --primary: <?php echo $_SESSION['MYSESSION']['company']['primary_color'] ?? "#213F75"; ?>;
            --secondary: <?php echo $_SESSION['MYSESSION']['company']['secondary_color'] ?? "#A368ED"; ?>;
            --tertiary: <?php echo $_SESSION['MYSESSION']['company']['tertiary_color'] ?? "#F773CC"; ?>;
            --accent: <?php echo $_SESSION['MYSESSION']['company']['accent_color'] ?? "#74d7ff"; ?>;
            --textSecondary: <?php echo $_SESSION['MYSESSION']['company']['menutext_color'] ?? "#fff"; ?>;
            --fontPlusSize: <?php echo $_SESSION['MYSESSION']['company']['text_size_plus'].'pt' ?? "0pt"; ?>;
        }
        .font1 {
            background-image: url(<?php echo $_SESSION['MYSESSION']['company']['img_font'] ? "assets/img/company/".$_SESSION['MYSESSION']['company']['id']."/".$_SESSION['MYSESSION']['company']['img_font'] : "assets/img/system/font.jpg"; ?>);
            background-position: center center;
            background-size: cover;
        }

    </style>
    <?php }else{ ?>
    <style>
        :root {
            --primary: #213F75;
            --secondary: #A368ED;
            --tertiary: #F773CC;
            --accent: #74d7ff;
            --urlFont: "../img/system/font.jpg";
            --textSecondary: white;
            --fontPlusSize: 0pt;
        }
    </style>
    <?php } ?>

    <script src="./node_modules/jquery/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/required/dataTables/datatables.min.css">
    <link rel="stylesheet" href="./node_modules/flatpickr/dist/flatpickr.min.css">

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
