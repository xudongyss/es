# 快速开始

## 配置

项目入口文件
```php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
```

配置文件 .env 放在项目入口文件同级目录
```bash
ELASTICSEARCH_HOST=""
ELASTICSEARCH_USERNAME=""
ELASTICSEARCH_PASSWORD=""
```

## 创建索引

```php
use xudongyss\es\Client;
use xudongyss\es\index\Index;
use xudongyss\es\index\Analyzer;
use xudongyss\es\index\mappings\properties\Field;

$index = Index::create()
    ->setIndex('jxzrzyhgh')
    ->setSettingsNumberOfShards(3)
    ->setSettingsNumberOfReplicas(2)
    ->setSettingsAnalysisAnalyzer(Analyzer::create()
        ->setName('ik_analyzer')
        ->setType('custom')
        ->setTokenizer('ik_max_word'))
    ->setMappingsProperties(Field::create()
        ->setFiled('id')
        ->setType('integer'))
    ->setMappingsProperties(Field::create()
        ->setFiled('title')
        ->setType('text')
        ->setAnalyzer('ik_analyzer')
        ->setFields(Field::create()
            ->setFiled('raw')
            ->setType('keyword')
        )
    )
    ->setMappingsProperties(Field::create()
        ->setFiled('content')
        ->setType('text')
        ->setAnalyzer('ik_analyzer')
    )
    ->setMappingsProperties(Field::create()
        ->setFiled('url')
        ->setType('keyword')
    )
    ->setMappingsProperties(Field::create()
        ->setFiled('create_time')
        ->setType('date')
        ->setFormat('yyyy-MM-dd HH:mm:ss')
    )
    ->build();
Client::indices()->create($index);
```

## 插入
```php
use xudongyss\es\Client;
use use xudongyss\es\document\Index;

$params = Index::create()
    ->setIndex('jxzrzyhgh')
    ->setId('')
    ->setBody([
        'id' => '',
        'title' => '',
        'content' => '',
        'url' => '',
        'create_time' => ''
    ])
    ->build();
Client::index($params);
```

## 搜索

### match

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\QueryMatch;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(QueryMatch::create()
        ->setQuery('藏龙岛')
        ->setField('title'))
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setSize(10000)
    ->build();
$list = Client::search($params);
$list = json_decode((string)$list->getBody(), true);
```

### match_phrase

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\MatchPhrase;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(MatchPhrase::create()
        ->setQuery('藏龙岛')
        ->setField('title'))
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setSize(10000)
    ->build();
$list = Client::search($params);
$list = json_decode((string)$list->getBody(), true);
```

### multi_match

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\MultiMatch;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(MultiMatch::create()
        ->setQuery('藏龙岛')
        ->setFields(['title'])
    )
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setSize(10000)
    ->build();

// phrase
$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(MultiMatch::create()
        ->setQuery('藏龙岛')
        ->setFields(['title'])
        ->setType('phrase')
    )
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setSize(10000)
    ->build();

$list = Client::search($params);
$list = json_decode((string)$list->getBody(), true);
```