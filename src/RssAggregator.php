<?php
namespace EngBlogs;

use EngBlogs\MeiliSearch\MeiliSearch;

class RssAggregator {
    public function getBlogJsonUrls(): array {
        $blogsString = file_get_contents(__DIR__ . '/../vendor/snuzi/awesome-blogs/engineering-tech-blogs.json');
        $blogsJson = json_decode($blogsString, true);

        return $blogsJson;
    }

    public function run() {
        $meiliClient = new MeiliSearch(getenv('MEILI_INDEX_NAME'));

        $blogsJson = $this->getBlogJsonUrls();
        foreach($blogsJson as $blogJson) {
            $blog = new Blog();
            $blog->setName($blogJson['title'])
                ->setId($blogJson['id'])
                ->setLink($blogJson['blogUrl'])
                ->setRssFeed($blogJson['rssFeed']);

            $xml = simplexml_load_file($blog->getRssFeed());
            $xmlParser = new XmlParser($xml, $blog);
            $posts = $xmlParser->getPosts();
            $meiliClient->addDocuments($posts);
        }
    }
}
