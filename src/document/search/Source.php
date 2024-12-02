<?php
namespace xudongyss\es\document\search;

class Source
{
    private $includes = [];

    private $excludes = [];

    public static function create()
    {
        return new static();
    }

    public function setIncludes(array|string $includes)
    {
        if (is_array($includes)) {
            $this->includes = array_merge($this->includes, $includes);

            return $this;
        }

        $this->includes[] = $includes;

        return $this;
    }

    public function setExcludes(array|string $excludes)
    {
        if (is_array($excludes)) {
            $this->excludes = array_merge($this->excludes, $excludes);

            return $this;
        }

        $this->excludes[] = $excludes;

        return $this;
    }

    public function build()
    {
        $data = [];
        if ($this->includes) {
            $data['includes'] = $this->includes;
        }
        if ($this->excludes) {
            $data['excludes'] = $this->excludes;
        }

        return $data;
    }
}