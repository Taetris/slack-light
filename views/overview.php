<?php require_once('partials/header.php');

use Data\DataManager;
use SlackLight\AuthenticationManager;
use SlackLight\Controller;
use Util\Util;

$user = AuthenticationManager::getAuthenticatedUser();
$channelsForUser = DataManager::getChannelsForUser($user);

?>

<link href="views/css/overview.css" rel="stylesheet">

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Slack Light</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <form method="post" action="<?php echo Util::action(Controller::ACTION_LOGOUT); ?>">
                <input id="signOut" type="submit" value="Sign Out">
            </form>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <?php foreach ($channelsForUser as $channel) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span data-feather="home"></span>
                            #<?php echo $channel->getName(); ?>
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
</div>

<?php require_once('partials/footer.php'); ?>

