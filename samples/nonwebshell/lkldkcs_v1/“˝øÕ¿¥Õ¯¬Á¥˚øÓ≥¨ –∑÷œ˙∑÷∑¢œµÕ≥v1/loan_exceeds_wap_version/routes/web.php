<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return redirect('login');
//});


Route::group(['middleware'=>['log']],function (){
    Auth::routes();
    Route::post('uploadImage','Admin\PublicController@uploadImage')->name('uploadImage');
    Route::post('commonUpload','Admin\PublicController@commonUpload')->name('upload');
    Route::post('uploadFile','Admin\PublicController@uploadFile')->name('uploadFile');
    Route::post('uploadApk','Admin\PublicController@uploadApk')->name('uploadApk');
});

Route::group(['namespace'=>'Admin','middleware'=>['auth','admin'],'prefix'=>'admin'],function (\Illuminate\Routing\Router $router){

    $router->get('home','HomeController@layout')->name('admin.home');
    $router->get('index','HomeController@index')->name('admin.index');
    $router->get('icons','IndexController@icons')->name('admin.icons');

    $router->get('password','UserController@showPasswordForm')->name('admin.getPassword');
    $router->post('password','UserController@password')->name('admin.postPassword');

});

//系统管理
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['auth','admin','permission:system.manage']],function (){
    //数据表格接口
    Route::get('data','IndexController@data')->name('admin.data')->middleware('permission:system.role|system.user|system.permission');
    //用户管理
    Route::group(['middleware'=>['permission:system.user']],function (){
        Route::get('user','UserController@index')->name('admin.user');
        //添加
        Route::get('user/create','UserController@create')->name('admin.user.create')->middleware('permission:system.user.create');
        Route::post('user/store','UserController@store')->name('admin.user.store')->middleware('permission:system.user.create');
        //编辑
        Route::get('user/{id}/edit','UserController@edit')->name('admin.user.edit')->middleware('permission:system.user.edit');
        Route::put('user/{id}/update','UserController@update')->name('admin.user.update')->middleware('permission:system.user.edit');
        //启用禁用
        Route::post('user/status','UserController@status')->name('admin.user.status')->middleware('permission:system.user.status');
        //删除
        Route::delete('user/destroy/{id?}','UserController@destroy')->name('admin.user.destroy')->middleware('permission:system.user.destroy');
        //分配角色
        Route::get('user/{id}/role','UserController@role')->name('admin.user.role')->middleware('permission:system.user.role');
        Route::put('user/{id}/assignRole','UserController@assignRole')->name('admin.user.assignRole')->middleware('permission:system.user.role');
        //分配权限
        Route::get('user/{id}/permission','UserController@permission')->name('admin.user.permission')->middleware('permission:system.user.permission');
        Route::put('user/{id}/assignPermission','UserController@assignPermission')->name('admin.user.assignPermission')->middleware('permission:system.user.permission');
    });
    //角色管理
    Route::group(['middleware'=>'permission:system.role'],function (){
        Route::get('role','RoleController@index')->name('admin.role');
        //添加
        Route::get('role/create','RoleController@create')->name('admin.role.create')->middleware('permission:system.role.create');
        Route::post('role/store','RoleController@store')->name('admin.role.store')->middleware('permission:system.role.create');
        //编辑
        Route::get('role/{id}/edit','RoleController@edit')->name('admin.role.edit')->middleware('permission:system.role.edit');
        Route::put('role/{id}/update','RoleController@update')->name('admin.role.update')->middleware('permission:system.role.edit');
        //删除
        Route::delete('role/destroy','RoleController@destroy')->name('admin.role.destroy')->middleware('permission:system.role.destroy');
        //分配权限
        Route::get('role/{id}/permission','RoleController@permission')->name('admin.role.permission')->middleware('permission:system.role.permission');
        Route::put('role/{id}/assignPermission','RoleController@assignPermission')->name('admin.role.assignPermission')->middleware('permission:system.role.permission');
    });
    //权限管理
    Route::group(['middleware'=>'permission:system.permission'],function (){
        Route::get('permission','PermissionController@index')->name('admin.permission');
        //添加
        Route::get('permission/create','PermissionController@create')->name('admin.permission.create')->middleware('permission:system.permission.create');
        Route::post('permission/store','PermissionController@store')->name('admin.permission.store')->middleware('permission:system.permission.create');
        //编辑
        Route::get('permission/{id}/edit','PermissionController@edit')->name('admin.permission.edit')->middleware('permission:system.permission.edit');
        Route::put('permission/{id}/update','PermissionController@update')->name('admin.permission.update')->middleware('permission:system.permission.edit');
        //删除
//        Route::delete('permission/destroy','PermissionController@destroy')->name('admin.permission.destroy')->middleware('permission:system.permission.destroy');
        Route::delete('permission/destroy/{id?}','PermissionController@destroy')->name('admin.permission.destroy')->middleware('permission:system.permission.destroy');
        Route::post('permission/sort','PermissionController@sort')->name('admin.permission.sort');
    });
    //菜单管理
   /* Route::group(['middleware'=>'permission:system.menu'],function (){
        Route::get('menu','MenuController@index')->name('admin.menu');
        Route::get('menu/data','MenuController@data')->name('admin.menu.data');
        //添加
        Route::get('menu/create','MenuController@create')->name('admin.menu.create')->middleware('permission:system.menu.create');
        Route::post('menu/store','MenuController@store')->name('admin.menu.store')->middleware('permission:system.menu.create');
        //编辑
        Route::get('menu/{id}/edit','MenuController@edit')->name('admin.menu.edit')->middleware('permission:system.menu.edit');
        Route::put('menu/{id}/update','MenuController@update')->name('admin.menu.update')->middleware('permission:system.menu.edit');
        //删除
        Route::delete('menu/destroy','MenuController@destroy')->name('admin.menu.destroy')->middleware('permission:system.menu.destroy');
    });*/
});


