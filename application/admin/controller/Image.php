<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\common\lib\Upload;
/**
 * 后台图片上传相关逻辑
 */
class Image extends Base{
    public function upload(){
        $file = Request::instance()->file('file');
        // 把图片上传到指定的文件夹中
        $info = $file->move('upload');

        if($info && $info->getPathname()) {
            $data = [
                'status' => 1,
                'message' => 'OK',
                'data' => '/'.$info->getPathname(),
            ];
            echo json_encode($data);exit;
        }

        echo json_encode(['status' => 0, 'message' => '上传失败']);

    }
}
