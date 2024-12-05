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

### Geopoint field type

```php
use xudongyss\es\Client;
use xudongyss\es\index\Index;
use xudongyss\es\index\mappings\properties\Field;

$index = Index::create()
    ->setIndex('geo')
    ->setSettingsNumberOfShards(3)
    ->setSettingsNumberOfReplicas(2)
    ->setMappingsProperties(Field::create()
        ->setFiled('name')
        ->setType('keyword')
    )
    ->setMappingsProperties(Field::create()
        ->setFiled('location')
        ->setType('geo_point')
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

### query And bool
#### match

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\QueryMatch;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(QueryMatch::create()
        ->setQuery('武汉')
        ->setField('title'))
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setSize(10000)
    ->build();
$list = Client::search($params);
$list = json_decode((string)$list->getBody(), true);
```

#### match_phrase

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\MatchPhrase;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(MatchPhrase::create()
        ->setQuery('武汉')
        ->setField('title'))
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setSize(10000)
    ->build();
$list = Client::search($params);
$list = json_decode((string)$list->getBody(), true);
```

#### multi_match

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\MultiMatch;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(MultiMatch::create()
        ->setQuery('武汉')
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
        ->setQuery('武汉')
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

#### term

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\Term;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(Term::create()
        ->setField('url')
        ->setValue('https://baidu.com')
    )
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setSize(10000)
    ->build();

$list = Client::search($params);
$list = json_decode((string)$list->getBody(), true);
```

#### terms
```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\Terms;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(Terms::create()
        ->setField('url')
        ->setTerms(['https://baidu.com'])
    )
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setSize(10000)
    ->build();

$list = Client::search($params);
$list = json_decode((string)$list->getBody(), true);
```

#### range

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\Range;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(Range::create()
        ->setField('create_time')
        ->setGte(date('Y-m-d H:i:s', strtotime('-7 days')))
        ->setLte(date('Y-m-d H:i:s'))
    )
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setSize(10000)
    ->build();

$list = Client::search($params);
$list = json_decode((string)$list->getBody(), true);
```

#### ids

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\IDs;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQuery(IDs::create()
        ->setValues([34709, 36923, 42330])
    )
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setSize(10000)
    ->build();

$list = Client::search($params);
$list = json_decode((string)$list->getBody(), true);
```

#### geo_distance

```php
use xudongyss\es\document\query\geo\Distance;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('geo')
    ->setQuery(Distance::create()
        ->setField('location')
        ->setDistance('5km')
        ->setLocation('30.503151,114.414082')
    )
    ->setFields(['name', 'location'])
    ->build();
```

### query
### bool

### script_fields

```php
use xudongyss\es\document\query\geo\Distance;
use xudongyss\es\document\script\Field;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('geo')
    ->setQuery(Distance::create()
        ->setField('location')
        ->setDistance('5km')
        ->setLocation('30.503151,114.414082')
    )
    ->setFields(['name', 'location'])
    ->setScriptFields(Field::create()
        ->setField('distance_to_target')
        ->setSource("doc['location'].arcDistance(params.lat, params.lon)")
        ->setParams('lat', 30.503151)
        ->setParams('lon', 114.414082)
    )
    ->build();
```

### fields
### source
### from

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\QueryMatch;
use xudongyss\es\document\Search;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(QueryMatch::create()
        ->setQuery('武汉')
        ->setField('title'))
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setFrom(0)
    ->setSize(5)
    ->build();
$list = Client::search($params);
$list = json_decode((string)$list->getBody(), true);
```

### size
### sort

```php
use xudongyss\es\document\highlight\Field;
use xudongyss\es\document\query\QueryMatch;
use xudongyss\es\document\Search;
use xudongyss\es\document\Sort;

$params = Search::create()
    ->setIndex('jxzrzyhgh')
    ->setQueryBoolShould(QueryMatch::create()
        ->setQuery('武汉')
        ->setField('title'))
    ->setSourceIncludes(['id', 'title', 'url', 'create_time'])
    ->setHighlightFields(Field::create()
        ->setField('title'))
    ->setFrom(0)
    ->setSize(5)
    ->setSort(Sort::create()
        ->setField('create_time')
        ->setOrder('desc')
    )
    ->build();
```

### highlight