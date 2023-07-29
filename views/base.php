<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<?php echo ($this->renderLayout('head')); ?>

<body>
    <div class="container">
        <?php echo ($this->renderLayout('header')); ?>

        {{contents}}
    </div>

    <?php echo ($this->renderLayout('footer')); ?>
    <?php echo ($this->renderLayout('elements')); ?>
    <?php echo ($this->renderLayout('script')); ?>
</body>

</html>