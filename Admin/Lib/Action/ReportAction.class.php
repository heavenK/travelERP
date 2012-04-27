<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename ReportAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class ReportAction extends Action {

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $rModel=D('Report');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);

        $count=$rModel->count();
        $p= new Page($count,20);
        $page = $p->show("admin.php?s=/Report/index/p/");
        $content = $rModel->order("dateline DESC")->limit($p->firstRow.','.$p->listRows)->select();

        $this->assign('content',$content);
        $this->assign('page',$page);
        $this->assign('position','其他设置 -> 举报管理');
        $this->display();
    }

    public function delreport() {
        $deljb=$_POST['deljb'];

        if (is_array($deljb)) {
            $delid=implode(',',$deljb);
            D('Report')->where("id IN ($delid)")->delete();
        }

        msgreturn('举报信息删除成功',SITE_URL.'/admin.php?s=/Report');
    }
}
?>