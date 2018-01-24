<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/24
 * Time: 11:36
 */
namespace app\export\controller;

use cmf\controller\AdminBaseController;
use app\export\model\NewsModel;
use app\export\service\PostService;
use think\Db;
use app\admin\model\ThemeModel;
class AdminNewsController extends AdminBaseController
{
    public function index() {
//        $data = new NewsModel();
        $data = NewsModel::get(1);
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        return $this->fetch();
    }
}