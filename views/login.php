<?php require_once('partials/header.php');

use SlackLight\AuthenticationManager;
use SlackLight\Controller;
use Util\Util;

$userName = isset($_REQUEST['userName']) ? $_REQUEST['userName'] : null;

?>

<link href="views/css/login.css" rel="stylesheet">

<div class="container">
    <form class="form-login" method="post"
          action="<?php echo Util::action(Controller::ACTION_LOGIN, array('view' => $view)); ?>">

        <h1 class="h3 mb-3 font-weight-normal">Slack Light</h1>

        <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus
               name="<?php echo Controller::USER_NAME; ?>">
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required
               name="<?php echo Controller::USER_PASSWORD; ?>">

        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
    </form>

    <a href="index.php?view=register">Register</a>
</div>


<?php require_once('partials/footer.php'); ?>
