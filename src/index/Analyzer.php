<?php
namespace xudongyss\es\index;

class Analyzer
{
    // name
    private $name;

    // type
    private $type;

    // char_filter
    private $charFilter;

    // tokenizer
    private $tokenizer;

    public static function create()
    {
        return new static();
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param mixed $charFilter
     */
    public function setCharFilter($charFilter)
    {
        $this->charFilter[] = $charFilter;

        return $this;
    }

    /**
     * @param mixed $tokenizer
     */
    public function setTokenizer($tokenizer)
    {
        $this->tokenizer = $tokenizer;

        return $this;
    }

    public function build()
    {
        return [
            'type' => $this->type,
            'char_filter' => $this->charFilter,
            'tokenizer' => $this->tokenizer,
        ];
    }
}