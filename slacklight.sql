DROP DATABASE IF EXISTS fh_2018_scm4_S1610307002;
CREATE DATABASE fh_2018_scm4_S1610307002;
USE fh_2018_scm4_S1610307002;

-- main tables

CREATE TABLE users (
 id int(11) NOT NULL AUTO_INCREMENT,
 userName varchar(255) NOT NULL,
 passwordHash char(40) NOT NULL,

 PRIMARY KEY (id),
 UNIQUE KEY userName (userName)
) ENGINE=InnoDb AUTO_INCREMENT=1 CHARSET=utf8;;

CREATE TABLE channels (
  id int(11) NOT NULL AUTO_INCREMENT,
  channelName varchar(255) NOT NULL,

  PRIMARY KEY (id),
  UNIQUE KEY channelName (channelName)
) ENGINE=InnoDb AUTO_INCREMENT=1 CHARSET=utf8;;

CREATE TABLE posts (
  id int(11) NOT NULL AUTO_INCREMENT,
  channelId int(11) NOT NULL,
  title varchar(255) NOT NULL,
  content varchar(255) NOT NULL,
  author varchar(255) NOT NULL,
  timestamp datetime NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (channelId) REFERENCES channels(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDb AUTO_INCREMENT=1 CHARSET=utf8;;

-- helper tables for many-to-many relations

CREATE TABLE channelsForUser (
  userId int(11) NOT NULL,
  channelId int (11) NOT NULL,

  PRIMARY KEY (userId, channelId),
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (channelId) REFERENCES channels(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDb AUTO_INCREMENT=1 CHARSET=utf8;;

CREATE TABLE favourites (
  userId int(11) NOT NULL,
  postId int(11) NOT NULL,

  PRIMARY KEY (userId, postId),
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (postId) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDb AUTO_INCREMENT=1 CHARSET=utf8;;

CREATE TABLE lastReadPost (
  userId int(11) NOT NULL,
  channelId int (11) NOT NULL,
  postId int(11) NOT NULL,

  PRIMARY KEY (userId, channelId, postId),
  FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (channelId) REFERENCES channels(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (postId) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDb AUTO_INCREMENT=1 CHARSET=utf8;;

INSERT INTO channels VALUES (1, 'Random');
INSERT INTO channels VALUES (2, 'FH');
