<?php
namespace app\admin\controller;

use think\Controller;

class Admin extends Controller
{
   public function add(){
       //判断是否为POST提交
       if (request()->isPost()) {
           $data=input('post.');
           //实例化验证类
            $validate=validate('AdminUser');
            //调用check方法进行验证
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $data['password']=md5($data['password'].'_#sing_ty');
            //进行插入
            try {
                $id=model('AdminUser')->add($data);
            } catch (\Exception $e) {
                $this->error('添加失败');
            }
            //判断插入是否成功
            if ($id) {
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }

       }else{
        return $this->fetch('add');
        }

    }
   
   
}
