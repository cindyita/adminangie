<li class="<?php echo activeUrl("home",$page); ?>">
    <a href="home"><i class="fa-solid fa-gauge-high"></i><span>Escritorio</span></a>
</li>
<li class="<?php echo activeUrl("sales",$page); ?>">
    <a href="sales"><i class="fa-solid fa-clipboard-check"></i><span>Ventas</span></a>
</li>
<li class="<?php echo activeUrl("orders",$page); ?>">
    <a href="orders"><i class="fa-solid fa-calendar"></i><span>Pedidos</span></a>
</li>
<li class="<?php echo activeUrl("products",$page); ?>">
    <a href="products"><i class="fa-solid fa-box"></i><span>Productos</span></a>
</li>
<li class="<?php echo activeUrl("services",$page); ?>">
    <a href="services"><i class="fa-solid fa-bell-concierge"></i><span>Servicios</span></a>
</li>
<!-- <li class="?php echo activeUrl("inventory",$page); ?>">
    <a href="inventory" class="link-disabled"><i class="fa-solid fa-boxes-stacked"></i><span>Inventario</span></a>
</li> -->
<li class="<?php echo activeUrl("categories",$page); ?>">
    <a href="categories"><i class="fa-solid fa-tag"></i><span>Categorías</span></a>
</li>
<li class="<?php echo activeUrl("contacts",$page); ?>">
    <a href="contacts"><i class="fa-solid fa-book"></i><span>Contactos</span></a>
</li>

<?php if($_SESSION['MYSESSION']['id_role'] == 1){ ?>
    <li class="<?php echo activeUrl("users",$page); ?>">
        <a href="users"><i class="fa-solid fa-user"></i><span>Usuarios</span></a>
    </li>
    <li class="<?php echo activeUrl("settings",$page); ?>">
        <a href="settings"><i class="fa-solid fa-gear"></i><span>Ajustes</span></a>
    </li>
<?php } ?>