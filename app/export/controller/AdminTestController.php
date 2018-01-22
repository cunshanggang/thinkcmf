<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/22
 * Time: 15:50
 */
namespace app\export\controller;

use cmf\controller\AdminBaseController;
class AdminTestController extends AdminBaseController
{
    public function index() {
        $articles = "";
        $this->assign("articles",$articles);
        return $this->fetch();
    }
}