<?php

namespace EngBlogs\Commands;

use EngBlogs\MeiliSearch\MeiliSearch;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateIndex extends Command {

    protected function configure() {
        $this->setName('db:create-index')
            ->setDescription('Create database index');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $meiliClient = new MeiliSearch(getenv('MEILI_INDEX_NAME'));
        $meiliClient->createIndex();
        $output->writeln('Index created');
        try {
            $meiliClient->createIndex();
            $output->writeln('Index created');
        } catch (\Exception $exception) {
            $output->writeln('Index already exists');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
