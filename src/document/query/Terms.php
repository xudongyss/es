<?php
namespace xd\es\document\query;

class Terms extends Query
{
    private $field;

    private $terms;

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function setTerms(array $terms)
    {
        $this->terms = $terms;

        return $this;
    }

    public function build()
    {
        return [
            'terms' => [
                $this->field => $this->terms
            ]
        ];
    }
}