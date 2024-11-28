<?php
namespace xd\es\index;

class Delete
{
    private $index;

    public static function create()
    {
        return new static();
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    public function build()
    {
        return [
            'index' => $this->index
        ];
    }
}