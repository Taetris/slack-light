<?php

namespace Data;

interface IDataManager {

    public static function deletePost(int $postId): bool;

    public static function pinPostForUser(string $userName, int $postId): bool;

    public static function unpinPostForUser(string $userName, int $postId): bool;

    public static function storePost(int $channelId, string $title, string $content, string $userName, string $timestamp): bool;

    public static function editPost(int $postId, string $title, string $content): bool;

    public static function getPostsForChannel(int $channelId): array;

    public static function getPostById(int $postId);

    public static function getChannelForId(int $channelId);

    public static function getAllChannels(): array;

    public static function getChannelsForUser(string $userName): array;

    public static function storeUser(string $userName, string $passwordHash): bool;

	public static function getUserById(int $userId);

	public static function getUserByUserName(string $userName);
}
