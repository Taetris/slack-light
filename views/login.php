<?php require_once('partials/header.php');

use SlackLight\Controller;
use Util\Util;

?>

<link href="views/css/login.css" rel="stylesheet">

<form class="form-login" method="post"
      action="<?php echo Util::action(Controller::ACTION_LOGIN, array('view' => $view)); ?>">

    <h1 class="h3 mb-3 font-weight-normal">Slack Light</h1>

    <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus
           name="<?php print Controller::USER_NAME; ?>">
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required
           name="<?php print Controller::USER_PASSWORD; ?>">

    <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
</form>

<a href="index.php?view=register">Register</a>

<?php require_once('partials/footer.php'); ?>
