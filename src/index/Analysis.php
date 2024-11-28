<?php
namespace xudongyss\es\index;

class Analysis
{
    // tokenizer
    private $tokenizer;

    // analyzer
    private $analyzer;

    public static function create()
    {
        return new static();
    }

    public function setTokenizer(Tokenizer $tokenizer)
    {
        $this->tokenizer[$tokenizer->getName()] = $tokenizer;

        return $this;
    }

    public function setAnalyzer(Analyzer $analyzer)
    {
        $this->analyzer[$analyzer->getName()] = $analyzer->build();

        return $this;
    }

    public function build()
    {
        $data = [];
        if ($this->tokenizer) {
            $data['tokenizer'] = $this->tokenizer;
        }

        if ($this->analyzer) {
            $data['analyzer'] = $this->analyzer;
        }

        return $data;
    }
}