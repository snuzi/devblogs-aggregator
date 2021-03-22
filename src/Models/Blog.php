<?php
namespace EngBlogs\Models;

class Blog {
    const TYPE_COMPANY = 'company';
    const TYPE_INDIVIDUAL = 'individual';

    private string $name;
    private string $link;
    private string $rssFeed;
    private string $type;
    private string $image = '';
    private string $githubUsername;

    public function setLink(string $link): Blog {
        $this->link = $link;

        return $this;
    }

    public function getLink():string {
        return $this->link;
    }

    public function setName(string $name): Blog {
        $this->name = $name;

        return $this;
    }

    public function getName():string {
        return $this->name;
    }

    public function setRssFeed(string $feed): Blog {
        $this->rssFeed = $feed;

        return $this;
    }

    public function getRssFeed():string {
        return $this->rssFeed;
    }

    public function setImage(string $img): Blog {
        $this->image = $img;

        return $this;
    }

    public function getImage():string {
        return $this->image;
    }

    public function setGithubUsername(string $username): Blog {
        $this->githubUsername = $username;

        return $this;
    }

    public function getGithubUsername():string {
        return $this->githubUsername;
    }

    public function setType(string $type): Blog {
        $this->type = $type;

        return $this;
    }

    public function getType():string {
        return $this->type;
    }

    public function serialize(): array {
        $object = [
            'link' => $this->getLink(),
            'githubUsername' => $this->getGithubUsername(),
            'name' => $this->getName(),
            'rssFeed' => $this->getRssFeed(),
            'type' => $this->getType()
        ];

        if (!empty($this->getImage())) {
            $object['image'] = $this->getImage();
        }

        return $object;
    }
}
