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
use think\Loader;
class AdminTestController extends AdminBaseController
{
    public function index() {
        $param = $this->request->param();
        $postService = new PostService();
        $data = $postService->adminNewsList($param);
        //分页
        $this->assign('articles', $data->items());
        $this->assign('page', $data->render());
        return $this->fetch();
    }

    public function delete() {
        $param           = $this->request->param();
        $newsPostModel = new NewsPostModel();
        //单条删除
//        echo "<pre>";
//        print_r($param);
//        echo "</pre>";exit;
        if(isset($param['id'])) {
            $id = $this->request->param('id',0,'intval');
            $result = $newsPostModel->where(['id'=>$id])->delete();
            if($result) {
                $this->success("删除成功！", '');
            }
        }
        //多条删除
        if(isset($param['ids'])) {
            $ids = $this->request->param("ids/a");
            $recycle = $newsPostModel->where(['id' => ['in', $ids]])->delete();;
//            echo "<pre>";
//            print_r($ids);
//            echo "</pre>";
            if($recycle) {
                $this->success("删除成功！", '');
            }
        }

    }

    //添加文章
    public function add() {
        $themeModel        = new ThemeModel();
        $articleThemeFiles = $themeModel->getActionThemeFiles('export/Test/index');
        $this->assign('article_theme_files', $articleThemeFiles);
        return $this->fetch();
    }

    //添加文章数据处理
    public function addPost()
    {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $result = $this->validate($post, 'AdminNews');
            if ($result !== true) {
                $this->error($result);
            }

            $NewsPostModel = new NewsPostModel();
            $NewsPostModel->adminAddNews($post);
            $this->success('添加成功!', url('AdminTest/index'));
        }

    }

    //编辑文章
    public function edit() {

        $id = $this->request->param('id', 0, 'intval');

        $NewsPostModel = new NewsPostModel();
        $post = $NewsPostModel->where('id', $id)->find();
//        echo "<pre>";
//        print_r($post);
//        echo "</pre>";

        $themeModel   = new ThemeModel();
        $articleThemeFiles = $themeModel->getActionThemeFiles('export/Test/index');
        $this->assign('article_theme_files', $articleThemeFiles);
        $this->assign('post', $post);

        return $this->fetch();
    }

    //编辑更新数据
    public function editPost() {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            echo "<pre>";
            print_r($post);
            echo "</pre>";
            $result = $this->validate($post, 'AdminNews');
            if ($result !== true) {
                $this->error($result);
            }

            $NewsPostModel = new NewsPostModel();
            $result = $NewsPostModel->adminEditNews($post);
            if($result) {
                $this->success('更新成功!', url('AdminTest/index'));
            }

        }
    }
    //上传图片
    public function uploadPic() {

        return $this->fetch('pic');//不用带后缀名.html
    }

    //处理上传文件
    public function upload() {
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $data['post']['more']['photos'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
                }
            }
