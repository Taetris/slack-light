<?php /** @noinspection ALL */

namespace SlackLight;

use Base\BaseObject;
use Data\DataManager;
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
    const CHANNELS = "channels[]";
    const SEND_POST = "sendPost";
    const TITLE = "title";
    const CONTENT = "content";
    const CHANNEL_ID = "channelId";
    const PIN_POST = "pinPost";
    const UNPIN_POST = "unpinPost";
    const EDIT_POST = "editPost";
    const DELETE_POST = "deletePost";
    const POST_ID = "postId";

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
            throw new \Exception(self::ACTION.' not specified.');
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
                Util::redirect("index.php");
                break;
            case self::ACTION_REGISTER:
                if (!AuthenticationManager::register($_REQUEST[self::USER_NAME], $_REQUEST[self::USER_PASSWORD])) {
                    self::forwardRequest(['Failed to register. User already exists.']);
                }
                Util::redirect("index.php");
                break;
            case self::SEND_POST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    self::forwardRequest(['Session expired. Please log in.']);
                }

                $title = $_REQUEST[self::TITLE];
                $content = $_REQUEST[self::CONTENT];
                $channelId = $_REQUEST[self::CHANNEL_ID];
                $timestamp = date("Y-m-d h:i:sa");

                if (!DataManager::storePost($channelId, $title, $content, $user->getUserName(), $timestamp)) {
                    self::forwardRequest(['Failed to send post.']);
                }

                Util::redirect();
                break;
            case self::PIN_POST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    self::forwardRequest(['Session expired. Please log in.']);
                }

                if (!DataManager::pinPostForUser($user->getUserName(), $_REQUEST[self::POST_ID])) {
                    self::forwardRequest(['Failed to pin post.']);
                }

                Util::redirect();
                break;
            case self::UNPIN_POST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    self::forwardRequest(['Session expired. Please log in.']);
                }

                if (!DataManager::unpinPostForUser($user->getUserName(), $_REQUEST[self::POST_ID])) {
                    self::forwardRequest(['Failed to unpin post.']);
                }

                Util::redirect();
                break;
            case self::EDIT_POST:
                break;
            case self::DELETE_POST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    self::forwardRequest(['Session expired. Please log in.']);
                }

                if (!DataManager::deletePost($_REQUEST[self::POST_ID])) {
                    self::forwardRequest(['Failed to delete post.']);
                }

                Util::redirect();
                break;
            default:
                throw new \Exception('Unknown controller action: '.$action);
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
            $target .= '&errors='.urlencode(serialize($errors));
            header('Location:'.$target);
            exit();
        }
    }
}