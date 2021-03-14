<?php
namespace EngBlogs;

class FeedParser {
    private $feed;
    private Blog $blog;
    private $scraper;

    function __construct($feed, Blog $blog) {
        $this->feed = $feed;
        $this->blog = $blog;

        $this->scraper = new Scraper();
    }

    private function parsePostItem($feedEntry): Post {
        $title = $feedEntry->getTitle();
        $categories = array_unique(
            $feedEntry->getCategories()->getValues()
        );

        $categories = $this->cleanUpCatgories($categories);
        
        $link = $feedEntry->getLink();
        $pubDate = $feedEntry->getDateModified()->format('Y-m-d H:i:s');
        $description = $feedEntry->getDescription();

        if (!$description) {
            $description = $feedEntry->getContent();
        }

        $post = new Post();
        $post->setTitle($title)
            ->setLink($link)
            ->setBlog($this->blog)
            ->setCategories($categories)
            ->setDescription(strip_tags($description))
            ->setPublishDate($pubDate);

        $scrapedPost = $this->scraper->scrapePage($link);
        $post->setImage($scrapedPost['image']);

        return $post;
    }

    private function parseFeed(): array {
        $posts = [];
        foreach ($this->feed as $entry) {
            $post = $this->parsePostItem($entry);
            $posts[] = $post->serialize();
        }

        return $posts;
    }

    private function cleanUpCatgories($categories): array {
        return preg_replace("/[^a-zA-Z 0-9]+/", "", $categories);
    }

    public function getPosts(): array {
        return $this->parseFeed();
    }
}
