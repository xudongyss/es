<?php

namespace xudongyss\es\index;

class Analyze
{
    private $index;

    private $analyzer;

    private $text;

    public static function create()
    {
        return new static();
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    public function setAnalyzer($analyzer)
    {
        $this->analyzer = $analyzer;

        return $this;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function build()
    {
        $data = [
            'index' => $this->index,
            'body' => [
                'analyzer' => $this->analyzer,
                'text' => $this->text,
            ],
        ];

        return $data;
    }

}
