<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename BlacklistAction.class.php $

    @Author hjoeson $

    @Date 2011-08-09 08:45:20 $
*************************************************************/

class BlacklistAction extends Action {

    public function addblack() {
        $blackuid=$_POST['uid'];
        $blackuname=$_POST['uname'];
        if ($blackuid && $blackuid!=$this->my['user_id']){
            $bModel=D('Blacklist');
            $data=$bModel->where("user_id='".$this->my['user_id']."' AND black_uid='$blackuid'")->find();
            if (!$data) {
                $insert['user_id']=$this->my['user_id'];
                $insert['black_uid']=$blackuid;
                $bModel->add($insert);
            }
            //删除相互收听
            $fModel=D('Friend');
            $fModel->delfollow($blackuname,$this->my['user_id']);
            $fModel->delfollow($this->my['user_name'],$this->user['user_id']);

            echo json_encode(array("ret"=>'success',"tip"=>L('blackaddok')));
        } else {
            echo json_encode(array("ret"=>'error',"tip"=>L('blackuiderror')));
        }
    }

    public function delblack() {
        $blackuid=$_POST['uid'];
        if ($blackuid && $blackuid!=$this->my['user_id']){
            D('Blacklist')->where("user_id='".$this->my['user_id']."' AND black_uid='$blackuid'")->delete();
            echo json_encode(array("ret"=>'success',"tip"=>L('delblackok')));
        } else {
            echo json_encode(array("ret"=>'error',"tip"=>L('blackuiderror')));
        }
    }

}
?>