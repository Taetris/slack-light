<?php

use SlackLight\Controller;
use Util\Util;

?>

<form method="post"
      action="<?php echo Util::action(Controller::POST_ACTION, array('view' => $view)); ?>">
    <i class="fa fa-map-pin"></i>
</form>

