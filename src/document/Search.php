<?php
namespace xudongyss\es\document;

use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\QueryBool;
use xudongyss\es\document\query\Query;

/**
 * @method $this setQueryBoolMust(Query $query) 设置must条件
 * @method $this setQueryBoolShould(Query $query) 设置should条件
 * @method $this setQueryBoolMustNot(Query $query) 设置must_not条件
 * @method $this setHighlightFields(Field $field) 设置高亮字段
 */
class Search
{
    private $index;

    private $bool;

    private $from;

    private $size;

    private $sort;

    private $highlight;

    public function __construct()
    {
        $this->bool = QueryBool::create();
        $this->highlight = Highlight::create();
    }

    public static function create()
    {
        return new static();
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    public function setSort(Sort $sort)
    {
        $this->sort[] = $sort;

        return $this;
    }

    public function build()
    {
        $data = [
            'index' => $this->index,
            'body' => [
                'query' => [],
            ],
        ];

        $bool = $this->bool->build();
        if ($bool) {
            $data['body']['query']['bool'] = $bool;
        }

        if ($this->from) {
            $data['from'] = $this->from;
        }

        if ($this->size) {
            $data['size'] = $this->size;
        }

        if ($this->sort) {
            $data['sort'] = $this->sort;
        }

        $highlight = $this->highlight->build();
        if ($highlight) {
            $data['body']['highlight'] = $highlight;
        }

        return $data;
    }

    public function __call($name, $arguments)
    {
        if (str_starts_with($name, 'setQueryBool')) {
            $method = substr($name, 12);
            call_user_func_array([$this->bool, 'set' . $method], $arguments);

            return $this;
        }

        if (str_starts_with($name, 'setHighlight')) {
            $method = substr($name, 12);
            call_user_func_array([$this->highlight, 'set' . $method], $arguments);

            return $this;
        }

        return $this;
    }
}