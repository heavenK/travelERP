<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename WidgetAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class WidgetAction extends Action {

    public function _initialize() {
        if ($this->site['widgetopen']==0) {
            echo L('sidewidgetclose');
            exit;
        }
        parent::init();
    }

    public function index() {
        $user_name=$_GET['name'];
        $type=$_GET['type']?$_GET['type']:1;
        $height=$_GET['height']?$_GET['height']:'500px';
        $width=$_GET['width']?$_GET['width']:'100%';

        $user=D('Users')->where("user_name='$user_name'")->find();
        if (!$user) {
            $this->assign('type','nouser');
            $this->display('Error/index');
            exit;
        }

        $ctent = D('Content');
        $content = $ctent->where("user_id='$user[user_id]' AND replyid=0 AND filetype=0")->order("posttime DESC")->limit(20)->select();
        $content = $ctent->loadretwitt($content,2);

        $wg['uname']=$user_name;
        $wg['width']=$width;
        $wg['height']=$height;
        if ($type==1) {
            $wg['bgcolor']='#f3f3f3';
            $wg['border']='#dbdbdb';
        } else if ($type==2) {
            $wg['bgcolor']='#ffd87b';
            $wg['border']='#d99900';
        } else if ($type==3) {
            $wg['bgcolor']='#affffa';
            $wg['border']='#69d3ff';
        } else if ($type==4) {
            $wg['bgcolor']='#ffc6f9';
            $wg['border']='#ff85f2';
        }
        $this->assign('ctent',$ctent);
        $this->assign('user',$user);
        $this->assign('content',$content);
        $this->assign('wg',$wg);
        $this->display();
    }
}
?>