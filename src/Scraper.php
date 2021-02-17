<?php
namespace EngBlogs;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Wa72\Url\Url;

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
            $metaImage = $this->getAbsoluteUrl($url, $metaImage);
        } catch (\Exception $e) {
            // Image missing
            $metaImage = '';
        }

        return [
            'image' => $metaImage
        ];
    }

    /**
     * Resolve url https://example.com/page.html + ../subdir/image.png
     * into https://example.com/subdir/image.png
     * @param $baseUrl
     * @param $imageUrl
     * @return string
     */
    private function getAbsoluteUrl($baseUrl, $imageUrl): string {
        if (str_starts_with($imageUrl, 'http')) {
            return $imageUrl;
        }

        $waUrl = Url::parse($imageUrl);
        $baseWaUrl = Url::parse($baseUrl);
        $waUrl->makeAbsolute($baseWaUrl);

        return $waUrl;
    }
}
