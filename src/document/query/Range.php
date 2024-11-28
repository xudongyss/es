<?php

namespace xd\es\document\query;

/**
 * 范围查询
 */
class Range extends Query
{
    /**
     * 字段
     */
    private $field;

    /**
     * 大于
     */
    private $gt;

    /**
     * 大于等于
     */
    private $gte;

    /**
     * 小于
     */
    private $lt;

    /**
     * 小于等于
     */
    private $lte;

    public static function create()
    {
        return new static();
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function setGt($gt)
    {
        $this->gt = $gt;

        return $this;
    }

    public function setGte($gte)
    {
        $this->gte = $gte;

        return $this;
    }

    public function setLt($lt)
    {
        $this->lt = $lt;

        return $this;
    }

    public function setLte($lte)
    {
        $this->lte = $lte;

        return $this;
    }

    public function build()
    {
        $data = [
            'range' => [
                $this->field => []
            ]
        ];

        if ($this->gt) {
            $data['range'][$this->field]['gt'] = $this->gt;
        }

        if ($this->gte) {
            $data['range'][$this->field]['gte'] = $this->gte;
        }

        if ($this->lt) {
            $data['range'][$this->field]['lt'] = $this->lt;
        }

        if ($this->lte) {
            $data['range'][$this->field]['lte'] = $this->lte;
        }

        return $data;
    }
}