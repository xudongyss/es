<?php
namespace xd\es\document\query;

class QueryBool
{
    private $must = [];

    private $should = [];

    private $mustNot = [];

    private $filter = [];

    public static function create()
    {
        return new static();
    }

    public function setMust(Query $query)
    {
        $this->must[] = $query->build();

        return $this;
    }
}