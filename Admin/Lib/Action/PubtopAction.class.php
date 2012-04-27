<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename PubtopAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class PubtopAction extends Action {

     public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $user=D('PubtopView')->select();
        $this->assign('position','用户管理 -> 广场用户榜');
        $this->assign('user',$user);
        $this->display();
    }

    public function xiabang() {
        $user_id=$_POST['user_id'];
        D('Pubtop')->where("user_id='$user_id'")->delete();

        msgreturn('广场用户榜操作完成',SITE_URL.'/admin.php?s=/Pubtop');
    }
}
?>