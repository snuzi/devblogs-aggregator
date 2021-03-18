<?php
namespace EngBlogs;

use EngBlogs\MeiliSearch\MeiliSearch;

class FeedParser {
    private $feed;
    private Blog $blog;
    private $scraper;
    private $meiliClient;

    function __construct($feed, Blog $blog, MeiliSearch $meiliClient) {
        $this->feed = $feed;
        $this->blog = $blog;
        $this->meiliClient = $meiliClient;

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
            $postId = md5($entry->getLink());
            $documentIndexed = $this->getDocument($postId);
            if ($documentIndexed !== null) { // Post already exists, skip indexing the rest of feed posts
                break;
            }

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

    private function getDocument(string $id): ?array {
        return $this->meiliClient->getDocument($id);
    }
}
