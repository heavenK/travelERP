<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename MessagesViewModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class MessagesViewModel extends ViewModel {
    public $viewFields = array(
        'Messages'=>array('message_id','senduid','sendtouid','messagebody','sendtime','isread','_type'=>'LEFT'),
        'Users'=>array('user_id','user_name','nickname','user_head','user_auth','_on'=>'Messages.senduid=Users.user_id'),
    );
}
?>