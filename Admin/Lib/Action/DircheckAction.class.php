<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename DircheckAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class DircheckAction extends Action {

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $dirs=array();
        $dirs[]=array('dir'=>'./Home/Runtime','iswrite'=>$this->dir_writeable('./Home/Runtime'));
        $dirs[]=array('dir'=>'./Home/Runtime/Cache','iswrite'=>$this->dir_writeable('./Home/Runtime/Cache'));
        $dirs[]=array('dir'=>'./Home/Runtime/Data','iswrite'=>$this->dir_writeable('./Home/Runtime/Data'));
        $dirs[]=array('dir'=>'./Home/Runtime/Logs','iswrite'=>$this->dir_writeable('./Home/Runtime/Logs'));
        $dirs[]=array('dir'=>'./Home/Runtime/Temp','iswrite'=>$this->dir_writeable('./Home/Runtime/Temp'));
        $dirs[]=array('dir'=>'./Admin/Runtime','iswrite'=>$this->dir_writeable('./Admin/Runtime'));
        $dirs[]=array('dir'=>'./Admin/Runtime/Cache','iswrite'=>$this->dir_writeable('./Admin/Runtime/Cache'));
        $dirs[]=array('dir'=>'./Admin/Runtime/Data','iswrite'=>$this->dir_writeable('./Admin/Runtime/Data'));
        $dirs[]=array('dir'=>'./Admin/Runtime/Logs','iswrite'=>$this->dir_writeable('./Admin/Runtime/Logs'));
        $dirs[]=array('dir'=>'./Admin/Runtime/Temp','iswrite'=>$this->dir_writeable('./Admin/Runtime/Temp'));
        $dirs[]=array('dir'=>'./Public/attachments','iswrite'=>$this->dir_writeable('./Public/attachments'));
        $dirs[]=array('dir'=>'./Public/attachments/usertemplates','iswrite'=>$this->dir_writeable('./Home/Runtime/Temp'));
        $dirs[]=array('dir'=>'./Public/attachments/usertemplates/themetemp','iswrite'=>$this->dir_writeable('./Public/attachments/usertemplates/themetemp'));
        $dirs[]=array('dir'=>'./Public/attachments/photo','iswrite'=>$this->dir_writeable('./Public/attachments/photo'));
        $dirs[]=array('dir'=>'./Public/attachments/head','iswrite'=>$this->dir_writeable('./Public/attachments/head'));
        $dirs[]=array('dir'=>'./Public/attachments/downtheme','iswrite'=>$this->dir_writeable('./Public/attachments/downtheme'));
        $dirs[]=array('dir'=>'./Public/backup','iswrite'=>$this->dir_writeable('./Public/backup'));
        $dirs[]=array('dir'=>'./Plugin','iswrite'=>$this->dir_writeable('./Plugin'));

        $this->assign('dirs',$dirs);
        $this->assign('position','其他设置 -> 目录检查');
        $this->display();
    }

    private function dir_writeable($dir) {
        if(!is_dir($dir)) {
            @mkdir($dir, 0777);
        }
        if(is_dir($dir)) {
            if($fp = @fopen("$dir/test.test", 'w')) {
                @fclose($fp);
                @unlink("$dir/test.test");
                $writeable = 1;
            } else {
                $writeable = 0;
            }
        }
        return $writeable;
    }
}
?>