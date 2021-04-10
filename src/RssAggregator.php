<?php
namespace EngBlogs;

use EngBlogs\Models\Blog;

class RssAggregator {
    public static function getBlogJsonUrls(): array {
        $companyBlogsFeedStr = file_get_contents(getenv('RSS_COMPANY_FEEDS'));
        $individualBlogsFeedStr = file_get_contents(getenv('RSS_INDIVIDUAL_FEEDS'));

        $blogs = [];
        if ($companyBlogsFeedStr) {
            $blogs[] = [
                'type' => Blog::TYPE_COMPANY,
                'feed' => json_decode($companyBlogsFeedStr, true)
            ];
        }

        if ($individualBlogsFeedStr) {
            $blogs[] = [
                'type' => Blog::TYPE_INDIVIDUAL,
                'feed' => json_decode($individualBlogsFeedStr, true)
            ];
        }
        return $blogs;
    }

    public function run() {
        $blogAggregator = new BlogRssAggregator();

        $blogsFeeds = self::getBlogJsonUrls();
        foreach ($blogsFeeds as $blogsJson) {
            printf("Aggregating blogs for type: %s \n", $blogsJson['type']);
            foreach($blogsJson['feed'] as $blogJson) {
                $blogJson['type'] = $blogsJson['type'];
                $blogAggregator->run($blogJson);
            }
        }
    }
}
