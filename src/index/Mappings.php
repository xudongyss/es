<?php
namespace xudongyss\es\index;

use xudongyss\es\index\mappings\properties\Field;

class Mappings
{
    private $properties;

    public function __construct()
    {
        $this->properties = [];
    }

    public static function create()
    {
        return new static();
    }

    public function setProperties(Field $field)
    {
        $this->properties[$field->getFiled()] = $field->build();

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