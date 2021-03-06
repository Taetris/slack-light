<?php use SlackLight\AuthenticationManager;
use SlackLight\Controller;

require_once('inc/bootstrap.php');

if (AuthenticationManager::isAuthenticated()) {
    $view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'overview';
} else {
    $view = isset($_REQUEST['view']) ? $_REQUEST['view'] : 'login';
}

$postAction = isset($_REQUEST[Controller::ACTION]) ? $_REQUEST[Controller::ACTION] : null;
if ($postAction != null) {
    Controller::getInstance()->invokePostAction();
}

if (file_exists(__DIR__ . '/views/' . $view . '.php')) {
    require_once('views/' . $view . '.php');
}
else {
    require_once('views/' . $default_view . '.php');
}