//资讯管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','admin', 'permission:zixun.manage']], function () {
    //分类管理
    /*Route::group(['middleware' => 'permission:zixun.category'], function () {
        Route::get('category/data', 'CategoryController@data')->name('admin.category.data');
        Route::get('category', 'CategoryController@index')->name('admin.category');
        //添加分类
        Route::get('category/create', 'CategoryController@create')->name('admin.category.create')->middleware('permission:zixun.category.create');
        Route::post('category/store', 'CategoryController@store')->name('admin.category.store')->middleware('permission:zixun.category.create');
        //编辑分类
        Route::get('category/{id}/edit', 'CategoryController@edit')->name('admin.category.edit')->middleware('permission:zixun.category.edit');
        Route::put('category/{id}/update', 'CategoryController@update')->name('admin.category.update')->middleware('permission:zixun.category.edit');
        //删除分类
        Route::delete('category/destroy', 'CategoryController@destroy')->name('admin.category.destroy')->middleware('permission:zixun.category.destroy');
    });*/
    //文章管理
    Route::group(['middleware' => 'permission:zixun.article'], function () {
        Route::get('article/data', 'ArticleController@data')->name('admin.article.data');
        Route::get('article', 'ArticleController@index')->name('admin.article');
        //添加
        Route::get('article/create', 'ArticleController@create')->name('admin.article.create')->middleware('permission:zixun.article.create');
        Route::post('article/store', 'ArticleController@store')->name('admin.article.store')->middleware('permission:zixun.article.create');
        //编辑
        Route::get('article/{id}/edit', 'ArticleController@edit')->name('admin.article.edit')->middleware('permission:zixun.article.edit');
        Route::put('article/{id}/update', 'ArticleController@update')->name('admin.article.update')->middleware('permission:zixun.article.edit');
        //删除
        Route::delete('article/destroy', 'ArticleController@destroy')->name('admin.article.destroy')->middleware('permission:zixun.article.destroy');
    });
    //标签管理
   /* Route::group(['middleware' => 'permission:zixun.tag'], function () {
        Route::get('tag/data', 'TagController@data')->name('admin.tag.data');
        Route::get('tag', 'TagController@index')->name('admin.tag');
        //添加
        Route::get('tag/create', 'TagController@create')->name('admin.tag.create')->middleware('permission:zixun.tag.create');
        Route::post('tag/store', 'TagController@store')->name('admin.tag.store')->middleware('permission:zixun.tag.create');
        //编辑
        Route::get('tag/{id}/edit', 'TagController@edit')->name('admin.tag.edit')->middleware('permission:zixun.tag.edit');
        Route::put('tag/{id}/update', 'TagController@update')->name('admin.tag.update')->middleware('permission:zixun.tag.edit');
        //删除
        Route::delete('tag/destroy', 'TagController@destroy')->name('admin.tag.destroy')->middleware('permission:zixun.tag.destroy');
    });*/
});

//会员管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'admin', 'permission:member.manage']], function () {
//Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','admin']], function () {
    //用户信息
