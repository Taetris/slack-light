<?php /** @noinspection ALL */

namespace Data;

include 'IDataManager.php';

class DataManager implements IDataManager
{
    public static function deletePost(int $postId): bool
    {
        $connection = self::getConnection();
        $connection->beginTransaction();

        try {
            self::query($connection, "
            DELETE FROM posts WHERE id = ?", [$postId]);
            $connection->commit();
            return true;
        } catch (\Exception $e) {
            $connection->rollBack();
            return false;
        } finally {
            self::closeConnection($connection);
        }
    }

    public static function pinPostForUser(int $userId, int $postId): bool
    {
        $connection = self::getConnection();
        $connection->beginTransaction();

        try {
            self::query($connection, "
            INSERT INTO favourites (userId, postId) VALUES (?, ?)", [$userId, $postId]);
            $connection->commit();
            return true;
        } catch (\Exception $e) {
            $connection->rollBack();
            return false;
        } finally {
            self::closeConnection($connection);
        }
    }

    public static function unpinPostForUser(int $userId, int $postId): bool
    {
        $connection = self::getConnection();
        $connection->beginTransaction();

        try {
            self::query($connection, "
            DELETE FROM favourites WHERE userId = ? AND postId = ?", [$userId, $postId]);
            $connection->commit();
            return true;
        } catch (\Exception $e) {
            $connection->rollBack();
            return false;
        } finally {
            self::closeConnection($connection);
        }
    }

    public static function storePost(int $channelId, string $title, string $content, string $userName): bool
    {
        $connection = self::getConnection();
        $connection->beginTransaction();

        try {
            self::query($connection, "
            INSERT INTO posts (channelId, title, content, author, timestamp) VALUES (?, ?, ?, ?, NOW());", [$channelId, $title, $content, $userName]);
            $connection->commit();
            return true;
        } catch (\Exception $e) {
            $connection->rollBack();
            return false;
        } finally {
            self::closeConnection($connection);
        }
    }

    public static function editPost(int $postId, string $title, string $content): bool
    {
        $connection = self::getConnection();
        $connection->beginTransaction();

        try {
            self::query($connection, "
            UPDATE posts SET title = ?, content = ? WHERE id = ?", [$title, $content, $postId]);
            $connection->commit();
            return true;
        } catch (\Exception $e) {
            $connection->rollBack();
            return false;
        } finally {
            self::closeConnection($connection);
        }
    }

    public static function getPostsForChannel(int $userId, int $channelId): array
    {
        if ($channelId == -1) {
            return array();
        }

        $posts = array();

        $connection = self::getConnection();

        $user = self::getUserById($userId);

        // get timestamp of last seen post
        $result = self::query($connection, "SELECT * FROM lastReadPost WHERE userId = ? AND channelId = ?;", [$userId, $channelId]);
        $lastSeenPostTimestamp = null;
        if ($p = self::fetchObject($result)) {
            $post = self::getPostById($p->postId);
            $lastSeenPostTimestamp = $post->getTimestamp();
        }

        // get pinned posts
        $result = self::query($connection, "SELECT * FROM favourites WHERE userId = ?", [$userId]);
        $pinnedPosts = array();
        while ($pinnedPost = self::fetchObject($result)) {
            $pinnedPosts[] = $pinnedPost->postId;
        }

        $result = self::query($connection, "SELECT * FROM posts WHERE channelId = ? ORDER BY timestamp ASC;", [$channelId]);

        while ($post = self::fetchObject($result)) {
            // mark previous posts and posts by the same user as seen
            $newPost = new Post($post->id, $post->channelId, $post->title, $post->content, $post->author, $post->timestamp);
            if ($lastSeenPostTimestamp != null &&
                ($post->timestamp <= $lastSeenPostTimestamp
                || $post->author === $user->getUserName())) {
                $newPost->setSeen(true);
            } else {
                $newPost->setSeen(false);
            }

            if (in_array($newPost->getId(), $pinnedPosts)) {
                $newPost->setPinned(true);
            } else {
                $newPost->setPinned(false);
            }

            $posts[] = $newPost;
        }

        // update last seen post
        if (!empty($posts)) {
            self::updateLastSeen($userId, $channelId, end($posts)->getId());
        }

        self::close($result);
        self::closeConnection($connection);

        return $posts;
    }

    private static function updateLastSeen($userId, $channelId, $postId)
    {
        $connection = self::getConnection();
        $connection->beginTransaction();

        try {
            self::query($connection, "
           INSERT INTO lastReadPost (userId, channelId, postId) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE postId = ?;",
                [$userId, $channelId, $postId, $postId]);
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
        } finally {
            self::closeConnection($connection);
        }
    }

    public static function getPostById(int $postId)
    {
        if ($postId == -1) {
            return null;
        }

        $post = null;

        $connection = self::getConnection();
        $result = self::query($connection, "SELECT * FROM posts WHERE id = ?;", [$postId]);

        if ($p = self::fetchObject($result)) {
            $post = new Post($p->id, $p->channelId, $p->title, $p->content, $p->author, $p->timestamp);
        }

        self::close($result);
        self::closeConnection($connection);

        return $post;
    }

    public static function getChannelForId(int $channelId)
    {
        $channel = null;

        $connection = self::getConnection();
        $result = self::query($connection, "SELECT id, channelName FROM channels WHERE id = ?;", [$channelId]);

        if ($c = self::fetchObject($result)) {
            $channel = new Channel($c->id, $c->channelName);
        }

        self::close($result);
        self::closeConnection($connection);

        return $channel;
    }

    public static function getAllChannels(): array
    {
        $channels = array();

        $connection = self::getConnection();
        $result = self::query($connection, "SELECT id, channelName FROM channels;");

        while ($channel = self::fetchObject($result)) {
            $channels[] = new Channel($channel->id, $channel->channelName);
        }

        self::close($result);
        self::closeConnection($connection);

        return $channels;
    }

    public static function getChannelsForUser(int $userId): array
    {
        $channels = array();

        $connection = self::getConnection();
        $result = self::query($connection, "SELECT channelId FROM channelsForUser WHERE userId = ?", [$userId]);

        while ($channel = self::fetchObject($result)) {
            $channels[] = self::getChannelForId($channel->channelId);
        }

        self::close($result);
        self::closeConnection($connection);

        return $channels;
    }

    public static function storeUser(string $userName, string $passwordHash, array $channels): bool
    {
        $connection = self::getConnection();
        $connection->beginTransaction();

        try {
            self::query($connection, "
            INSERT INTO users (userName, passwordHash) VALUES (?, ?);", [$userName, $passwordHash]);

            $user = self::getUserByUserName($userName);
            foreach ($channels as $channel) {
                self::query($connection, "INSERT INTO channelsForUser (userId, channelId) VALUES (?, ?);", [$user->getId(), $channel]);
            }
            $connection->commit();
            return true;
        } catch (\Exception $e) {
            $connection->rollBack();
            return false;
        } finally {
            self::closeConnection($connection);
        }
    }

    public static function getUserById(int $userId)
    {
        $user = null;

        $connection = self::getConnection();
        $result = self::query($connection, "
			SELECT id, userName, passwordHash
			FROM users
			WHERE id = ?;
		", [$userId]);

        if ($u = self::fetchObject($result)) {
            $user = new User($u->id, $u->userName, $u->passwordHash);
        }

        self::close($result);
        self::closeConnection($connection);

        return $user;
    }

    public static function getUserByUserName(string $userName)
    {
        $user = null;

        $connection = self::getConnection();
        $result = self::query($connection, "
			SELECT id, userName, passwordHash
			FROM users
			WHERE userName = ?;
		", [$userName]);

        if ($u = self::fetchObject($result)) {
            $user = new User($u->id, $u->userName, $u->passwordHash);
        }

        self::close($result);
        self::closeConnection($connection);

        return $user;
    }

    // helper methods 

    private static $__connection;

    private static function getConnection()
    {
        if (!isset(self::$__connection)) {

            $type = 'mysql';
            $host = 'localhost';
            $name = 'fh_2018_scm4_S1610307002';
            $user = 'root';
            $pass = 'root';

            self::$__connection = new \PDO(
                $type . ':host=' . $host . ';dbname=' . $name . ';charset=utf8', $user, $pass
            );
        }

        return self::$__connection;
    }

    public static function exposeConnection()
    {
        return self::getConnection();
    }

    private static function query($connection, $query, $parameters = array())
    {
        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        try {
            $statement = $connection->prepare($query);
            $i = 1;

            foreach ($parameters AS $param) {
                if (is_int($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_INT);
                }
                if (is_string($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_STR);
                }

                $i++;
            }

            $statement->execute();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $statement;
    }

    private static function lastInsertId($connection)
    {
        return $connection->lastInsertId();
    }

    private static function fetchObject($cursor)
    {
        return $cursor->fetchObject();
    }

    private static function close($cursor)
    {
        $cursor->closeCursor();
    }

    private static function closeConnection($connection)
    {
        self::$__connection = null;
    }
}



















