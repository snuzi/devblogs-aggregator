<?php
namespace EngBlogs;

use EngBlogs\MeiliSearch\MeiliSearch;
use EngBlogs\Models\Blog;
use Laminas\Feed\Reader\Reader;

class BlogRssAggregator {
    public function run($rssFeed) {
        $meiliClient = new MeiliSearch(getenv('MEILI_INDEX_NAME'));

        try {
            $blog = new Blog();
            $blog->setName($rssFeed['title'])
                ->setLink($rssFeed['blogUrl'])
                ->setType($rssFeed['type'])
                ->setGithubUsername($rssFeed['githubUsername'])
                ->setRssFeed($rssFeed['rssFeed']);

            if (!empty($rssFeed['image'])) {
                $blog->setImage($rssFeed['image']);
            }

            printf("Aggregating %s ...\n", $blog->getName());

            $feed = Reader::import($blog->getRssFeed());

            $xmlParser = new FeedParser($feed, $blog, $meiliClient);
            $posts = $xmlParser->getPosts();

            $meiliClient->addDocuments($posts);
            printf("%d documents indexed \n", count($posts));

        } catch (\Exception $e) {
            printf("Failed, message: %s \n", $e->getMessage());
        }
    }
}
