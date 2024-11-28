<?php

namespace xd\es\document;

class Sort
{
    private $field;

    private $order;

    public static function create()
    {
        return new static();
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    public function build()
    {
        return [
            $this->field => [
                'order' => $this->order,
            ]
        ];
    }
}