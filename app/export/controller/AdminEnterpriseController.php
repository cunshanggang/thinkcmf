<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/22
 * Time: 15:26
 */
namespace app\export\controller;

use cmf\controller\AdminBaseController;
class AdminEnterpriseController extends AdminBaseController
{
    public function index() {
        return $this->fetch();
    }
}