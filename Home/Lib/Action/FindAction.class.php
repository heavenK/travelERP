<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename FindAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class FindAction extends Action {

    public function _initialize() {
        A('Api')->tologin();
        parent::init();
    }

    public function index() {
        $t=$_GET['t']?$_GET['t']:1;
        $uModel=D('Users');

        //获取我已经收听的用户
        $mf=array();
        $userf=D('friend')->field('fid_jieshou')->where("fid_fasong='".$this->my['user_id']."'")->select();
        foreach($userf as $val) {
            $mf[]=$val['fid_jieshou'];
        }
        $mf=implode(',',$mf);
        $mf=$mf?$mf.','.$this->my['user_id']:$this->my['user_id'];

        if ($t==1) {
            $user=$uModel->where('user_auth=1 AND user_id not in ('.$mf.')')->order('msg_num DESC')->limit(24)->select();
        } else if ($t==2) {
            $user=$uModel->where('followme_num>0 AND user_id not in ('.$mf.')')->order('followme_num DESC')->limit(24)->select();
        } else if ($t==3 && $this->my['live_city']) {
            $user=$uModel->where('live_city="'.$this->my['live_city'].'" AND user_id not in ('.$mf.')')->order('msg_num DESC')->limit(24)->select();
        }

        $this->assign('uModel',$uModel);
        $this->assign('user',$user);
        $this->assign('t',$t);
        $this->assign('menu','finder');
        $this->display();
    }

    public function invite() {
        $this->assign('menu','invite');
        $this->display();
    }

    public function doinvite() {
        $mail=trim(daddslashes($_POST['email']));
        $title = "“".$this->my['nickname']."”".L('invite_you_join').$this->site['sitename'];

        if ($mail) {
            $ctent=D('Content');
            $cview=D('ContentView');
            $content=$cview->where("retid=0 AND replyid=0")->order("posttime DESC")->limit('5')->select();
            ob_start();
            $this->assign('ctent',$ctent);
            $this->assign('content',$content);
            $this->display('mail');
            $send=ob_get_contents();
            ob_end_clean();

            A('Api')->sendMail($title,$send,$mail);

            Cookie::set('setok','finder1');
            header('location:'.SITE_URL.'/Find/invite');
        } else {
            Cookie::set('setok','finder2');
            header('location:'.SITE_URL.'/Find/invite');
        }
    }

    public function search() {
        if ($_POST['sname']) {
            header("location: ".SITE_URL."/Find/search?sname=".$_POST['sname']);
        }
        $searchname=$_GET['sname'];
        $uModel=D('Users');
        $fModel=D('Friend');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        if ($searchname) {
            $count=$uModel->where("user_name LIKE '%$searchname%' OR nickname LIKE '%$searchname%'")->count();
            $count=intval($count);
            $p= new Page($count,20);
            $page = $p->show('./Find/search?sname='.$searchname.'&p=');
            $users=$uModel->where("user_name LIKE '%$searchname%' OR nickname LIKE '%$searchname%'")->order("msg_num DESC")->limit($p->firstRow.','.$p->listRows)->select();

            if (is_array($users)) {
                $fids=$isfollower=array();
                foreach ($users as $key=>$val) {
                    $fids[]=$val['user_id'];
                }
                $num=count($fids);
                if ($num>0) {
                    $fids=implode(",",$fids);
                    $isfollower= $fModel->followstatus($fids,$this->my['user_id']);
                }
            }
        } else {
            $count=0;
        }

        $this->assign('searchname',$searchname);
        $this->assign('users',$users);
        $this->assign('page',$page);
        $this->assign('isfollower',$isfollower);
        $this->assign('count',$count);
        $this->display();
    }
}