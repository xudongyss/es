<?php
namespace xd\es\index;

class Tokenizer
{
    private $name;

    private $type;

    public static function create()
    {
        return new static();
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function build()
    {
        return [
            'type' => $this->type,
        ];
    }
}