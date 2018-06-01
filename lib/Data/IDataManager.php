<?php

namespace Data;

interface IDataManager {

    public static function deletePost(int $postId): bool;

    public static function pinPostForUser(int $userId, int $postId): bool;

    public static function unpinPostForUser(int $userId, int $postId): bool;

    public static function storePost(int $channelId, string $title, string $content, string $userName): bool;

    public static function editPost(int $postId, string $title, string $content): bool;

    public static function getPostsForChannel(int $userId, int $channelId): array;

    public static function getPostById(int $postId);

    public static function getChannelForId(int $channelId);

    public static function getAllChannels(): array;

    public static function getChannelsForUser(int $userId): array;

    public static function storeUser(string $userName, string $passwordHash, array $channels): bool;

	public static function getUserById(int $userId);

	public static function getUserByUserName(string $userName);
}
