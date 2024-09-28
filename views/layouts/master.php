<!DOCTYPE html>
<html lang="en" data-bs-theme="<?= $appTheme ?>">

<head>
    <?= $this->renderLayout('head', $params) ?>
</head>

<body>

    {{contents}}

    <?= $this->renderLayout('script', $params) ?>

</body>

</html>