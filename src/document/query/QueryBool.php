<?php
namespace xudongyss\es\document\query;

/**
 * 组合查询
 */
class QueryBool extends Query
{
    private $must = [];

    private $should = [];

    private $mustNot = [];

    private $filter = [];

    public function setMust(Query $query)
    {
        $this->must[] = $query->build();

        return $this;
    }

    public function setShould(Query $query)
    {
        $this->should[] = $query->build();

        return $this;
    }

    public function setMustNot(Query $query)
    {
        $this->mustNot[] = $query->build();

        return $this;
    }

    public function setFilter(Query $query)
    {
        $this->filter[] = $query->build();

        return $this;
    }

    public function build()
    {
        $data = [];
        if ($this->must) {
            $data['must'] = $this->must;
        }
        if ($this->should) {
            $data['should'] = $this->should;
        }
        if ($this->mustNot) {
            $data['must_not'] = $this->mustNot;
        }
        if ($this->filter) {
            $data['filter'] = $this->filter;
        }

        return $data;
    }
}