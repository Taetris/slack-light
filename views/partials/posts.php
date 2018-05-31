<?php

use Data\DataManager;

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2"><?php echo DataManager::getChannelForId($channelId)->getName(); ?></h1>
</div>

<?php foreach ($posts as $post) { ?>
    <div class="container float-left text-left border-bottom mt-3 justify-content-between">
        <div class="row">
            <div class="col"><b>@<?php echo $post->getAuthor(); echo ': '; echo $post->getTimestamp();?></b></div>
            <div class="w-100"></div>
            <div class="col"><b><?php echo $post->getTitle();?></b> <?php echo $post->getContent();?></div>
        </div>
        <br>
    </div>
<?php } ?>

<?php foreach ($posts as $post) { ?>
    <div class="container float-left text-left border-bottom mt-3 justify-content-between">
        <div class="row">
            <div class="col"><b>@<?php echo $post->getAuthor(); echo ': '; echo $post->getTimestamp();?></b></div>
            <div class="w-100"></div>
            <div class="col"><b><?php echo $post->getTitle();?></b> <?php echo $post->getContent();?></div>
        </div>
        <br>
    </div>
<?php } ?>
