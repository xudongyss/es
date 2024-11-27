<?php
namespace xd\es\index;

/**
 * @method $this setAnalysisTokenizer(Tokenizer $tokenizer)
 * @method $this setAnalysisAnalyzer(Analyzer $analyzer)
 */
class Settings
{
    private $settings;

    /**
     * @var Analysis
     */
    private $analysis;

    private $callMap = [
        'setAnalysisTokenizer' => 'analysis',
        'setAnalysisAnalyzer' => 'analysis',
    ];

    public function __construct()
    {
        $this->analysis = Analysis::create();
    }

    public static function create()
    {
        return new static();
    }

    /**
     * 设置分片数
     * @param $number
     * @return $this
     */
    public function setNumberOfShards($number)
    {
        $this->settings['number_of_shards'] = $number;

        return $this;
    }

    /**
     * 设置副本数
     * @param $number
     * @return $this
     */
    public function setNumberOfReplicas($number)
    {
        $this->settings['number_of_replicas'] = $number;

        return $this;
    }

    /**
     * @return Analysis
     */
    public function analysis()
    {

        return $this->analysis;
    }

    public function build()
    {
        $data = [];
        if ($this->settings) {
            $data = $this->settings;
        }
        $analysis = $this->analysis->build();
        if ($analysis) {
            $data['analysis'] = $analysis;
        }

        return $data;
    }

    public function __call($name, $arguments)
    {
        $attribute = $this->callMap[$name] ?? null;
        if ($attribute) {
            $name = str_replace(ucfirst($attribute), '', $name);
            call_user_func_array([$this->$attribute, $name], $arguments);
        }

        return $this;
    }
}