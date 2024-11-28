<?php
namespace xudongyss\es\document\query;

abstract class Query
{
    public static function create()
    {
        return new static();
    }

    abstract public function build();
}