//            echo "4654646";
//            echo "<pre>";
//            print_r($data);
//            echo "</pre>";
            $this->success("上传成功",url("adminTest/uploadPic"));
        }
    }


    //导出
    public function export() {

        return $this->fetch();
    }

    public function exportExcel() {
//        $fileName = "news";
//        $headArr = array("序号","标题","发布者","内容","时间","状态");
//        $data = db("news")->select();
        $fileName = "hs_code";
        $headArr = array("序号","商品编码","附件编码","商品附件码","名称","属性","单位一","单位二","进口税率(优惠)","进口税率(普通)","增值税","消费税","监控条件");
        $data = db("hs_code")->select();

//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        $data1 = array();
//        foreach($data as $k=>$v) {
//            echo "<pre>";
//            print_r($v);
//            echo "</pre>";
            //新闻表
//            $data1[$k]['id'] = $v['id'];
//            $data1[$k]['title'] = $v['title'];
//            $data1[$k]['author'] = $v['author'];
//            $data1[$k]['content'] = $v['content'];
//            $data1[$k]['time'] = date("Y-m-d H:i:s",$v['time']);
//            $data1[$k]['status'] = ($v['status'] == 1) ? '开启':'锁定';
//            echo "<hr>";
//        }
//        exit;
        $this->getExcel($fileName,$headArr,$data);
    }

    //导出引用方法
    public  function getExcel($fileName,$headArr,$data)
    {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
//        import("Org.Util.PHPExcel");
//        import("Org.Util.PHPExcel.Writer.Excel5");
//        import("Org.Util.PHPExcel.IOFactory.php");

        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();

        //设置表头
        $key = ord("A");
        //print_r($headArr);exit;
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
        }

        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();

        //print_r($data);exit;
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列写入
                $j = chr($span);
                $objActSheet->setCellValue($j.$column, $value);
                $span++;
            }
            $column++;
        }

        $fileName = iconv("utf-8", "gb2312", $fileName);

        //重命名表
        //$objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;

    }
    //导入
    public function import() {
//        echo "<pre>";
//        print_r($_FILES);
//        echo "</pre>";
//        Loader::import('');
//        vendor("phpoffice.phpexcel.Classes.PHPExcel.PHPExcel",".php");
//        $excelObj = new \PHPExcel();
        //集体引入类库
//        vendor("phpexcel.Classes.PHPExcel.PHPExcel");
//        //5后面如果没有.的话也会报错
//        vendor("phpexcel.Classes.PHPExcel.Writer.Excel5.");
//        //7后面如果没有.的话也会报错
//        vendor("phpexcel.Classes.PHPExcel.Writer.Excel2007.");
//        vendor("phpexcel.Classes.PHPExcel.IOFactory");

        if ($this->request->isPost()) {
            $data   = $this->request->param();
//            echo "<pre>";
//            print_r($data);
//            echo "</pre>";
        }

        $arrExcel = "";
        if (!empty($data['file_names']) && !empty($data['file_urls'])) {
            $data['post']['more']['files'] = [];
            foreach ($data['file_urls'] as $key => $url) {
                $fileUrl = cmf_asset_relative_url($url);
                array_push($data['post']['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
            }
//            echo "<pre>";
//            print_r($fileUrl);
//            echo "</pre>";
            $url = UPLOAD."/{$data['file_urls'][0]}";
            $objPHPExcel = \PHPExcel_IOFactory::load($url);//读取上传的文件
            $arrExcel = $objPHPExcel->getSheet(0)->toArray();//获取其中的数据
//            echo "<pre>";
//            print_r($arrExcel);
//            echo "</pre>";
//            exit;
            foreach ($arrExcel as $k=>$v) {
//                $data1['id'] = $v[0];
                $data1['title'] = $v[1];
                $data1['author'] = $v[2];
                $data1['content'] = $v[3];
                $data1['time'] = $v[4];
                $data1['status'] = $v[5];
                db("news")->insert($data1);
            }
            $this->success("插入成功!",url("AdminTest/index"));
        }
//        echo "<pre>";
//        print_r($arrExcel);//die;
//        echo "</pre>";exit;
//        return $arrExcel;
        return $this->fetch();
    }
    //弹窗框
    public function box() {

        return $this->fetch();
    }

    //插件
    public function myfrm() {
        return $this->fetch();
    }
    //测试
    public function test() {
        //更新update和插入insert
        $r = Db::execute("UPDATE cmf_news SET content='内容2' WHERE id=2");
        //如果更新返回结果为：1
        //如果没有更新返回结果为：0
        //查询select
//        $r = Db::query("select * from cmf_news where id=1");
        echo "<pre>";
        print_r($r);
        echo "</pre>";
    }

    //订单信息，商品信息，订单状态三表查询
    public function orders() {
        $m = model("News");
        $r = $m->orderList();
        echo "<pre>";
        print_r($r);
        echo "</pre>";
        echo "<hr>";
        echo "<pre>";
        print_r(Db::getLastSql());//打印最近执行的sql语句
        echo "</pre>";
    }
}