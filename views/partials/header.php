<?php

if (isset($_GET["errors"])) {
    $errors = unserialize(urldecode($_GET["errors"]));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">

    <title>Slack Light</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">

</head>
<?php

use Util\Util;

if (isset($errors) && is_array($errors)): ?>
    <div class="errors alert alert-danger container mb-3 fixed-bottom text-center">
        <?php foreach ($errors as $errMsg): ?>
            <p><?php echo(Util::escape($errMsg)); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<body class="text-center">


<!--/display error messages-->

