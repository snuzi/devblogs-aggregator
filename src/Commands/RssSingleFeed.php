<?php

namespace EngBlogs\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Rss extends Command {

    protected function configure() {
        $this->setName('rss:feed')
            ->setDescription('Crawl posts from a RSS blog feed')
            ->addArgument('url', InputArgument::REQUIRED, 'The blog feed xml URL');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        return Command::FAILURE;
    }
}
