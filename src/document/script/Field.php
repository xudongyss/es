<?php

namespace xudongyss\es\document\script;

class Field
{
    private $field;

    private $lang;

    private $source;

    private $params;

    public static function create()
    {
        return new static();
    }

    public function getField()
    {
        return $this->field;
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    public function setParams($name, $value)
    {
        $this->params[$name] = $value;

        return $this;
    }

    public function build()
    {
        $data = [];

        if ($this->lang) {
            $data['lang'] = $this->lang;
        }

        if ($this->source) {
            $data['source'] = $this->source;
        }

        if ($this->params) {
            $data['params'] = $this->params;
        }

        return [
            'script' => $data
        ];
    }
}