<?php
namespace EngBlogs;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class Scraper {
    private $client;

    public function __construct() {
        $this->client = new Client(HttpClient::create(['timeout' => 10]));
    }

    public function getCrawler($url): Crawler {
        return $this->client->request('GET', $url);
    }

    public function scrapePage($url): array {
        $crawler = $this->getCrawler($url);
        try {
            $metaImage = $crawler->filter('meta[property="og:image"]')->eq(0)->attr('content');
        } catch (\Exception $e) {
            // Image missing
            $metaImage = '';
        }

        return [
            'image' => $metaImage
        ];
    }
}