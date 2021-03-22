<?php
namespace EngBlogs\Commands;

use EngBlogs\Models\Blog;
use EngBlogs\RssAggregator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use EngBlogs\MeiliSearch\MeiliSearch;

class UpdateIndexDocs extends Command {

    protected function configure() {
        $this->setName('index:update-docs')
            ->setDescription('Update index docs');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $meiliClient = new MeiliSearch(getenv('MEILI_INDEX_NAME'));

        $blogsJson = RssAggregator::getBlogJsonUrls();
        $blogs = [];
        foreach($blogsJson as $rssFeed) {
            $rssFeed['type'] = Blog::TYPE_COMPANY;

            $blog = new Blog();
            $blog->setName($rssFeed['title'])
                ->setLink($rssFeed['blogUrl'])
                ->setType($rssFeed['type'])
                ->setGithubUsername($rssFeed['githubUsername'])
                ->setRssFeed($rssFeed['rssFeed']);

            $blogs[$rssFeed['blogUrl']] = $blog;
        }

        $documents = $meiliClient->getDocuments(1000);

        $docsToUpdate = [];
        foreach($documents as $document) {

            $docsToUpdate[] = [
                'id' => $document['id'],
                'post_id' => md5($document['link']),
                'blog' => $blogs[$document['blog']['link']]->serialize()
            ];
        }

        $meiliClient->updateDocuments($docsToUpdate);

        return Command::SUCCESS;
    }
}
