<?php
namespace EngBlogs;

use EngBlogs\MeiliSearch\MeiliSearch;

class BlogRssAggregator {
    public function run($rssFeed) {
        $meiliClient = new MeiliSearch(getenv('MEILI_INDEX_NAME'));

        $blog = new Blog();
        $blog->setName($rssFeed['title'])
            ->setId($rssFeed['id'])
            ->setLink($rssFeed['blogUrl'])
            ->setRssFeed($rssFeed['rssFeed']);

        $xml = simplexml_load_file($blog->getRssFeed());
        $xmlParser = new XmlParser($xml, $blog);
        $posts = $xmlParser->getPosts();
        $meiliClient->addDocuments($posts);
    }
}
