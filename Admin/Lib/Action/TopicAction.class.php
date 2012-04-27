<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename TopicAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class TopicAction extends Action {

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
         $tModel=D('Topic');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);

        $order=$_GET['order']?$_GET['order']:1;
        if ($order==1) {
            $condition='topictimes DESC';
        } else if ($order==2) {
            $condition='topictimes ASC';
        } else if ($order==3) {
            $condition='follownum DESC';
        } else if ($order==4) {
            $condition='follownum ASC';
        } else if ($order==5) {
            $condition='tuijian DESC';
        } else if ($order==6) {
            $condition='tuijian ASC';
        } else if ($order==7) {
            $condition='info DESC';
        }
        $topicname=$_POST['topicname'];
        if ($topicname) {
            $count=$tModel->where("topicname LIKE '%$topicname%'")->count();
        } else {
            $count=$tModel->count();
        }
        $p= new Page($count,20);
        $page = $p->show("admin.php?s=/Topic/index/order/$order/p/");
        if ($topicname) {
            $content = $tModel->where("topicname LIKE '%$topicname%'")->order($condition)->limit($p->firstRow.','.$p->listRows)->select();
        } else {
            $content = $tModel->order($condition)->limit($p->firstRow.','.$p->listRows)->select();
        }

        $this->assign('order',$order);
        $this->assign('topicname',$topicname);
        $this->assign('content',$content);
        $this->assign('page',$page);
        $this->assign('position','其他设置 -> 话题管理');
        $this->display();
    }

    public function deltopic() {
        $deltp=$_POST['deltp'];
        $tp=D('Topic');
        if (is_array($deltp)) {
            $delid=implode(',',$deltp);
            $tpdata=$tp->where("id IN ($delid)")->select();
            foreach ($tpdata as $val) {
                $tpname[]=$val['topicname'];
            }
            $tpnames=implode("','",$tpname);
            $tp->where("id IN ($delid)")->delete();
            D('Content_topic')->where("topic_id IN ($delid)")->delete();
            D('Mytopic')->where("topic IN ('$tpnames')")->delete();
        }
        msgreturn('管理删除成功',SITE_URL.'/admin.php?s=/Topic');
    }

    public function tuijian() {
        $tid=$_GET['id'];
        D('Topic')->where("id='$tid'")->setField('tuijian','1');
        msgreturn('话题推荐成功',SITE_URL.'/admin.php?s=/Topic&order=5');
    }

    public function deltuijian() {
        $tid=$_GET['id'];
        D('Topic')->where("id='$tid'")->setField('tuijian','0');
        msgreturn('取消话题推荐成功',SITE_URL.'/admin.php?s=/Topic');
    }

    public function info() {
        $tid=$_POST['tid'];
        $info=$_POST['info'];
        $info=daddslashes(getsubstr(trim($info),0,100,false));
        if ($tid) {
            D('Topic')->where("id='$tid'")->setField('info',$info);
            echo 'success';
        } else {
            echo '很抱歉，数据传输失败！';
        }
    }
}
?>