<?php

namespace Data;

class Post extends Entity {

    private $channelId;
    private $title;
    private $content;
    private $author;
    private $timestamp;
    private $isPinned;

    public function __construct(int $id, int $channelId, string $title, string $content, string $author, string $timestamp, bool $isPinned) {
        parent::__construct($id);
        $this->channelId = $channelId;
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->timestamp = $timestamp;
        $this->isPinned = $isPinned;
    }

    public function getChannelId() {
        return $this->channelId;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function isPinned() {
        return $this->isPinned;
    }
}