//    Route::group(['middleware' => 'permission:member.member'], function () {
        Route::get('member/data', 'MemberController@data')->name('admin.member.data');
        Route::get('member', 'MemberController@index')->name('admin.member')->middleware('permission:admin.member.member');

        Route::get('member/{id}/edit','MemberController@edit')->name('admin.member.edit');
        Route::put('member/{id}/update','MemberController@update')->name('admin.member.update');

        Route::get('member/toExcel', 'MemberController@toExcel')->name('admin.member.toExcel')->middleware('permission:admin.member.member.toExcel');
        Route::delete('member/destroy', 'MemberController@destroy')->name('admin.member.destroy');

//    });
        //意向管理
        Route::get('apply', 'ApplyController@index')->name('admin.apply')->middleware('permission:admin.member.apply');
        Route::get('apply/data', 'ApplyController@data')->name('admin.apply.data');
        Route::get('apply/toExcel', 'ApplyController@toExcel')->name('admin.apply.toExcel')->middleware('permission:admin.member.apply.toExcel');

        //综合行为日志
        Route::get('behaviorlog','BehaviorLogController@index')->name('admin.behaviorlog')->middleware('permission:admin.member.behaviorlog');
        Route::get('behaviorlog/data','BehaviorLogController@data')->name('admin.behaviorlog.data');
        Route::get('behaviorlog/toExcel','BehaviorLogController@toExcel')->name('admin.behaviorlog.toExcel')->middleware('permission:admin.member.behaviorlog.toExcel');

        //用户模型
        Route::get('userModel','UserModelController@index')->name('admin.userModel')->middleware('permission:admin.member.userModel');
        Route::get('userModel/data','UserModelController@data')->name('admin.userModel.data');

        Route::get('userModel/create','UserModelController@create')->name('admin.userModel.create')->middleware('permission:admin.member.userModel.create');
        Route::post('userModel/store','UserModelController@store')->name('admin.userModel.store')->middleware('permission:admin.member.userModel.create');

        Route::get('userModel/{id}/edit','UserModelController@edit')->name('admin.userModel.edit')->middleware('permission:admin.member.userModel.edit');
        Route::put('userModel/{id}/update','UserModelController@update')->name('admin.userModel.update')->middleware('permission:admin.member.userModel.edit');

        Route::get('userModel/refreshSnapshot','UserModelController@refreshSnapshot')->name('admin.userModel.refreshSnapshot'); //手动刷新全部模型快照
        Route::get('userModel/cronRefreshSnapshot','UserModelController@cronRefreshSnapshot'); //定时任务刷新全部模型快照

        //用户信息采集
        Route::get('real/information','RealInformationController@index')->name('admin.real.information')->middleware('permission:admin.real.information');
        Route::get('real/information/data','RealInformationController@data')->name('admin.real.information.data');
        Route::get('real/information/show/{id}','RealInformationController@show')->name('admin.real.information.show')->middleware('permission:admin.real.information.show');//查看详情
        Route::get('real/information/export', 'RealInformationController@export')->name('admin.real.information.export')->middleware('permission:admin.real.information.export');//导出


});




