<?php
namespace app\common\model;
use app\common\model\Base;

use think\Model;
class News extends Base{
   /**
    * 后台自动化分页
    */
    public function getNews($data=[]){
        $data['status']=[
            'neq',config('code.status_delete')
        ];
        $order=['id'=>'desc'];
        //开始查询
        $result=$this->where($data)
            ->order($order)
            ->paginate(5);
            return $result;
    }
}





?>