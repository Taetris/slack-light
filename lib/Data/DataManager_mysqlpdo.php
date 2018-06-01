<?php /** @noinspection ALL */

namespace Data;

include 'IDataManager.php';

class DataManager implements IDataManager
{
    public static function deletePost(int $postId): bool
    {
    }

    public static function pinPostForUser(string $userName, int $postId): bool
    {
    }

    public static function unpinPostForUser(string $userName, int $postId): bool
    {
    }

    public static function storePost(int $channelId, string $title, string $content, string $userName, string $timestamp): bool
    {
    }

    public static function editPost(int $postId, string $title, string $content): bool
    {
    }

    public static function getPostsForChannel(int $channelId): array
    {
        if ($channelId == -1) {
            return array();
        }

        $posts = array();

        $connection = self::getConnection();
        // sort chronologically
        $result = self::query($connection, "SELECT * FROM posts WHERE channelId = ?;" [$channelId]);

        while ($post = self::fetchObject($result)) {
            // missing union with pinned and seen posts
            $posts[] = new Post($p->id, $p->channelId, $p->title, $p->content, $p->author, $p->timestamp, false, false);
        }

        self::close($result);
        self::closeConnection($connection);

        return $posts;
    }

    public static function getPostById(int $postId)
    {
        $post = null;

        $connection = self::getConnection();
        $result = self::query($connection, "SELECT * FROM posts WHERE id = ?;", [$postId]);

        if ($p = self::fetchObject($result)) {
            // we don't care here if the post is pinned or seen
            $post = new Post($p->id, $p->channelId, $p->title, $p->content, $p->author, $p->timestamp, false, false);
        }

        self::close($result);
        self::closeConnection($connection);

        return $channels;
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

    public static function getChannelsForUser(string $userName): array
    {
        $channels = array();
        $user = self::getUserByUserName($userName);

        $connection = self::getConnection();
        $result = self::query($connection, "SELECT channelId FROM channelsForUser WHERE userId = ?", [$user->getId()]);

        while ($channel = self::fetchObject($result)) {
            $channels[] = self::getChannelForId($channel->channelId);
        }

        self::close($result);
        self::closeConnection($connection);

        return $channels;
    }

    public static function storeUser(string $userName, string $passwordHash, $channels): bool
    {
        $connection = self::getConnection();
        $connection->beginTransaction();

        try {
            self::query($connection, "
            INSERT INTO users (userName, passwordHash) VALUES (?, ?);", [$userName, $passwordHash]);

            $user = self::getUserByUserName($userName);
            foreach($channels as $channel) {
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



















