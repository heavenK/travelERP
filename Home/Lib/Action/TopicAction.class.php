<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename TopicAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class TopicAction extends Action {

    function _initialize() {
        A('Api')->tologin();
        parent::init();
        $this->assign('allowseo',0);
    }

    public function index() {
        $keyword=$_GET['keyword'];
        if (StrLenW($keyword)<2 || StrLenW($keyword)>15) {
            $keyword='';
        }
        $tModel=D('Topic');
        $ctent=D('Content');
        $ctview=D('ContenttopicView');

        if (!$keyword) {
            $topic1 = $tModel->where("topictimes>0")->order("topictimes DESC")->limit(30)->select();
            $topic2 = $tModel->where("topictimes>0 AND tuijian=1")->order("topictimes DESC")->limit(30)->select();
            $topic3 = $tModel->where("topictimes>0 AND follownum>0")->order("follownum DESC")->limit(30)->select();
        } else {
            $topic = $tModel->where("topicname='$keyword'")->find();
            if ($topic) {
                import("@.ORG.Page");
                C('PAGE_NUMBERS',10);
                $count=intval($topic['topictimes']);
                $count=min($count,200);
                $p= new Page($count,20);
                $page = $p->show("k/$keyword/");
                $content = $ctview->where("topic_id='$topic[id]' AND replyid=0")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
                $content=$ctent->loadretwitt($content);
                $isfollow=D('Mytopic')->isfollow($topic['id'],$this->my['user_id']);
                if ($p->firstRow==0) {
                    $this->assign('sendtalk',1);
                }
                if ($count>0) {
                    $topicusers=D('MytopicView')->where("topicid='$topic[id]'")->order('id desc')->limit(9)->select();
                } else {
                    $topicusers=array();
                }
            } else {
                $count=$isfollow=0;
            }
        }

        $this->assign('ctent',$ctent);
        $this->assign('hottopic',$tModel->hottopic(1));
        $this->assign('keyword',$keyword);
        $this->assign('topic',$topic);
        $this->assign('topicusers',$topicusers);
        $this->assign('topic1',$topic1);
        $this->assign('topic2',$topic2);
        $this->assign('topic3',$topic3);
        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('count',$count);
        $this->assign('isfollow',$isfollow);
        if (!$keyword) {
            $this->assign('subname',L('hot_topic'));
        } else {
            $this->assign('subname','#'.$keyword.'#');
        }
        $this->display();
    }

    public function follow() {
        $keyword=$_GET['keyword'];
        $op=$_GET['op'];
        $mt=D('Mytopic');
        $tp=D('Topic');

        $tpdata=$tp->where("topicname='$keyword'")->find();
        if ($tpdata) {
            $data=$mt->where("topicid='$tpdata[id]' AND user_id='".$this->my['user_id']."'")->find();
            if ($op=='fl') {
                if (!$data) {
                    $insert['topicid']=$tpdata['id'];
                    $insert['user_id']=$this->my['user_id'];
                    $mt->add($insert);
                    $tp->where("id='$tpdata[id]'")->setInc('follownum');
                }
                echo json_encode(array("ret"=>'success',"tip"=>L('fl_topic_success')));
            } else if ($op=='jc') {
                if ($data) {
                    $mt->where("topicid='$tpdata[id]' AND user_id='".$this->my['user_id']."'")->delete();
                    $tp->where("id='$tpdata[id]'")->setDec('follownum');
                }
                echo json_encode(array("ret"=>'success',"tip"=>L('unfl_topic_success')));
            }
        } else {
            echo json_encode(array("ret"=>'error',"tip"=>L('topic_null')));
        }
    }

    public function mytopic() {
        $data = D('Mytopic')->usertopic($this->my['user_id']);
        foreach ($data as $key=>$val) {
            $lis.='<li><a href="javascript:void(0)" onclick="Sharetopic(\''.$val['topicname'].'\');">'.$val['topicname'].'</a></li>';
        }
        echo $lis==''?L('no_fltopic'):$lis;
    }

    public function tjtopic() {
        $data = D('Topic')->where('tuijian=1')->order('topictimes DESC')->limit(10)->select();
        foreach ($data as $key=>$val) {
            $lis.='<li><a href="javascript:void(0)" onclick="Sharetopic(\''.$val['topicname'].'\');">'.$val['topicname'].'</a><em>('.$val['topictimes'].')</em></li>';
        }
        echo $lis==''?L('no_tuijian_topic'):$lis;
    }
}
?>