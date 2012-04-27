<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename SettingAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class SettingAction extends Action{

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $system=D('System');
        $siteall=$system->select();
        foreach($siteall as $val) {
            $site[$val['name']]=$val;
        }
        $this->assign('site',$site);
        $this->assign('position','全局设置 -> 网站设置');
        $this->display();
    }

    public function mail() {
        $system=D('System');
        $siteall=$system->select();
        foreach($siteall as $val) {
            $site[$val['name']]=$val;
        }
        $this->assign('site',$site);
        $this->assign('position','全局设置 -> 邮件设置');
        $this->display();
    }

    public function ads() {
        $system=D('System');
        $siteall=$system->select();
        foreach($siteall as $val) {
            $site[$val['name']]=$val;
        }
        $this->assign('site',$site);
        $this->assign('position','其他设置 -> 通用广告管理');
        $this->display();
    }

    public function about() {
        $system=D('System');
        $siteall=$system->select();
        foreach($siteall as $val) {
            $site[$val['name']]=$val;
        }
        $this->assign('site',$site);
        $this->assign('position','其他设置 -> 关于我们设置');
        $this->display();
    }

    public function shorturl() {
        $system=D('System');
        $siteall=$system->select();
        foreach($siteall as $val) {
            $site[$val['name']]=$val;
        }
        $this->assign('site',$site);
        $this->assign('position','全局设置 -> 短域名设置');
        $this->display();
    }

    public function switchs() {
        $system=D('System');
        $siteall=$system->select();
        foreach($siteall as $val) {
            $site[$val['name']]=$val;
        }
        $this->assign('site',$site);
        $this->assign('position','全局设置 -> 网站开关');
        $this->display();
    }

    public function badword() {
        $system=D('System');
        $siteall=$system->select();
        foreach($siteall as $val) {
            $site[$val['name']]=$val;
        }
        $this->assign('site',$site);
        $this->assign('position','全局设置 -> 屏蔽管理');
        $this->display();
    }

    public function sidebox() {
        $system=D('System');
        $systemside=array('hottopic','hotuser','bangnormal','bangvip','userfollower','userfollowing');
        $t=$_GET['t']?$_GET['t']:'userside';
        $siteall=$system->select();
        foreach($siteall as $val) {
            $site[$val['name']]=$val;
        }
        $side['userside']=json_decode($site['userside']['contents'],true);
        $side['proside']=json_decode($site['proside']['contents'],true);
        $side['pubside']=json_decode($site['pubside']['contents'],true);

        $this->assign('t',$t);
        $this->assign('systemside',$systemside);
        $this->assign('site',$site);
        $this->assign('side',$side);
        $this->assign('position','全局设置 -> 侧边栏设置');
        $this->display();
    }

    public function addside() {
        $system=D('System');
        $sidetype=$_POST['sidetype'];
        $side=$_POST['addside'];
        $systemside=array('hottopic','hotuser','bangnormal','bangvip','userfollower','userfollowing');

        if ($sidetype && $side && $side['name']) {
            $data=$system->where("name='$sidetype'")->find();
            if ($data) {
                $sides=json_decode($data['contents'],true);
                if (in_array($side['name'],$systemside)) { //系统默认
                    foreach($sides as $val) { //是否重复
                        if ($val['name']==$side['name']) {
                            msgreturn('很抱歉，已经有相同类型的系统默认侧栏',SITE_URL.'/admin.php?s=/Setting/sidebox/t/'.$sidetype);
                        }
                    }
                    if ($sidetype=='pubside' && ($side['name']=='userfollower' || $side['name']=='userfollowing')) {
                        msgreturn('很抱歉，广场侧栏不能添加此类型',SITE_URL.'/admin.php?s=/Setting/sidebox/t/'.$sidetype);
                    } else {
                        $side['title']=$side['val']='';
                    }
                }
                $sides[]=$side;
                $sides=$this->resetarray($sides);
                $newdata=json_encode($sides);
                $system->where("name='$sidetype'")->setField('contents',$newdata);

                msgreturn('侧栏添加成功',SITE_URL.'/admin.php?s=/Setting/sidebox/t/'.$sidetype);
            } else {
                msgreturn('很抱歉，操作有误',SITE_URL.'/admin.php?s=/Setting/sidebox');
            }
        } else {
            msgreturn('很抱歉，您还没有填写完信息',SITE_URL.'/admin.php?s=/Setting/sidebox');
        }
    }

    public function delside() {
        $system=D('System');
        $t=$_GET['t'];
        $order=$_GET['order'];
        if ($t) {
            $data=$system->where("name='$t'")->find();
            if ($data) {
                $side=json_decode($data['contents'],true);
                unset($side[$order]);
                $side=$this->resetarray($side);
                $newdata=json_encode($side);
                $system->where("name='$t'")->setField('contents',$newdata);

                msgreturn('恭喜您，删除侧栏成功',SITE_URL.'/admin.php?s=/Setting/sidebox/t/'.$t);
            } else {
                msgreturn('很抱歉，操作有误！',SITE_URL.'/admin.php?s=/Setting/sidebox');
            }
        } else {
            msgreturn('很抱歉，操作有误！',SITE_URL.'/admin.php?s=/Setting/sidebox');
        }
    }

    private function resetarray($arr) {
        $arr2=array();
        if (is_array($arr)) {
            foreach($arr as $val) {
                $arr2[]=$val;
            }
        }
        return $arr2;
    }

    private function keyfu($arr) {
        if (is_array($arr)) {
            $min=0;
            foreach($arr as $val) {
                $min=min($val,$min);
            }
            if ($min<0) {
                $add=abs($min);
                foreach($arr as $val) {
                    $arr2[]=intval($val)+$add;
                }
                return $arr2;
            }
        }
        return $arr;
    }

    private function keysort($arr,$key) {
        if ($arr[$key]) {
            $key+=1;
            return $this->keysort($arr,$key);
        } else {
            return $key;
        }
    }

    public function webset() {
        $system=D('System');
        $sitedata=$_POST['site'];
        $reurl=$_POST['reurl'];
        //保存侧栏
        $sidetype=$_POST['sidetype'];
        $side=$_POST['side'];
        if ($side && $sidetype) {
            $order=$this->keyfu($side['order']);//清除数组中的负数和非数字
            $name=$side['name'];
            $title=$side['title'];
            $val=$side['val'];

            foreach($name as $key=>$v) {
                $k=$this->keysort($newside,$order[$key]);
                $newside[$k]=array('name'=>$name[$key],'title'=>$title[$key],'val'=>$val[$key]);
            }
            ksort($newside);
            $newside=$this->resetarray($newside);
            $newside=json_encode($newside);
            $system->where("name='$sidetype'")->setField('contents',$newside);
        }
        if ($sitedata) {
            $allowhtml=array('ad1','ad2','ad3','foottongji','about','contect','join');
            foreach($sitedata as $key=>$val) {
                if (!in_array($key,$allowhtml)) {
                    $val=clean_html($val);
                }
                $system->where("name='$key'")->setField('contents',$val);
            }
        }
        //clearcache
        $this->deleteDir('./Home/Runtime/Data/site.php');
        //重新写入site
        $site=array();
        $data = M('system')->select();
        foreach ($data as $key=>$val) {
            $site[$val['name']]=$val['contents'];
        }
        F('site',$site,'./Home/Runtime/Data/');

        msgreturn('恭喜您，设置成功了',SITE_URL.'/admin.php?s=/'.$reurl);
    }

    private function deleteDir($dirName){
        if(!is_dir($dirName)){
            @unlink($dirName);
            return false;
        }
        $handle = @opendir($dirName);
        while(($file = @readdir($handle)) !== false){
            if($file != '.' && $file != '..'){
                $dir = $dirName . '/' . $file;
                is_dir($dir) ? $this->deleteDir($dir) : @unlink($dir);
            }
        }
        closedir($handle);
        return rmdir($dirName);
    }
}
?>