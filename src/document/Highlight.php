<?php
namespace xudongyss\es\document;

use xudongyss\es\document\highlight\Field;

class Highlight
{
    private $fields = [];

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
        if (count($this->fields)) {
            return [
                'fields' => $this->fields
            ];
        }

        return [];
    }
}