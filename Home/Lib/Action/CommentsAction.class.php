<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename CommentsAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class CommentsAction extends Action {

    public function _initialize() {
        A('Api')->tologin();
        parent::init();
    }

    public function index() {
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $uModel=D('Users');
        $count = D('Comments')->where("user_id='".$this->my['user_id']."'")->count();
        $p= new Page($count,20);
        $page = $p->show('Comments/index/p/');
        $data = D('CommentsView')->where("Comments.user_id='".$this->my['user_id']."'")->order("dateline DESC")->limit($p->firstRow.','.$p->listRows)->select();

        if ($this->my['comments']>0) {
            $uModel->where("user_id='".$this->my['user_id']."'")->setField('comments',0);
        }

        $this->assign('ctent',D('Content'));
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->assign('usertemp',usertemp($this->my));
        $this->assign('userside',$uModel->userside($this->my,'userside'));
        $this->assign('subname',L('comments_title1'));
        $this->assign('type','comments');
        $this->display();
    }

    public function sendlist() {
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $uModel=D('Users');
        $count = D('Comments')->where("comment_uid='".$this->my['user_id']."'")->count();
        $p= new Page($count,20);
        $page = $p->show('Comments/sendlist/p/');
        $data = D('CommentslistView')->where("Comments.comment_uid='".$this->my['user_id']."'")->order("dateline DESC")->limit($p->firstRow.','.$p->listRows)->select();

        if ($this->my['comments']>0) {
            $uModel->where("user_id='".$this->my['user_id']."'")->setField('comments',0);
        }

        $this->assign('ctent',D('Content'));
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->assign('usertemp',usertemp($this->my));
        $this->assign('userside',$uModel->userside($this->my,'userside'));
        $this->assign('subname',L('comments_title2'));
        $this->assign('type','comments');
        $this->display();
    }

    public function delmsg() {
        $cmid=$_REQUEST['cmid'];
        if (is_array($cmid)) {
            $cids=implode(',',$cmid);

            D('Comments')->where("comment_id IN ($cids) AND (user_id='".$this->my['user_id']."' OR comment_uid='".$this->my['user_id']."')")->delete();
        } else if (is_numeric($cmid)) {
            D('Comments')->where("comment_id='$cmid' AND (user_id='".$this->my['user_id']."' OR comment_uid='".$this->my['user_id']."')")->delete();
        }
        echo json_encode(array("ret"=>'success',"tip"=>L('del_comment_success')));
    }
}
?>