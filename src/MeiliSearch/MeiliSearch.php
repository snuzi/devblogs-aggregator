<?php
namespace EngBlogs\MeiliSearch;

use MeiliSearch\Client;

class MeiliSearch {
    private $client;
    private $host;
    private $masterKey;
    private $indexName;

    public function __construct(string $indexName) {
        $this->indexName = $indexName;
        $this->host = getenv('MEILI_HOST_NAME');
        $this->masterKey = getenv('MEILI_MASTER_KEY');
    }

    public function getClient(): Client {
        if ($this->client) {
            return $this->client;
        }

        $this->client = new Client($this->host, $this->masterKey);

        return $this->client;
    }

    public function getIndex() {
        return $this->getClient()->index($this->indexName);
    }

    public function updateIndexSettings() {
        $string = file_get_contents(__DIR__ . '/index-settings.json');
        $settings = json_decode($string, true);

        $this->getIndex()->updateSettings($settings);
    }

    public function addDocuments(array $documents, $returnStatus = false) {
        $updateItem = $this->getIndex()->addDocuments($documents);
        if ($returnStatus) {
            return $this->getIndex()->getUpdateStatus($updateItem['updateId']);
        }
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

    public function delete($documentsIds) {
        $this->getIndex()->deleteDocument($documentsIds);
    }
}
