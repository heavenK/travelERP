<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename BaseModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class BaseModel extends Model {

    public $site;
    public $my;

    function _initialize() {
        $this->site = Action::$site_info;
        $this->my = Action::$login_user;
    }
}
?>