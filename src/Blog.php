<?php
namespace EngBlogs;

class Blog {
    const TYPE_COMPANY = 'company';
    const TYPE_INDIVIDUAL = 'individual';

    private string $name;
    private string $link;
    private string $id;
    private string $rssFeed;
    private string $type;

    public function setLink(string $link) {
        $this->link = $link;

        return $this;
    }

    public function getLink():string {
        return $this->link;
    }

    public function setName(string $name) {
        $this->name = $name;

        return $this;
    }

    public function getName():string {
        return $this->name;
    }

    public function setId(string $id) {
        $this->id = $id;

        return $this;
    }

    public function getId():string {
        return $this->id;
    }

    public function setRssFeed(string $feed) {
        $this->rssFeed = $feed;

        return $this;
    }

    public function getRssFeed():string {
        return $this->rssFeed;
    }

    public function setType(string $type) {
        $this->type = $type;

        return $this;
    }

    public function getType():string {
        return $this->type;
    }

    public function serialize(): array {
        return [
            'id' => $this->getId(),
            'link' => $this->getLink(),
            'name' => $this->getName(),
            'rssFeed' => $this->getRssFeed(),
            'type' => $this->getType()
        ];
    }
}
