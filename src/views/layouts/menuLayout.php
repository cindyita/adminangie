<div class="menuPrimary" id="menu-primary">
    
    <!-- sidebar -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="index.html"><img src="assets/img/system/logo.png" alt="logo"></a>
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
                        <div class="search-box pull-left">
                            <form action="#">
                                <input type="text" name="search" placeholder="Buscar.." required>
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </form>
                        </div>
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
                                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-user"></i> Perfil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gear"></i> Ajustes</a></li>
                                <li><hr class="dropdown-divider"></hr></li>
                                <li><a href="logout" class="dropdown-item"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- header end -->
        </div>
    
</div>

<div class="main-content"><!---OPEN CONTENT-->
