<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename FavoriteModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class FavoriteModel extends BaseModel {

    //添加收藏
    public function dofavor($contentid,$mid) {
        $isfav=$this->where("content_id='$contentid' AND sc_uid='$mid'")->find();
        if (!$isfav) {
            if (D('Content')->where("content_id='$contentid' AND replyid=0")->find()) {
                $insert['content_id']=$contentid;
                $insert['sc_uid']=$mid;
                $this->add($insert);
                return 'success';
            } else {
                return L('favor_talk_null');
            }
        } else {
            return 'success';
        }
    }

    //删除收藏
    public function delfavor($contentid,$mid) {
        $this->where("content_id='$contentid' AND sc_uid='$mid'")->delete();
        return 'success';
    }
}
?>