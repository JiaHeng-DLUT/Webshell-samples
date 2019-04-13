<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清空表
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \Illuminate\Support\Facades\DB::table('model_has_permissions')->truncate();
        \Illuminate\Support\Facades\DB::table('model_has_roles')->truncate();
        \Illuminate\Support\Facades\DB::table('role_has_permissions')->truncate();
        \Illuminate\Support\Facades\DB::table('users')->truncate();
        \Illuminate\Support\Facades\DB::table('roles')->truncate();
        \Illuminate\Support\Facades\DB::table('permissions')->truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //用户
        $user = \App\Models\User::create([
            'username' => 'root',
            'phone' => '18502873917',
            'name' => '超级管理员',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'uuid' => \Faker\Provider\Uuid::uuid(),
            'role_slug'=>'admin',
            'status'=>1
        ]);

        //角色
        $role = \App\Models\Role::create([
            'name' => 'root',
            'display_name' => '超级管理员'
        ]);

        //权限
        $permissions = [
            [
                'name' => 'system.manage',
                'display_name' => '系统管理',
                'route' => '',
                'icon_id' => '100',
                'child' => [
                    [
                        'name' => 'system.user',
                        'display_name' => '账户管理',
                        'route' => 'admin.user',
                        'icon_id' => '123',
                        'child' => [
                            ['name' => 'system.user.create', 'display_name' => '添加用户','route'=>'admin.user.create'],
                            ['name' => 'system.user.edit', 'display_name' => '编辑用户','route'=>'admin.user.edit'],
                            ['name' => 'system.user.destroy', 'display_name' => '删除用户','route'=>'admin.user.destroy'],
                            ['name' => 'system.user.role', 'display_name' => '分配角色','route'=>'admin.user.role'],
                            ['name' => 'system.user.permission', 'display_name' => '分配权限','route'=>'admin.user.permission'],
                            ['name' => 'system.user.status', 'display_name' => '启用禁用','route'=>'admin.user.status'],
                        ]
                    ],
                    [
                        'name' => 'system.role',
                        'display_name' => '角色管理',
                        'route' => 'admin.role',
                        'icon_id' => '121',
                        'child' => [
                            ['name' => 'system.role.create', 'display_name' => '添加角色','route'=>'admin.role.create'],
                            ['name' => 'system.role.edit', 'display_name' => '编辑角色','route'=>'admin.role.edit'],
                            ['name' => 'system.role.destroy', 'display_name' => '删除角色','route'=>'admin.role.destroy'],
                            ['name' => 'system.role.permission', 'display_name' => '分配权限','route'=>'admin.role.permission'],
                        ]
                    ],
                    [
                        'name' => 'system.permission',
                        'display_name' => '权限管理',
                        'route' => 'admin.permission',
                        'icon_id' => '12',
                        'child' => [
                            ['name' => 'system.permission.create', 'display_name' => '添加权限','route'=>'admin.permission.create'],
                            ['name' => 'system.permission.edit', 'display_name' => '编辑权限','route'=>'admin.permission.edit'],
                            ['name' => 'system.permission.destroy', 'display_name' => '删除权限','route'=>'admin.permission.destroy'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'member.manage',
                'display_name' => '用户管理',
                'route' => '',
                'icon_id' => '123',
                'child' => [
                    [
                        'name' => 'admin.member.member',
                        'display_name' => '用户信息',
                        'route' => 'admin.member',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.member.member.toExcel', 'display_name' => '导出用户信息','route'=>'admin.member.toExcel'],
                        ]
                    ],
                    [
                        'name' => 'admin.member.apply',
                        'display_name' => '意向管理',
                        'route' => 'admin.apply',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.member.apply.toExcel', 'display_name' => '导出意向管理','route'=>'admin.apply.toExcel'],
                        ]
                    ],
                    [
                        'name' => 'admin.member.behaviorlog',
                        'display_name' => '综合行为日志',
                        'route' => 'admin.behaviorlog',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.member.behaviorlog.toExcel', 'display_name' => '导出综合行为日志','route'=>'admin.behaviorlog.toExcel'],
                        ]
                    ],
                    [
                        'name' => 'admin.member.userModel',
                        'display_name' => '用户模型',
                        'route' => 'admin.userModel',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.member.userModel.create', 'display_name' => '添加用户模型','route'=>'admin.userModel.create'],
                            ['name' => 'admin.member.userModel.edit', 'display_name' => '编辑用户模型','route'=>'admin.userModel.edit'],
                        ]
                    ],
                ]
            ],
            //
            [
                'name' => 'channel.manage',
                'display_name' => '渠道管理',
                'route' => '',
                'icon_id' => '3',
                'child' => [
                    [
                        'name' => 'admin.channel.department',
                        'display_name' => '部门管理',
                        'route' => 'admin.channel.department',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.channel.department.create', 'display_name' => '添加部门','route'=>'admin.channel.department.create'],
                            ['name' => 'admin.channel.department.edit', 'display_name' => '编辑部门','route'=>'admin.channel.department.edit'],
                            ['name' => 'admin.channel.department.destroy', 'display_name' => '删除部门','route'=>'admin.channel.department.destroy'],
                        ]
                    ],
                    [
                        'name' => 'admin.channel.distributeTemplate',
                        'display_name' => '模板管理',
                        'route' => 'admin.channel.distributeTemplate',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.channel.distributeTemplate.create', 'display_name' => '添加模板','route'=>'admin.channel.distributeTemplate.create'],
                            ['name' => 'admin.channel.distributeTemplate.edit', 'display_name' => '编辑模板','route'=>'admin.channel.distributeTemplate.edit'],
                        ]
                    ],
                    [
                        'name' => 'admin.channel.channel',
                        'display_name' => '渠道管理',
                        'route' => 'admin.channel',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.channel.channel.create', 'display_name' => '添加渠道','route'=>'admin.channel.create'],
                            ['name' => 'admin.channel.channel.edit', 'display_name' => '编辑渠道','route'=>'admin.channel.edit'],
                            ['name' => 'admin.channel.channel.destroy', 'display_name' => '删除渠道','route'=>'admin.channel.destroy'],
                            ['name' => 'admin.channel.channel.status', 'display_name' => '停用状态','route'=>'admin.channel.status'],
                            ['name' => 'admin.channel.channel.redirect_status', 'display_name' => '跳转状态','route'=>'admin.channel.redirect_status'],
                            ['name' => 'admin.channel.channel.dealAtSet', 'display_name' => '结算时间','route'=>'admin.channel.dealAtSet'],
                            ['name' => 'admin.channel.channel.toExcel', 'display_name' => '导出渠道','route'=>'admin.channel.toExcel'],

                            ['name' => 'admin.channel.distribute.create', 'display_name' => '添加APP包','route'=>'admin.channel.distribute.create'],
                            ['name' => 'admin.channel.distribute.edit', 'display_name' => '编辑APP包','route'=>'admin.channel.distribute.edit'],
                            ['name' => 'admin.channel.distribute.destroy', 'display_name' => '删除APP包','route'=>'admin.channel.distribute.destroy'],

                            ['name' => 'admin.channel.distribute', 'display_name' => '分发管理','route'=>'admin.channel.distribute'],
                            ['name' => 'admin.channel.distribute.createDistribute', 'display_name' => '添加分发','route'=>'admin.channel.distribute.createDistribute'],
                            ['name' => 'admin.channel.distribute.editDistribute', 'display_name' => '编辑分发','route'=>'admin.channel.distribute.editDistribute'],
                            ['name' => 'admin.channel.distribute.distributeUpdate', 'display_name' => '刷新模板','route'=>'admin.channel.distribute.distributeUpdate'],
                            ['name' => 'admin.channel.distribute.destroyDistribute', 'display_name' => '删除分发','route'=>'admin.channel.distribute.destroyDistribute'],
                            ['name' => 'admin.channel.distribute.status', 'display_name' => '分发状态','route'=>'admin.channel.distribute.status'],
                        ]
                    ],

                    [
                        'name' => 'admin.channel.channelReduce',
                        'display_name' => '扣量设置',
                        'route' => 'admin.channel.channelReduce',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.channel.channelReduce.toExcel', 'display_name' => '导出扣量','route'=>'admin.channel.channelReduce.toExcel'],
                            ['name' => 'admin.channel.channelReduce.edit', 'display_name' => '编辑扣量','route'=>'admin.channel.channelReduce.update'],
                            ['name' => 'admin.channel.channelReduce.reduceRecord', 'display_name' => '扣量记录','route'=>'admin.channel.channelReduce.reduceRecord'],
                        ]
                    ],
                ]
            ],
            //
            [
                'name' => 'website.manage',
                'display_name' => '门户管理',
                'route' => '',
                'icon_id' => '28',
                'child' => [
                    [
                        'name' => 'admin.website.website',
                        'display_name' => '门户设置',
                        'route' => 'admin.website',
                        'icon_id' => '13',
                        'child'   => [
                            ['name' => 'admin.website.update', 'display_name' => '编辑门户', 'route' => 'admin.website.update'],
                        ]
                    ],
                    [
                        'name' => 'admin.website.article',
                        'display_name' => '发现管理',
                        'route' => 'admin.website.article',
                        'icon_id' => '13',
                        'child' => [
                            ['name' => 'admin.website.article.create', 'display_name' => '添加发现','route'=>'admin.website.article.create'],
                            ['name' => 'admin.website.article.edit', 'display_name' => '修改发现','route'=>'admin.website.article.edit'],
                            ['name' => 'admin.website.article.destroy', 'display_name' => '删除发现','route'=>'admin.website.article.destroy'],
                        ]
                    ],
                    [
                        'name' => 'admin.website.help',
                        'display_name' => '帮助管理',
                        'route' => 'admin.website.help',
                        'icon_id' => '13',
                        'child' => [
                            ['name' => 'admin.website.help.create', 'display_name' => '添加帮助','route'=>'admin.website.help.create'],
                            ['name' => 'admin.website.help.edit', 'display_name' => '编辑帮助','route'=>'admin.website.help.edit'],
                            ['name' => 'admin.website.help.destroy', 'display_name' => '删除帮助','route'=>'admin.website.help.destroy'],
                        ]
                    ],
                    [
                        'name' => 'admin.website.circle',
                        'display_name' => '圈子管理',
                        'route' => 'admin.website.circle',
                        'icon_id' => '13',
                        'child' => [
                            ['name' => 'admin.website.circle.create', 'display_name' => '添加圈子','route'=>'admin.website.circle.create'],
                            ['name' => 'admin.website.circle.edit', 'display_name' => '编辑圈子','route'=>'admin.website.circle.edit'],
                            ['name' => 'admin.website.circle.destroy', 'display_name' => '删除圈子','route'=>'admin.website.circle.destroy'],
                        ]
                    ],
                    [
                        'name' => 'admin.website.image',
                        'display_name' => '营销位管理',
                        'route' => 'admin.website.image',
                        'icon_id' => '13',
                        'child' => [
                            ['name' => 'admin.website.image.create', 'display_name' => '添加营销位','route'=>'admin.website.image.store'],
                            ['name' => 'admin.website.image.edit', 'display_name' => '编辑营销位','route'=>'admin.website.image.edit'],
                            ['name' => 'admin.website.image.destroy', 'display_name' => '删除营销位','route'=>'admin.website.image.destroy'],
                        ]
                    ],
                ]
            ],

            [
                'name' => 'data.manage',
                'display_name' => '基础数据',
                'route' => '',
                'icon_id' => '29',
                'child' => [
                    [
                        'name' => 'data.dictionary',
                        'display_name' => '数据字典',
                        'route' => 'admin.dictionary',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'data.dictionary.edit', 'display_name' => '数据字典-编辑','route'=>''],
                        ]
                    ],
                    [
                        'name' => 'data.operateLog',
                        'display_name' => '操作日志',
                        'route' => 'admin.operateLog',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'data.operateLog.destroy', 'display_name' => '操作日志-删除','route'=>'admin.operateLog.destroy'],
                            ['name' => 'data.operateLog.excel', 'display_name' => '操作日志-导出','route'=>'admin.operateLog.excel'],
                        ]
                    ],
                    [
                        'name' => 'data.page',
                        'display_name' => '单页管理',
                        'route' => 'admin.page',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'data.page.edit', 'display_name' => '单页管理-编辑','route'=>'admin.page.edit'],
                        ]
                    ],
                    [
                        'name' => 'data.virtualPhone',
                        'display_name' => '虚拟号码池',
                        'route' => 'admin.virtualPhone',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'data.virtualPhone.create', 'display_name' => '虚拟号码导入','route'=>'admin.virtualPhone.create'],
                            ['name' => 'data.virtualPhone.destroy', 'display_name' => '虚拟号码删除','route'=>'admin.virtualPhone.destroy'],
                            ['name' => 'data.virtualPhone.destroyAll', 'display_name' => '一键清空','route'=>'admin.virtualPhone.destroyAll'],
                        ]
                    ],
                    [
                        'name' => 'data.district',
                        'display_name' => '省市区管理',
                        'route' => 'admin.district',
                        'icon_id' => null,
                        'child' => [
                        ]
                    ],
                    [
                        'name' => 'data.hotCity',
                        'display_name' => '热门城市管理',
                        'route' => 'admin.hotCity',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'data.hotCity.create', 'display_name' => '添加热门城市','route'=>'admin.hotCity.create'],
                            ['name' => 'data.hotCity.edit', 'display_name' => '编辑热门城市','route'=>'admin.hotCity.edit'],
                            ['name' => 'data.hotCity.destroy', 'display_name' => '移除热门城市','route'=>'admin.hotCity.destroy'],
                        ]
                    ],


                ]
            ],

            [
                'name' => 'product.manage',
                'display_name' => '贷款管理',
                'route' => '',
                'icon_id' => '22',
                'child' => [
                    [
                        'name' => 'product.product',
                        'display_name' => '贷款产品',
                        'route' => 'admin.product',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'product.create', 'display_name' => '贷款产品-新增','route'=>'admin.product.create'],
                            ['name' => 'product.edit', 'display_name' => '贷款产品-修改','route'=>'admin.product.edit'],
                            ['name' => 'product.destroy', 'display_name' => '贷款产品-删除','route'=>'admin.product.destroy'],
                            ['name' => 'product.status', 'display_name' => '贷款产品-上下架','route'=>'admin.product.status'],
                            ['name' => 'product.excel', 'display_name' => '贷款产品-导出','route'=>'admin.product.excel'],
                        ]
                    ],
                    [
                        'name' => 'product.category',
                        'display_name' => '贷款类目',
                        'route' => 'admin.productCategory',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'product.category.create', 'display_name' => '贷款类目-新增','route'=>'admin.productCategory.create'],
                            ['name' => 'product.category.edit', 'display_name' => '贷款类目-修改','route'=>'admin.productCategory.edit'],
                            ['name' => 'product.category.destroy', 'display_name' => '贷款类目-删除','route'=>'admin.productCategory.destroy'],
                        ]
                    ],
                    [
                        'name' => 'product.column',
                        'display_name' => '贷款栏目',
                        'route' => 'admin.productColumn',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'product.column.create', 'display_name' => '贷款栏目-新增','route'=>'admin.productColumn.create'],
                            ['name' => 'product.column.edit', 'display_name' => '贷款栏目-修改','route'=>'admin.productColumn.edit'],
                            ['name' => 'product.column.destroy', 'display_name' => '贷款栏目-删除','route'=>'admin.productColumn.destroy'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'access.manage',
                'display_name' => '统计中心',
                'route' => '',
                'icon_id' => '105',
                'child' => [
                    [
                        'name' => 'access.channel',
                        'display_name' => '渠道综合统计',
                        'route' => 'admin.access.channel',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'access.channel.show', 'display_name' => '查看详情','route'=>'admin.access.channel.show'],
                            ['name' => 'access.channel.excel', 'display_name' => '导出','route'=>'admin.access.channel.excel'],
                            ['name' => 'access.channel.excelChildren', 'display_name' => '导出全部下钻数据','route'=>'admin.access.channel.excelChildren'],
                        ]
                    ],
                    [
                        'name' => 'access.product',
                        'display_name' => '贷款产品统计',
                        'route' => 'admin.access.product',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'access.product.excel', 'display_name' => '导出','route'=>'admin.access.product.excel'],
                        ]
                    ],
                    [
                        'name' => 'access.page',
                        'display_name' => '分发页统计',
                        'route' => 'admin.access.page',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'access.page.excel', 'display_name' => '导出','route'=>'admin.access.page.excel'],
                        ]
                    ],
                    [
                        'name' => 'access.app',
                        'display_name' => 'App活跃统计',
                        'route' => 'admin.access.app',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'access.app.excel', 'display_name' => '导出','route'=>'admin.access.app.excel'],
                        ]
                    ],
                    [
                        'name' => 'access.reg',
                        'display_name' => '渠道注册统计(超管)',
                        'route' => 'admin.access.reg',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'access.reg.show', 'display_name' => '查看详情','route'=>'admin.access.reg.show'],
                            ['name' => 'access.reg.excel', 'display_name' => '导出','route'=>'admin.access.reg.excel'],
                            ['name' => 'access.reg.sync', 'display_name' => '同步注册数','route'=>'admin.access.reg.sync'],
                        ]
                    ],
                    [
                        'name' => 'access.reg.channel',
                        'display_name' => '渠道注册统计(渠道)',
                        'route' => 'admin.access.regChannel',
                        'icon_id' => null,
                        'child' => [
                        ]
                    ],
                    [
                        'name' => 'access.deduct',
                        'display_name' => '实时注册清单(超管)',
                        'route' => 'admin.access.deduct',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'access.deduct.excel', 'display_name' => '导出','route'=>'admin.access.deduct.excel'],
                        ]
                    ],
                    [
                        'name' => 'access.deduct.channel',
                        'display_name' => '实时注册清单(渠道)',
                        'route' => 'admin.access.deduct.channel',
                        'icon_id' => null,
                        'child' => [
                        ]
                    ],
                    /*[
                        'name' => 'access.reg.day',
                        'display_name' => '每日注册统计(超管)',
                        'route' => 'admin.access.reg.day',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'access.reg.day.show', 'display_name' => '查看详情','route'=>'admin.access.reg.dayShow'],
                            ['name' => 'access.reg.day.excel', 'display_name' => '导出','route'=>'admin.access.reg.dayExcel'],
                        ]
                    ],*/
                    [
                        'name' => 'access.reg.day.channel',
                        'display_name' => '每日注册统计(渠道)',
                        'route' => 'admin.access.reg.dayChannel',
                        'icon_id' => null,
                        'child' => [
                        ]
                    ],
                ]
            ],
            //信用卡
            [
                'name' => 'credit.manage',
                'display_name' => '信用卡',
                'route' => '',
                'icon_id' => '42',
                'child' => [
                    [
                        'name' => 'admin.credit',
                        'display_name' => '信用卡列表',
                        'route' => 'admin.credit',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.credit.create', 'display_name' => '新增','route'=>'admin.credit.create'],
                            ['name' => 'admin.credit.edit', 'display_name' => '编辑','route'=>'admin.credit.edit'],
                            ['name' => 'admin.credit.set', 'display_name' => '上/下架','route'=>'admin.credit.set'],
                            ['name' => 'admin.credit.excel', 'display_name' => '导出','route'=>'admin.credit.excel'],
                        ]
                    ],
                ]
            ],
            //用户反馈
            [
                'name' => 'user.feedback',
                'display_name' => '用户反馈',
                'route' => '',
                'icon_id' => '46',
                'child' => [
                    [
                        'name' => 'admin.feedback',
                        'display_name' => '建议反馈',
                        'route' => 'admin.feedback',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.feedback.edit', 'display_name' => '编辑','route'=>'admin.feedback.edit'],
                            ['name' => 'admin.feedback.export', 'display_name' => '导出','route'=>'admin.feedback.export'],
                        ]
                    ],
                    [
                        'name' => 'admin.comment',
                        'display_name' => '产品评论管理',
                        'route' => 'admin.comment',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.comment.destroy', 'display_name' => '删除','route'=>'admin.comment.destroy'],
                            ['name' => 'admin.comment.edit', 'display_name' => '编辑','route'=>'admin.comment.edit'],
                            ['name' => 'admin.comment.auditPass', 'display_name' => '批量处理','route'=>'admin.comment.auditPass'],
                            ['name' => 'admin.comment.export', 'display_name' => '导出','route'=>'admin.comment.export'],
                            ['name' => 'admin.virtual.comment.create', 'display_name' => '新增虚拟评论','route'=>'admin.virtual.comment.create'],
                        ]
                    ],
                    [
                        'name' => 'admin.virtual.comment.index',
                        'display_name' => '评论池管理',
                        'route' => 'admin.virtual.comment.index',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.virtual.comment.edit', 'display_name' => '评论处理','route'=>'admin.virtual.comment.edit'],
                            ['name' => 'admin.virtual.comment.down', 'display_name' => '模板下载','route'=>'admin.virtual.comment.down.template'],
                            ['name' => 'admin.virtual.comment.import', 'display_name' => '评论导入','route'=>'admin.virtual.comment.import.template'],
                            ['name' => 'admin.virtual.comment.destroy', 'display_name' => '删除','route'=>'admin.virtual.comment.destroy'],
                            ['name' => 'admin.virtual.comment.audit.destroy', 'display_name' => '批量删除','route'=>'admin.virtual.comment.audit.destroy'],
                        ]
                    ],
                ]
            ],
            //推送消息
            [
                'name' => 'push.manage',
                'display_name' => '推送管理',
                'route' => '',
                'icon_id' => '24',
                'child' => [
                        [
                        'name' => 'admin.push',
                        'display_name' => '消息列表',
                        'route' => 'admin.push',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.system.edit', 'display_name' => '编辑系统消息','route'=>'admin.system.edit'],
                            ['name' => 'admin.push.edit', 'display_name' => '编辑推送消息','route'=>'admin.push.edit'],
                            ['name' => 'admin.push.excel', 'display_name' => '导出','route'=>'admin.push.excel'],

                        ]
                    ],
                    [
                        'name' => 'admin.push.create',
                        'display_name' => '新增push消息',
                        'route' => 'admin.push.create',
                        'icon_id' => null,
                        'child' => [
                            ['name' => 'admin.push.import', 'display_name' => '导入','route'=>'admin.push.import'],
                        ]
                    ],
                    [
                        'name' => 'admin.system.create',
                        'display_name' => '新增系统消息',
                        'route' => 'admin.system.create',
                        'icon_id' => null,
                        'child' => []
                    ],
                ]
            ],


        ];

        $channel_permissions=['access.reg.channel','access.deduct.channel','access.reg.day.channel'];
        foreach ($permissions as $pem1) {
            //生成一级权限
            $p1 = \App\Models\Permission::create([
                'name' => $pem1['name'],
                'display_name' => $pem1['display_name'],
                'route' => $pem1['route']??'',
                'icon_id' => $pem1['icon_id']??1,
            ]);
            //为角色添加权限
            $role->givePermissionTo($p1);
            //为用户添加权限
            $user->givePermissionTo($p1);
            if (isset($pem1['child'])) {
                foreach ($pem1['child'] as $pem2) {
                    //生成二级权限
                    $p2 = \App\Models\Permission::create([
                        'name' => $pem2['name'],
                        'display_name' => $pem2['display_name'],
                        'parent_id' => $p1->id,
                        'route' => $pem2['route']??1,
                        'icon_id' => $pem2['icon_id']??1,
                    ]);
                    if(in_array($pem2['name'],$channel_permissions)){
                        continue;
                    }
                    //为角色添加权限
                    $role->givePermissionTo($p2);
                    //为用户添加权限
                    $user->givePermissionTo($p2);
                    if (isset($pem2['child'])) {
                        foreach ($pem2['child'] as $pem3) {
                            //生成三级权限
                            $p3 = \App\Models\Permission::create([
                                'name' => $pem3['name'],
                                'display_name' => $pem3['display_name'],
                                'parent_id' => $p2->id,
                                'route' => $pem3['route']??'',
                                'icon_id' => $pem3['icon_id']??1,
                            ]);
                            if(in_array($pem2['name'],$channel_permissions)){
                                continue;
                            }
                            //为角色添加权限
                            $role->givePermissionTo($p3);
                            //为用户添加权限
                            $user->givePermissionTo($p3);
                        }
                    }
                }
            }
        }

        //为用户添加角色
        $user->assignRole($role);

        //初始化的角色
        $roles = [
            ['name' => 'business', 'display_name' => '商务'],
            ['name' => 'assessor', 'display_name' => '审核员'],
            ['name' => 'channel', 'display_name' => '渠道专员','type'=>'channel'],
            ['name' => 'editor', 'display_name' => '编辑人员'],
            ['name' => 'admin', 'display_name' => '管理员'],
        ];
        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
