<?php
namespace xudongyss\es\document;

class DocumentIndex
{
    private $index;

    private $id;

    private $body;

    public static function create()
    {
        return new static();
    }

    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setBody(array $body)
    {
        $this->body = $body;

        return $this;
    }

    public function build()
    {
        $data = [
            'index' => $this->index,
            'body' => $this->body,
        ];

        if ($this->id) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}