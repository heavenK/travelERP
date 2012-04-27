<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename GuideAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class GuideAction extends Action {

    public function _initialize() {
        parent::init();
        A('Api')->tologin();
        if ($this->my['userguide']==1) {
            header('location:'.SITE_URL);
            exit;
        }
    }

    public function index() {
        $province=D('District')->where('level=1')->select();
        $this->assign('province',$province);
        $this->display();
    }

    public function doset() {
        $user=D('Users');
        $ctent=D('Content');
        $data=array();

        $nickname= daddslashes(clean_html(trim($_POST["nickname"])));
        $gender= $_POST["gender"];
        $city=trim($_POST["livesf"].' '.$_POST["livecity"]);
        $info= daddslashes($ctent->replace(trim($_POST["info"])));

        if(!preg_match('/^[0-9a-zA-Z\xe0-\xef\x80-\xbf._-]+$/i',$nickname)) {
            Cookie::set('setok','setting2');
            header('location:'.SITE_URL.'/Guide/index');
            exit;
        }
        if (!$nickname || !$gender || !$city) {
            Cookie::set('setok','setting1');
            header('location:'.SITE_URL.'/Guide/index');
            exit;
        }
        if ($city && $city!=$this->my['live_city'] && $city!="选择省份 选择城市"){
            $data['live_city']=$city;
        }
        if ($gender!=$this->my['user_gender']){
            $data['user_gender']=$gender;
        }
        if ($info!=$this->my['user_info']){
            $data['user_info']=$info;
        }
        if ($nickname && $nickname!=$this->my['nickname']) {
            if (StrLenW($nickname)<=12 && StrLenW($nickname)>=1) {
                $newnickname=$user->where("user_name='$nickname' OR nickname='$nickname'")->find();
                if ($newnickname) {
                    Cookie::set('setok','setting4');
                    header('location:'.SITE_URL.'/Guide/index');
                    exit;
                } else {
                    $data['nickname']=$nickname;
                }
            } else {
                Cookie::set('setok','setting2');
                header('location:'.SITE_URL.'/Guide/index');
                exit;
            }
        }
        $user->where("user_id='".$this->my['user_id']."'")->data($data)->save();
        header('location:'.SITE_URL.'/Guide/followtopic');
    }

    public function followtopic() {
        $topic = D('Topic')->where("topictimes>0 AND tuijian=1")->order("topictimes DESC")->limit(30)->select();
        $this->assign('topic',$topic);
        $this->display();
    }

    public function dotopic() {
        $topicnames=$_POST['topicnames'];
        if (is_array($topicnames)) {
            $keyword=implode("','",$topicnames);
            $mt=D('Mytopic');
            $tp=D('Topic');

            $tpdata=$tp->where("topicname IN ('$keyword')")->select();
            if ($tpdata) {
                foreach($tpdata as $val) {
                    $keywords[]=$val['id'];
                }
                $keyword=implode("','",$keywords);
                $data=$mt->where("topicid IN ('$keyword') AND user_id='".$this->my['user_id']."'")->select();
                foreach($data as $val) {
                    $followed[]=$val['topicid'];
                }
                if ($followed) {
                    $diff=array_diff($keywords,$followed);
                } else {
                    $diff=$keywords;
                }
                if (is_array($diff)) {
                    foreach($diff as $val) {
                        $insert['topicid']=$val;
                        $insert['user_id']=$this->my['user_id'];
                        $mt->add($insert);
                        $key=array_keys($keywords,$val);
                        $key=$key[0];
                        $tp->where("id='$key'")->setInc('follownum');
                    }
                }
            }
        }
        header('location:'.SITE_URL.'/Guide/followuser');
    }

    public function followuser() {
        $uModel=D('Users');

        //获取我已经收听的用户
        $mf=array();
        $userf=D('friend')->field('fid_jieshou')->where("fid_fasong='".$this->my['user_id']."'")->select();
        foreach($userf as $val) {
            $mf[]=$val['fid_jieshou'];
        }
        $mf=implode(',',$mf);
        $mf=$mf?$mf.','.$this->my['user_id']:$this->my['user_id'];

        $user=$uModel->where('user_id not in ('.$mf.') AND msg_num>0')->order('msg_num DESC')->limit(21)->select();

        $this->assign('user',$user);
        $this->display();
    }

    public function douser() {
        $usernames=$_POST['usernames'];
        if (is_array($usernames)) {
            $fModel=D('Friend');
            foreach($usernames as $val) {
                $fModel->addfollow($val,$this->my['user_id']);
            }
        }
        D('Users')->where("user_id='".$this->my['user_id']."'")->setField('userguide',1);
        header('location:'.SITE_URL);
    }

    public function doface() {
        import("@.ORG.UploadFile");
        $uploadurl='/Public/attachments/head/temp/';
        $uploadurl2=__PUBLIC__.'/attachments/head/temp/';
        $upload = new UploadFile();
        $upload->maxSize  = 2097152 ;
        $upload->allowExts  = explode(',','jpg,gif,png,jpeg');
        $upload->savePath =  ET_ROOT.$uploadurl;
        $upload->thumb =  false;
        $upload->autoSub = false;
        $upload->saveRule = time;
        $upload->thumbRemoveOrigin = true;
        if($upload->upload()) {
            $uploadList = $upload->getUploadFileInfo();
            $picinfo=getimagesize(ET_ROOT.$uploadurl.$uploadList[0]['savename']);
            echo '<script language="Javascript">parent.document.getElementById("cropbox").src="'.$uploadurl2.$uploadList[0]['savename'].'";parent.document.getElementById("imgpath").value="'.$uploadurl.$uploadList[0]['savename'].'";parent.document.getElementById("cropboxdiv").style.display="block";parent.document.getElementById("loadpic").style.display="none";parent.frames.faceinit("'.$picinfo[0].'");parent.document.getElementById("picpath").innerHTML="'.L('head_filename').$uploadList[0]['savename'].'";</script>';
        } else {
            echo '<script language="Javascript">parent.document.getElementById("loadpic").style.display="none";alert("'.L('head_upload_error').'");</script>';
        }
    }

    public function doface2() {
        $ysw=$_POST['ysw'];
        if ($ysw>460) {
            $zoom=intval($ysw)/460;
        } else {
            $zoom=1;
        }
        $x=$_POST['x']*$zoom;
        $y=$_POST['y']*$zoom;
        $w=$_POST['w']*$zoom;
        $h=$_POST['h']*$zoom;
        $imgpath=ET_ROOT.$_POST['imgpath'];
        $ext=strtolower(getExtensionName($imgpath));

        import("@.ORG.IoHandler");
        $IoHandler = new IoHandler();
        if($ext!='jpg' && $ext!='jpeg' && $ext!='gif' && $ext!='png') {
            $IoHandler->DeleteFile($imgpath);
            Cookie::set('setok','face2');
            header('location:'.SITE_URL.'/Guide');
            exit;
        }
        $image_path = ET_ROOT.'/Public/attachments/head/'.date('Ymd').'/';
        if(!is_dir($image_path)) {
            mkdir($image_path);
        }
        $f=date('His');
        //大图片
        $filename=$f.'_big.'.$ext;
        $dst_file = $image_path.$filename;
        $make_result = makethumb($imgpath,$dst_file,max(10,min(120,$w)),max(10,min(120,$h)),0,0,$x,$y,$w,$h);
        //小图片
        $filename=$f.'_small.'.$ext;
        $dst_file = $image_path.$filename;
        $make_result = makethumb($imgpath,$dst_file,max(10,min(50,$w)),max(10,min(50,$h)),0,0,$x,$y,$w,$h);
        $IoHandler->DeleteFile($imgpath);

        $user=M('Users');
        $data['user_head']=date('Ymd').'/'.$filename;
        $user->where("user_id='".$this->my['user_id']."'")->data($data)->save();
        Cookie::set('setok','face1');
        header('location:'.SITE_URL.'/Guide');
    }
}
?>