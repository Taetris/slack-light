<?php require_once('partials/header.php');

use Data\DataManager;
use SlackLight\AuthenticationManager;
use SlackLight\Controller;
use Util\Util;

$user = AuthenticationManager::getAuthenticatedUser();
if ($user != null) {
    $channelsForUser = DataManager::getChannelsForUser($user->getUserName());
}

$channelId = isset($_REQUEST['channelId']) ? (int)$_REQUEST['channelId'] : -1;
$posts = DataManager::getPostsForChannel($channelId);

?>

<link href="views/css/overview.css" rel="stylesheet">

<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-md-1 mr-0" href="#">Slack Light</a>

    <form class="navbar-brand col-sm-1 mr-0 text-center" method="post"
          action="<?php echo Util::action(Controller::ACTION_LOGOUT, array('view' => $view)); ?>">
        <button class="signOut" type="submit">Sign Out</button>
    </form>
</nav>

<main id="mainContent" class="ml-sm-auto col-lg-11 pt-3">
    <?php if ($channelId == -1) {
        require_once('partials/welcome.php');
    } else {
        require_once('partials/posts.php');
    } ?>
</main>

<div class="container-fluid" onscroll="updateSeenMessages()">
    <div class="row">
        <nav class="col-md-1 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <?php foreach ($channelsForUser as $channel) { ?>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?php echo $_SERVER['PHP_SELF'] ?>?view=overview&channelId=<?php echo urlencode($channel->getId()); ?>">
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

<script>
    document.addEventListener('scroll', function(event) {
        console.log('scrolling');
        let elements = document.getElementsByClassName("badge badge-danger");
        while(elements.length > 0){
            elements[0].parentNode.removeChild(elements[0]);
        }
    }, true);
</script>

<?php require_once('partials/footer.php'); ?>

