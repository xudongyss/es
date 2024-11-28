<?php
namespace xudongyss\es\document\highlight;

class Field
{
    private $field;

    public static function create()
    {
        return new static();
    }

    public function getField()
    {
        return $this->field;
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function build()
    {
        return (object)[];
    }
}