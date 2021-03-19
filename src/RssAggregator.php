<?php
namespace EngBlogs;

use EngBlogs\Models\Blog;

class RssAggregator {
    public static function getBlogJsonUrls(): array {
        $blogsString = file_get_contents(getenv('RSS_FEEDS'));
        if (!$blogsString) {
            $blogsString = file_get_contents(__DIR__ . '/../vendor/snuzi/awesome-blogs/engineering-tech-blogs.json');
        }

        return json_decode($blogsString, true);
    }

    public function run() {
        $blogAggregator = new BlogRssAggregator();
        $blogsJson = self::getBlogJsonUrls();
        foreach($blogsJson as $blogJson) {
            $blogJson['type'] = Blog::TYPE_COMPANY;
            $blogAggregator->run($blogJson);
        }
    }
}
