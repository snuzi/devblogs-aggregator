<?php
namespace EngBlogs\MeiliSearch;

use MeiliSearch\Client;
use MeiliSearch\Endpoints\Indexes;

class MeiliSearch {
    private Client $client;
    private string $host;
    private string $masterKey;
    private string $indexName;

    public function __construct(string $indexName) {
        $this->indexName = $indexName;
        $this->host = getenv('MEILI_HOST_NAME');
        $this->masterKey = getenv('MEILI_MASTER_KEY');
    }

    public function getClient(): Client {
        if (isset($this->client)) {
            return $this->client;
        }

        $this->client = new Client($this->host, $this->masterKey);

        return $this->client;
    }

    public function getIndex(): Indexes {
        return $this->getClient()->index($this->indexName);
    }

    public function updateIndexSettings(): array {
        $string = file_get_contents(__DIR__ . '/index-settings.json');
        $settings = json_decode($string, true);

        return $this->getIndex()->updateSettings($settings);
    }

    public function addDocuments(array $documents): array
    {
        return $this->getIndex()->addDocuments($documents);
    }

    public function updateDocuments(array $documents) {
        $this->getIndex()->updateDocuments($documents);
    }

    public function getDocuments(int $limit): array {
        return $this->getIndex()->getDocuments(['limit' => $limit]);
    }

    public function getDocument(string $id): array {
        return $this->getIndex()->getDocument($id);
    }

    public function delete($documentsIds): array {
        return $this->getIndex()->deleteDocument($documentsIds);
    }
}
