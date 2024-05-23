<?php
namespace xd\es;

use Elasticsearch\ClientBuilder;

class EsClient
{
    public static function client()
    {
        $client = ClientBuilder::create()
            ->setConnectionPool('\Elasticsearch\ConnectionPool\StaticConnectionPool')
            ->setHosts(['https://es-qdqxq4at.public.tencentelasticsearch.com:9200'])
            ->setBasicAuthentication('elastic', 'E.MYhryJ69ATiUL')
            ->build();

        return $client;
    }
}