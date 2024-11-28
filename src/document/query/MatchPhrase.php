<?php
namespace xudongyss\es\document\query;

class MatchPhrase extends Query
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
            'match_phrase' => [
                $this->field => $this->query,
            ]
        ];
    }
}