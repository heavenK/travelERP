<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename FollowingViewModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class FollowingViewModel extends ViewModel {
    public $viewFields = array(
        'Friend'=>array('fid_jieshou','fid_fasong','_type'=>'LEFT'),
        'Users'=>array('user_id','user_name','nickname','user_head','user_auth','live_city','msg_num','follow_num','followme_num','_on'=>'Friend.fid_jieshou=Users.user_id'),
    );
}
?>