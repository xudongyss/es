<?php
namespace xudongyss\es\document\query;

/**
 * IDs 查询
 */
class IDs extends Query
{
    private $values;

    public function setValues(array $values)
    {
        $this->values = $values;

        return $this;
    }

    public function build()
    {
        return [
            'ids' => [
                'values' => $this->values
            ]
        ];
    }
}