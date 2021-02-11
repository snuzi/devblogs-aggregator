<?php

namespace EngBlogs\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Rss extends Command {

    protected function configure() {
        $this->setName('rss:crawl')
            ->setDescription('Crawl posts from rss feeds');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        // @todo implement
    }
}
