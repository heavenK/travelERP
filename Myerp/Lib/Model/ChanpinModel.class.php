<?php

class ChanpinModel extends Model {
	//protected $tableName = 'categories'; 	
	protected $trueTableName = 'myerp_chanpin';	
	
   // 自动验证设置 
    protected $_validate = array( 
        array('title', 'require', '标题必须！', 1), 
//        array('user_name', 'require', '用户名必须！', 1), 
    ); 
    // 自动填充设置 
    protected $_auto = array( 
        array('status', '准备', 1), 
        array('time', 'time', 1, 'function'), 
    ); 

	
    //显示产品列表
    public function chanpin_list($where,$pagenum = 20) {
		$myerp_chanpin = D("myerp_chanpin");
		$myerp_chanpin_xianlu = D("myerp_chanpin_xianlu");
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $myerp_chanpin->where($where)->count();
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $chanpin = $myerp_chanpin->where($where)->order("time DESC")->limit($p->firstRow.','.$p->listRows)->select();
		$i = 0;
		foreach($chanpin as $v){
			$d = $myerp_chanpin_xianlu->where("`chanpinID` ='$v[chanpinID]'")->find();
			$chanpin[$i]['ext'] = $d;
			$i++;
		}
		$redata['page'] = $page;
		$redata['chanpin'] = $chanpin;
		return $redata;
		
	}




}
?>