<?php
namespace EngBlogs;

use EngBlogs\XmlParser;

class RssAggregator {
    public function getBlogJsonUrls(): array {
        $blogsString = file_get_contents(__DIR__ . '/../vendor/snuzi/awesome-blogs/engineering-tech-blogs.json');
        $blogsJson = json_decode($blogsString, true);

        return $blogsJson;
    }

    public function run() {
        $blogsJson = $this->getBlogJsonUrls();
        foreach($blogsJson as $blog) {
            $xml = simplexml_load_file($blog['rssFeed']);
            $xmlParser = new XmlParser($xml);
            $posts = $xmlParser->getPosts();
            // Parse blog
        }
    }
}
