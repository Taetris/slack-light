<?php

use Data\DataManager;
use SlackLight\Controller;
use Util\Util;

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mt-5 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?php echo DataManager::getChannelForId($channelId)->getName(); ?></h1>
</div>

<?php
$i = 0;
$count = count($posts);
foreach ($posts as $post) {
    $i++; ?>
    <div class="container float-left text-left mt-3 justify-content-between"
        <?php if ($i === $count) { ?>
            style="margin-bottom: 100px"
        <?php } ?>>
        <nav class="navbar navbar-light bg-light" style="border-radius: 10px">
            <div class="row w-75">
                <div class="col"><b>@<?php echo $post->getAuthor();
                        echo ': ';
                        echo $post->getTimestamp(); ?></b>
                </div>
                <div class="w-100"></div>
                <div class="col"><b><?php echo $post->getTitle(); ?></b> <?php echo $post->getContent(); ?></div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div role="separator" class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
<?php } ?>

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
