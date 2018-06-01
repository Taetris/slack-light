<?php

namespace Data;

class Post extends Entity {

    private $channelId;
    private $title;
    private $content;
    private $author;
    private $timestamp;
    private $isPinned;
    private $isSeen;

    public function __construct(int $id, int $channelId, string $title, string $content, string $author, string $timestamp) {
        parent::__construct($id);
        $this->channelId = $channelId;
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->timestamp = $timestamp;
        $this->isPinned = false;
        $this->isSeen = false;
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

    public function isSeen() {
        return $this->isSeen;
    }

    public function setPinned($isPinned) {
        $this->isPinned = $isPinned;
    }

    public function setSeen($isSeen) {
        $this->isSeen = $isSeen;
    }
}