//门户管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'admin','permission:website.manage']], function () {

        //门户管理
        Route::get('website', 'WebSiteController@index')->name('admin.website')->middleware('permission:admin.website.website');
        Route::put('website/update', 'WebSiteController@update')->name('admin.website.update')->middleware('permission:admin.website.update');

        //营销位
        Route::get('website/image', 'ImageController@index')->name('admin.website.image')->middleware('permission:admin.website.image');
        Route::get('website/image/data', 'ImageController@data')->name('admin.website.image.data');

        Route::get('website/image/{id}/edit', 'ImageController@edit')->name('admin.website.image.edit')->middleware('permission:admin.website.image.edit');
        Route::post('website/image/store', 'ImageController@store')->name('admin.website.image.store')->middleware('permission:admin.website.image.create');
        Route::put('website/image/{id}/update', 'ImageController@update')->name('admin.website.image.update')->middleware('permission:admin.website.image.edit');
        Route::delete('website/image/destroy/{id?}', 'ImageController@destroy')->name('admin.website.image.destroy')->middleware('permission:admin.website.image.destroy');

        //发现管理
        Route::get('website/article','ArticleController@index')->name('admin.website.article')->middleware('permission:admin.website.article');
        Route::get('website/article/data','ArticleController@data')->name('admin.website.article.data');

        //修改状态
        Route::post('website/article/status','ArticleController@status')->name('admin.website.article.status');
        //添加
        Route::get('website/article/create','ArticleController@create')->name('admin.website.article.create')->middleware('permission:admin.website.article.create');
        Route::post('website/article/store','ArticleController@store')->name('admin.website.article.store')->middleware('permission:admin.website.article.create');
        //修改
        Route::get('website/article/{id}/edit','ArticleController@edit')->name('admin.website.article.edit')->middleware('permission:admin.website.article.edit');
        Route::put('website/article/{id}/update','ArticleController@update')->name('admin.website.article.update')->middleware('permission:admin.website.article.edit');
        //删除
        Route::delete('website/article/destroy/{id?}','ArticleController@destroy')->name('admin.website.article.destroy')->middleware('permission:admin.website.article.destroy');

        //帮助管理
        Route::get('website/help','HelpController@index')->name('admin.website.help')->middleware('permission:admin.website.help');
        Route::get('website/help/data','HelpController@data')->name('admin.website.help.data');
        //添加
        Route::get('website/help/create','HelpController@create')->name('admin.website.help.create')->middleware('permission:admin.website.help.create');
        Route::post('website/help/store','HelpController@store')->name('admin.website.help.store')->middleware('permission:admin.website.help.create');
        //编辑
        Route::get('website/help/{id}/edit','HelpController@edit')->name('admin.website.help.edit')->middleware('permission:admin.website.help.edit');
        Route::put('website/help/{id}/update','HelpController@update')->name('admin.website.help.update')->middleware('permission:admin.website.help.edit');
        //删除
        Route::delete('website/help/destroy/{id?}','HelpController@destroy')->name('admin.website.help.destroy')->middleware('permission:admin.website.help.destroy');


        //圈子管理
        Route::get('website/circle','CircleController@index')->name('admin.website.circle')->middleware('permission:admin.website.circle');
        Route::get('website/circle/data','CircleController@data')->name('admin.website.circle.data');
        //添加
        Route::get('website/circle/create','CircleController@create')->name('admin.website.circle.create')->middleware('permission:admin.website.circle.create');
        Route::post('website/circle/store','CircleController@store')->name('admin.website.circle.store')->middleware('permission:admin.website.circle.create');
        //编辑
        Route::get('website/circle/{id}/edit','CircleController@edit')->name('admin.website.circle.edit')->middleware('permission:admin.website.circle.edit');
        Route::put('website/circle/{id}/update','CircleController@update')->name('admin.website.circle.update')->middleware('permission:admin.website.circle.edit');
        //删除
        Route::delete('website/circle/destroy/{id?}','CircleController@destroy')->name('admin.website.circle.destroy')->middleware('permission:admin.website.circle.destroy');

//    });

});



