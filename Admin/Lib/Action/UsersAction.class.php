<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename UsersAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class UsersAction extends Action {
    public $vipgroup;

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
        $this->vipgroup=@include(ET_ROOT.'/Home/Runtime/Data/vipgroup.php');
    }

    public function index() {
        if ($this->vipgroup) {
            foreach($this->vipgroup as $val){
                $sgroup.='<option value="'.$val['id'].'">'.$val['name'].'</option>';
            }
        }
        $this->assign('sgroup',$sgroup);
        $this->assign('position','用户管理 -> 搜索用户');
        $this->display();
    }

    public function edit() {
        $user_name=$_GET['user_name'];

        $user=D('Users')->where("user_name='$user_name'")->find();

        if (!$user) {
            msgreturn('很抱歉，没有找到您要编辑的用户',SITE_URL.'/admin.php?s=/Users');
        }

        if ($user['user_auth']==0) {
            $vgroup='<option value="0" selected>普通用户</option>';
        } else {
            $vgroup='<option value="0">普通用户</option>';
        }
        if ($this->vipgroup) {
            foreach($this->vipgroup as $val){
                if ($user['user_auth']==$val['id']) {
                    $vgroup.='<option value="'.$val['id'].'" selected>'.$val['name'].'</option>';
                } else {
                    $vgroup.='<option value="'.$val['id'].'">'.$val['name'].'</option>';
                }
            }
        }

        $data=D('Pubtop')->select();
        foreach($data as $val) {
            $pubtop[$val['user_id']]=1;
        }

        $this->assign('vgroup',$vgroup);
        $this->assign('pubtop',$pubtop);
        $this->assign('user',$user);
        $this->assign('position','用户管理 -> 用户编辑');
        $this->display('index');
    }

    public function search() {
        $user_name=$_REQUEST['user_name'];
        $group=$_REQUEST['group'];
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $umodel=D('Users');

        if ($group) {
            if ($user_name) {
                $where="user_name LIKE '%$user_name%' AND ";
            } else {
                $where="";
            }
            if ($group=='all') {
                $where.="1";
            } else if ($group=='admin1') {
                $where.="isadmin=1";
            } else if ($group=='admin2') {
                $where.="isadmin=2";
            } else if ($group=='public') {
                $where.="isadmin=0 AND userlock=0";
            } else if ($group=='lock') {
                $where.="userlock=1";
            } else if ($group=='close') {
                $where.="userlock=2";
            } else if (is_numeric($group) && $group>0) {
                $where.="user_auth='$group'";
            }
            $count=$umodel->where($where)->count();
            $p= new Page($count,20);
            $page = $p->show("admin.php?s=/Users/search/user_name/$user_name/group/$group/p/");

            $user=$umodel->where($where)->limit($p->firstRow.','.$p->listRows)->select();

            if ($this->vipgroup) {
                foreach($this->vipgroup as $val){
                    $sgroup2[$val['id']]=$val['name'];
                }
            }
        } else {
            header('location:'.SITE_URL.'/admin.php?s=/Users');
            exit;
        }
        $this->assign('position','用户管理 -> 搜索用户');
        $this->assign('user',$user);
        $this->assign('sgroup2',$sgroup2);
        $this->assign('page',$page);
        $this->assign('count',$count);
        $this->display('index');
    }

    public function admin() {
        $user=D('Users')->where("isadmin>0")->select();
        $this->assign('position','用户管理 -> 管理员管理');
        $this->assign('user',$user);
        $this->display();
    }

    public function adminedit() {
        $user_name=$_POST['user_name'];
        $isadmin=$_POST['isadmin'];

        D('Users')->where("user_id!=1 AND user_name='$user_name'")->setField('isadmin',$isadmin);
        msgreturn('管理员编辑成功',SITE_URL.'/admin.php?s=/Users/admin');
    }

    public function edituser() {
        $pubtopm=D('Pubtop');
        $user_name=$_POST['user_name'];
        $userdata=$_POST['user'];
        $pubtop=$_POST['pubtop'];
        $regmailauth=intval($_POST['regmailauth']);
        $delmsg=$_POST['delmsg'];

        $uModel=D('Users');
        if ($user_name) {
            $user=$uModel->where("user_name='$user_name'")->find();
            if ($user) {
                if ($userdata['nickname']!=$user['nickname']) {
                    $newdt=$uModel->where("nickname='$userdata[nickname]'")->find();
                    if ($newdt) {
                        msgreturn('很抱歉，您修改的新昵称，已经存在！',SITE_URL.'/admin.php?s=/Users/index/user_name/'.$user_name);
                    }
                }
                $keys=$vals=array();
                foreach($userdata as $key=>$val) {
                    if ($key=='password')  {
                        if ($val) {
                            $keys[]='password';
                            $vals[]=md5(md5(trim($val)));
                        }
                    } else {
                        $keys[]=$key;
                        $vals[]=$val;
                    }
                }
                //广播数清零
                if ($delmsg==1) {
                    $keys[]='msg_num';
                    $vals[]=0;
                }
                //邮件认证
                if ($regmailauth==1) {
                    $keys[]='regmailauth';
                    $vals[]=1;
                } else {
                    $keys[]='regmailauth';
                    $vals[]=0;
                }
                $uModel->where("user_name='$user_name'")->setField($keys,$vals);
                //写入广场用户榜
                if ($pubtop==0) {
                    $pubtopm->where("user_id='$user[user_id]'")->delete();
                } else {
                    $pubtop=$pubtopm->where("user_id='$user[user_id]'")->find();
                    if (!$pubtop) {
                        $insertdata['user_id']=$user['user_id'];
                        $pubtopm->add($insertdata);
                    }
                }
                //删除用户数据
                if ($delmsg==1) {
                    $ct=D('Content');
                    $ctp=D('Content_topic');
                    $data=$ct->where("user_id='$user[user_id]'")->select();
                    if (is_array($data)) {
                        foreach ($data as $val1) {
                            //删除话题
                            $data2=$ctp->where("content_id='$val1[content_id]'")->select();
                            if (is_array($data2)) {
                                foreach ($data2 as $val) {
                                    D('Topic')->where("id='$val[topic_id]'")->setDec('topictimes');
                                }
                            }
                            $ctp->where("content_id='$val1[content_id]'")->delete();
                            $ct->where("content_id='$val1[content_id]'")->delete();
                            D('Content_mention')->where("cid='$val1[content_id]'")->delete();
                        }
                    }
                }
                msgreturn('用户信息编辑成功',SITE_URL.'/admin.php?s=/Users/edit/user_name/'.$user_name);
            } else {
                msgreturn('很抱歉，没有找到您要编辑的用户',SITE_URL.'/admin.php?s=/Users');
            }
        }
    }
}
?>