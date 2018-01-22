<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/22
 * Time: 14:50
 */
namespace app\export\controller;

use cmf\controller\AdminBaseController;
class AdminOrderController extends AdminBaseController
{
    public function index() {
        return $this->fetch();
    }
}