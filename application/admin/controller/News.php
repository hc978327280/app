<?php
namespace app\admin\controller;
use think\Controller;
class News extends Base{
    public function index(){
        $news=model('News')->getNews();
        return $this->fetch('',[
            'cats'=>config('cat.list'),
            'news'=>$news
        ]);
    }
    /**
     * 增加操作
     */
    public function add(){
        if(request()->isPost()) {

            $data = input('post.');
            // 数据需要做检验 validate机制小伙伴自行完成
            $validate=validate('News');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            //入库操作
            try {
                $id = model('News')->add($data);
            }catch (\Exception $e) {
                return $this->result('', 0, '新增失败');
            }

            if($id) {
                return $this->result(['jump_url' => url('news/index')], 1, 'OK');
            } else {
                return $this->result('', 0, '新增失败');
            }
        }else {
            return $this->fetch('', [
                'cats' => config('cat.list')
            ]);
        }
    }
}
