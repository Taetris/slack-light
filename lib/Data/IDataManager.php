<?php

namespace Data;

interface IDataManager {

	public static function getUserById(int $userId);

	public static function getUserByUserName(string $userName);
}
