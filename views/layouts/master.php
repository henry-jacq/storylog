<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->renderLayout('head', $params) ?>
</head>

<body class="bg-gray-100">

    {{contents}}

    <?= $this->renderLayout('script', $params) ?>

</body>

</html>