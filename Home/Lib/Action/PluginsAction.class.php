<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename PluginsAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class PluginsAction extends Action {

    public function _initialize() {
        parent::init();
    }

    public function index() {
        $app=$_GET['app'];
        $action=$_GET['action'];//直接调用方法
        $out=urldecode($_GET['out']);

        if (@file_exists(ET_ROOT .'/Plugin/'.$app.'/'.$app.'.class.php')) {
            $class = $app.'_action';
            if (class_exists($class)) {
                if (!@file_exists(ET_ROOT.'/Plugin/'.$app.'/'.$out)) {
                    $out='';
                }
                if (!$out) {
                    $plugin=new $class($this);
                    if ($action) {
                        echo $plugin->$action();
                        exit;
                    } else {
                        if (method_exists($class,page)) {
                            if (!$this->my) {
                                echo '<script type="text/javascript">window.location.href="'.SITE_URL.'/login"</script>';
                                exit;
                            }
                            $content=$plugin->page();
                        }
                    }
                } else {
                    include_once(ET_ROOT .'/Plugin/'.$app.'/'.$out);
                    exit;
                }
            }
        }

        if (!$content) {
            header('location:'.SITE_URL.'/'.rawurlencode($this->my['user_name']));
            exit;
        }

        $this->assign('content',$content);
        $this->display();
    }

    public function widget() {
        A('Api')->tologin();
        if ($this->site['widgetopen']==0) {
            echo '<script>alert("'.L('widget_not_open').'");window.location.href="'.SITE_URL.'"</script>';
            exit;
        }
        $this->display();
    }
}
?>