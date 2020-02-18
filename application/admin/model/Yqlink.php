<?php

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;

class Yqlink extends Model
{
	use SoftDelete;
    protected $pk = 'id';
}
