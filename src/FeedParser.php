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
        $categories = [];
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

    public function getPosts(): array {
        return $this->parseFeed();
    }
}
