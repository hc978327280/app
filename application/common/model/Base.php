<?php
namespace app\common\model;
use think\Model;
class Base extends Model{
    protected $autoWriteTimestamp = true;
    public function add($data){
        /**
         * 新增
         */
        if (!is_array($data)) {
            exception('传递数据不合法');
        }
        $this->allowField(true)->save($data);
        //返回插入的id
        return $this->id;
    }
}





?>