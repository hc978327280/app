<?php
namespace app\admin\controller;
use app\common\validate\AdminUser;
use think\Controller;
use app\common\lib\IAuth;

class Login extends Base
{
    public function _initialize()
    { }
    public function index()
    {
        $isLogin = $this->isLogin();
        if ($isLogin) {
            return $this->redirect('index/index');
        } else {
            return $this->fetch();
        }
    }
    //登陆验证
    public function check()
    {
        if (request()->isPost()) {
            $data = input('post.');
            //检测验证码
            if (!captcha_check($data['code'])) {
                $this->error('验证码不正确');
            } else {
                //实例化验证
                $validate = validate('AdminUser');
                //调用check方法进行验证
                if (!$validate->check($data)) {
                    $this->error($validate->getError());
                }
                try {
                    //验证用户名和密码
                    $user = model('AdminUser')->get(['username' => $data['username']]);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
                //对用户名进行判断
                if (!$user || $user->status != config('code.status_normal')) {
                    $this->error('用户名不存在');
                }
                //对密码进行校验
                if (IAuth::setPassword($data['password']) != $user['password']) {
                    $this->error('密码不正确');
                }
                /**
                 * 更新数据库  登录时间  登陆ip
                 */
                $udata = [
                    'last_login_time' => time(),
                    'last_login_ip' => request()->ip(),
                ];
                try {
                    model('AdminUser')->save($udata, ['id' => $user->id]);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
                //将信息存入session
                session('adminuser', $user, 'think');
                $this->success('登陆成功', 'index/index');
            }
        } else {
            $this->error('请求不合法');
        }
    }
    /**
     * 退出登陆
     */
    public function loginout()
    {
        //清除session
        session(null, 'think');
        $this->redirect('login/index');
    }
}
