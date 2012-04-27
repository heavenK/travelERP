<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename SpaceAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class SpaceAction extends Action{
    private $user;
    private $ctent;
    private $uModel;

    //初始化
    public function _initialize() {
        parent::init();
        $this->ctent=D('Content');
        $this->assign('ctent',$this->ctent);
    }

    public function index(){
        $this->uModel=D('Users');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $cview=D('ContentView');
        $fview=D('FavoriteView');
        $t=$_GET['t']?$_GET['t']:'a';

        //查看条件
        if ($t=='p') {
            $condition=' AND filetype="photo"';
        } else if ($t=='m') {
            $condition=' AND (filetype="video" OR filetype="music")';
        } else if ($t=='o') {
            $condition=' AND retid=0';
        } else if ($t=='r') {
            $condition=' AND retid!=0';
        } else {
            $condition='';
        }
        //关键词搜索
        if ($_GET['hq']) {
            $condition.=' AND content_body LIKE "%'.$_GET['hq'].'%"';
        }
        //时间搜索
        if ($_GET['dt']) {
            $stime=strtotime($_GET['dt'].' 00:00:00');
            $condition.=' AND posttime>='.$stime.' AND posttime<='.($stime+86400);
        }
        $type=$_GET['type']?$_GET['type']:'home';
        $user_name=$_GET['user_name'];
        if ($user_name==$this->my['user_name']) {
            $this->user=$this->my;
        } else {
            $data=$this->uModel->where('user_name="'.$user_name.'"')->select();
            $this->user=$data[0];
        }
        if (!$this->user) {
            $this->assign('type','nouser');
            $this->display('Error/index');
            exit;
        }
        if ($this->user['userlock']==1) {
            $this->assign('type','userlock');
            $this->display('Error/index');
            exit;
        }
        if ($this->user['user_id']!=$this->my['user_id'] && $type!='follower' && $type!='following') {
            $this->profile();
            exit;
        }
        if ($type=='home') {
            $group=$_GET['group']?$_GET['group']:'0';
            $cfview=D('FollowContentView');
            if ($group==0) {
                //总页数
                $count = $cfview->where("fid_fasong='".$this->my['user_id']."' AND replyid=0".$condition)->count();
                $count=$count+$this->my['msgnum'];
                $p= new Page($count,20);
                $page = $p->show($this->my['user_name'].'/'.$type.'/'.$t.'/');
                //内容
                $fuids=array();
                $_fuids=$this->uModel->friends($this->my['user_id']);
                if ($_fuids) {
                    foreach($_fuids as $val){
                        $fuids[]=$val['fid_jieshou'];
                    }
                }
                $fuids[]=$this->my['user_id'];
                $fuids2=implode(',',$fuids);
                $content = $cview->where("Users.user_id IN ($fuids2) AND replyid=0".$condition)->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
                $content=$this->ctent->loadretwitt($content);
                if ($p->firstRow==0) {
                    $this->assign('sendtalk',1);
                }
            } else if ($group==1) {
                $_fuids1=$this->uModel->friends($this->my['user_id']);
                $_fuids2=$this->uModel->follows($this->my['user_id']);
                if ($_fuids1) {
                    foreach($_fuids1 as $val){
                        $fuids1[]=$val['user_id'];
                    }
                }
                if ($_fuids2) {
                    foreach($_fuids2 as $val){
                        $fuids2[]=$val['user_id'];
                    }
                }
                $fuids=array_intersect($fuids1,$fuids2);
                $fuids=implode(',',$fuids);
                //总页数
                $count=$cview->where("Users.user_id IN ($fuids) AND replyid=0".$condition)->order("posttime DESC")->count();
                $p= new Page($count,20);
                $page = $p->show($this->my['user_name'].'/'.$type.'/'.$t.'/');
                //内容
                $content = $cview->where("Users.user_id IN ($fuids) AND replyid=0".$condition)->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
                $content=$this->ctent->loadretwitt($content);
            } else if ($group==2) {
                $ctview=D('ContenttopicView');
                $mytopic=D('Mytopic')->usertopic($this->user['user_id']);
                if ($mytopic) {
                    foreach ($mytopic as $val){
                        $mytopicid[]=$val['topicid'];
                    }
                }
                $mytopicid=implode(',',$mytopicid);
                if ($mytopicid) {
                    $count = $ctview->where("topic_id IN ($mytopicid) AND replyid=0".$condition)->count();
                    $p= new Page($count,20);
                    $page = $p->show($this->my['user_name'].'/'.$type.'/'.$t.'/');

                    $content = $ctview->where("topic_id IN ($mytopicid) AND replyid=0".$condition)->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
                    $content=$this->ctent->loadretwitt($content);
                } else {
                    $count=0;
                }
            }
            $this->assign('group',$group);
        } else if ($type=='mine') {
            //总页数
            $count = $this->ctent->where("user_id='".$this->my['user_id']."' AND replyid=0".$condition)->count();
            $p= new Page($count,20);
		    $page = $p->show($this->my['user_name'].'/'.$type.'/'.$t.'/');
            //内容
            $content = $cview->where("Users.user_id='".$this->my['user_id']."' AND replyid=0".$condition)->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $content=$this->ctent->loadretwitt($content);
            if ($p->firstRow==0) {
                $this->assign('sendtalk',1);
            }
        } else if ($type=='at') {
            $caview=D('ContentatView');
            //总页数
            $count = $caview->where("Content_mention.user_id='".$this->my['user_id']."' AND replyid=0".$condition)->count();
            $p= new Page($count,20);
		    $page = $p->show($this->my['user_name'].'/'.$type.'/'.$t.'/');
            //内容
            $content = $caview->where("Content_mention.user_id='".$this->my['user_id']."' AND replyid=0".$condition)->order("attime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $content=$this->ctent->loadretwitt($content);
            //清空提示
            if ($this->my['atnum']>0 && $this->user['user_id']==$this->my['user_id']) {
                $this->uModel->where("user_id='".$this->my['user_id']."'")->setField('atnum',0);
            }
        } else if ($type=='favor') {
            //总页数
            $count = $fview->where("sc_uid='".$this->my['user_id']."' AND replyid=0".$condition)->count();
            $p= new Page($count,20);
		    $page = $p->show($this->my['user_name'].'/'.$type.'/'.$t.'/');
            //内容
            $content = $fview->where("sc_uid='".$this->my['user_id']."' AND replyid=0".$condition)->order("fav_id DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $content=$this->ctent->loadretwitt($content);
        } else if ($type=='profile') {
            $this->profile();
            exit;
        } else if ($type=='follower') {
            $this->follower();
            exit;
        } else if ($type=='following') {
            $this->following();
            exit;
        }

        $this->assign('subname',$this->user['nickname'].L('space_key_wb'));
        $this->assign('userside',$this->uModel->userside($this->user,'userside'));
        $this->assign('page',$page);
        $this->assign('type',$type);
        $this->assign('t',$t);
        $this->assign('content',$content);
        $this->assign('usertemp',usertemp($this->user));
        $this->assign('usertopic',D('Mytopic')->usertopic($this->user['user_id']));
        $this->assign('menu','home');
        $this->assign('allowseo',0);
        $this->display();
    }

    public function profile() {
        $cview=D('ContentView');
        $t=$_GET['t']?$_GET['t']:'a';
        //查看条件
        if ($t=='p') {
            $condition=' AND filetype="photo"';
        } else if ($t=='m') {
            $condition=' AND (filetype="video" OR filetype="music")';
        } else if ($t=='o') {
            $condition=' AND retid=0';
        } else if ($t=='r') {
            $condition=' AND retid!=0';
        } else {
            $condition='';
        }
        //时间搜索
        if ($_GET['dt']) {
            $stime=strtotime($_GET['dt'].' 00:00:00');
            $condition.=' AND posttime>='.$stime.' AND posttime<='.($stime+86400);
        }
        //总页数
        $count = $this->ctent->where("user_id='".$this->user['user_id']."' AND replyid=0".$condition)->count();
        $p= new Page($count,20);
        if ($this->user['user_id']==$this->my['user_id']) {
            $this->assign('menu','profile');
        }
        $page = $p->show($this->user['user_name'].'/profile/'.$t.'/');
        //内容
        $content = $cview->where("Users.user_id='".$this->user['user_id']."' AND replyid=0".$condition)->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$this->ctent->loadretwitt($content);

        //黑名单
        if ($this->my['user_id']!=$this->user['user_id']) {
            $isblack=D('Blacklist')->where("user_id='".$this->my['user_id']."' AND black_uid='".$this->user['user_id']."'")->find();
            $this->assign('isblack',$isblack);
        }

        //认证分组
        $vipgroup=F('vipgroup');
        if ($vipgroup) {
            foreach($vipgroup as $val){
                $vgroup[$val['id']]=$val;
            }
        }
        $this->assign('vipgroup',$vgroup);
        $this->assign('subname',$this->user['nickname'].L('space_key_wb'));
        $this->assign('keyword',$this->user['nickname'].L('space_key_wb').',');
        $this->assign('page',$page);
        $this->assign('type','profile');
        $this->assign('userside',$this->uModel->userside($this->user,'proside'));
        $this->assign('content',$content);
        $this->assign('user',$this->user);
        $this->assign('isfriend',D('Friend')->followstatus($this->user['user_id'],$this->my['user_id']));
        $this->assign('usertemp',usertemp($this->user));
        $this->assign('usertopic',D('Mytopic')->usertopic($this->user['user_id']));
        $this->assign('t',$t);
        $this->assign('allowseo',0);
        $this->display('profile');
    }

    public function follower() {
        $fModel=D('Friend');
        $keyword=trim($_GET['keyword']);
        $keyword=$keyword==L('inputfollowaccount')?'':$keyword;

        if ($keyword) {
            $count=$this->uModel->followsnum($this->user['user_id'],$keyword);
        } else {
            $count=$this->user['followme_num'];
        }
        $p= new Page($count,20);
        $page = $p->show($this->user['user_name'].'/follower/p/');
        $follower=$this->uModel->follows($this->user['user_id'],$p->firstRow,$p->listRows,$keyword);

        if (is_array($follower)) {
            $fids=$isfollower=array();
            foreach ($follower as $val) {
                $fids[]=$val['user_id'];
            }
            $fids[]=$this->user['user_id'];
            $count=count($fids);
            if ($count>0) {
                $fids=implode(",",$fids);
                $isfollower= $fModel->followstatus($fids,$this->my['user_id']);
            }
            if ($this->my['newfollownum']>0 && $this->user['user_id']==$this->my['user_id']) {
                $this->uModel->where("user_id='".$this->my['user_id']."'")->setField('newfollownum',0);
            }
        }

        if ($this->user['user_id']==$this->my['user_id']) {
            $this->assign('userside',$this->uModel->userside($this->my,'userside'));
        } else {
            $this->assign('userside',$this->uModel->userside($this->user,'userside'));
        }
        $this->assign('isfriend',$fModel->followstatus($this->user['user_id'],$this->my['user_id']));
        $this->assign('isfollower',$isfollower);
        $this->assign('follower',$follower);
        $this->assign('page',$page);
        $this->assign('subname',$this->user['nickname'].L('space_headline_fl'));
        $this->assign('user',$this->user);
        $this->assign('usertemp',usertemp($this->user));
        $this->assign('usertopic',D('Mytopic')->usertopic($this->user['user_id']));
        $this->assign('menu','follow');
        $this->assign('keyword',$keyword);
        $this->assign('count',$count);
        $this->display('follower');
    }

    public function following() {
        $fModel=D('Friend');
        $keyword=trim($_GET['keyword']);
        $keyword=$keyword==L('inputfollowaccount')?'':$keyword;

        if ($keyword) {
            $count=$this->uModel->friendsnum($this->user['user_id'],$keyword);
        } else {
            $count=$this->user['follow_num'];
        }
        $p= new Page($count,20);
        $page = $p->show($this->user['user_name'].'/following/p/');
        $following=$this->uModel->friends($this->user['user_id'],$p->firstRow,$p->listRows,$keyword);
        if (is_array($following)) {
            $fids=$isfollower=array();
            foreach ($following as $val) {
                $fids[]=$val['user_id'];
            }
            $fids[]=$this->user['user_id'];
            $count=count($fids);
            if ($count>0) {
                $fids=implode(",",$fids);
                $isfollower= $fModel->followstatus($fids,$this->my['user_id']);
            }
        }
        if ($this->user['user_id']==$this->my['user_id']) {
            $this->assign('userside',$this->uModel->userside($this->my,'userside'));
        } else {
            $this->assign('userside',$this->uModel->userside($this->user,'userside'));
        }
        $this->assign('isfriend',$fModel->followstatus($this->user['user_id'],$this->my['user_id']));
        $this->assign('isfollower',$isfollower);
        $this->assign('following',$following);
        $this->assign('page',$page);
        $this->assign('subname',$this->user['nickname'].L('space_headline_fler'));
        $this->assign('user',$this->user);
        $this->assign('userside',$this->uModel->userside($this->user,'userside'));
        $this->assign('usertemp',usertemp($this->user));
        $this->assign('usertopic',D('Mytopic')->usertopic($this->user['user_id']));
        $this->assign('menu','follow');
        $this->assign('keyword',$keyword);
        $this->assign('count',$count);
        $this->display('following');
    }

    public function addfollow() {
        A('Api')->tologin();
        $fModel=D('Friend');
        $ret=$fModel->addfollow($_GET['user_name'],$this->my['user_id']);
        if ($ret=='success') {
            echo json_encode(array("ret"=>'success',"tip"=>L('follow_success')));
        } else {
            echo json_encode(array("ret"=>'error',"tip"=>$ret));
        }
    }

    public function delfollow() {
        A('Api')->tologin();
        $fModel=D('Friend');
        $ret=$fModel->delfollow($_GET['user_name'],$this->my['user_id']);
        if ($ret=='success') {
            echo json_encode(array("ret"=>'success',"tip"=>L('unfollow_success')));
        } else {
            echo json_encode(array("ret"=>'error',"tip"=>$ret));
        }
    }

    public function reply() {
        $cview=D('ContentView');
        $contentid=$_GET['cid'];
        $replynum=0;
        if ($contentid) {
            $content = $cview->where("replyid='$contentid'")->order("posttime DESC")->select();
            $data = D('Content')->where("content_id='$contentid'")->find();
            foreach ($content as $val) {
                $replynum++;
                if ($replynum<=10) {
                    $replys.=$this->ctent->loadonereply($val);
                } else {
                    break;
                }
            }
        }
        if ($data['replytimes']>10) {
            $replys.='<li class="lire fright"><a href="'.SITE_URL.'/v/'.$contentid.'">'.L('view_reply_1').' '.($data['replytimes']-10).' '.L('view_reply_2').'</a></li>';
        }
        $this->assign('contentid',$contentid);
        $this->assign('replys',$replys);
        $this->display();
    }

    public function sendmsg() {
        A('Api')->tologin();
        $cview=D('ContentView');
        $ret=json_decode($this->ctent->sendmsg($_POST["content"],$_POST["morecontent"]),true);
        if ($ret['ret']=='success') {
            $data = $cview->where("content_id='$ret[insertid]'")->find();
            echo json_encode(array("ret"=>"success","tip"=>L('send_talk_success'),"data"=>$this->ctent->loadoneli($data)));
        } else {
            echo json_encode(array("ret"=>"error","tip"=>$ret['ret'],"data"=>''));
        }
    }

    public function checkvideourl() {
        $url=$_POST['videourl'];
        $ret=videourl($url);
        echo json_encode($ret);
    }

    public function delmsg() {
        A('Api')->tologin();
        $ret=D('Content')->delmsg($_GET['cid']);
        if ($ret=='success') {
            echo json_encode(array("ret"=>'success',"tip"=>L('del_talk_success')));
        } else {
            echo json_encode(array("ret"=>'error',"tip"=>$ret));
        }
    }

    public function uploadpic() {
        A('Api')->tologin();
        $url=$_POST['picurl']?$_POST['picurl']:0;
        echo D('Content')->uploadpic($url);
    }

    public function dofavor() {
        A('Api')->tologin();
        $ret=D('Favorite')->dofavor($_GET['cid'],$this->my['user_id']);
        if ($ret=='success') {
            echo json_encode(array("ret"=>'success',"tip"=>L('favor_success')));
        } else {
            echo json_encode(array("ret"=>'error',"tip"=>$ret));
        }
    }

    public function delfavor() {
        A('Api')->tologin();
        $ret=D('Favorite')->delfavor($_GET['cid'],$this->my['user_id']);
        if ($ret=='success') {
            echo json_encode(array("ret"=>'success',"tip"=>L('del_favor_success')));
        } else {
            echo json_encode(array("ret"=>'error',"tip"=>$ret));
        }
    }

    public function doreply() {
        A('Api')->tologin();
        $isret=$_POST['rck']=="true"?1:0;
        $closebox=intval($_POST['closebox']);
        $cview=D('ContentView');
        $ret=json_decode($this->ctent->doreply($_POST['scont'],$_POST['sid'],$isret),true);
        if ($ret['ret']=='success') {
            $data = $cview->where("content_id='$ret[insertid]'")->find();
            if ($closebox==1) {
                $dt=$this->ctent->loadonereply($data,1);
            } else {
                $dt=$this->ctent->loadonereply($data);
            }
            echo json_encode(array("ret"=>"success","tip"=>L('reply_success'),"data"=>$dt));
        } else {
            echo json_encode(array("ret"=>"error","tip"=>$ret['ret'],"data"=>''));
        }
    }

    public function retwit() {
        A('Api')->tologin();
        $ret=json_decode($this->ctent->retwit($_POST['cid'],$_POST["retcont"]),true);
        if ($ret['ret']=='success') {
            $cview=D('ContentView');
            $row = $cview->where("content_id='$ret[insertid]' OR content_id='$ret[retid]'")->select();
            foreach($row as $val) {
                if ($val['content_id']==$ret['retid']) {
                    $retdata = $val;
                } else {
                    $data = $val;
                }
            }
            $data['retbody'] = $this->ctent->loadretbody($retdata,$ret['insertid']);

            echo json_encode(array("ret"=>"success","tip"=>L('ret_success'),"data"=>$this->ctent->loadoneli($data)));
        } else {
            echo json_encode(array("ret"=>"error","tip"=>$ret['ret'],"data"=>''));
        }
    }

    public function report() {
        A('Api')->tologin();
        $reporttp=$_POST['reporttp'];
        $reportbd=daddslashes(trim($_POST['describe']));

        if ($reporttp && $reportbd) {
            $insert['user_name']=$this->my['user_name'];
            $insert['reporttype']=$reporttp;
            $insert['reportbody']=$reportbd;
            $insert['dateline']=time();

            D('Report')->add($insert);

            echo json_encode(array("ret"=>"success","tip"=>L('report_success')));
        } else {
            echo json_encode(array("ret"=>"error","tip"=>L('report_error')));
        }
    }
}
?>