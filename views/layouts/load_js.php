<?php

use App\Core\Session;
?>

<!-- Bootstrap JS -->
<script src="<?= URL_ROOT ?>js/bootstrap/bootstrap.bundle.min.js"></script>

<?php
// If user is authenticated
if (Session::isAuthenticated()) { ?>
    <script src="<?= URL_ROOT ?>js/theme-switcher.js"></script>
    <script src="<?= URL_ROOT ?>js/hello.js"></script>
<?php } ?>

<!-- Jquery -->
<script src="<?= URL_ROOT ?>js/jquery/jquery.js">
</script>

<?php
if (Session::isAuthenticated()) { ?>
    <!-- Dialog JS -->
    <script src="<?= URL_ROOT ?>js/dialog/dialog.js"></script>

    <!-- Toast JS -->
    <script src="<?= URL_ROOT ?>js/toast/toast.js"></script>
<?php } ?>

<!-- App JS -->
<script src="<?= URL_ROOT ?>js/app.min.js"></script>

<!-- Font Awesome icons -->
<script src="https://kit.fontawesome.com/cd2caad5e8.js" crossorigin="anonymous"></script>