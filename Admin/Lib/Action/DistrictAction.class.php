<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename DistrictAction.class.php $

    @Author hjoeson $

    @Date 2011-06-01 08:45:20 $
*************************************************************/

class DistrictAction extends Action {

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $type=$_GET['type']?$_GET['type']:'loadprovince';
        $level=intval($_GET['level'])?intval($_GET['level']):1;
        $pid=intval($_GET['pid']);
        $dModel=D('District');

        $districts = $dModel->select();

        $this->assign('districts',$districts);
        $this->assign('type',$type);
        $this->assign('pid',$pid);
        $this->assign('level',$level);
        $this->assign('position','全局设置 -> 地区管理');
        $this->display();
    }

    public function editnames() {
        $dModel=D('District');
        $names=$_POST['names'];
        $newnames=$_POST['newnames'];
        $level=$_POST['level']?$_POST['level']:1;
        $pid=$_POST['pid'];

        $districts = $dModel->select();
        if ($districts) {//原始的项目
            foreach ($districts as $val) {
                if ($val['level']==$level && $val['upid']==$pid) {
                    $oripri[]=$val['id'];
                }
            }
        }

        if ($names) {
            foreach ($names as $key=>$val) {
                $nowpri[]=$key;
                //修改元素
                $dModel->where("`id`='$key'")->setField('name',$val);
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
            $dModel->where("`id` IN ($removenames)")->delete();
        }
        //添加元素
        if ($newnames) {
            foreach ($newnames as $val) {
                $insert['name']=$val;
                $insert['level']=$level;
                $insert['upid']=$pid;
                $dModel->add($insert);
            }
        }
        if ($pid) {
            msgreturn('地区信息保存成功！',SITE_URL.'/admin.php?s=/District/index/type/loadcity/pid/'.$pid.'/level/'.$level);
        } else {
            msgreturn('地区信息保存成功！',SITE_URL.'/admin.php?s=/District');
        }
    }
}
?>