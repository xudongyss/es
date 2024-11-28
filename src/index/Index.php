<?php
namespace xudongyss\es\index;

/**
 * @method $this setSettingsNumberOfShards($number) 设置分片数
 * @method $this setSettingsNumberOfReplicas($number) 设置副本数
 * @method $this setSettingsAnalysisTokenizer(Tokenizer $tokenizer)
 * @method $this setSettingsAnalysisAnalyzer(Analyzer $analyzer)
 * @method $this setMappingsProperties(Propertie $properties)
 */
class Index
{
    private $index;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var Mappings
     */
    private $mappings;

    private $callMap = [
        'setSettingsNumberOfShards' => 'settings',
        'setSettingsNumberOfReplicas' => 'settings',
        'setSettingsAnalysisTokenizer' => 'settings',
        'setSettingsAnalysisAnalyzer' => 'settings',
        'setMappingsProperties' => 'mappings',
    ];

    public function __construct()
    {
        $this->settings = Settings::create();
        $this->mappings = Mappings::create();
    }

    public static function create()
    {
        return new static();
    }

    /**
     * @param mixed $index
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @return Settings
     */
    public function settings()
    {
        return $this->settings;
    }

    public function build()
    {
        $data = [
            'index' => $this->index,
            'body' => [],
        ];

        $settings = $this->settings->build();
        if ($settings) {
            $data['body']['settings'] = $settings;
        }

        $mappings = $this->mappings->build();
        if ($mappings) {
            $data['body']['mappings'] = $mappings;
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