//推送消息
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','admin']], function () {
    Route::get('push', 'MessageController@index')->name('admin.push');
    Route::get('push/create', 'MessageController@create')->name('admin.push.create');
    Route::post('push/create', 'MessageController@store')->name('admin.push.create');

    Route::get('system/create', 'MessageController@system')->name('admin.system.create');
    Route::post('system/create', 'MessageController@systemSave')->name('admin.system.create');

    Route::get('system/{id}/edit', 'MessageController@edit')->name('admin.system.edit');
    Route::post('system/{id}/edit', 'MessageController@systemUpdate')->name('admin.system.edit');

    Route::get('push/data', 'MessageController@data')->name('admin.push.data');
    Route::get('push/excel', 'MessageController@exportExcelData')->name('admin.push.excel');

    Route::get('push/{id}/edit', 'MessageController@edit')->name('admin.push.edit');
    Route::post('push/{id}/edit', 'MessageController@update')->name('admin.push.edit');

    Route::post('push/get/count', 'MessageController@getCountsOfSelect')->name('admin.push.count');//异步查询号码数量

    Route::post('push/set', 'MessageController@setStatus')->name('admin.push.set');
    Route::post('push/excel', 'MessageController@importExcelData')->name('admin.push.import');//数据导入


    //定时推送
    Route::get('message/cron/index', 'MessageCrontabController@index')->name('admin.message.cron.index');
    Route::get('message/cron/data', 'MessageCrontabController@data')->name('admin.message.cron.data');
   // Route::get('message/cron/{id}/edit', 'MessageCrontabController@edit')->name('admin.message.cron.edit');

});
//反馈管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','admin']], function () {
    Route::get('feedback', 'FeedBackController@index')->name('admin.feedback');
    Route::post('feedback', 'FeedBackController@store')->name('admin.feedback');

    Route::get('feedback/export', 'FeedBackController@export')->name('admin.feedback.export');//导出

    Route::get('feedback/data', 'FeedBackController@data')->name('admin.feedback.data');

    Route::get('feedback/{id}/edit', 'FeedBackController@edit')->name('admin.feedback.edit');
    Route::post('feedback/{id}/edit', 'FeedBackController@update')->name('admin.feedback.edit');

    //评论管理
    Route::get('comment', 'CommentController@index')->name('admin.comment');//评论管理
    Route::get('comment/data', 'CommentController@data')->name('admin.comment.data');//评论数据
    Route::get('comment/{id}/edit', 'CommentController@edit')->name('admin.comment.edit');//评论回复
    Route::post('comment/update', 'CommentController@update')->name('admin.comment.update');//评论回复提交
    Route::post('comment/auditPass', 'CommentController@batchAuditPass')->name('admin.comment.auditPass');//批量通过
    Route::post('comment/notAuditPass', 'CommentController@batchNotAuditPass')->name('admin.comment.notAuditPass');//批量不予通过
    Route::post('comment/auditDestroy', 'CommentController@batchDestroy')->name('admin.comment.auditDestroy');//批量删除
    Route::get('comment/export', 'CommentController@batchExport')->name('admin.comment.export');//导出
    Route::delete('comment/destroy', 'CommentController@destroy')->name('admin.comment.destroy');//删除评论
    //评论池管理
    Route::get('virtual/comment/index', 'VirtualCommentController@index')->name('admin.virtual.comment.index');//评论池管理
    Route::get('virtual/comment/data', 'VirtualCommentController@data')->name('admin.virtual.comment.data');//评论池数据
    Route::post('virtual/comment/update', 'VirtualCommentController@update')->name('admin.virtual.comment.update');//编辑提交
    Route::get('virtual/comment/down/template', 'VirtualCommentController@downTemplate')->name('admin.virtual.comment.down.template');//下载模板
    Route::post('virtual/comment/import/template', 'VirtualCommentController@importTemplate')->name('admin.virtual.comment.import.template');//导入数据
    Route::get('virtual/comment/export', 'VirtualCommentController@export')->name('admin.virtual.comment.export');//导出
    Route::delete('virtual/comment/destroy', 'VirtualCommentController@destroy')->name('admin.virtual.comment.destroy');//删除评论
    Route::post('virtual/comment/audit/destroy', 'VirtualCommentController@VirtualDestroy')->name('admin.virtual.comment.audit.destroy');//批量删除
    //新增评论
    Route::get('virtual/comment/create', 'VirtualCommentController@create')->name('admin.virtual.comment.create');//评论池管理
    Route::get('virtual/comment/product/data', 'VirtualCommentController@productData')->name('admin.virtual.comment.product.data');//获取产品
    Route::post('virtual/comment/post/data', 'VirtualCommentController@postData')->name('admin.virtual.comment.post.data');//编辑提交


});
//基础数据
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:data.manage','admin']], function () {
    //数据字典
    Route::group(['middleware' => 'permission:data.dictionary'], function () {

        Route::get('dictionary', 'DictionaryController@index')->name('admin.dictionary');
        Route::get('dictionary/data', 'DictionaryController@data')->name('admin.dictionary.data');

        Route::get('dictionary/create', 'DictionaryController@create')->name('admin.dictionary.create')->middleware('permission:data.dictionary.edit');
        Route::post('dictionary/store','DictionaryController@store')->name('admin.dictionary.store')->middleware('permission:data.dictionary.edit');

        Route::get('product/material','ProductMaterialController@index')->name('admin.product.material')->middleware('permission:data.dictionary.edit');
        Route::post('product/material/store','ProductMaterialController@store')->name('admin.product.material.store')->middleware('permission:data.dictionary.edit');

        Route::get('product/label','ProductLabelController@index')->name('admin.product.label')->middleware('permission:data.dictionary.edit');
        Route::post('product/label/store','ProductLabelController@store')->name('admin.product.label.store')->middleware('permission:data.dictionary.edit');

        Route::get('product/quota','ProductQuotaController@index')->name('admin.product.quota')->middleware('permission:data.dictionary.edit');
        Route::post('product/quota/store','ProductQuotaController@store')->name('admin.product.quota.store')->middleware('permission:data.dictionary.edit');

        Route::get('product/repay','ProductRepayController@index')->name('admin.product.repay')->middleware('permission:data.dictionary.edit');
        Route::post('product/repay/store','ProductRepayController@store')->name('admin.product.repay.store')->middleware('permission:data.dictionary.edit');

        Route::get('product/corner','CornerController@product')->name('admin.product.corner')->middleware('permission:data.dictionary.edit');
        Route::post('product/corner/store','CornerController@storeProduct')->name('admin.product.corner.store')->middleware('permission:data.dictionary.edit');

        Route::get('credit/corner','CornerController@credit')->name('admin.credit.corner')->middleware('permission:data.dictionary.edit');
        Route::post('credit/corner/store','CornerController@storeCredit')->name('admin.credit.corner.store')->middleware('permission:data.dictionary.edit');

        Route::get('credit/bank','CreditBankController@index')->name('admin.credit.bank')->middleware('permission:data.dictionary.edit');
        Route::post('credit/bank/store','CreditBankController@store')->name('admin.credit.bank.store')->middleware('permission:data.dictionary.edit');

        Route::get('credit/level','CreditLevelController@index')->name('admin.credit.level')->middleware('permission:data.dictionary.edit');
        Route::post('credit/level/store','CreditLevelController@store')->name('admin.credit.level.store')->middleware('permission:data.dictionary.edit');

        Route::get('credit/organization','CreditOrgController@index')->name('admin.credit.organization')->middleware('permission:data.dictionary.edit');
        Route::post('credit/organization/store','CreditOrgController@store')->name('admin.credit.organization.store')->middleware('permission:data.dictionary.edit');

        Route::get('article/corner','CornerController@article')->name('admin.article.corner')->middleware('permission:data.dictionary.edit');
        Route::post('article/corner/store','CornerController@storeArticle')->name('admin.article.corner.store')->middleware('permission:data.dictionary.edit');

        Route::get('article/category','ArticleCategoryController@index')->name('admin.article.category')->middleware('permission:data.dictionary.edit');
        Route::post('article/category/store','ArticleCategoryController@store')->name('admin.article.category.store')->middleware('permission:data.dictionary.edit');

        Route::get('feedback/category','FeedbackCategoryController@index')->name('admin.feedback.category')->middleware('permission:data.dictionary.edit');
        Route::post('feedback/category/store','FeedbackCategoryController@store')->name('admin.feedback.category.store')->middleware('permission:data.dictionary.edit');

        //商务合作  //business_cooperation    friendship_cooperation
        Route::get('business/cooperation', 'BusinessCooperationController@index')->name('admin.business.cooperation')->middleware('permission:data.dictionary.edit');
        Route::post('business/cooperation/store', 'BusinessCooperationController@store')->name('admin.business.cooperation.store')->middleware('permission:data.dictionary.edit');
        //合作机构和友情链接
        Route::get('cooperation', 'FriendshipCooperationController@index')->name('admin.cooperation')->middleware('permission:data.dictionary.edit');

        Route::get('friendship', 'FriendshipCooperationController@friendship')->name('admin.friendship')->middleware('permission:data.dictionary.edit');
        Route::post('cooperation/store', 'FriendshipCooperationController@store')->name('admin.cooperation.store')->middleware('permission:data.dictionary.edit');




    });

    //单页管理
    Route::group(['middleware' => 'permission:data.page'], function () {

        //列表
        Route::get('page', 'PageController@index')->name('admin.page');
        Route::get('page/data', 'PageController@data')->name('admin.page.data');
        //添加
        Route::get('page/create', 'PageController@create')->name('admin.page.create')->middleware('permission:data.page.create');
        Route::post('page/store', 'PageController@store')->name('admin.page.store')->middleware('permission:data.page.create');
        Route::get('page/{id}/edit', 'PageController@edit')->name('admin.page.edit')->middleware('permission:data.page.edit');
        Route::put('page/{id}/update', 'PageController@update')->name('admin.page.update')->middleware('permission:data.page.edit');
        //删除
        Route::delete('page/destroy', 'PageController@destroy')->name('admin.page.destroy')->middleware('permission:data.page.destroy');

    });

    //虚拟号码池
    Route::group(['middleware' => 'permission:data.virtualPhone'], function () {

        //列表
        Route::get('virtualPhone', 'VirtualPhoneController@index')->name('admin.virtualPhone');
        Route::get('virtualPhone/data', 'VirtualPhoneController@data')->name('admin.virtualPhone.data');
        //添加
        Route::get('virtualPhone/create', 'VirtualPhoneController@create')->name('admin.virtualPhone.create')->middleware('permission:data.virtualPhone.create');
        Route::post('virtualPhone/store', 'VirtualPhoneController@store')->name('admin.virtualPhone.store')->middleware('permission:data.virtualPhone.create');
        Route::get('virtualPhone/{id}/edit', 'VirtualPhoneController@edit')->name('admin.virtualPhone.edit')->middleware('permission:data.virtualPhone.edit');
        Route::put('virtualPhone/{id}/update', 'VirtualPhoneController@update')->name('admin.virtualPhone.update')->middleware('permission:data.virtualPhone.edit');
        //删除
        Route::delete('virtualPhone/destroy', 'VirtualPhoneController@destroy')->name('admin.virtualPhone.destroy')->middleware('permission:data.virtualPhone.destroy');
        Route::delete('virtualPhone/destroyAll', 'VirtualPhoneController@destroyAll')->name('admin.virtualPhone.destroyAll')->middleware('permission:data.virtualPhone.destroyAll');

    });

    //省市区管理
    Route::group(['middleware' => 'permission:data.district'], function () {

        //省份列表
        Route::get('district', 'DistrictController@index')->name('admin.district');
        Route::get('district/data', 'DistrictController@data')->name('admin.district.data');

    });

    //热门城市
    Route::group(['middleware' => 'permission:data.hotCity'], function () {

        Route::get('hotCity', 'DistrictController@hotCity')->name('admin.hotCity');
        Route::get('hotCity/data', 'DistrictController@hotCityData')->name('admin.hotCity.data');
        Route::get('hotCity/create', 'DistrictController@hotCityCreate')->name('admin.hotCity.create')->middleware('permission:data.hotCity.create');
        Route::post('hotCity/store', 'DistrictController@hotCityStore')->name('admin.hotCity.store')->middleware('permission:data.hotCity.create');
        Route::get('hotCity/{id?}/edit', 'DistrictController@hotCityEdit')->name('admin.hotCity.edit')->middleware('permission:data.hotCity.edit');
        Route::put('hotCity/{id?}/update', 'DistrictController@hotCityUpdate')->name('admin.hotCity.update')->middleware('permission:data.hotCity.edit');
        Route::delete('hotCity/destroy', 'DistrictController@hotCityDestroy')->name('admin.hotCity.destroy')->middleware('permission:data.hotCity.destroy');

    });

});


Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:data.manage']], function () {
    Route::group(['middleware' => 'permission:data.operateLog'], function () {

        Route::get('operateLog', 'OperateLogController@index')->name('admin.operateLog');
        Route::get('operateLog/data', 'OperateLogController@data')->name('admin.operateLog.data');
        Route::delete('operateLog/destroy', 'OperateLogController@destroy')->name('admin.operateLog.destroy')->middleware('permission:data.operateLog.destroy');
        Route::get('operateLog/excel', 'OperateLogController@excel')->name('admin.operateLog.excel')->middleware('permission:data.operateLog.excel');

    });
});


