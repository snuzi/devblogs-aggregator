<?php
namespace EngVlogs\Meili;

use MeiliSearch\Client;

class MeiliSearch {
    private $client;
    private $host;
    private $masterKey;
    private $indexName;

    public function __construct(string $index) {
        $this->indexName = $index;
        $this->host = getenv('MEILI_HOST_NAME');
        $this->masterKey = getenv('MEILI_MASTER_KEY');
    }

    public function getClient() {
        if ($this->client) {
            return $this->client;
        }

        $this->client = new Client($this->host);

        return $this->client;
    }


    public function getIndex() {
        return $this->getClient()->getIndex($this->indexName);
    }

    public function createIndex($indexName, $primaryKey = 'id') {
        $indexer = $this->getClient()->createIndex([
                'uid' => $indexName,
                'primaryKey' => $primaryKey
            ]);

        return $this;
    }

    public function add(array $documents, $returnStatus = false) {
        $updateItem = $this->getIndex()->addDocuments($documents);
        if ($returnStatus) {
            return $this->getIndex()->getUpdateStatus($updateItem['updateId']);
        }
    }

    public function delete($documentsIds) {
        $this->getIndex()->deleteDocument($documentsIds);
    }
}
