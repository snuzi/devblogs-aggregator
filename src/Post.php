<?php
namespace EngBlogs;

class Post {
    private string $link;
    private string $blogName;
    private string $description;
    private string $publishDate;

    public function setLink(string $link) {
        $this->link = $link;

        return $this;
    }

    public function getLink():string {
        return $this->link;
    }

    public function setBlogName(string $blogName) {
        $this->blogName = $blogName;
        
        return $this;
    }

    public function getBlogName():string {
        return $this->blogName;
    }

    public function setDescription(string $description) {
        $this->description = $description;

        return $this;
    }

    public function getDescription():string {
        return $this->description;
    }

    public function setPublishDate(string $date) {
        $this->publishDate = $date;
        
        return $this;
    }

    public function getPublishDate():string {
        return $this->publishDate;
    }

    public function getPublishTimestamp(): int {
        return strtotime((string) $this->publishDate);
    }

    public function getId(): string {
        return md5($this->link);
    }
}
