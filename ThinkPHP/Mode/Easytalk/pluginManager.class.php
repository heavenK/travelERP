<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename pluginManager.class.php $

    @Author hjoeson $

    @Date 2011-04-18 08:45:20 $
*************************************************************/

class pluginManager {

    private $_viewlis = array();
    private $_actionlis = array();
    private $_icolis = array();

    public function __construct($action='action') {
        $plugins = $this->get_active_plugins();
        if($plugins) {
            foreach($plugins as $plugin) {
                if (@file_exists(ET_ROOT .'/Plugin/'.$plugin['directory'].'/'.$plugin['directory'].'.class.php')) {
                    include_once(ET_ROOT .'/Plugin/'.$plugin['directory'].'/'.$plugin['directory'].'.class.php');
                    $class = $plugin['directory'].'_action';
                    if (class_exists($class)) {
                        new $class($this,$action);
                    }
                }
            }
        }

    }

    private function get_active_plugins() {
        $plus=Action::$plugin_av['allplugins'];
        $plus=json_decode($plus,true);
        return $plus;
    }

    function add_action($tag, $hook, &$reference, $method, $data='') {
        $key = get_class($reference).'->'.$method;
        $this->_actionlis[$tag][$hook][$key] = array(&$reference, $method, $data);
    }

    function add_view($tag, $hook, &$reference, $method, $data='') {
        $key = get_class($reference).'->'.$method;
        $this->_viewlis[$tag][$hook][$key] = array(&$reference, $method, $data);
    }

    function add_ico($tag,$icohtml,$order=0) {
        $key = get_class($reference).'->'.$method;
        $this->_icolis[] = array('tag'=>$tag,'ico'=>$icohtml,'order'=>$order);
    }

    function do_view() {
        $now=MODULE_NAME.ACTION_NAME;
        $currma=array('Indexindex','Indexindex','Indexregister','Indexlogin','Indexlogin','Indexregister','all','all','all','Pubindex','Pubindex','Pubindex','Pubindex','all','all','all','all','Spaceindex','Spaceindex','Spaceindex','Spaceindex','Spaceindex','Spaceindex','Spaceindex','Spaceindex','Spaceindex','Spaceindex','Spaceindex','Messageinbox','Messageinbox','Messagesendbox','Messagesendbox','Commentsindex','Commentsindex','Commentssendlist','Commentssendlist','Spaceindex','Spaceindex','Findindex','Findindex','Findindex','Findindex','Settingindex','Topicindex','Topicindex','Topicindex','Topicindex','Topicindex','all');

        $dytag=array('index_login_btn','index_login_banner','register_top','login_top','login_btn','reg_login_btn','main_top','main_foot1','main_foot2','pub_left_top','pub_left_mid','pub_side_top','pub_side_bottom','home_side_top','home_side_mid1','home_side_mid2','home_side_bottom','index_post_top1','index_post_top2','index_left_mid1','index_left_mid2','follow_left_top','profile_left_top1','profile_left_top2','profile_left_mid','profile_side_top','profile_side_mid','profile_side_bottom','inbox_left_top','inbox_left_mid','sendbox_left_top','sendbox_left_mid','comment_left_top','comment_left_mid','commentsend_left_top','commentsend_left_mid','error_top','error_bottom','find_top','find_mid1','find_mid2','find_bottom','setting_item','topic_top','topic_side_top','topic_left_mid1','topic_left_mid2','topic_side_bottom','floatbox');

        $key1=array_keys($currma,$now);
        $key2=array_keys($currma,'all');
        $key=array_merge($key1,$key2);
        if ($key) {
            foreach($key as $val) {
                $cantag[]=$dytag[$val];
            }
        }
        $result=array();
        foreach($this->_viewlis as $key=>$val) {
            if (in_array($key,$cantag)) {
                $result[$key]=$this->_do_view($key);
            }
        }
        if ($this->_icolis) {
            foreach ($this->_icolis as $val) {
                $order[]=$val['order'];
            }
            array_multisort($this->_icolis,SORT_DESC,SORT_NUMERIC,$order);
            foreach ($this->_icolis as $val) {
                $val['ico']='<div style="float:left;margin-right:10px">'.$val['ico'].'</div>';
                $result[$val['tag']]=$result[$val['tag']].$val['ico'];
                $tags[]=$val['tag'];
            }
            $tags=array_unique($tags);
            if ($tags) {
                foreach ($tags as $val) {
                    $result[$val]='<div style="margin:10px 0px;display:block">'.$result[$val].'<div class="clearline"></div></div>';
                }
            }
        }
        return $result;
    }

    private function _do_view($tag) {
        $result = '';
        if (isset($this->_viewlis[$tag]) && is_array($this->_viewlis[$tag]) && count($this->_viewlis[$tag]) > 0) {
            foreach ($this->_viewlis[$tag] as $hook=>$val) {
                if (isset($this->_viewlis[$tag][$hook]) && is_array($this->_viewlis[$tag][$hook]) && count($this->_viewlis[$tag][$hook]) > 0) {
                    foreach ($this->_viewlis[$tag][$hook] as $listener) {
                        $class =& $listener[0];
                        $method = $listener[1];
                        if(method_exists($class,$method)) {
                            $result.= $class->$method($listener[2]);
                        }
                    }
                }
            }
        }
        return $result;
    }

    function do_action($tag) {
        if (isset($this->_actionlis[$tag]) && is_array($this->_actionlis[$tag]) && count($this->_actionlis[$tag]) > 0) {
            foreach ($this->_actionlis[$tag] as $hook=>$val) {
                if (isset($this->_actionlis[$tag][$hook]) && is_array($this->_actionlis[$tag][$hook]) && count($this->_actionlis[$tag][$hook]) > 0) {
                    foreach ($this->_actionlis[$tag][$hook] as $listener) {
                        $class =& $listener[0];
                        $method = $listener[1];
                        if(method_exists($class,$method)) {
                            $class->$method($listener[2]);
                        }
                    }
                }
            }
        }
    }
}
?>