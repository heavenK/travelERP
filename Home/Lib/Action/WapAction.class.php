<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename WapAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class WapAction extends Action {

    function _initialize() {
        if ($this->site['wapopen']==0) {
            $this->showmessage("<div class='showmag'><p>".L('wap_close')."</p></div>");
            exit;
        }
        parent::init();
        $uModel=M('Users');
        $authcookie = Cookie::get('authcookie');
        $exp=authcode($authcookie,'DECODE');
        list($user_name,$user_id) = explode("\t", authcode($authcookie,'DECODE'));
        if ($user_name && $user_id) {
            $this->my = $uModel->where("user_id='$user_id' AND user_name='$user_name'")->find();
        } else {
            $this->my='';
        }
        $this->assign('ctent',D('Content'));
    }
    private function wpage($url,$page,$simbol) {
        $_GET[$simbol]=intval($_GET[$simbol])==0?1:$_GET[$simbol];
        if ($_GET[$simbol]>1) {
            $pre='<a href="'.SITE_URL.'/'.$url.''.($_GET[$simbol]-1).'">'.L('wap_pre').'</a>';
        }
        if ($_GET[$simbol]<$page && $_GET[$simbol]<C('PAGE_NUMBERS')) {
            $next='<a href="'.SITE_URL.'/'.$url.''.($_GET[$simbol]+1).'">'.L('wap_next').'</a>';
        }
        return $pre.$next;
    }
    function index() {
        $this->tohome();
        $this->display();
    }
    function reg() {
        $this->tohome();
        $this->display();
    }
    function doreg() {
        $this->tohome();
        $result=A('Index')->doregcheck();

        if ($result['ret']=='check_ok') {
            $this->logindt($result['user']['user_id']);
            Cookie::set('authcookie', authcode($result['user']['user_name']."\t".$result['user']['user_id'],'ENCODE'), 31536000);
            D('Users')->where("user_id='".$result['user']['user_id']."'")->setField(array('regmailauth','userguide'),array(1,1));
            $this->showmessage("<div class='showmag'><p>".L('wap_reg_success')."</p><p><a href='".SITE_URL."/Wap'>".L('wap_tohome')."</a></p></div>");
        } else {
            $this->showmessage("<div class='showmag'><p>".$result."</p><p><a href='".SITE_URL."/Wap/reg'>".L('go_back_a')."</a></p></div>");
        }
    }
    function space() {
        $this->tologin();
        $user_name=$_GET['user_name'];
        $user_name=$user_name?$user_name:$this->my['user_name'];
        if ($user_name!=$this->my['user_name']) {
            $user=D('Users')->where("user_name='$user_name'")->find();
        } else {
            $user=$this->my;
        }
        if (!$user) {
            $this->tologin();
            $this->showmessage("<div class='showmag'><p>".L('wap_nouser')."</p><p><a href='".SITE_URL."/Wap'>".L('wap_tohome')."</a></p></div>");
            exit;
        }
        import("@.ORG.Page");
        C('PAGE_NUMBERS',50);
        $cview=D('ContentView');
        $ctent=D('Content');
        $count = $ctent->where("user_id='".$user['user_id']."' AND replyid=0")->count();
        $p= new Page($count,15);
        $page = $this->wpage('Wap/space/user_name/'.rawurlencode($user['user_name']).'/p/',ceil($count/15),'p');
        $content = $cview->where("Users.user_id='".$user['user_id']."' AND replyid=0")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$ctent->loadretwitt($content,1);

        //认证分组
        $vipgroup=F('vipgroup');
        if ($vipgroup) {
            foreach($vipgroup as $val){
                $vgroup[$val['id']]=$val;
            }
        }
        $this->assign('vipgroup',$vgroup);
        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('isfriend',D('Friend')->followstatus($user['user_id'],$this->my['user_id']));
        $this->assign('user',$user);
        $this->assign('subname',$user['nickname']);
        $this->assign('showmenu',1);
        $this->display();
    }
    function home() {
        $this->tologin();
        import("@.ORG.Page");
        C('PAGE_NUMBERS',50);
        $cfview=D('FollowContentView');
        $ctent=D('Content');


        //总页数
        $count = $cfview->where("fid_fasong='".$this->my['user_id']."' AND replyid=0")->count();
        $count=$count+$this->my['msgnum'];
        $p= new Page($count,15);
        $page = $this->wpage('Wap/home/p/',ceil($count/15),'p');
        //内容
        $fuids=array();
        $_fuids=D('Users')->friends($this->my['user_id']);
        if ($_fuids) {
            foreach($_fuids as $val){
                $fuids[]=$val['fid_jieshou'];
            }
        }
        $fuids[]=$this->my['user_id'];
        $fuids2=implode(',',$fuids);
        $content = D('ContentView')->where("Users.user_id IN ($fuids2) AND replyid=0")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$ctent->loadretwitt($content,1);

        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('subname',$user['nickname']);
        $this->assign('showmenu',1);
        $this->display();
    }
    function follow() {
        $this->tologin();
        $fModel=D('Friend');
        $uModel=D('Users');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',50);
        $tab=$_GET['tab']?$_GET['tab']:1;
        $title=$tab==1?L('who_i_follow'):L('who_follow_me');

        if ($tab==1) {
            $p= new Page($this->my['follow_num'],15);
            $page = $this->wpage('Wap/follow/tab/'.$tab.'/p/',ceil($this->my['follow_num']/15),'p');
            $data=$uModel->friends($this->my['user_id'],$p->firstRow,$p->listRows);
            if (is_array($data)) {
                $fids=$isfollower=array();
                foreach ($data as $val) {
                    $fids[]=$val['user_id'];
                }
                $fids[]=$this->my['user_id'];
                $count=count($fids);
                if ($count>0) {
                    $fids=implode(",",$fids);
                    $isfollower= $fModel->followstatus($fids,$this->my['user_id']);
                }
            }
        } else {
            $p= new Page($this->my['followme_num'],15);
            $page = $this->wpage('Wap/follow/tab/'.$tab.'/p/',ceil($this->my['followme_num']/15),'p');
            $data=$uModel->follows($this->my['user_id'],$p->firstRow,$p->listRows);
            if (is_array($data)) {
                $fids=$isfollower=array();
                foreach ($data as $val) {
                    $fids[]=$val['user_id'];
                }
                $fids[]=$this->my['user_id'];
                $count=count($fids);
                if ($count>0) {
                    $fids=implode(",",$fids);
                    $isfollower= $fModel->followstatus($fids,$this->my['user_id']);
                }
            }
        }

        if ($this->my['newfollownum']>0) {
            $uModel->where("user_id='".$this->my['user_id']."'")->setField('newfollownum',0);
        }

        $this->assign('isfriend',$isfollower);
        $this->assign('isfollower',$isfollower);
        $this->assign('data',$data);
        $this->assign('page',$page);
        $this->assign('tab',$tab);
        $this->assign('subname',$title);
        $this->assign('showmenu',1);
        $this->display();
    }
    function topic() {
        $this->tologin();
        $k=$_GET['k'];
        if (!$k) {
            header("location:".SITE_URL.'/Wap');
        }
        import("@.ORG.Page");
        C('PAGE_NUMBERS',50);
        $ctview=D('ContenttopicView');
        $ctent=D('Content');

        $topic=D('Topic')->where("topicname='$k'")->find();
        $count=intval($topic['topictimes']);
        $p= new Page($count,15);
        $page = $this->wpage('Wap/topic/k/'.rawurlencode($k).'/p/',ceil($count/15),'p');
        $content = $ctview->where("topic_id='$topic[id]' AND replyid=0")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$ctent->loadretwitt($content,1);

        $this->assign('page',$page);
        $this->assign('topic',$k);
        $this->assign('content',$content);
        $this->assign('subname',L('topic_word').'#'.$k.'#');
        $this->assign('showmenu',1);
        $this->display();
    }

    function message() {
        $this->tologin();
        $mes=D('Messages');
        $ctent=D('Content');
        $uModel=D('Users');

        import("@.ORG.Page");
        C('PAGE_NUMBERS',50);
        $count = $mes->where("sendtouid='".$this->my['user_id']."'")->count();
        $p= new Page($count,15);
        $page = $this->wpage('Wap/message/p/',ceil($count/15),'p');

        $data = D('MessagesView')->where("sendtouid='".$this->my['user_id']."'")->order("message_id DESC")->limit($p->firstRow.','.$p->listRows)->select();

        if ($this->my['priread']>0) {
            $uModel->where("user_id='".$this->my['user_id']."'")->setField('priread',0);
        }

        $this->assign('count',$count);
        $this->assign('data',$data);
        $this->assign('page',$page);
        $this->assign('subname',L('wap_my_message'));
        $this->assign('showmenu',1);
        $this->display();
    }

    function at() {
        $this->tologin();

        import("@.ORG.Page");
        C('PAGE_NUMBERS',50);
        $ctent=D('Content');
        $caview=D('ContentatView');

        //总页数
        $count = $caview->where("Content_mention.user_id='".$this->my['user_id']."' AND replyid=0")->count();
        $p= new Page($count,15);
        $page = $this->wpage('Wap/at/p/',ceil($count/15),'p');
        //内容
        $content = $caview->where("Content_mention.user_id='".$this->my['user_id']."' AND replyid=0")->order("attime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$ctent->loadretwitt($content,1);

        if ($this->my['atnum']>0) {
            D('Users')->where("user_id='".$this->my['user_id']."'")->setField('atnum',0);
        }

        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('subname',L('at_mytalk').' - '.$this->my['nickname']);
        $this->assign('showmenu',1);
        $this->display();
    }
    function myfavor() {
        $this->tologin();

        import("@.ORG.Page");
        C('PAGE_NUMBERS',50);
        $ctent=D('Content');
        $fview=D('FavoriteView');

        //总页数
        $count = $fview->where("sc_uid='".$this->my['user_id']."' AND replyid=0")->count();
        $p= new Page($count,15);
        $page = $this->wpage('Wap/myfavor/p/',ceil($count/15),'p');
        //内容
        $content = $fview->where("sc_uid='".$this->my['user_id']."' AND replyid=0")->order("fav_id DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$ctent->loadretwitt($content,1);

        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('subname',L('my_favtalks').' - '.$this->my['nickname']);
        $this->assign('showmenu',1);
        $this->display();
    }
    function mycomment() {
        $this->tologin();
        $tab=$_GET['tab']?$_GET['tab']:1;
        $title=$tab==1?L('receivecomments'):L('sendcomments');

        import("@.ORG.Page");
        C('PAGE_NUMBERS',50);
        if ($tab==1) {
            $count = D('Comments')->where("user_id='".$this->my['user_id']."'")->count();
            $p= new Page($count,15);
            $page = $this->wpage('Wap/mycomment/tab/'.$tab.'/p/',ceil($count/15),'p');
            $data = D('CommentsView')->where("Comments.user_id='".$this->my['user_id']."'")->order("dateline DESC")->limit($p->firstRow.','.$p->listRows)->select();
        } else {
            $count = D('Comments')->where("comment_uid='".$this->my['user_id']."'")->count();
            $p= new Page($count,15);
            $page = $this->wpage('Wap/mycomment/tab/'.$tab.'/p/',ceil($count/15),'p');
            $data = D('CommentslistView')->where("Comments.comment_uid='".$this->my['user_id']."'")->order("dateline DESC")->limit($p->firstRow.','.$p->listRows)->select();
        }

        if ($this->my['comments']>0) {
            D('Users')->where("user_id='".$this->my['user_id']."'")->setField('comments',0);
        }

        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->assign('tab',$tab);
        $this->assign('subname',$title.' - '.$this->my['nickname']);
        $this->assign('showmenu',1);
        $this->display();
    }
    function sendprimsg() {
        $this->tologin();
        $user_name=$_GET['user_name'];
        $user=D('Users')->where("user_name='$user_name'")->find();
        if (!$user) {
            $this->showmessage("<div class='showmag'><p>".L('wap_nouser')."</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>".L('go_prepage')."</a></p></div>");
            exit;
        }

        $this->assign('from',base64_decode($_GET['from']));
        $this->assign('user',$user);
        $this->assign('submenu',L('wap_sendmessage'));
        $this->assign('showmenu',1);
        $this->display();
    }
    function dosendprimsg() {
        $this->tologin();
        $msg=D('Messages')->sendmsg($_POST['content'],$_POST['nickname'],$this->my['user_id']);
        $msg=$msg=='success'?L('send_msg_success'):$msg;
        $this->showmessage("<div class='showmag'>$msg<p></p><p><a href='".SITE_URL."/Wap/".base64_decode($_POST['from'])."'>".L('go_prepage')."</a></p></div>");
    }
    function delprimsg() {
        $this->tologin();
        $mid=$_GET['mid'];
        $this->showmessage("<div class='showmag'><p>".L('wap_delmsg_confirm')."</p><p><a href='".SITE_URL."/Wap/dodelprimsg/mid/$mid'>".L('sure')."</a>&nbsp;&nbsp;&nbsp;<a href='".SITE_URL."/Wap/message'>".L('cancel')."</a></p></div>");
    }
    function dodelprimsg() {
        $this->tologin();
        D('Messages')->delmsg($_GET['mid'],$this->my['user_id']);
        $this->showmessage("<div class='showmag'><p>".L('wap_delmsg_success')."</p><p><a href='".SITE_URL."/Wap/message'>".L('go_prepage')."</a></p></div>");
    }
    function delfollow() {
        $this->tologin();
        $user_name=$_GET['user_name'];
        $from=base64_decode($_GET['from']);
        $this->showmessage("<div class='showmag'><p>".L('wap_delfl_confirm')."</p><p><a href='".SITE_URL."/Wap/dodelfollow/user_name/".rawurlencode($user_name)."/from/".base64_encode($from)."'>".L('sure')."</a>&nbsp;&nbsp;&nbsp;<a href='".SITE_URL."/Wap/$from'>".L('cancel')."</a></p></div>");
    }
    function dodelfollow() {
        $this->tologin();
        $from=base64_decode($_GET['from']);
        D('Friend')->delfollow($_GET['user_name'],$this->my['user_id']);
        $this->showmessage("<div class='showmag'><p>".L('wap_delfl_success')."</p><p><a href='".SITE_URL."/Wap/$from'>".L('go_prepage')."</a></p></div>");
    }
    function addfollow() {
        $this->tologin();
        $from=base64_decode($_GET['from']);
        D('Friend')->addfollow($_GET['user_name'],$this->my['user_id']);
        $this->showmessage("<div class='showmag'><p>".L('wap_fl_success')."</p><p><a href='".SITE_URL."/Wap/$from'>".L('go_prepage')."</a></p></div>");
    }
    function delcm() {
        $this->tologin();
        $cid=$_GET['cid'];
        $from=base64_decode($_GET['from']);
        $this->showmessage("<div class='showmag'><p>".L('wap_delreply_confirm')."</p><p><a href='".SITE_URL."/Wap/dodelcm/cid/$cid/from/".base64_encode($from)."'>".L('sure')."</a>&nbsp;&nbsp;&nbsp;<a href='".SITE_URL."/Wap/mycomment'>".L('cancel')."</a></p></div>");
    }
    function dodelcm() {
        $this->tologin();
        D('Comments')->where("comment_id='".$_GET['cid']."' AND (user_id='".$this->my['user_id']."' OR comment_uid='".$this->my['user_id']."')")->delete();
        $this->showmessage("<div class='showmag'><p>".L('wap_delreply_success')."</p><p><a href='".SITE_URL."/Wap/mycomment'>".L('go_prepage')."</a></p></div>");
    }
    function delfavor() {
        $this->tologin();
        $cid=$_GET['cid'];
        $from=base64_decode($_GET['from']);
        $this->showmessage("<div class='showmag'><p>".L('wap_delfavor_confirm')."</p><p><a href='".SITE_URL."/Wap/dodelfavor/cid/$cid/from/".base64_encode($from)."'>".L('sure')."</a>&nbsp;&nbsp;&nbsp;<a href='".SITE_URL."/Wap/$from'>".L('cancel')."</a></p></div>");
    }
    function dodelfavor() {
        $this->tologin();
        D('Favorite')->delfavor($_GET['cid'],$this->my['user_id']);
        $this->showmessage("<div class='showmag'><p>".L('wap_delfavor_confirm')."</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>".L('go_prepage')."</a></p></div>");
    }
    function sendphoto() {
        $this->tologin();
        $this->assign('subname',L('wap_phototalk'));
        $this->assign('showmenu',1);
        $this->display();
    }
    function dosendphoto() {
        $this->tologin();
        $ctent=D('Content');
        $content=$_POST['content']?$_POST['content']:'#'.L('wap_sharephoto').'#';
        $ret=json_decode($ctent->uploadpic(),true);
        if ($ret['ret']!='success') {
            $this->showmessage("<div class='showmag'><p>".L('wap_photo_error1')."</p><p><a href='".SITE_URL."/Wap/sendphoto'>".L('go_prepage')."</a></p></div>");
        } else {
            $ret=json_decode($ctent->sendmsg($content,$ret['content'],L('phone')),true);
            if ($ret['ret']=='success') {
                $this->showmessage("<div class='showmag'><p>".L('wap_photo_success')."</p><p><a href='".SITE_URL."/Wap/sendphoto'>".L('go_prepage')."</a></p></div>");
            } else {
                $this->showmessage("<div class='showmag'><p>".L('wap_photo_error2')."</p><p><a href='".SITE_URL."/Wap/sendphoto'>".L('go_prepage')."</a></p></div>");
            }
        }
    }
    function sendmsg() {
        $this->tologin();
        $ret=json_decode(D('Content')->sendmsg($_POST["content"],'',L('phone')),true);
        if ($ret['ret']=='success') {
            $this->showmessage("<div class='showmag'><p>".L('wap_talk_success')."</p><p><a href='".SITE_URL."/Wap'>".L('go_prepage')."</a></p></div>");
        } else {
            $this->showmessage("<div class='showmag'><p>".$ret['ret']."</p><p><a href='".SITE_URL."/Wap'>".L('go_prepage')."</a></p></div>");
        }
    }
    function ret() {
        $this->tologin();
        $cid=$_GET['cid'];

        import("@.ORG.Page");
        C('PAGE_NUMBERS',50);

        $cview=D('ContentView');
        $ctent=D('Content');
        $content = $cview->where("content_id='$cid' AND replyid=0")->findAll();
        $content=$ctent->loadretwitt($content,1);
        $content=$content[0];
        if (!$content) {
            $this->showmessage("<div class='showmag'><p>".L('wap_notalk')."</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>".L('go_prepage')."</a></p></div>");
            exit;
        }
        //ret
        $p= new Page($content['zftimes'],15);
        $page = $this->wpage('Wap/ret/cid/$cid/from/$_GET[from]/p/',ceil($content['zftimes']/15),'p');
        $ret = $cview->where("retid='$cid'")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();

        $this->assign('cont',$content['zftimes']);
        $this->assign('ret',$ret);
        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('showmenu',1);
        $this->display();
    }
    function doret() {
        $this->tologin();
        $ctent=D('Content');
        $ret=json_decode($ctent->retwit($_POST['cid'],$_POST["scont"],L('phone')),true);
        if ($ret['ret']=='success') {
            $this->showmessage("<div class='showmag'><p>".L('wap_ret_success')."</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>".L('go_prepage')."</a></p></div>");
        } else {
            $this->showmessage("<div class='showmag'><p>".$ret['ret']."</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>".L('go_prepage')."</a></p></div>");
        }
    }
    function comment() {
        $this->tologin();
        $cid=$_GET['cid'];

        import("@.ORG.Page");
        C('PAGE_NUMBERS',50);

        $cview=D('ContentView');
        $ctent=D('Content');
        $content = $cview->where("content_id='$cid' AND replyid=0")->findAll();
        $content=$ctent->loadretwitt($content,1);
        $content=$content[0];
        if (!$content) {
            $this->showmessage("<div class='showmag'><p>".L('wap_notalk')."</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>".L('go_prepage')."</a></p></div>");
            exit;
        }
        //reply
        $p= new Page($content['replytimes'],15);
        $page = $this->wpage('Wap/comment/cid/$cid/from/$_GET[from]/p/',ceil($content['replytimes']/15),'p');
        $reply = $cview->where("replyid='$cid'")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $reply=$ctent->loadretwitt($reply,1);

        $this->assign('cont',$content['replytimes']);
        $this->assign('reply',$reply);
        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('showmenu',1);
        $this->display();
    }
    function docomment() {
        $this->tologin();
        $isret=$_POST['ret']=="on"?1:0;
        $cview=D('ContentView');
        $ret=json_decode(D('Content')->doreply($_POST["scont"],$_POST['cid'],$isret,L('phone')),true);
        if ($ret['ret']=='success') {
            $this->showmessage("<div class='showmag'><p>".L('wap_reply_success')."</p><p><a href='".SITE_URL."/Wap/".base64_decode($_POST['from'])."'>".L('go_prepage')."</a></p></div>");
        } else {
            $this->showmessage("<div class='showmag'><p>".$ret['ret']."</p><p><a href='".SITE_URL."/Wap/".base64_decode($_POST['from'])."'>".L('go_prepage')."</a></p></div>");
        }
    }
    function favor() {
        $this->tologin();
        $msg=D('Favorite')->dofavor($_GET['cid'],$this->my['user_id']);
        $msg=$msg=='success'?L('wap_favor_success'):$msg;
        $this->showmessage("<div class='showmag'><p>$msg</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>".L('go_prepage')."</a></p></div>");
    }
    function delmsg() {
        $this->tologin();
        $cid=$_GET['cid'];
        $from=base64_decode($_GET['from']);
        $this->showmessage("<div class='showmag'><p>".L('wap_deltalk_confirm')."</p><p><a href='".SITE_URL."/Wap/dodelmsg/cid/$cid/from/".base64_encode($from)."'>".L('sure')."</a>&nbsp;&nbsp;&nbsp;<a href='".SITE_URL."/Wap/$from'>".L('cancel')."</a></p></div>");
    }
    function dodelmsg() {
        $this->tologin();
        $msg=D('Content')->delmsg($_GET['cid']);
        $msg=$msg=='success'?L('wap_deltalk_success'):$msg;
        $this->showmessage("<div class='showmag'><p>$msg</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>".L('go_prepage')."</a></p></div>");
    }
    function showmessage($message) {
        $this->display('header');
        echo $message;
        $this->display('footer');
    }
    function logout() {
        setcookie('authcookie','',-1,'/');
        Cookie::delete('authcookie');
        header('location:'.SITE_URL.'/Wap/index');
    }
    function dologin() {
        $this->tohome();
        $username = daddslashes($_POST["loginname"]);
        $userpass = md5(md5($_POST["password"]));
        $remember = $_POST["rememberMe"];

        //整合UCENTER
        if (ET_UC==TRUE) {
            list($uid, $username, $password, $email) = uc_user_login($_POST['loginname'], $_POST['password']);
            if($username && $uid>0) {
                $user = D("Users")->where("user_name='$username'")->field('user_id,user_name,password')->find();
                if(!$user) {
                    $sitedenie=explode('|',$this->site['regname']);
                    $deniedname=array_merge(C('DIFNAME'),$sitedenie);
                    if (in_array($username,$deniedname)) {
                        $this->showmessage("<div class='showmag'><p>".L('wap_login_error1')."</p><p><a href='".SITE_URL."/Wap'>".L('wap_tohome')."</a></p></div>");
                        exit;
                    }
                    $auth = rawurlencode(authcode("$username\t".time(), 'ENCODE'));
			        $this->showmessage("<div class='showmag'><p>".L('wap_login_error2')."</p><p><a href='".SITE_URL."/Wap'>".L('wap_tohome')."</a></p></div>");
                    exit;
                } else {
                    if (md5(md5($password))!=$user['password']) {
                        $this->showmessage("<div class='showmag'><p>".L('wap_login_error3')."</p><p><a href='".SITE_URL."/Wap'>".L('wap_tohome')."</a></p></div>");
                        exit;
                    }
                    $this->logindt($user['user_id']);
                    if ($remember=="on") {
                        Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
                    } else {
                        Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'));
                    }
                    header('location:'.SITE_URL.'/Wap/home');
                }
            } else {
                $this->showmessage("<div class='showmag'><p>".L('wap_login_error3')."</p><p><a href='".SITE_URL."/Wap'>".L('wap_tohome')."</a></p></div>");
                exit;
            }
        //end
        } else {
            $user = D("Users")->where("(user_name='$username' OR mailadres='$username') AND password='$userpass'")->field('user_id,user_name,userlock')->find();
            if($user) {
                if ($user["userlock"]==1) {
                    $this->showmessage("<div class='showmag'><p>".L('wap_login_error4')."</p><p><a href='".SITE_URL."/Wap'>".L('wap_tohome')."</a></p></div>");
                    exit;
                } else {
                    $this->logindt($user['user_id']);
                    if ($remember=="on") {
                        Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
                    } else {
                        Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'));
                    }
                    header('location:'.SITE_URL.'/Wap/home');
                }
            } else {
                $this->showmessage("<div class='showmag'><p>".L('wap_login_error3')."</p><p><a href='".SITE_URL."/Wap'>".L('wap_tohome')."</a></p></div>");
                exit;
            }
        }
    }
    private function tohome() {
        if ($this->my) {
            header("location: ".SITE_URL."/Wap/home");
            exit;
        }
    }
    private function tologin() {
        if (!$this->my) {
            header("location: ".SITE_URL."/Wap");
            exit;
        }
    }
    private function logindt($uid) {
        $insert['user_id']=$uid;
        $insert['login_ip']=real_ip();
        $insert['login_time']=time();
        $insert['login_type']='wap';
        D('Logindt')->add($insert);
    }
}
?>