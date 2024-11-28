<?php
require_once 'vendor/autoload.php';

use xd\es\Client;
use xd\es\index\Index;
use xd\es\index\Analyzer;
use xd\es\index\Propertie;
use xd\es\document\Search;
use xd\es\document\query\MultiMatch;
use xd\es\document\highlight\Field;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo '<pre>';
try {
    $index = Index::create()
        ->setIndex('jxzrzyhgh')
        ->setSettingsNumberOfShards(3)
        ->setSettingsNumberOfReplicas(2)
        ->setSettingsAnalysisAnalyzer(Analyzer::create()
            ->setName('ik_analyzer')
            ->setType('custom')
            ->setTokenizer('ik_max_word'))
        ->setMappingsProperties(Propertie::create()
            ->setFiled('title')
            ->setType('text')
            ->setAnalyzer('ik_analyzer'))
        ->setMappingsProperties(Propertie::create()
            ->setFiled('content')
            ->setType('text')
            ->setAnalyzer('ik_analyzer'))
        ->setMappingsProperties(Propertie::create()
            ->setFiled('create_time')
            ->setType('date')
            ->setFormat('yyyy-MM-dd HH:mm:ss'))
        ->build();
//    Client::indices()->create($index);
    $params = [
        'index' => 'jxzrzyhgh',
        'body' => [
            'title' => '武汉华腾汽车零部件有限公司武汉华腾汽车零部件新建项目规划方案批前公示',
            'content' => '<div id="content"> <!--主题内容开始-->
      	<div align="center"></div>
<div align="center"></div>
<div><font face="仿宋_GB2312">武汉华腾汽车零部件有限公司武汉华腾汽车零部件新建项目位于</font><font face="仿宋_GB2312">武汉</font><font face="仿宋_GB2312">江夏经济开发区金港产业园杨咀村，经江夏区自然资源和规划局审查，现将该项目规划方案总平面及效果图进行批前公示。公示内容如下：</font></div>
<div><font face="仿宋_GB2312">公示日期：</font><font face="仿宋_GB2312">2024年 </font><font face="仿宋_GB2312">5</font><font face="仿宋_GB2312">月</font><font face="仿宋_GB2312">23</font><font face="仿宋_GB2312">日</font> <font face="仿宋_GB2312">—— 2024年</font><font face="仿宋_GB2312">6</font><font face="仿宋_GB2312">月</font><font face="仿宋_GB2312">2</font><font face="仿宋_GB2312">日</font><font face="仿宋_GB2312">公示反映方式：在公示期间，有关单位和个人对该项目审批有何意见或建议的，可以通过以下方式向江夏区自然资源和规划局反映。</font></div>
<div><font face="仿宋_GB2312">1、联系电话：027-87912260 &nbsp;余工</font></div>
<div><font face="仿宋_GB2312">2、传真：027-87019626（请注明“规划公示”字样） </font></div>
<div><font face="仿宋_GB2312">3、信件寄往“江夏区文化大道37号楚天大厦江夏区自然资源和规划局建设工程审批服务中心”（请注明“规划公示”字样），邮编：430200</font><font face="仿宋_GB2312">4.网上留言：jxzgjgs@163.com</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
<div align="right"><font face="仿宋_GB2312">&nbsp;</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;武汉市江夏区自然资源和规划局</div>
<div align="right">&nbsp;<font face="仿宋_GB2312">2024年</font><font face="仿宋_GB2312">5</font><font face="仿宋_GB2312">月</font><font face="仿宋_GB2312">23</font><font face="仿宋_GB2312">日</font></div>
<div align="right">&nbsp;</div>
<div align="center"><img align="middle" src="/UploadFileNew/20240523112500550.jpg" width="850"></div><!--EndFragment-->
          </div>',
            'create_time' => '2024-05-23 11:22:50',
        ]
    ];
//    Client::index($params);
    $params = [
        'index' => 'jxzrzyhgh',
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        [
                            'multi_match' => [
                                'query' => '武汉',
                                'fields' => ['title', 'content'],
                            ]
                        ],
                        [
                            'multi_match' => [
                                'query' => '江夏',
                                'fields' => ['title', 'content'],
                            ]
                        ]
                    ]
                ],
            ]
        ]
    ];
    $params = Search::create()
        ->setIndex('jxzrzyhgh')
        ->setQueryBoolShould(MultiMatch::create()
            ->setQuery('武汉江夏')
            ->setFields(['title', 'content']))
        ->setHighlightFields(Field::create()
            ->setField('title'))
        ->setHighlightFields(Field::create()
            ->setField('content'))
        ->build();
    print_r($params);
    $list = Client::search($params);print_r(json_decode((string)$list->getBody(), true));

    $params = [
        'index' => 'jxzrzyhgh',
        'body' => [
            'analyzer' => 'ik_analyzer', // 使用之前定义的 ik_analyzer
            'text' => '武汉华腾汽车零部件有限公司武汉华腾汽车零部件新建项目规划方案批前公示'
        ]
    ];
//    $response = Client::indices()->analyze($params);print_r(json_decode((string)$response->getBody(), true));

    // 删除文档
//    Client::delete(\xd\es\document\Delete::create()
//        ->setIndex('jxzrzyhgh')
//        ->setId('9jPzbJMB0Gp5RZvesbGd')
//        ->build());
    // 删除索引
//    Client::indices()->delete(\xd\es\index\Delete::create()
//        ->setIndex("jxzrzyhgh")
//        ->build());
} catch (\Exception $e) {
    echo $e->getTraceAsString();
    echo $e->getMessage();
}
