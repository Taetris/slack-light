<?php

use Data\DataManager;
use SlackLight\Controller;
use Util\Util;

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-5 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?php echo DataManager::getChannelForId($channelId)->getName(); ?></h1>
</div>

<?php
    $latestPost = end($posts);

    require_once ("pinnedPosts.php");
    require_once ("unpinnedPosts.php");
?>

<form method="post"
      action="<?php echo Util::action(Controller::SEND_POST, array('view' => $view, Controller::CHANNEL_ID => $channelId)); ?>">
    <div class="container mb-3 fixed-bottom">
        <div class="input-group">
            <input id="postInput" autocomplete="off" type="text" class="form-control" placeholder="Title"
                   aria-label="Title"
                   aria-describedby="basic-addon2" required name="<?php echo Controller::TITLE; ?>">
            <input id="postInput" autocomplete="off" type="text" class="form-control" placeholder="Content"
                   aria-label="Content"
                   aria-describedby="basic-addon2" required name="<?php echo Controller::CONTENT; ?>">
            <div class="input-group-append">
                <button id="postInput" class="btn btn-outline-secondary" type="submit">Send</button>
            </div>
        </div>
    </div>
</form>
