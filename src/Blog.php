<?php
namespace EngBlogs;

class Blog {
    private string $name;
    private string $link;
    private string $id;
    private string $rssFeed;

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

    public function serialize(): array {
        return [
            'id' => $this->getId(),
            'link' => $this->getLink(),
            'name' => $this->getName(),
            'rssFeed' => $this->getRssFeed()
        ];
    }
}
