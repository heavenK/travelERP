<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename HotAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class HotAction extends Action {

    public function _initialize() {
        parent::init();
    }

    public function index() {
        $uModel=D('Users');
        $topcity=$_GET['c'];
        if (!$topcity) {
            $condition='';
        } else {
            $condition=" AND live_city LIKE '%$topcity%'";
        }

        $top1=$uModel->where('user_auth=1 AND followme_num>0'.$condition)->order('followme_num DESC')->limit(25)->select();
        $top2=$uModel->where('user_auth=0 AND followme_num>0'.$condition)->order('followme_num DESC')->limit(25)->select();
        $top3=$uModel->where('msg_num>0'.$condition)->order('msg_num DESC')->limit(25)->select();

        $province=D('District')->where('level=1')->select();

        $this->assign('province',$province);
        $this->assign('topcity',$topcity);
        $this->assign('top1',$top1);
        $this->assign('top2',$top2);
        $this->assign('top3',$top3);
        $this->assign('menu','hot');
        $this->assign('subname',L('hot_title'));
        $this->assign('allowseo',0);
        $this->display();
    }
}
?>