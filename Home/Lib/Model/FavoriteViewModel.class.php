<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename FavoriteViewModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class FavoriteViewModel extends ViewModel {
    public $viewFields = array(
        'Content'=>array('content_id','content_body','media_body','posttime','type','retid','replyid','replytimes','zftimes','_type'=>'LEFT'),
        'Favorite'=>array('_type'=>'LEFT','_on'=>'Content.content_id=Favorite.content_id'),
        'Users'=>array('user_id','user_name','nickname','user_head','user_auth','live_city','_on'=>'Content.user_id=Users.user_id'),
    );
}
?>