<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename MytopicViewModel.class.php $

    @Author hjoeson $

    @Date 2011-05-24 08:45:20 $
*************************************************************/

class MytopicViewModel extends ViewModel {
    public $viewFields = array(
        'Mytopic'=>array('id','topicid','user_id','_type'=>'LEFT'),
        'Topic'=>array('topicname','info','topictimes','follownum','tuijian','_type'=>'LEFT','_on'=>'Mytopic.topicid=Topic.id'),
        'Users'=>array('user_id','user_name','nickname','user_head','user_auth','_on'=>'Mytopic.user_id=Users.user_id'),
    );
}
?>