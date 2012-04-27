<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename MessageAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class MessageAction extends Action {

    public function _initialize() {
        A('Api')->tologin();
        parent::init();
    }

    public function index() {
        header('location:'.SITE_URL.'/Message/inbox');
    }

    public function inbox() {
        $mes=D('Messages');
        $ctent=D('Content');
        $uModel=D('Users');

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $count = $mes->where("sendtouid='".$this->my['user_id']."'")->count();
        $p= new Page($count,20);
        $page = $p->show('Message/inbox/');

        $data = D('MessagesView')->where("sendtouid='".$this->my['user_id']."'")->order("message_id DESC")->limit($p->firstRow.','.$p->listRows)->select();

        if ($this->my['priread']>0) {
            $uModel->where("user_id='".$this->my['user_id']."'")->setField('priread',0);
            $mes->where("sendtouid='".$this->my['user_id']."'")->setField('isread',1);
        }

        $this->assign('userside',$uModel->userside($this->my,'userside'));
        $this->assign('ctent',$ctent);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->assign('type','message');
        $this->assign('subname',L('inbox'));
        $this->assign('usertemp',usertemp($this->my));
        $this->display();
    }

    public function sendbox() {
        $mes=D('Messages');
        $ctent=D('Content');
        $uModel=D('Users');

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $count = $mes->where("senduid='".$this->my['user_id']."'")->count();
        $p= new Page($count,20);
        $page = $p->show('Message/inbox/');

        $data = D('MessagesSendView')->where("senduid='".$this->my['user_id']."'")->order("message_id DESC")->limit($p->firstRow.','.$p->listRows)->select();

        if ($this->my['priread']>0) {
            $uModel->where("user_id='".$this->my['user_id']."'")->setField('priread',0);
        }

        $this->assign('userside',$uModel->userside($this->my,'userside'));
        $this->assign('ctent',$ctent);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->assign('type','message');
        $this->assign('subname',L('sendbox'));
        $this->assign('usertemp',usertemp($this->my));
        $this->display();
    }

    public function delmsg() {
        $mes=D('Messages');
        $messgeid=$_GET['mid'];
        $ret=$mes->delmsg($messgeid,$this->my['user_id']);
        if ($ret=='success') {
            echo json_encode(array("ret"=>'success',"tip"=>L('del_msg_success')));
        } else {
            echo json_encode(array("ret"=>'error',"tip"=>$ret));
        }
    }

    public function sendmsg() {
        $mes=D('Messages');
        $ret=$mes->sendmsg($_POST['content'] ,$_POST['funame'],$this->my['user_id']);
        if ($ret=='success') {
            echo json_encode(array("ret"=>'success',"tip"=>L('send_msg_success')));
        } else {
            echo json_encode(array("ret"=>'error',"tip"=>$ret));
        }
    }

    public function getMsgUser() {
        $uModel=D('Users');
        $q = strtolower($_GET["q"]);
        if ($q) {
            echo $uModel->getMsgUser($q,$this->my['user_id']);
        }
    }
}
?>