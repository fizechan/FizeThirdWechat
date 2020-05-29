<?php

namespace api;

use fize\third\wechat\api\Menu;
use PHPUnit\Framework\TestCase;

class TestMenu extends TestCase
{

    public function testCreate()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true
        ];

        $data = [
            'button' => [
                [
                    'name' => '功能1',
                    'sub_button' => [
                        [
                            "type" => Menu::BUTTON_TYPE_CLICK,
                            "name" => "触发点击",
                            "key" => "V1001_GOOD"
                        ],
                        [
                            "type" => Menu::BUTTON_TYPE_VIEW,
                            "name" => "网页跳转",
                            "url" => "http://www.soso.com/"
                        ]
                    ]
                ],
                [
                    'name' => '功能2',
                    'sub_button' => [
                        [
                            'type' => Menu::BUTTON_TYPE_SCANCODE_PUSH,
                            'name' => '扫码推事件',
                            'key' => 'rselfmenu_2_1',
                        ],
                        [
                            'type' => Menu::BUTTON_TYPE_SCANCODE_WAITMSG,
                            'name' => '扫码带提示',
                            'key' => 'rselfmenu_2_2',
                        ],
                        [
                            'type' => Menu::BUTTON_TYPE_PIC_SYSPHOTO,
                            'name' => '系统拍照发图',
                            'key' => 'rselfmenu_2_3',
                        ],
                        [
                            'type' => Menu::BUTTON_TYPE_PIC_WEIXIN,
                            'name' => '微信相册发图',
                            'key' => 'rselfmenu_2_4',
                        ],
                        [
                            'type' => Menu::BUTTON_TYPE_PIC_PHOTO_OR_ALBUM,
                            'name' => '选择拍照或相册',
                            'key' => 'rselfmenu_2_5',
                        ]
                    ]
                ],
                [
                    'name' => '功能3',
                    'sub_button' => [
                        [
                            'type' => Menu::BUTTON_TYPE_LOCATION_SELECT,
                            'name' => '发送位置',
                            'key' => 'rselfmenu_3_1'
                        ],
//                         [
//                             'type' => Menu::BUTTON_TYPE_MEDIA_ID,
//                             'name' => '发送指定素材',
//                             'media_id' => 'MEDIA_ID1',
//                         ],
//                         [
//                             'type' => Menu::BUTTON_TYPE_VIEW_LIMITED,
//                             'name' => '发送永久素材',
//                             'media_id' => 'MEDIA_ID2',
//                         ],
//                         [
//                             'type' => Menu::BUTTON_TYPE_MINIPROGRAM,
//                             'name' => '小程序',
//                             'appid' => '123456',
//                             'url' => 'http://www.soso.com/',
//                             'pagepath' => 'test'
//                         ]
                    ]
                ]
            ]
        ];

        $wx_menu = new Menu($config);
        $wx_menu->create($data);
        self::assertIsObject($wx_menu);
    }

    public function testDelete()
    {

    }

    public function testGet()
    {
        $config = [
            'appid' => 'wx12078319bd1c19dd',
            'appsecret' => '89212483aa60a23a74ab7a11d78019f0',
            'debug' => true,
            'cache' => [
                'handler' => 'file',
                'config' => [
                    'path'    =>  __DIR__ . '/../../temp/cache',
                ]
            ]
        ];

        $wx_menu = new Menu($config);
        $menus = $wx_menu->get();
        var_dump($menus);
        self::assertIsArray($menus);
    }

    public function testAddconditional()
    {

    }

    public function testDelconditional()
    {

    }

    public function test__construct()
    {

    }

    public function testTrymatch()
    {

    }

    public function testGetCurrentSelfmenuInfo()
    {

    }
}
