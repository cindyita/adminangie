<div class="menuPrimary" id="menu-primary">
    
    <!-- sidebar -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="home">
                        <img src="<?php echo $_SESSION['MYSESSION'] ? './assets/img/company/'.$_SESSION['MYSESSION']['company']['id'].'/'.$_SESSION['MYSESSION']['company']['img_logo'] : "./assets/img/system/logo.png"; ?>" alt="logo">
                    </a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <?php require_once(component("menu")); ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div>
            <!-- header -->
            <div class="header-area">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- nav and search -->
                    <div class="d-flex">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <!--------SEARCH----------------->
                        <div class="search-box pull-left d-none">
                            <form action="#">
                                <input type="text" name="search" placeholder="Buscar.." required>
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </form>
                        </div>
                        <!------------------------------->
                    </div>
                    <!-- profile -->
                    <div class="d-flex gap-3 align-items-center">
                        <div class="maxmin d-flex gap-3">
                            <li id="full-view" title="Maximizar pantalla"><i class="fa-solid fa-expand"></i></li>
                            <li id="full-view-exit" title="Minimizar pantalla"><i class="fa-solid fa-minimize"></i></li>
                            <li onclick="toggleTheme();" title="Cambiar tema"><i class="fa-solid fa-circle-half-stroke"></i></li>
                        </div>
                        <div class="dropdown dropdown-menu-end">
                            <div class="img-profile" data-bs-toggle="dropdown">
                                <img src="assets/img/system/user.avif" alt="User profile">
                            </div>
                            <ul class="dropdown-menu">
                                <?php require_once(component("menuUser")); ?>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- header end -->
        </div>
    
</div>

<div class="main-content"><!---OPEN CONTENT-->
