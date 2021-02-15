<?php

namespace EngBlogs\Commands;

use EngBlogs\MeiliSearch\MeiliSearch;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateIndexSettings extends Command {

    protected function configure() {
        $this->setName('db:update-index-settings')
            ->setDescription('Update index settings');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $meiliClient = new MeiliSearch(getenv('MEILI_INDEX_NAME'));
        $meiliClient->updateIndexSettings();

        $output->writeln('Settings updated');

        return Command::SUCCESS;
    }
}
