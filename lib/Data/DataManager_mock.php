<?php

namespace Data;

include 'IDataManager.php';

class DataManager implements IDataManager
{
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
            case 'users':
                $data = [
                    1 => new User(1, "admin", "68be59da0cf353ae74ee8db8b005454b515e1a22"), //USER = admin; PASSWORD = admin
                    2 => new User(1, "admin2", "b9b6a1904a89af73a1ade05206ad3374ccb49d53"), //USER = admin2; PASSWORD = admin2
                ];
                break;
        }

        return $data;
    }
}


















