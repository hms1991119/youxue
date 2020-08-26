<?php
/**
 * 后台菜单
 */
class Menu{
    
    public static function getMenuList()
    {
        return [
           [
               'id' => 1,
               'module_name' => '首页',
               'icon_class' => 'el-icon-s-custom',
               'child_items' => [
                   [
                       'id' => 101,
                       'module_name' => '数据中心',
                       'url' => '/useradd',
                   ],
               ]
           ],
           [
               'id' => 2,
               'module_name' => '公告管理',
               'icon_class' => 'el-icon-school',
               'child_items' => [
                   [
                       'id' => 201,
                       'module_name' => '公告列表',
                       'url' => ''
                   ]
               ]
           ],
           [
               'id' => 3,
               'module_name' => '社区管理',
               'icon_class' => 'el-icon-s-check',
               'child_items' => [
                   [
                       'id' => 301,
                       'module_name' => '社区管理',
                       'url' => ''
                   ],
                   [
                       'id' => 302,
                       'module_name' => '志愿服务',
                       'url' => ''
                   ]
               ]
           ],
           [
               'id' => 4,
               'module_name' => '资讯管理',
               'icon_class' => 'el-icon-chat-line-round',
               'child_items' => [
                   [
                       'id' => 401,
                       'module_name' => '党建动态',
                       'url' => ''
                   ],
                   [
                       'id' => 402,
                       'module_name' => '社区动态',
                       'url' => ''
                   ],
                   [
                       'id' => 403,
                       'module_name' => '通知公告',
                       'url' => ''
                   ]
               ]
           ],
           [
               'id' => 5,
               'module_name' => '基础数据',
               'icon_class' => 'el-icon-reading',
               'child_items' => [
                   [
                       'id' => 501,
                       'module_name' => '房屋管理',
                       'url' => ''
                   ],
                   [
                       'id' => 502,
                       'module_name' => '人口信息',
                       'url' => ''
                   ],
                   [
                       'id' => 503,
                       'module_name' => '特殊人群',
                       'url' => ''
                   ],
                   [
                       'id' => 504,
                       'module_name' => '单位信息',
                       'url' => ''
                   ],
                   [
                       'id' => 505,
                       'module_name' => '医院信息',
                       'url' => ''
                   ],
                   [
                       'id' => 506,
                       'module_name' => '学校信息',
                       'url' => ''
                   ],
                   [
                       'id' => 507,
                       'module_name' => '门店信息',
                       'url' => ''
                   ],
                   [
                       'id' => 508,
                       'module_name' => '特殊行业',
                       'url' => ''
                   ],
                   [
                       'id' => 509,
                       'module_name' => '服务团队',
                       'url' => ''
                   ],
                   [
                       'id' => 510,
                       'module_name' => '机构设置',
                       'url' => ''
                   ],
               ]
           ],
           /*[
               'id' => 6,
               'module_name' => '活动管理',
               'icon_class' => 'el-icon-present',
               'child_items' => [
                   [
                       'id' => 601,
                       'module_name' => '优惠券',
                       'url' => ''
                   ],
                   [
                       'id' => 602,
                       'module_name' => '分享规则',
                       'url' => ''
                   ]
               ]
           ],
           [
               'id' => 7,
               'module_name' => '积分管理',
               'icon_class' => 'el-icon-medal-1',
               'child_items' => [
                   [
                       'id' => 701,
                       'module_name' => '兑换物品',
                       'url' => ''
                   ],
                   [
                       'id' => 702,
                       'module_name' => '兑换记录',
                       'url' => ''
                   ]
               ]
           ],
           [
               'id' => 8,
               'module_name' => '实时资讯',
               'icon_class' => 'el-icon-chat-line-round',
               'child_items' => [
                   [
                       'id' => 801,
                       'module_name' => '资讯列表',
                       'url' => ''
                   ]
               ]
           ],*/
           [
               'id' => 9,
               'module_name' => '系统设置',
               'icon_class' => 'el-icon-setting',
               'child_items' => [
                   [
                       'id' => 901,
                       'module_name' => '用户列表',
                       'url' => '/accountlist'
                   ],
                   [
                       'id' => 902,
                       'module_name' => '角色列表',
                       'url' => '/rolelist'
                   ],
               ]
           ]
        ];
    }
}