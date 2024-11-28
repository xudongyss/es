<?php
namespace xudongyss\es\document\query;

class MultiMatch extends Query
{
    private $query;

    private $fields;

    private $type;

    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function build()
    {
        $data = [
            'multi_match' => [
                'query' => $this->query,
                'fields' => $this->fields,
            ]
        ];

        if ($this->type) {
            $data['multi_match']['type'] = $this->type;
        }

        return $data;
    }
}