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
        $data = $postService->adminNewsList($param);
        //分页
        $this->assign('articles', $data->items());
        $this->assign('page', $data->render());
        return $this->fetch();
    }

    //添加文章
    public function add() {
        $themeModel        = new ThemeModel();
        $articleThemeFiles = $themeModel->getActionThemeFiles('export/test/index');
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

        return $this->fetch();
    }
}