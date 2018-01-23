<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/22
 * Time: 15:50
 */
namespace app\export\controller;

use cmf\controller\AdminBaseController;
use app\export\model\NewsPostModel;
use app\export\service\PostService;
use think\Db;
use app\admin\model\ThemeModel;
class AdminTestController extends AdminBaseController
{
    public function index() {
        $param = $this->request->param();
        $postService = new PostService();
        $data       = $postService->adminNewsList($param);
//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
//        $articles = "";
        $this->assign('articles', $data->items());
//        $this->assign('category_tree', $categoryTree);
//        $this->assign('category', $categoryId);
        $this->assign('page', $data->render());
        return $this->fetch();
    }
}