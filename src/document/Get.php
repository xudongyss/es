<?php

namespace xudongyss\es\document;

class Get
{
    private $index;

    private $id;

    public static function create()
    {
        return new static();
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function build()
    {
        return [
            'index' => $this->index,
            'id' => $this->id,
        ];
    }
}