<?php

use SlackLight\Controller;
use Util\Util;

foreach ($posts as $post) {
    if ($post->isPinned()) { ?>
        <div class="container float-left text-left mt-3 justify-content-between">
            <nav class="navbar navbar-light bg-light" style="border-radius: 10px; border: 2px solid midnightblue;">

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
                                  action="<?php echo Util::action(Controller::UNPIN_POST, array('view' => $view, Controller::POST_ID => $post->getId())) ?>">
                                <button class="dropdown-item" type="submit">Pin</button>
                            </form>
                            <form method="post"
                                  action="<?php echo Util::action(Controller::EDIT_POST, array('view' => $view, Controller::POST_ID => $post->getId())) ?>">
                                <button class="dropdown-item" type="submit">Edit</button>
                            </form>
                            <form method="post"
                                  action="<?php echo Util::action(Controller::DELETE_POST, array('view' => $view, Controller::POST_ID => $post->getId())) ?>">
                                <button class="dropdown-item" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>

            </nav>
        </div>
    <?php }
} ?>