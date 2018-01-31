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

    //导入
    public function import() {
//        echo "<pre>";
//        print_r($_FILES);
//        echo "</pre>";
//        Loader::import('');
//        vendor("phpoffice.phpexcel.Classes.PHPExcel.PHPExcel",".php");
//        $excelObj = new \PHPExcel();

        if ($this->request->isPost()) {
            $data   = $this->request->param();
//            echo "<pre>";
//            print_r($data);
//            echo "</pre>";
        }

        if (!empty($data['file_names']) && !empty($data['file_urls'])) {
            $data['post']['more']['files'] = [];
            foreach ($data['file_urls'] as $key => $url) {
                $fileUrl = cmf_asset_relative_url($url);
                array_push($data['post']['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
            }
            $objPHPExcel = \PHPExcel_IOFactory::load($data['file_urls'][0]);//读取上传的文件
            $arrExcel = $objPHPExcel->getSheet(0)->toArray();//获取其中的数据
            echo "<pre>";
            print_r($arrExcel);//die;
            echo "</pre>";exit;
//            print_r($data);

        }

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
}