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
//        echo "<pre>";
//        print_r($this->request->isPost());
//        echo "</pre>";exit;
        if ($this->request->isPost()) {
            $data   = $this->request->param();
            $post   = $data['post'];
            $result = $this->validate($post, 'AdminNews');
            if ($result !== true) {
                $this->error($result);
            }

            $portalPostModel = new NewsPostModel();

            if (!empty($data['photo_names']) && !empty($data['photo_urls'])) {
                $data['post']['more']['photos'] = [];
                foreach ($data['photo_urls'] as $key => $url) {
                    $photoUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['photos'], ["url" => $photoUrl, "name" => $data['photo_names'][$key]]);
                }
            }

            if (!empty($data['file_names']) && !empty($data['file_urls'])) {
                $data['post']['more']['files'] = [];
                foreach ($data['file_urls'] as $key => $url) {
                    $fileUrl = cmf_asset_relative_url($url);
                    array_push($data['post']['more']['files'], ["url" => $fileUrl, "name" => $data['file_names'][$key]]);
                }
            }

            $portalPostModel->adminAddArticle($data['post'], $data['post']['categories']);

            $data['post']['id'] = $portalPostModel->id;
            $hookParam          = [
                'is_add'  => true,
                'article' => $data['post']
            ];
            hook('portal_admin_after_save_article', $hookParam);


            $this->success('添加成功!', url('AdminTest/edit', ['id' => $portalPostModel->id]));
        }

    }

    //编辑文章
    public function edit() {

        return $this->fetch();
    }
}