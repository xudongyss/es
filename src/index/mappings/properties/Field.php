<?php
namespace xudongyss\es\index\mappings\properties;

class Field
{
    private $field;

    private $type;

    private $analyzer;

    private $format;

    private $fields;

    public static function create()
    {
        return new static();
    }

    public function getFiled()
    {
        return $this->field;
    }

    public function setFiled($field)
    {
        $this->field = $field;

        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function setAnalyzer($analyzer)
    {
        $this->analyzer = $analyzer;

        return $this;
    }

    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    public function setFields(Field $field)
    {
        $this->fields[$field->getFiled()] = $field->build();

        return $this;
    }

    public function build()
    {
        $data = [];
        if ($this->type) {
            $data['type'] = $this->type;
        }

        if ($this->analyzer) {
            $data['analyzer'] = $this->analyzer;
        }

        if ($this->format) {
            $data['format'] = $this->format;
        }

        if ($this->fields) {
            $data['fields'] = $this->fields;
        }

        return $data;
    }
}