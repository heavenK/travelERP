<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename VipgroupAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class VipgroupAction extends Action{

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $data=D('Vipgroup')->select();
        $this->assign('data',$data);
        $this->assign('position','用户管理 -> 用户认证分组管理');
        $this->display();
    }

    public function edit() {
        $vModel=D('Vipgroup');
        $edit=$_POST['edit'];
        $newgroup=$_POST['newgroup'];

        $vipgroup = $vModel->select();

        if ($vipgroup) {//原始的项目
            foreach ($vipgroup as $val) {
                $oripri[]=$val['id'];
            }
        }

        if ($edit) {
            foreach ($edit as $key=>$val) {
                $nowpri[]=$key;
                //修改元素
                if ($val['name'] && $val['iconurl'] && $val['titleurl']) {
                    $vModel->where("`id`='$key'")->setField(array('name','iconurl','titleurl'),array($val['name'],$val['iconurl'],$val['titleurl']));
                }
            }
        }
        //删除元素
        if ($nowpri)  {
            $removename = array_diff($oripri,$nowpri);
        } else {
            $removename = $oripri;
        }

        if ($removename) {
            $removenames=implode(',',$removename);
            $vModel->where("`id` IN ($removenames)")->delete();
        }
        //添加元素
        if ($newgroup) {
            foreach ($newgroup['name'] as $key=>$val) {
                $name=$val;
                $iconurl=$newgroup['iconurl'][$key];
                $titleurl=$newgroup['titleurl'][$key];
                if ($name && $iconurl && $titleurl) {
                    $insert['name']=$name;
                    $insert['iconurl']=$iconurl;
                    $insert['titleurl']=$titleurl;
                    $vModel->add($insert);
                }
            }
        }
        $vipgroup = $vModel->select();
        F('vipgroup',$vipgroup,'./Home/Runtime/Data/');
        msgreturn('认证分组保存成功！',SITE_URL.'/admin.php?s=/Vipgroup');
    }
}
?>