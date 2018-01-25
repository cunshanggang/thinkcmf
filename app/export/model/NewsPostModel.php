<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 15:04
 */
namespace app\export\model;
use app\admin\model\RouteModel;
use think\Model;
use think\Db;
class NewsPostModel extends Model {
    protected $table="cmf_news";

    //增加新闻
    public function adminAddNews($data) {
        //保存数据到数据库
        $result = $this->save($data);
        return $result;
    }

}