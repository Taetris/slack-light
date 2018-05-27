<?php /** @noinspection ALL */

namespace SlackLight;

use Base\BaseObject;
use Util\Util;

class Controller extends BaseObject
{
    const ACTION = 'action';
    const PAGE = 'page';
    const ACTION_LOGIN = 'login';
    const ACTION_REGISTER = 'register';
    const ACTION_LOGOUT = 'logout';
    const USER_NAME = 'userName';
    const USER_PASSWORD = 'password';

    private static $instance = false;

    public static function getInstance(): Controller
    {
        if (!self::$instance) {
            self::$instance = new Controller();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function invokePostAction(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            throw new \Exception('Controller can only handle POST requests.');
        }

        $action = $_REQUEST[self::ACTION];
        if (!isset($action)) {
            throw new \Exception(self::ACTION . ' not specified.');
        }

        switch ($action) {
            case self::ACTION_LOGIN:
                if (!AuthenticationManager::authenticate($_REQUEST[self::USER_NAME], $_REQUEST[self::USER_PASSWORD])) {
                    self::forwardRequest(['Invalid user credentials.']);
                }
                Util::redirect();
                break;
            case self::ACTION_LOGOUT:
                AuthenticationManager::signOut();
                Util::redirect();
                break;
            case self::ACTION_REGISTER:
                Util::redirect('index.php?view=register');
                break;
            default :
                throw new \Exception('Unknown controller action: ' . $action);
                break;
        }
    }

    protected function forwardRequest(array $errors = null, $target = null)
    {
        if ($target == null) {
            if (isset($_REQUEST[self::PAGE])) {
                $target = $_REQUEST[self::PAGE];
            } else {
                $target = $_SERVER['REQUEST_URI'];
            }
        }

        if (count($errors) > 0) {
            $target .= '&errors=' . urlencode(serialize($errors));
            header('Location:' . $target);
            exit();
        }
    }
}