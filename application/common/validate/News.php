<?php
namespace app\common\validate;
use think\Validate;
class News extends Validate{
    protected $rule = [
        'title'=>'require|length:4,25',
        'description'=>'require|length:4,25',
    ];
}



?>