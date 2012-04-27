<?php
if (!defined('IN_ET')) exit();

class googlemap_admin {

    public function admin() {
        $googlekey=include(ET_ROOT.'/Home/Runtime/Data/site.php');
        return "<form action='".SITE_URL."/admin.php?s=/Plugins/doadmin/appname/googlemap/action/dosave' method='POST'>
        <table style='margin:5px 0 20px 0;line-height:250%'>
        <tr>
            <td width='120px'>谷歌地图API KEY:</td>
            <td width='330px'><input type='text' name='googleapi' class='txt_input' value='$googlekey[googlekey]'></td>
            <td>● 申请地址：http://code.google.com/intl/zh-CN/apis/maps/signup.html</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan='2'><input type='submit' class='button1' value='保存提交'></td>
        </tr>
        </table>
        </form>";
        exit;
    }

    public function dosave() {
        $googleapi=clean_html($_POST['googleapi']);

        D('System')->where("name='googlekey'")->setField('contents',$googleapi);

        $this->deleteDir('./Home/Runtime/Data/site.php');
        $site=array();
        $data = M('system')->select();
        foreach ($data as $key=>$val) {
            $site[$val['name']]=$val['contents'];
        }
        F('site',$site,'./Home/Runtime/Data/');

        msgreturn('插件信息保存成功！',SITE_URL.'/admin.php?s=/Plugins/appsetting/appname/googlemap');
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