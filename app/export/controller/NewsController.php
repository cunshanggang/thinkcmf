<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/8
 * Time: 10:18
 */
namespace app\export\controller;

use app\export\model\NewsModel;
use cmf\controller\HomeBaseController;
use app\export\service\PostService;
use app\export\model\NewsPostModel;
use think\Db;

class NewsController extends HomeBaseController
{
    public function index() {
        $newsId['id']  = $this->request->param('id', 0, 'intval');
        $m = new NewsModel();

//        echo "<pre>";
//        print_r($newsId);
//        echo "</pre>";
        $one_news = $m->oneNews($newsId);
        echo "<pre>";
        print_r($one_news);
        echo "</pre>";
        hook('portal_before_assign_article', $one_news);
        $this->assign("news",$one_news);
        return $this->fetch('/news');
    }
}