<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/24
 * Time: 14:37
 */
namespace app\export\validate;

use think\Validate;

class AdminNewsValidate extends Validate
{
    protected $rule = [
        'title' => 'require',
        'author' => 'require',
        'content' => 'require',
    ];
    protected $message = [
        'title.require' => '新闻标题不能为空！',
        'author.require' => '发布者不能为空！',
        'content.require' => '内容不能为空！',
    ];

    protected $scene = [
//        'add'  => ['user_login,user_pass,user_email'],
//        'edit' => ['user_login,user_email'],
    ];
}