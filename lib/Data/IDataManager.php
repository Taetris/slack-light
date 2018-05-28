<?php

namespace Data;

interface IDataManager {

    public static function getAllChannels(): array;

    public static function getChannelsForUser($userName): array;

    public static function storeUser($userName, $passwordHash): bool;

	public static function getUserById(int $userId);

	public static function getUserByUserName(string $userName);
}
