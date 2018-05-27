<?php require_once('partials/header.php');

use SlackLight\Controller;
use Util\Util;

?>

<link href="views/css/register.css" rel="stylesheet">

<form class="form-register" method="post"
      action="<?php echo Util::action(Controller::ACTION_REGISTER, array('view' => $view)); ?>">

    <h1 class="h3 mb-3 font-weight-normal">Register</h1>

    <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus
           name="<?php print Controller::USER_NAME; ?>">
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required
           name="<?php print Controller::USER_PASSWORD; ?>">
    <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm Password" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="validatePassword()">Register</button>
</form>

<script>
    let password = document.getElementById("inputPassword");
    let confirmPassword = document.getElementById("confirmPassword");

    function validatePassword(){
        if(inputPassword.value != confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords Don't Match");
        } else {
            confirmPassword.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirmPassword.onkeyup = validatePassword;
</script>

<?php require_once('partials/footer.php'); ?>
