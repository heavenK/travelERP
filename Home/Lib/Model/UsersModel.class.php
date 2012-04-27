<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename UsersModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class UsersModel extends BaseModel {

    public function friendsnum($uid,$keyword=0) { //收听的
        $fview=D('FollowingView');
        $condition='';
        if ($keyword) {
            $condition=" AND (user_name LIKE '%$keyword%' || nickname LIKE '%$keyword%')";
        }
        $data=$fview->where("fid_fasong='$uid'".$condition)->count();
        return $data;
    }

    public function followsnum($uid,$keyword=0) { //听众数量
        $fview=D('FollowerView');
        $condition='';
        if ($keyword) {
            $condition=" AND (user_name LIKE '%$keyword%' || nickname LIKE '%$keyword%')";
        }
        $data=$fview->where("fid_jieshou='$uid'".$condition)->count();
        return $data;
    }

    public function friends($uid,$start=0,$limit=0,$keyword=0) { //收听的
        $fview=D('FollowingView');
        $condition='';
        if ($keyword) {
            $condition=" AND (user_name LIKE '%$keyword%' || nickname LIKE '%$keyword%')";
        }
        if ($limit) {
            $data=$fview->where("fid_fasong='$uid'".$condition)->order('fri_id DESC')->limit($start.','.$limit)->select();
        } else {
            $data=$fview->where("fid_fasong='$uid'".$condition)->order('fri_id DESC')->select();
        }
        return $data;
    }

    public function follows($uid,$start=0,$limit=0,$keyword=0) { //听众
        $fview=D('FollowerView');
        $condition='';
        if ($keyword) {
            $condition=" AND (user_name LIKE '%$keyword%' || nickname LIKE '%$keyword%')";
        }
        if ($limit) {
            $data=$fview->where("fid_jieshou='$uid'".$condition)->order('fri_id DESC')->limit($start.','.$limit)->select();
        } else {
            $data=$fview->where("fid_jieshou='$uid'".$condition)->order('fri_id DESC')->select();
        }
        return $data;
    }

    public function updatemsgnum($uid,$update) {
        if ($update=='++') {
            $this->setInc('msg_num',"user_id='$uid'");
        } else if ($update=='--') {
            $this->setDec('msg_num',"user_id='$uid'");
        }
    }

    public function getMsgUser($q,$uid) { //邮件选择用户
        if ($q) {
            $frilist=$this->follows($uid);
            foreach($frilist as $key=>$val) {
                if (strpos($val['nickname'],$q)!==false) {
                    $u.= "$val[nickname]\n";
                }
            }
            return $u;
        } else {
            return;
        }
    }

    public function getUser($condition) {  //获得某个用户
        return $this->where($condition)->find();
    }

    //热门用户
    public function hotuser($order) {
        $class=$order==0?'first-sect':'';
        $data=S('hotuser');
        if (!$data) {
            $data= $this->field('user_id,user_name,nickname,user_head')->where("followme_num>0")->order('followme_num DESC')->limit($this->site['hotusernum'])->select();
            S('hotuser',$data,$this->site['hotuser_cache_time']);
        }
        if ($data) {
            foreach($data as $key=>$val) {
                $userlist.=$this->userlist($val);
            }
            return '<div class="sect '.$class.'">
                <h2>'.L('tuijian_user').'</h2>
                <ul class="alist">'.$userlist.'</ul>
                <a class="more" href="'.SITE_URL.'/Hot">'.L('user_more').'</a>
            </div>';
        } else {
            return '';
        }
    }

    //热门用户排行
    public function userbang($order,$type='normal') {
        $class=$order==0?'first-sect':'';
        $lis=S('bang'.$type);
        if (!$lis) {
            if ($type=='vip') {
                $data= $this->field('user_name,nickname,followme_num')->where("user_auth>0 AND followme_num>0")->order('followme_num DESC')->limit(10)->select();
            } else if ($type=='normal') {
                $data= $this->field('user_name,nickname,followme_num')->where("user_auth=0 AND followme_num>0")->order('followme_num DESC')->limit(10)->select();
            }
            foreach ($data as $key=>$val) {
                if ($key<3) {
                    $cla='top3';
                } else {
                    $cla='top4';
                }
                $lis.='<li><span class="fleft"><div class="'.$cla.'">'.($key+1).'</div><a href="'.SITE_URL.'/'.rawurlencode($val['user_name']).'">'.$val['nickname'].'</a></span><span class="num">'.$val['followme_num'].'</span><span class="clearline"></span></li>';
            }
            S('bang'.$type,$lis,$this->site['hotuser_cache_time']);
        }
        if ($type=='vip') {
            $title=L('auth_top');
        } else if ($type=='normal') {
            $title=L('star_top');
        }
        if ($lis) {
            return '<div class="sect '.$class.'">
                <h2><span class="fleft">'.$title.'</span><span class="right">'.L('followme_num').'</span><span class="clearline"></span></h2>
                <ul class="ulist">'.$lis.'</ul>
                <a class="morebottom" href="'.SITE_URL.'/Hot">'.L('user_more_top').'</a>
            </div>';
        } else {
            return '';
        }
    }

    //用户的听众
    public function userfollower($user,$order) {
        $class=$order==0?'first-sect':'';
        $data=S('follower'.$user['user_id']);
        if (!$data) {
            $data=$this->follows($user['user_id'],0,$this->site['userfollownum']);
            S('follower'.$user['user_id'],$data,$this->site['userfollow_cache_time']);
        }
        if ($data) {
            foreach ($data as $key=>$val) {
                $userlist.=$this->userlist($val);
            }
            return '<div class="sect '.$class.'">
                <h2>'.L('followuser').'<small>('.$user['followme_num'].')</small></h2>
                <ul class="alist">'.$userlist.'</ul>
                <a class="more" href="'.SITE_URL.'/'.rawurlencode($user['user_name']).'/follower">'.L('user_more').'</a>
            </div>';
        } else {
            return '';
        }
    }

    //用户收听的
    public function userfollowing($user,$order) {
        $class=$order==0?'first-sect':'';
        $data=S('following'.$user['user_id']);
        if (!$data) {
            $data=$this->friends($user['user_id'],0,$this->site['userfollownum']);
            S('following'.$user['user_id'],$data,$this->site['userfollow_cache_time']);
        }
        if ($data) {
            foreach ($data as $key=>$val) {
                $userlist.=$this->userlist($val);
            }
            return '<div class="sect '.$class.'">
                <h2>TA收听的<small>('.$user['follow_num'].')</small></h2>
                <ul class="alist">'.$userlist.'</ul>
                <a class="more" href="'.SITE_URL.'/'.rawurlencode($user['user_name']).'/following">'.L('user_more').'</a>
            </div>';
        } else {
            return '';
        }
    }

    //广场侧边
    public function pubside() {
        $sidebody='';
        $pubside=json_decode($this->site['pubside'],true);
        if (is_array($pubside)) {
            foreach($pubside as $key=>$val) {
                if ($val['name']=='hottopic') {
                    $sidebody.=D('Topic')->hottopic($key);
                } else if ($val['name']=='hotuser') {
                    $sidebody.=$this->hotuser($key);
                } else if ($val['name']=='bangnormal') {
                    $sidebody.=$this->userbang($key,'normal');
                } else if ($val['name']=='bangvip') {
                    $sidebody.=$this->userbang($key,'vip');
                } else {
                    $sidebody.=$this->diyside($val['title'],$val['val'],$key);
                }
            }
        }
        return $sidebody;
    }

    //用户侧边
    public function userside($user,$type) {
        $sidebody='';
        $userside=json_decode($this->site[$type],true);
        if (is_array($userside)) {
            foreach($userside as $val) {
                if ($val['name']=='hottopic') {
                    $sidebody.=D('Topic')->hottopic(1);
                } else if ($val['name']=='hotuser') {
                    $sidebody.=$this->hotuser(1);
                } else if ($val['name']=='bangnormal') {
                    $sidebody.=$this->userbang(1,'normal');
                } else if ($val['name']=='bangvip') {
                    $sidebody.=$this->userbang(1,'vip');
                } else if ($val['name']=='userfollower') {
                    $sidebody.=$this->userfollower($user,1);
                } else if ($val['name']=='userfollowing') {
                    $sidebody.=$this->userfollowing($user,1);
                } else {
                    $sidebody.=$this->diyside($val['title'],$val['val'],1);
                }
            }
        }
        return $sidebody;
    }

    public function alist($val,$mid,$st) {
        if ($val['user_id']!=$mid) {
            if ($st==0) {
                $stdiv='<span style="cursor:pointer;" onclick="followone(\''.$val['user_name'].'\',this)"><img src="'.__PUBLIC__.'/images/finderst.png"></span>';
            } else {
                $stdiv='<span class="yst">'.L('yst').'</span>';
            }
        } else {
            $stdiv='<span class="yst">'.L('myself').'</span>';
        }
        return '<li><a href="'.SITE_URL.'/'.rawurlencode($val['user_name']).'"><img alt="'.$val['nickname'].'" class="followpreview" src="'.sethead($val['user_head']).'"/><span>'.$val['nickname'].'</span></a><div>'.$stdiv.'</div></li>';
    }

    //自定义侧边
    private function diyside($title,$body,$order) {
        $class=$order==0?'first-sect':'';
        return '<div class="sect '.$class.'"><h2>'.$title.'</h2>'.$body.'</div>';
    }

    public function userlist($user) {
        return '<li><a href="'.SITE_URL.'/'.rawurlencode($user['user_name']).'"><img alt="'.$user['nickname'].'" class="followpreview" src="'.sethead($user['user_head']).'"/><span>'.$user['nickname'].'</span></a><div>'.$stdiv.'</div></li>';
    }
}
?>