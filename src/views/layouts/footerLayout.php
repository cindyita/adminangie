</div> <!--END CONTENT-->
</div> <!--End main-->
<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="./assets/required/metisMenu/metisMenu.min.js"></script>
<script src="./assets/required/slimscroll/jquery.slimscroll.min.js"></script>
<script src="./assets/required/dataTables/datatables.min.js" defer></script>
<script src="./node_modules/flatpickr/dist/flatpickr.min.js"></script>

<script src="./assets/js/app.js?version=<?php echo VERSION; ?>"></script>
<?php 
    if($scripts){
        foreach ($scripts as $value) {
            echo '<script src="'.$value.'?version='.VERSION.'"></script>';
        }
    }
?>
</body>
</html>