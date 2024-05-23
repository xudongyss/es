<?php
namespace xd\es;

class EsIndex
{
    private $client;

    private $index;

    private $settings;

    public function __construct()
    {
        $this->client = EsClient::client();
    }

    public static function build()
    {
        return new static();
    }

    /**
     * 设置分片数
     * @param $number
     * @return $this
     */
    public function setNumberOfShards($number)
    {
        $this->settings['number_of_shards'] = $number;

        return $this;
    }

    /**
     * 设置副本数
     * @param $number
     * @return $this
     */
    public function setNumberOfReplicas($number)
    {
        $this->settings['number_of_replicas'] = $number;

        return $this;
    }

    /**
     * 创建索引
     * @return void
     * @throws \Exception
     */
    public function create()
    {
        try {
            $this->client->indices()->create([
                'index' => 'for_test',
                'body' => [
                    'settings' => $this->settings,
                    'mappings' => [
                        'properties' => [
                            'content' => ['type' => 'text'],
                        ]
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}