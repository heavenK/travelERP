<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename googlemap_action.class.php $

    @Author hjoeson $

    @Date 2011-04-16 08:45:20 $
*************************************************************/

if (!defined('IN_ET')) exit();

class googlemap_action {

    function __construct(&$pluginManager) {

    }

    function page() {
        $umodel=D('Users');
        if (Action::$site_info['pubusersx']==1) {
            $condition=" AND user_head!='' AND user_gender!='' AND user_info!='' AND auth_email='1'";
        }
        $content = $umodel->where("lastcontent!='' AND lastcontent!='0' AND live_city!='' AND live_city!='国外 海外'".$condition)->order("lastconttime DESC")->limit('30')->select();

        $result.='<script type="text/javascript">var googlekey="'.Action::$site_info[googlekey].'";var mapnum='.count($content).';</script>';
        $result.='<script src="'.ET_URL.'/Plugin/googlemap/js/map.js" type="text/javascript"></script>';
        $result.='<script src="http://maps.google.com/maps?file=api&v=2&sensor=true&key='.Action::$site_info[googlekey].'" type="text/javascript" charset="utf-8"></script>';
        $result.='<script type="text/javascript">';
        foreach($content as $key=>$val){
            $result.="mycars[$key]='".urlencode($val[live_city])."';\n";
            $result.="mycarss[$key]='".sethead($val[user_head])."';\n";
            $result.="mycarsss[$key]='<div class=\"maps\"><a href=\"".SITE_URL."/$val[user_name]\" title=\"$val[nickname]\" target=\"_blank\" class=\"link\"><img src=\"".sethead($val[user_head])."\" alt=\"$val[nickname]\"/></a><span class=\"body\"><span class=\"nickname ".setvip($val[user_auth])."\"><a href=\"".SITE_URL."/$val[user_name]\" title=\"$val[nickname]\" target=\"_blank\">$val[nickname]</a></span> ".daddslashes(D('Content')->ubb($val[lastcontent]))."<div class=\"other\">".timeop($val[lastconttime])." $val[live_city]</div></span></div>';\n";
        }
        $result.='</script>';

        $result.='<div id="etmap" style="width:775px;height:500px" ></div>';
        $result.='<script LANGUAGE="JavaScript">
            var go;
            var map = new Object();
            map =new GMap2(document.getElementById("etmap"));
            map.disableDoubleClickZoom();
            map.removeMapType(G_HYBRID_MAP);
            map.removeMapType(G_SATELLITE_MAP);
            map.addMapType(G_PHYSICAL_MAP);
            map.setMapType(G_PHYSICAL_MAP);
            map.setCenter(new GLatLng(35.917,110.397),6);
            setTimeout(warp,1000);
        </script>';
        return $result;
    }

    public function install() {
        $sys=D('System')->where("name='googlekey'")->find();
        if (!$sys) {
            $model=new model();
            $model->query("INSERT INTO `".C('DB_PREFIX')."system` (`name` ,`title` ,`contents` ,`description`)VALUES ('googlekey', '谷歌地图API KEY', '', '申请地址：http://code.google.com/intl/zh-CN/apis/maps/signup.html')");
        }
        return true;
    }

    public function uninstall() {
        $model=new model();
        $model->query("DELETE FROM `".C('DB_PREFIX')."system` WHERE name='googlekey'");
        return true;
    }
}
?>