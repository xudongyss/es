<?php
namespace xd\es\document;

use xd\es\document\highlight\Field;

class Highlight
{
    private $fields;

    public static function create()
    {
        return new static();
    }

    public function setFields(Field $field)
    {
        $this->fields[$field->getField()] = $field->build();

        return $this;
    }

    public function build()
    {
        return [
            'fields' => $this->fields
        ];
    }
}