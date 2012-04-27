<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename CacheAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class CacheAction extends Action {

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
        $this->assign('position','其他设置 -> 缓存管理');
        $this->display();
    }

    public function clearcache() {
        $clearcache=$_POST['clearcache'];
        foreach ($clearcache as $val) {
            if ($val=='setting') {
                $path='./Home/Runtime/Data';
                $this->deleteDir($path);
                mkdir($path);
                chmod($path,0777);
                //重新写入site
                $site=array();
                $data = M('system')->select();
                foreach ($data as $key=>$val) {
                    $site[$val['name']]=$val['contents'];
                }
                F('site',$site,'./Home/Runtime/Data/');
                //重新写入plugin cache
                A('Plugins')->resetplugincache();
                //admin cache
                $path='./Admin/Runtime/Data';
                $this->deleteDir($path);
                mkdir($path);
                chmod($path,0777);
            }
            if ($val=='dltheme') {
                $path='./Public/attachments/downtheme';
                $this->deleteDir($path);
                mkdir($path);
                chmod($path,0777);
            }
            if ($val=='webcache') {
                $path='./Home/Runtime/Temp';
                $this->deleteDir($path);
                mkdir($path);
                chmod($path,0777);
            }
            if ($val=='tpcache') {
                //home
                $path='./Home/Runtime/Cache';
                $this->deleteDir($path);
                mkdir($path);
                chmod($path,0777);
                //admin
                $path='./Admin/Runtime/Cache';
                $this->deleteDir($path);
                mkdir($path);
                chmod($path,0777);
            }
            D('System')->where("name='cachetime'")->setField('contents',time());
            $this->deleteDir('./Home/Runtime/~app.php');
            $this->deleteDir('./Home/Runtime/~easytalk_runtime.php');
        }
        msgreturn('缓存清理成功',SITE_URL.'/admin.php?s=/Cache');
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