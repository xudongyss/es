<?php
namespace xudongyss\es\document;

use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\QueryBool;
use xudongyss\es\document\query\Query;
use xudongyss\es\document\search\Source;

/**
 * @method $this setQueryBoolMust(Query $query) 设置must条件
 * @method $this setQueryBoolShould(Query $query) 设置should条件
 * @method $this setQueryBoolMustNot(Query $query) 设置must_not条件
 * @method $this setSourceIncludes(array|string $includes) 设置返回字段
 * @method $this setSourceExcludes(array|string $excludes) 设置不返回字段
 * @method $this setHighlightFields(Field $field) 设置高亮字段
 */
class Search
{
    private $index;

    private $query;

    private $bool;

    private $fields;

    private $source;

    private $from;

    private $size;

    private $sort;

    private $highlight;

    public function __construct()
    {
        $this->bool = QueryBool::create();
        $this->highlight = Highlight::create();
        $this->source = Source::create();
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

    public function setQuery(Query $query)
    {
        $this->query = $query;

        return $this;
    }

    public function setFields($fields)
    {
        $this->fields = $fields;

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

        if ($this->query) {
            $data['body']['query'] = $this->query->build();
        }

        $bool = $this->bool->build();
        if ($bool) {
            $data['body']['query']['bool'] = $bool;
        }

        if ($this->fields) {
            $data['body']['fields'] = $this->fields;
        }

        $source = $this->source->build();
        if ($source) {
            $data['body']['_source'] = $source;
        }

        if ($this->from) {
            $data['body']['from'] = $this->from;
        }

        if ($this->size) {
            $data['body']['size'] = $this->size;
        }

        if ($this->sort) {
            $data['body']['sort'] = $this->sort;
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

        if (str_starts_with($name, 'setSource')) {
            $method = substr($name, 9);
            call_user_func_array([$this->source, 'set' . $method], $arguments);

            return $this;
        }

        return $this;
    }
}