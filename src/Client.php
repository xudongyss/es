<?php
namespace xd\es;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Endpoints\Indices;

/**
 * @method Indices indices()
 * @method index($params)
 */

class Client
{
    /**
     * @return \Elastic\Elasticsearch\Client|null
     */
    public static function client()
    {
        static $client = null;
        if ($client) {
            return $client;
        }

        $client = ClientBuilder::create()
            ->setHosts([Env::get("ELASTICSEARCH_HOST")])
            ->setBasicAuthentication(Env::get("ELASTICSEARCH_USERNAME"), Env::get("ELASTICSEARCH_PASSWORD"))
            ->build();

        return $client;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::client(), $name], $arguments);
    }
}