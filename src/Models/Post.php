<?php
namespace EngBlogs\Models;

class Post {
    private string $link;
    private string $title;
    private string $description;
    private string $publishDate;
    private array $categories;
    private string $image;
    private Blog $blog;

    public function setLink(string $link): Post {
        $this->link = $link;

        return $this;
    }

    public function getLink():string {
        return $this->link;
    }

    public function setImage(string $image): Post {
        $this->image = $image;

        return $this;
    }

    public function getImage():string {
        return $this->image;
    }

    public function setBlog(Blog $blog): Post {
        $this->blog = $blog;

        return $this;
    }

    public function getBlog():Blog {
        return $this->blog;
    }

    public function setTitle(string $title): Post {
        $this->title = $title;

        return $this;
    }

    public function getTitle() :string {
        return $this->title;
    }

    public function setCategories(array $categories): Post {
        $this->categories = $categories;

        return $this;
    }

    public function getCategories():array {
        return $this->categories;
    }

    public function setDescription(string $description): Post {
        $this->description = $description;

        return $this;
    }

    public function getDescription():string {
        return $this->description;
    }

    public function setPublishDate(string $date): Post {
        $this->publishDate = $date;
        
        return $this;
    }

    public function getPublishDate():string {
        return $this->publishDate;
    }

    public function getPublishTimestamp(): int {
        return strtotime($this->publishDate);
    }

    public function getId(): string {
        return md5($this->link);
    }

    public function serialize(): array {
        return [
            'id' => $this->getId(),
            'link' => $this->getLink(),
            'description' => $this->getDescription(),
            'categories' => $this->getCategories(),
            'title' => $this->getTitle(),
            'publish_timestamp' => $this->getPublishTimestamp(),
            'publish_date' => $this->getPublishDate(),
            'update_timestamp' => time(),
            'blogName' => $this->getBlog() ? $this->getBlog()->getName() : '',
            'blogType' => $this->getBlog() ? $this->getBlog()->getType() : '',
            'blog' => $this->getBlog() ? $this->getBlog()->serialize() : [],
            'image' => $this->getImage()
        ];
    }
}