//产品管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:product.manage','admin']], function () {

    //产品
    Route::group(['middleware' => 'permission:product.product'], function () {

        Route::get('product', 'ProductController@index')->name('admin.product');
        Route::get('product/data', 'ProductController@data')->name('admin.product.data');

        Route::get('product/create', 'ProductController@create')->name('admin.product.create')->middleware('permission:product.create');
        Route::post('product/store', 'ProductController@store')->name('admin.product.store')->middleware('permission:product.create');
        Route::get('product/{id?}/edit', 'ProductController@edit')->name('admin.product.edit')->middleware('permission:product.edit');
        Route::put('product/{id?}/update', 'ProductController@update')->name('admin.product.update')->middleware('permission:product.edit');
        Route::delete('product/destroy', 'ProductController@destroy')->name('admin.product.destroy')->middleware('permission:product.destroy');

        Route::post('product/status', 'ProductController@status')->name('admin.product.status')->middleware('permission:product.status');
        Route::get('product/excel', 'ProductController@excel')->name('admin.product.excel')->middleware('permission:product.excel');
        Route::get('product/autoUpLoan', 'ProductController@autoUpLoan')->name('admin.product.autoUpLoan');
        Route::get('credit/autoUpCredit', 'CreditController@autoUpCredit')->name('admin.credit.autoUpCredit');
        Route::get('msg/cron/no/register', 'MessageCrontabController@notRegister')->name('admin.msg.cron.no.register');
        //推送测试
       /* Route::get('msg/cron/no/register/{type}', 'MessageCrontabController@notRegister')->name('admin.msg.cron.no.register');
        Route::get('msg/cron/no/apply/{type}', 'MessageCrontabController@noApplyOrLoss')->name('admin.msg.cron.no.apply');*/


    });

    //贷款类目
    Route::group(['middleware' => 'permission:product.category'], function () {

        Route::get('productCategory', 'ProductCategoryController@index')->name('admin.productCategory');
        Route::get('productCategory/data', 'ProductCategoryController@data')->name('admin.productCategory.data');

        Route::get('productCategory/create', 'ProductCategoryController@create')->name('admin.productCategory.create')->middleware('permission:product.category.create');
        Route::post('productCategory/store', 'ProductCategoryController@store')->name('admin.productCategory.store')->middleware('permission:product.category.create');
        Route::get('productCategory/{id?}/edit', 'ProductCategoryController@edit')->name('admin.productCategory.edit')->middleware('permission:product.category.edit');
        Route::put('productCategory/{id?}/update', 'ProductCategoryController@update')->name('admin.productCategory.update')->middleware('permission:product.category.edit');
        Route::delete('productCategory/destroy', 'ProductCategoryController@destroy')->name('admin.productCategory.destroy')->middleware('permission:product.category.destroy');

    });

    //贷款栏目
    Route::group(['middleware' => 'permission:product.column'], function () {

        Route::get('productColumn', 'ProductColumnController@index')->name('admin.productColumn');
        Route::get('productColumn/data', 'ProductColumnController@data')->name('admin.productColumn.data');

        Route::get('productColumn/create', 'ProductColumnController@create')->name('admin.productColumn.create')->middleware('permission:product.column.create');
        Route::post('productColumn/store', 'ProductColumnController@store')->name('admin.productColumn.store')->middleware('permission:product.column.create');
        Route::get('productColumn/{id?}/edit', 'ProductColumnController@edit')->name('admin.productColumn.edit')->middleware('permission:product.column.edit');
        Route::put('productColumn/{id?}/update', 'ProductColumnController@update')->name('admin.productColumn.update')->middleware('permission:product.column.edit');
        Route::delete('productColumn/destroy', 'ProductColumnController@destroy')->name('admin.productColumn.destroy')->middleware('permission:product.column.destroy');

    });

});



