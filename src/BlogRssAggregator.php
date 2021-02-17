<?php
namespace EngBlogs;

use EngBlogs\MeiliSearch\MeiliSearch;
use Laminas\Feed\Reader\Reader;

class BlogRssAggregator {
    public function run($rssFeed) {
        $meiliClient = new MeiliSearch(getenv('MEILI_INDEX_NAME'));

        $blog = new Blog();
        $blog->setName($rssFeed['title'])
            ->setId($rssFeed['id'])
            ->setLink($rssFeed['blogUrl'])
            ->setRssFeed($rssFeed['rssFeed']);

        $feed = Reader::import($blog->getRssFeed());

        $xmlParser = new XmlParser($feed, $blog);
        $posts = $xmlParser->getPosts();
        $meiliClient->addDocuments($posts);
    }
}
