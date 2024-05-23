<?php
require_once 'vendor/autoload.php';

use xd\es\EsClient;

$client = EsClient::client();

try {
//    $client->indices()->create([
//        'index' => 'for_test',
//        'body' => [
//            'settings' => [
//                'number_of_shards' => 3,
//                'number_of_replicas' => 2
//            ],
//            'mappings' => [
//                'properties' => [
//                    'content' => ['type' => 'text'],
//                ]
//            ],
//        ],
//    ]);
    $params = [
        'index' => 'jxzrzyhgh',
        'body' => [
            'settings' => [
                'analysis' => [
                    'tokenizer' => [
                        'my_ik_tokenizer' => [
                            'type' => 'ik_max_word'
                        ]
                    ],
                    'analyzer' => [
                        'ik_analyzer' => [
                            'type' => 'custom',
                            'tokenizer' => 'my_ik_tokenizer',
                        ]
                    ]
                ]
            ],
            'mappings' => [
                'properties' => [
                    'title' => [
                        'type' => 'text',
                        'analyzer' => 'ik_analyzer'
                    ],
                    'content' => [
                        'type' => 'text',
                        'analyzer' => 'ik_analyzer'
                    ]
                ]
            ]
        ]
    ];
//    $response = $client->indices()->create($params);
//    $client->index([
//        'index' => 'jxzrzyhgh',
//        'body' => [
//            'title' => '武汉华腾汽车零部件有限公司武汉华腾汽车零部件新建项目规划方案批前公示',
//            'content' => '<div id="content"> <!--主题内容开始-->
//      	<div align="center"></div>
//<div align="center"></div>
//<div><font face="仿宋_GB2312">武汉华腾汽车零部件有限公司武汉华腾汽车零部件新建项目位于</font><font face="仿宋_GB2312">武汉</font><font face="仿宋_GB2312">江夏经济开发区金港产业园杨咀村，经江夏区自然资源和规划局审查，现将该项目规划方案总平面及效果图进行批前公示。公示内容如下：</font></div>
//<div><font face="仿宋_GB2312">公示日期：</font><font face="仿宋_GB2312">2024年 </font><font face="仿宋_GB2312">5</font><font face="仿宋_GB2312">月</font><font face="仿宋_GB2312">23</font><font face="仿宋_GB2312">日</font> <font face="仿宋_GB2312">—— 2024年</font><font face="仿宋_GB2312">6</font><font face="仿宋_GB2312">月</font><font face="仿宋_GB2312">2</font><font face="仿宋_GB2312">日</font><font face="仿宋_GB2312">公示反映方式：在公示期间，有关单位和个人对该项目审批有何意见或建议的，可以通过以下方式向江夏区自然资源和规划局反映。</font></div>
//<div><font face="仿宋_GB2312">1、联系电话：027-87912260 &nbsp;余工</font></div>
//<div><font face="仿宋_GB2312">2、传真：027-87019626（请注明“规划公示”字样） </font></div>
//<div><font face="仿宋_GB2312">3、信件寄往“江夏区文化大道37号楚天大厦江夏区自然资源和规划局建设工程审批服务中心”（请注明“规划公示”字样），邮编：430200</font><font face="仿宋_GB2312">4.网上留言：jxzgjgs@163.com</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
//<div align="right"><font face="仿宋_GB2312">&nbsp;</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;武汉市江夏区自然资源和规划局</div>
//<div align="right">&nbsp;<font face="仿宋_GB2312">2024年</font><font face="仿宋_GB2312">5</font><font face="仿宋_GB2312">月</font><font face="仿宋_GB2312">23</font><font face="仿宋_GB2312">日</font></div>
//<div align="right">&nbsp;</div>
//<div align="center"><img align="middle" src="/UploadFileNew/20240523112500550.jpg" width="850"></div><!--EndFragment-->
//          </div>',
//            'create_time' => '2024-05-23 11:22:50',
//        ]
//    ]);
    $list = $client->search([
        'index' => 'jxzrzyhgh',
        'body' => [
            'query' => [
                'multi_match' => [
                    'query' => '华腾',
                    'fields' => ['title', 'content'],
                ]
            ]
        ]
    ]);
    echo '<pre>';print_r($list);

    $params = [
        'index' => 'jxzrzyhgh',
        'body' => [
            'analyzer' => 'ik_analyzer', // 使用之前定义的 ik_analyzer
            'text' => '武汉华腾汽车零部件有限公司武汉华腾汽车零部件新建项目规划方案批前公示'
        ]
    ];

    $response = $client->indices()->analyze($params);
    print_r($response);
} catch (\Exception $e) {
    echo $e->getMessage();
}
