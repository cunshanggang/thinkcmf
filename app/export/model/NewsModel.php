<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/24
 * Time: 11:38
 */
namespace app\export\model;
use think\Model;
use think\Db;
class NewsModel extends Model {

    public function orderList() {
        $list = Db::table("cmf_order_goods")->field('og.order_id,og.ent_goods_no,og.goods_name,oi.order_sn,oi.checking_no,msg.msg_status,msg.msg_name')
            ->alias('og')
            ->join('cmf_order_info oi','og.order_id=oi.order_id')
            ->join('cmf_msg msg','oi.order_id=msg.rec_id')
            ->where(['msg.xml_type'=>1])
            ->select();
        return $list;
    }

    public function oneNews($newsId) {
        $one_news = Db::table("cmf_news")->where($newsId)->find();
        return $one_news;
    }
}