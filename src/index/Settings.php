<?php
namespace xd\es\index;

/**
 * @method $this setNumberOfShards(Tokenizer $tokenizer) 设置分片数
 * @method $this setNumberOfReplicas(Tokenizer $tokenizer) 设置副本数
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

    public function set($name, $value)
    {
        $this->settings[$name] = $value;

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
        } else {
            $name = parse_name(str_replace('set', '', $name));

            call_user_func_array([$this, 'set'], array_merge([$name], $arguments));
        }

        return $this;
    }
}