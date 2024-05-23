<?php
require_once 'vendor/autoload.php';

use xd\es\EsClient;

$client = EsClient::client();

echo '<pre>';print_r($client);

try {
    $client->indices()->create([
        'index' => 'for_test',
        'body' => [
            'settings' => [
                'number_of_shards' => 3,
                'number_of_replicas' => 2
            ],
            'mappings' => [
                'properties' => [
                    'content' => ['type' => 'text'],
                ]
            ],
        ],
    ]);
} catch (\Exception $e) {
    echo $e->getMessage();
}
