</div> <!--END CONTENT-->
</div> <!--End main-->
<script src="https://kit.fontawesome.com/e0df5df9e9.js" crossorigin="anonymous"></script>
<script src="assets/js/app.js?version=<?php echo VERSION; ?>"></script>
<?php 
    if($scripts){
        foreach ($scripts as $value) {
            echo '<script src="'.$value.'?version='.VERSION.'"></script>';
        }
    }
?>
</body>
</html>