<?php
namespace xudongyss\es\document\query;

class QueryMatch extends Query
{
    private $field;

    private $query;

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    public function build()
    {
        return [
            'match' => [
                $this->field => $this->query
            ]
        ];
    }
}