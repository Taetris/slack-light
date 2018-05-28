<?php

namespace Data;

class Channel extends Entity {

    private $name;
    private $description;

    public function __construct(int $id, string $name, string $description) {
        parent::__construct($id);
        $this->name = $name;
        $this->description = $description;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }
}