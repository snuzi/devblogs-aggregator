<?php
namespace EngBlogs;

use EngBlogs\MeiliSearch\MeiliSearch;
use EngBlogs\Models\Blog;
use Laminas\Feed\Reader\Reader;

class BlogRssAggregator {
    public function run($rssFeed) {
        $meiliClient = new MeiliSearch(getenv('MEILI_INDEX_NAME'));

        $blog = new Blog();
        $blog->setName($rssFeed['title'])
            ->setId($rssFeed['id'])
            ->setLink($rssFeed['blogUrl'])
            ->setType($rssFeed['type'])
            ->setGithubUsername($rssFeed['githubUsername'])
            ->setImage($rssFeed['image'])
            ->setRssFeed($rssFeed['rssFeed']);

        $feed = Reader::import($blog->getRssFeed());

        $xmlParser = new FeedParser($feed, $blog, $meiliClient);
        $posts = $xmlParser->getPosts();

        printf("Crawling %s, %d docs to be indexed \n", $blog->getName(), count($posts));

        $meiliClient->addDocuments($posts);
    }
}
