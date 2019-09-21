<?php
namespace app\admin\controller;
use think\Controller;
/**
 * 后台的基础类库
 */
class Base extends Controller{
    /**
     * 控制器初始化
     */
    public function _initialize(){
        //判断是否登陆
        $isLogin=$this->isLogin();
        if (!$isLogin) {
            return $this->redirect('login/index');
        }
    }
    /**
     * 判断是否登陆
     */
    public function isLogin(){
        //获取session
        $user=session('adminuser','','think');
        if ($user && $user->id) {
            return true;
        }
        return false;
    }
}

?>