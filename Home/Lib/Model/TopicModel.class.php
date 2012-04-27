<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename TopicModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class TopicModel extends BaseModel {

    public function hottopic($order) {
        $class=$order==0?'first-sect':'';

        $lis=S('hottopic');
        if (!$lis) {
            $data=$this->where('tuijian=1')->order('topictimes DESC')->limit($this->site['hottopicnum'])->select();
            foreach ($data as $key=>$val) {
                if ($val['info']) {
                    $info='<div class="ttop"></div><div class="topicinfo">'.$val['info'].'</div>';
                } else {
                    $info='';
                }
                $lis.='<li><a href="'.SITE_URL.'/k/'.rawurlencode($val['topicname']).'">'.$val['topicname'].'</a><em>('.$val['topictimes'].')</em>'.$info.'</li>';
            }
            $lis=S('hottopic',$lis,$this->site['hottopic_cache_time']);
        }
        return '<div class="sect '.$class.'">
                <h2>'.L('tuijian_topic').'</h2>
                <ul class="tlist">'.$lis.'</ul>
                <a class="morebottom" href="'.SITE_URL.'/k">'.L('more_topic').'</a>
            </div>';
    }
}
?>