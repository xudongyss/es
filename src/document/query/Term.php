<?php
namespace xd\es\document\query;

class Term extends Query
{
    private $field;

    private $value;

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function build()
    {
        return [
            'term' => [
                $this->field => $this->value
            ]
        ];
    }
}