<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename InvitecodeAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class InvitecodeAction extends Action {

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $iModel=D('Invitecode');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $t=$_GET['t']?$_GET['t']:1;

        if ($t=='1') {
            $count=$iModel->where('isused=0')->count();
            $p= new Page($count,20);
            $page = $p->show("admin.php?s=/Invitecode/index/t/$t/p/");
            $idata=$iModel->where('isused=0')->order('id DESC')->limit($p->firstRow.','.$p->listRows)->select();
        } else {
            $count=$iModel->where('isused=1')->count();
            $p= new Page($count,20);
            $page = $p->show("admin.php?s=/Invitecode/index/t/$t/p/");
            $idata=$iModel->where('isused=1')->order('id DESC')->limit($p->firstRow.','.$p->listRows)->select();
        }

        $this->assign('page',$page);
        $this->assign('idata',$idata);
        $this->assign('t',$t);
        $this->assign('position','其他设置 -> 邀请码管理');
        $this->display();
    }


    public function delcode() {
        $iModel=D('Invitecode');
        $delcode=$_POST['delcode'];
        $t=$_POST['t']?$_POST['t']:1;
        if (is_array($delcode)) {
            $delcodes=implode(',',$delcode);
            $iModel->where("id IN ($delcodes)")->delete();

            msgreturn('指定的邀请码删除成功了',SITE_URL.'/admin.php?s=/Invitecode/index/t/'.$t);
        } else {
            header('location:'.SITE_URL.'/admin.php?s=/Invitecode/index/t/'.$t);
        }
    }

    public function deloverdue() {
        $iModel=D('Invitecode');
        $t=$_GET['t'];
        if ($t==1) {
            $iModel->where("isused=0 AND timeline<'".time()."' AND timeline!=0")->delete();
        }

        msgreturn('过期的邀请码删除成功',SITE_URL.'/admin.php?s=/Invitecode/index/t/'.$t);
    }

    public function create() {
        $num=intval($_POST['num']);
        $time=intval($_POST['time']);
        $num=max($num,1);
        $num=min($num,10);
        $time=$time?time()+$time*86400:0;
        $iModel=D('Invitecode');

        for($i=0;$i<$num;$i++) {
            $randStr=randStr(15);
            $insert['invitecode']=$randStr;
            $insert['timeline']=$time;
            $iModel->add($insert);
        }
        msgreturn('邀请码生成成功',SITE_URL.'/admin.php?s=/Invitecode');
    }
}
?>