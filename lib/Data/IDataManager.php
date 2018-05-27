<?php

namespace Data;

interface IDataManager {

    public static function storeUser($userName, $passwordHash): bool;

	public static function getUserById(int $userId);

	public static function getUserByUserName(string $userName);
}
