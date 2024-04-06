<div class="menuPrimary" id="menu-primary">
    
    <div class="menu-content">
        <div class="menu-row">
            <div>
                <div class="logo">
                    <img src="./assets/img/system/logo.png" id="logo">
                </div>
            </div>
            <div>
                <?php   require_once(component("menu")); ?>
            </div>
        </div>
        <div>
            <div>
                <?php   require_once(component("menuMobile")); ?>
            </div>
            <?php   require_once(component("menuUser"));
                    require_once(component("menuUserMobile"));
             ?>
        </div>
    </div>
    
</div>

<div class="main-content"><!---OPEN CONTENT-->