<?php

namespace EngBlogs\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Sitemap extends Command {

    protected function configure() {
        $this->setName('sitemap:crawl')
            ->setDescription('Crawl posts from a sitemap.xml')
            ->addArgument('url', InputArgument::REQUIRED, 'The blog sitemap.xml URL');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $url = $input->getArgument('url');
        // @todo implement
    }
}
