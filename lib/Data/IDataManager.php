<?php

namespace Data;

interface IDataManager {

    public static function deletePost($postId): bool;

    public static function pinPostForUser($user, $postId): bool;

    public static function unpinPostForUser($user, $postId): bool;

    public static function storePost($channelId, $title, $content, $userName, $timestamp): bool;

    public static function getPostsForChannel($channelId): array;

    public static function getChannelForId($channelId);

    public static function getAllChannels(): array;

    public static function getChannelsForUser($userName): array;

    public static function storeUser($userName, $passwordHash): bool;

	public static function getUserById(int $userId);

	public static function getUserByUserName(string $userName);
}