//统计中心
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:access.manage','admin']], function () {



    //刷量预警
    Route::group(['middleware' => 'permission:warn'], function () {


        //新版标签管理
        Route::get('label', 'LabelController@index')->name('admin.label')->middleware('permission:label.index');
        Route::get('label/data', 'LabelController@data')->name('admin.label.data');
        Route::get('label/create', 'LabelController@create')->name('admin.label.create')->middleware('permission:label.create');
        Route::post('label/store', 'LabelController@store')->name('admin.label.store');
        Route::get('label/{id?}/edit', 'LabelController@edit')->name('admin.label.edit')->middleware('permission:label.edit');
        Route::put('label/{id?}/update', 'LabelController@update')->name('admin.label.update');
        Route::delete('label', 'LabelController@destroy')->name('admin.label.destroy')->middleware('permission:label.destroy');
        Route::post('label/status', 'LabelController@status')->name('admin.label.status');

    });


});
//短信管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','admin']], function () {
    /*短信配置*/
    Route::get('sms', 'SmsController@index')->name('admin.sysmsg');
    Route::get('sms/data', 'SmsController@data')->name('admin.sysmsg.data');
    Route::get('sms/{id}/edit', 'SmsController@edit')->name('admin.sysmsg.edit');
    Route::post('sms/{id}/edit', 'SmsController@update')->name('admin.sysmsg.edit');
    Route::get('sms/create', 'SmsController@create')->name('admin.sysmsg.create');
    Route::post('sms/create', 'SmsController@store')->name('admin.sysmsg.create');
    Route::get('sms/recharge', 'SmsController@recharge')->name('admin.sysmsg.recharge');//充值列表
    Route::get('sms/recharge/data', 'SmsController@rechargeData')->name('admin.sysmsg.recharge.data');//充值列表
    Route::get('sms/charge', 'SmsController@charge')->name('admin.sysmsg.charge');//充值
    Route::get('sms/template', 'SmsController@getTemplate')->name('admin.sysmsg.template');//充值
    /*短信配置*/
});


Route::group(['namespace'=>'Admin'],function (){
   Route::get('getCityByProvince','DistrictController@getCityByProvince')->name('getCityByProvince');//省市联动
});

