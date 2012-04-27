<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename PluginsAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class PluginsAction extends Action{

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $plusname=array();
        $data=D('Plugins')->select();
        foreach ($data as $pname) {
            $plusname[]=$pname['directory'];
        }
		if(is_dir(ET_ROOT.'/Plugin')) {
			$dir = dir(ET_ROOT.'/Plugin');
			while($entry = $dir->read()) {
				if ($entry!='.' && $entry!='..') {
                    if (@file_exists(ET_ROOT .'/Plugin/'.$entry.'/info.php')
                        && @file_exists(ET_ROOT .'/Plugin/'.$entry.'/'.$entry.'.class.php')
                        && !in_array($entry,$plusname)) {
                        $info=@include(ET_ROOT .'/Plugin/'.$entry.'/info.php');
                        $plugins[$entry]=$info;
                    }
                }
			}
			$dir->close();
		}

        $this->assign('position','添加插件');
        $this->assign('plugins',$plugins);
        $this->display();
    }

    public function admin() {
        $data=D('Plugins')->order('`order` ASC')->select();
        foreach ($data as $plus) {
            if (@file_exists(ET_ROOT .'/Plugin/'.$plus['directory'].'/info.php')) {
                $info=@include(ET_ROOT .'/Plugin/'.$plus['directory'].'/info.php');
            } else {
                $info='';
            }
            $plugins[$plus['directory']]=array('plus'=>$plus,'info'=>$info);
        }

        $this->assign('position','管理插件');
        $this->assign('plugins',$plugins);
        $this->display();
    }

    public function switchs() {
        $appname=$_GET['appname'];
        $s=intval($_GET['s']);
        if ($appname) {
            D('Plugins')->where("directory='$appname'")->setField('available',$s);

            msgreturn('插件操作成功！',SITE_URL.'/admin.php?s=/Plugins/admin');

            $this->resetplugincache();
        } else {
            msgreturn('很抱歉，插件操作失败！',SITE_URL.'/admin.php?s=/Plugins/admin');
        }
    }

    public function install() {
        $appname=$_GET['appname'];
        $plusname=array();
        $data=D('Plugins')->select();
        foreach ($data as $pname) {
            $plusname[]=$pname['directory'];
        }
        if (@file_exists(ET_ROOT .'/Plugin/'.$appname.'/info.php')
            && @file_exists(ET_ROOT .'/Plugin/'.$appname.'/'.$appname.'.class.php')
            && !in_array($appname,$plusname)) {
            $info=@include(ET_ROOT .'/Plugin/'.$appname.'/info.php');
            //setup
            include_once(ET_ROOT .'/Plugin/'.$appname.'/'.$appname.'.class.php');
            $class = $appname.'_action';
            if (class_exists($class)) {
                $plus=new $class($this);
                $setup=$plus->install();
                if ($setup==true) {
                    $insert['name']=$info['name'];
                    $insert['directory']=$appname;
                    $insert['available']=0;
                    $insert['ispage']=$info['ispage'];
                    D('Plugins')->add($insert);

                    $this->resetplugincache();
                    msgreturn('【'.$info['name'].'】已经成功安装！',SITE_URL.'/admin.php?s=/Plugins/admin');
                } else {
                    msgreturn('很抱歉，该插件安装失败！',SITE_URL.'/admin.php?s=/Plugins');
                }
            } else {
                msgreturn('很抱歉，该插件不能被识别！',SITE_URL.'/admin.php?s=/Plugins');
            }
        } else {
            $this->assign('url',SITE_URL.'/admin.php?s=/Plugins');
            if (in_array($appname,$plusname)) {
                msgreturn('该插件已经安装了！',SITE_URL.'/admin.php?s=/Plugins');
            } else {
                msgreturn('该插件不存在或者不能被识别！',SITE_URL.'/admin.php?s=/Plugins');
            }
        }
    }

    public function uninstall() {
        $appname=$_GET['appname'];
        if (@file_exists(ET_ROOT .'/Plugin/'.$appname.'/'.$appname.'.class.php')) {
            include_once(ET_ROOT .'/Plugin/'.$appname.'/'.$appname.'.class.php');
            $class = $appname.'_action';
            if (class_exists($class)) {
                $plus=new $class($this);
                $unsetup=$plus->uninstall();
                if ($unsetup==true) {
                    D('Plugins')->where("directory='$appname'")->delete();
                    $this->resetplugincache();
                    msgreturn('插件已经成功卸载！',SITE_URL.'/admin.php?s=/Plugins/admin');
                } else {
                    msgreturn('很抱歉，该插件卸载失败！',SITE_URL.'/admin.php?s=/Plugins/admin');
                }
            } else {
                msgreturn('很抱歉，该插件未被识别！',SITE_URL.'/admin.php?s=/Plugins/admin');
            }
        } else {
            msgreturn('很抱歉，该插件未被识别！',SITE_URL.'/admin.php?s=/Plugins/admin');
        }
    }

    public function setting() {
        $appname=$_GET['appname'];
        $newname=clean_html($_POST['newname']);
        $neworder=intval($_POST['neworder']);
        if ($appname && $newname) {
            D('Plugins')->where("directory='$appname'")->setField(array('name','order'),array($newname,$neworder));
        }
        msgreturn('插件信息保存成功！',SITE_URL.'/admin.php?s=/Plugins/appsetting/appname/'.$appname);
    }

    public function appsetting() {
        $appname=$_GET['appname'];
        $plugin=D('Plugins')->where("directory='$appname'")->find();

        if (@file_exists(ET_ROOT .'/Plugin/'.$appname.'/admin.class.php')) {
            include_once(ET_ROOT .'/Plugin/'.$appname.'/admin.class.php');
            $class = $appname.'_admin';
            if (class_exists($class)) {
                $admin=new $class($this);
                $appadmin=$admin->admin();
            }
        }

        $this->assign('appadmin',$appadmin);
        $this->assign('position',$plugin['name'].'管理');
        $this->assign('plugin',$plugin);
        $this->display();
    }

    public function doadmin() {
        $appname=$_GET['appname'];
        $action=$_GET['action'];

        if (@file_exists(ET_ROOT .'/Plugin/'.$appname.'/admin.class.php')) {
            include_once(ET_ROOT .'/Plugin/'.$appname.'/admin.class.php');
            $class = $appname.'_admin';
            if (class_exists($class)) {
                $admin=new $class($this);
                $appadmin=$admin->$action();
            }
        }
    }

    public function delapp() {
        $appname=$_GET['appname'];

        if ($appname) {
            $this->deleteDir('./Plugin/'.$appname);
            msgreturn('插件文件删除成功！',SITE_URL.'/admin.php?s=/Plugins');
        } else {
            msgreturn('插件文件删除失败！',SITE_URL.'/admin.php?s=/Plugins');
        }
    }

    public function resetplugincache() {
        $this->deleteDir('./Home/Runtime/Data/plugincache.php');
        $allplugins=array();
        $pageplugins='';
        $plugins=D('Plugins')->where('available=1')->order('`order`')->select();
        foreach ($plugins as $val) {
            $allplugins[]=array('name'=>$val['name'],'directory'=>$val['directory']);
            if ($val['ispage']==1) {
                $pageplugins.='<p><a href="'.SITE_URL.'/p/'.$val['directory'].'">'.$val['name'].'</a></p>';
            }
        }
        $plus['allplugins']=json_encode($allplugins);
        $plus['pageplugins']=$pageplugins;
        F('plugincache',$plus,'./Home/Runtime/Data/');
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