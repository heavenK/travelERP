<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename SettingAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class SettingAction extends Action {

    public function _initialize() {
        A('Api')->tologin();
        parent::init();
        $this->assign('usertemp',usertemp($this->my));
        $this->assign('menu','setting');
        $this->assign('subname',L('setcenter'));
    }

    public function index() {
        $province=D('District')->where('level=1')->select();
        $this->assign('province',$province);
        $this->display();
    }

    public function doset() {
        $user=D('Users');
        $data=array();

        $nickname= daddslashes(clean_html(trim($_POST["nickname"])));
        $gender= $_POST["gender"];
        $city=trim($_POST["livesf"].' '.$_POST["livecity"]);
        $info= daddslashes(D('Content')->replace(trim($_POST["info"])));

        if(!preg_match('/^[0-9a-zA-Z\xe0-\xef\x80-\xbf._-]+$/i',$nickname)) {
            Cookie::set('setok','setting2');
            header('location:'.SITE_URL.'/Setting/index');
            exit;
        }
        if (!$nickname || !$gender || !$city) {
            Cookie::set('setok','setting1');
            header('location:'.SITE_URL.'/Setting/index');
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
        if ($nickname && $nickname!=$this->my['nickname'] && $this->my['user_auth']==0) {
            if (StrLenW($nickname)<=12 && StrLenW($nickname)>=1) {
                $newnickname=$user->where("user_name='$nickname' OR nickname='$nickname'")->find();
                if ($newnickname) {
                    Cookie::set('setok','setting4');
                    header('location:'.SITE_URL.'/Setting/index');
                    exit;
                } else {
                    $data['nickname']=$nickname;
                    //atuserlist
                    D('Atusers')->where("atuname='".$this->my['user_name']."'")->setField('atnickname',$nickname);
                }
            } else {
                Cookie::set('setok','setting2');
                header('location:'.SITE_URL.'/Setting/index');
                exit;
            }
        }
        $user->where("user_id='".$this->my['user_id']."'")->data($data)->save();
        Cookie::set('setok','setting3');
        header('location:'.SITE_URL.'/Setting/index');
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
            header('location:'.SITE_URL.'/Setting/face');
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
        header('location:'.SITE_URL.'/Setting/face');
    }

    public function doaccount() {
        $pass=md5(md5($_POST["pass"]));
        $newpass1= md5(md5($_POST["newpass1"]));
        $newpass2= md5(md5($_POST["newpass2"]));
        if ($pass==$this->my['password']) {
            if ($newpass1!=$newpass2 || !trim($_POST["newpass1"])) {
                Cookie::set('setok','account1');
            } else {
                //ucenter 修改密码
                if (ET_UC==TRUE) {
                    $ucresult = uc_user_edit($this->my['user_name'],$_POST["pass"],$_POST["newpass2"]);
                    if($ucresult!=1) {
                        Cookie::set('setok','account3');
                        header('location:'.SITE_URL.'/Setting/account');
                        exit;
                    }
                }
                //end
                D('Users')->where("user_id='".$this->my['user_id']."'")->setField('password',$newpass1);
                Cookie::set('setok','account2');
            }
        } else {
            Cookie::set('setok','account3');
        }
        header('location:'.SITE_URL.'/Setting/account');
    }

    public function domailauth() {
        if ($this->my['auth_email']==0) {
            $sendurl=randStr(20);
            $sendurl=base64_encode($this->my['user_id'].":".$sendurl);
            $url=SITE_URL."/Setting/doauth/auth/{$sendurl}";
            $send="<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
            <p>".L('mailauth_title').$this->my['nickname']."(<small>@".$this->my['user_name']."</small>)：</p>
            <p style='text-indent:2em'>".L('mailauth_this').$this->site['sitename'].L('mailauth_tip1')."<a href='$url' target='_blank'>".L('mailauth_click')."</a>".L('mailauth_copyurl')."</p>
            <p>".L('authurl').":<a href='$url' target='_blank'>$url</a></p>
            <p style='text-align:right'>".$this->site['sitename']." ".date('Y-m-d H:i')."</p>";
            $title=$this->site['sitename'].L('mailauth');

            A('Api')->sendMail($title,$send,$this->my['mailadres']);

            $user=M('Users');
            $data['auth_email']=$sendurl;
            $user->where("user_id='".$this->my['user_id']."'")->data($data)->save();

            Cookie::set('setok','mail1');
        }
        header('location:'.SITE_URL.'/Setting/mailauth');
    }

    public function changemail() {
        $user=D('Users');
        $new_email= daddslashes(trim($_POST["email"]));
        if(!strpos($new_email,"@")) {
            Cookie::set('setok','mail2');
        } else {
            if ($new_email && $new_email!=$this->my['mailadres']) {
                $row = $user->field('mailadres')->where("mailadres='$new_email'")->find();
                if ($row) {
                    Cookie::set('setok','mail3');
                } else {
                    //ucenter 修改邮箱
                    if (ET_UC==TRUE) {
                        $ucresult = uc_user_edit($this->my['user_name'],'','',$new_email,1);
                        if($ucresult!=1) {
                            Cookie::set('setok','mail2');
                            header('location:'.SITE_URL.'/Setting/mailauth');
                            exit;
                        }
                    }
                    //end
                    $data['mailadres']=$new_email;
                    $data['auth_email']=0;
                    $user->where("user_id='".$this->my['user_id']."'")->data($data)->save();
                    Cookie::set('setok','mail8');
                }
            } elseif ($new_email==$this->my['mailadres']){
                Cookie::set('setok','mail4');
            } else {
                Cookie::set('setok','mail5');
            }
        }
        header('location:'.SITE_URL.'/Setting/mailauth');
    }

    public function doauth() {
        $_authmsg=daddslashes($_GET['auth']);
        $authmsg=base64_decode($_authmsg);
        $tem=explode(":",$authmsg);
        $send_id=$tem[0];
        $user=D('Users');

        $row = $user->field('auth_email')->where("user_id='$send_id'")->find();
        $auth_email=$row['auth_email'];
        if ($_authmsg==$auth_email) {
            $data['auth_email']=1;
            $user->where("user_id='$send_id'")->data($data)->save();
            Cookie::set('setok','mail6');
        } else {
            Cookie::set('setok','mail7');
        }
        header('location:'.SITE_URL.'/Setting/mailauth');
    }

    public function theme() {
        $theme=D('Usertemplates');
        $tmdata = $theme->where("isopen=1")->order("ut_id")->select();
        $this->assign('theme',$tmdata);
        $this->assign('menu','theme');
        $this->display();
    }

    public function dotheme() {
        $bgcolor=trim($_POST['bg']);
        $textcolor=trim($_POST['text']);
        $links=trim($_POST['links']);
        $sidebarcl=trim($_POST['sidebarcl']);
        $sidebox=trim($_POST['sidebox']);
        $pictype=$_POST['pictype'];
        $newbgurl=$_POST['newbgurl'];

        if ($_FILES['bgpicture']['name']) {  //上传背景图
            import("@.ORG.UploadFile");
            $upload = new UploadFile();
            $upload->maxSize  = 2097152 ;
            $upload->allowExts  = explode(',','jpg,gif,png,jpeg');
            $upload->savePath =  './Public/attachments/photo/';
            $upload->thumb =  true;
            $upload->thumbPrefix   =  'theme_,thumb_';
            $upload->thumbMaxWidth =  '1280,112';
            $upload->thumbMaxHeight = '1280,72';
            $upload->subType = 'date';
            $upload->autoSub = true;
            $upload->suofang = '0,1';
            $upload->saveRule = time;
            $upload->thumbRemoveOrigin = true;
            if($upload->upload()) {
                $uploadList = $upload->getUploadFileInfo();

                $pictype=$pictype?$pictype:"center";
                $bgurl='photo/'.date('Ymd').'/thumb_'.$uploadList[0]['savename'];
            } else {
                echo "<script>alert('".$upload->getErrorMsg()."');location.href='".SITE_URL."/Setting/theme'</script>";
                exit;
            }
        }
        $newbgurl=$bgurl?$bgurl:$newbgurl;
        $newbgurl=daddslashes($newbgurl);

        $user=D('Users');
        $data['theme_bgcolor']=$bgcolor;
        $data['theme_pictype']=$pictype;
        $data['theme_text']=$textcolor;
        $data['theme_link']=$links;
        $data['theme_sidebar']=$sidebarcl;
        $data['theme_sidebox']=$sidebox;
        $data['theme_bgurl']=$newbgurl;
        $user->where("user_id='".$this->my['user_id']."'")->data($data)->save();

        Cookie::set('setok','theme1');
        header('location:'.SITE_URL.'/Setting/theme');
    }

    public function dltheme() {
        import("@.ORG.zip");
        $pre=C('DB_PREFIX');

        $theme_bgcolor = $this->my['theme_bgcolor']?$this->my['theme_bgcolor']:"#d3edfa";
        $theme_pictype = $this->my['theme_pictype']?$this->my['theme_pictype']:"left";
        $theme_text    = $this->my['theme_text']?$this->my['theme_text']:"#000000";
        $theme_link    = $this->my['theme_link']?$this->my['theme_link']:"#0066cc";
        $theme_sidebar = $this->my['theme_sidebar']?$this->my['theme_sidebar']:"#e2f2da";
        $theme_sidebox = $this->my['theme_sidebox']?$this->my['theme_sidebox']:"#b2d1a3";
        $isimg         = $this->my['theme_bgurl']?1:0;

        //文件内容和地址
        $filecont="INSERT INTO {$pre}usertemplates (theme_bgcolor,theme_pictype,theme_text,theme_link,theme_sidebar,theme_sidebox,theme_upload) VALUES ('$theme_bgcolor','$theme_pictype','$theme_text','$theme_link','$theme_sidebar','$theme_sidebox','$isimg')";
        $sqlfile=ET_ROOT."/Public/attachments/downtheme/theme.sql";
        $flname="Public/attachments/downtheme/theme_".$this->my['user_id'].".zip";

        //写入sql文件
        @unlink($sqlfile);
        $fp=fopen($sqlfile,"a");
        fwrite($fp,$filecont);
        fclose($fp);

        //文件列表
        if ($isimg) {
            $bgimgthumb=ET_ROOT."/Public/attachments/".$this->my['theme_bgurl'];
            $bgimg=thumb2theme($bgimgthumb);
            $files=array($bgimg,$bgimgthumb,$sqlfile);
        } else {
            $files=array($sqlfile);
        }

        //压缩
        if(is_array($files)){
            $zip = new zipfile();
            foreach($files as $file) {
                $this->listfiles($zip,$file);
            }
            $fp = fopen($flname, 'w');
            if(@fwrite($fp, $zip->file()) !== FALSE) {
                @unlink($sqlfile);
            }
            fclose($fp);
            header("location: ".str_replace('home.php','',SITE_URL)."/{$flname}");
        } else {
            Cookie::set('setok','theme2');
            header('location:'.SITE_URL.'/Setting/theme');
        }
    }

    private function listfiles($ZIP,$dir="."){
        if(is_file("$dir")){
            if(realpath($ZIP ->gzfilename)!=realpath("$dir")){
                $ZIP -> addfile(implode('',file("$dir")),basename($dir));
            }
        }
    }
}
?>