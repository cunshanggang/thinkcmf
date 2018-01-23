<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/22
 * Time: 14:50
 */
namespace app\export\controller;

use cmf\controller\AdminBaseController;
use app\portal\model\PortalPostModel;
use app\export\service\PostService;
use app\portal\model\PortalCategoryModel;
use think\Db;
use app\admin\model\ThemeModel;
class AdminOrderController extends AdminBaseController
{
    public function index() {
        $param = $this->request->param();

        return $this->fetch();
    }
}