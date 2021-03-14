<?php
namespace EngBlogs;

class RssAggregator {
    public function getBlogJsonUrls(): array {
        $blogsString = file_get_contents(getenv('RSS_FEEDS'));
        if (!$blogsString) {
            $blogsString = file_get_contents(__DIR__ . '/../vendor/snuzi/awesome-blogs/engineering-tech-blogs.json');
        }

        $blogsJson = json_decode($blogsString, true);

        return $blogsJson;
    }

    public function run() {
        $blogAggregator = new BlogRssAggregator();
        $blogsJson = $this->getBlogJsonUrls();
        foreach($blogsJson as $blogJson) {
            $blogJson['type'] = Blog::TYPE_COMPANY;
            $blogAggregator->run($blogJson);
        }
    }
}
