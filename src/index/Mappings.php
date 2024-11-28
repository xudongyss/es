<?php
namespace xudongyss\es\index;

class Mappings
{
    private $properties;

    private $callMap = [
        'setProperties' => 'properties',
    ];

    public function __construct()
    {
        $this->properties = [];
    }

    public static function create()
    {
        return new static();
    }

    public function setProperties(Propertie $propertie)
    {
        $this->properties[$propertie->getFiled()] = $propertie->build();

        return $this;
    }

    public function build()
    {
        $data = [];
        if ($this->properties) {
            $data['properties'] = $this->properties;
        }

        return $data;
    }
}