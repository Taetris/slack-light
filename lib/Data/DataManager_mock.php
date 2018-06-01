<?php

namespace Data;

include 'IDataManager.php';

class DataManager implements IDataManager
{
    public static function deletePost(int $postId): bool
    {
        return true;
    }

    public static function pinPostForUser(string $userName, int $postId): bool
    {
        return true;
    }

    public static function unpinPostForUser(string $userName, int $postId): bool
    {
        return true;
    }

    public static function storePost(int $channelId, string $title, string $content, string $userName, string $timestamp): bool
    {
        return true;
    }

    public static function editPost(int $postId, string $title, string $content): bool
    {
        return true;
    }

    public static function getPostsForChannel(int $channelId): array
    {
        return self::getMockData('posts');
    }

    public static function getPostById(int $postId)
    {
        if ($postId == -1) {
            return null;
        }

        return self::getMockData('posts')[$postId];
    }

    public static function getChannelForId(int $channelId)
    {
        if ($channelId == -1) {
            return null;
        }

        return self::getAllChannels()[$channelId];
    }

    public static function getAllChannels(): array
    {
        return self::getMockData('channels');
    }

    public static function getChannelsForUser(string $userName): array
    {
        return self::getAllChannels();
    }

    public static function storeUser(string $userName, string $passwordHash): bool
    {
        return true;
    }

    public static function getUserById(int $userId)
    {
        return array_key_exists($userId, self::getMockData('users')) ?
            self::getMockData('users')[$userId] : null;
    }

    public static function getUserByUserName(string $userName)
    {
        foreach (self::getMockData('users') AS $user) {
            if ($user->getUserName() === $userName) {
                return $user;
            }
        }

        return null;
    }

    private static function getMockData(string $type): array
    {
        $data = array();
        switch ($type) {
            case 'channels':
                $data = [
                    1 => new Channel(1, "Java"),
                    2 => new Channel(2, "Design Patterns"),
                ];
                break;
            case 'users':
                $data = [
                    1 => new User(1, "admin", "68be59da0cf353ae74ee8db8b005454b515e1a22"), //USER = admin; PASSWORD = admin
                    2 => new User(2, "admin2", "b9b6a1904a89af73a1ade05206ad3374ccb49d53"), //USER = admin2; PASSWORD = admin2
                ];
                break;
            case 'posts':
                $data = [
                    1 => new Post(1, 1, "Memory", "Memory is being handled by the garbage collector.", "admin", date("Y-m-d h:i:sa"), false, true),
                    2 => new Post(2, 2, "Memory", "This class provides a skeletal implementation of the Collection interface, to minimize the effort required to implement this interface.", "admin", date("Y-m-d h:i:sa"), false, true),
                    3 => new Post(3, 1, "Memory", "To implement a modifiable collection, the programmer must additionally override this class's add method.", "admin", date("Y-m-d h:i:sa"), false, true),
                    4 => new Post(4, 1, "Memory", "Memory is being handled by the garbage collector.", "admin2", date("Y-m-d h:i:sa"), true, true),
                    5 => new Post(5, 2, "Memory", "This class provides a skeletal implementation of the Collection interface, to minimize the effort required to implement this interface.", "admin", date("Y-m-d h:i:sa"), true, true),
                    6 => new Post(6, 2, "Memory", "Memory is being handled by the garbage collector.", "admin2", date("Y-m-d h:i:sa"), false, true),
                    7 => new Post(7, 1, "Memory", "To implement a modifiable collection, the programmer must additionally override this class's add method.", "admin", date("Y-m-d h:i:sa"), false,false),
                    8 => new Post(8, 2, "Memory", "Memory is being handled by the garbage collector.", "admin2", date("Y-m-d h:i:sa"), true, false),
                    9 => new Post(9, 1, "Memory", "To implement a modifiable collection, the programmer must additionally override this class's add method.", "admin", date("Y-m-d h:i:sa"), true, false),
                    10 => new Post(10, 2, "Memory", "Memory is being handled by the garbage collector.", "admin2", date("Y-m-d h:i:sa"), false, false),
                ];
                break;
        }

        return $data;
    }
}



















