<?php

namespace EngBlogs\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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

        $documents = $meiliClient->getDocuments(1000);

        $docsToUpdate = [];
        foreach($documents as $document) {
            $docsToUpdate[] = [
                'id' => $document['id'],
                'post_id' => md5($document['link'])
            ];
        }

        $meiliClient->updateDocuments($docsToUpdate);

        return Command::SUCCESS;
    }
}
