<?php

use SlackLight\AuthenticationManager;
use SlackLight\Controller;
use Util\Util;

$i = 0;
$count = count($posts);

foreach ($posts as $post) {
    $i++;
    if (!$post->isPinned()) { ?>
        <div class="container float-left text-left mt-3 justify-content-between"
            <?php if ($i === $count) { ?>
                style="margin-bottom: 200px;"
            <?php } ?>>

            <nav class="navbar navbar-light bg-light border-bottom" style="border-radius: 10px;">
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
                            <form method="post"
                                  action="<?php echo Util::action(Controller::PIN_POST, array('view' => $view, Controller::POST_ID => $post->getId())) ?>">
                                <button class="dropdown-item" type="submit">Pin</button>
                            </form>

                            <?php
                            $user = AuthenticationManager::getAuthenticatedUser();
                            if ($latestPost->getId() === $post->getId() && $latestPost->getAuthor() === $user->getUserName()) { ?>
                                <form method="post"
                                      action="<?php echo $_SERVER['PHP_SELF'] ?>?view=overview&channelId=<?php echo urlencode($post->getChannelId()); ?>&postId=<?php echo urlencode($post->getId());?>">
                                    <button class="dropdown-item" type="submit">Edit</button>
                                </form>
                                <form method="post"
                                      action="<?php echo Util::action(Controller::DELETE_POST, array('view' => $view, Controller::POST_ID => $post->getId())) ?>">
                                    <button class="dropdown-item" type="submit">Delete</button>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </nav>
        </div>
    <?php }
} ?>