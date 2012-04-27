<?php

class SystemguanliAction extends CommonAction{


    public function systemuser() {
		
		$navlist = "系统管理 > 系统用户";
		$this->assign('navlist',$navlist);
		
		$Glkehu = D('Glkehu');
		
		$type = $_POST['type'];
		$wheres = '';
		if (!empty($type)){
			$keyword = $_POST['tbKeyword'];
			if ($keyword){
				$wheres['_string'] = "user_name like '%".$keyword."%' OR realname like '%".$keyword."%' OR department like '%".$keyword."%'";
			}
		}
		//$wheres['usertype'] = '系统用户';
		$kehuAll = $Glkehu->where($wheres)->order("time desc")->findall();
		
		$glbasedata = D("glbasedata");
//		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
//		$this->assign('departmentAll',$departmentAll);
		$i = 0;
		foreach($kehuAll as $systemuser)
		{
			$mydepartment = $glbasedata->where("`id` = '$systemuser[department]'")->find();
			$kehuAll[$i]['department'] = $mydepartment['title'];
			$myjob = $glbasedata->where("`id` = '$systemuser[role]'")->find();
			$kehuAll[$i]['role'] = $myjob['title'];
			
			$i++;
		}
		$this->assign('kehuAll',$kehuAll);
		
		$this->setRDBC();
		
        $this->display();
    }
	
	private function setRDBC()
	{
		import ('@.ORG.RBAC');
		if($this->adminuser['user_name'] == 'tomature'){
		$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
		}
		if($this->adminuser['user_name'] == 'kkk'){
		$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
		}
		if($this->adminuser['user_name'] == 'aaa'){
		$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
		}
		if($this->adminuser['user_name'] == 'zhangwen'){
		$_SESSION[C('ADMIN_AUTH_KEY')]	= true;
		}
		$_SESSION[C('USER_AUTH_KEY')]	= $this->adminuser['user_id'];
		RBAC::saveAccessList();
		
	}
	


    public function adduser() {
		$navlist = "系统管理 > 系统用户 > 添加用户";
		$this->assign('navlist',$navlist);
		
		$gllvxingshe = D("gllvxingshe");
		$companyAll = $gllvxingshe->findall();
		$this->assign('companyAll',$companyAll);
		
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$this->assign('departmentAll',$departmentAll);
		
		$jobAll = $glbasedata->where("`type` = '职位'")->findall();
		$this->assign('jobAll',$jobAll);
		
        $this->display();
    }

    public function addusertosystem() {
		$gllvxingshe = D("gllvxingshe");
		$companyAll = $gllvxingshe->findall();
		$this->assign('companyAll',$companyAll);
		
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$this->assign('departmentAll',$departmentAll);
		
		$jobAll = $glbasedata->where("`type` = '职位'")->findall();
		$this->assign('jobAll',$jobAll);
		
        $this->display();
    }



    public function dopostadduser() {
		
		$postdata = $_POST;
		//检查
        $username=daddslashes(trim(strtolower($postdata['user_name'])));
        $pass1=daddslashes(trim($postdata['password']));
        $pass2=daddslashes(trim($postdata['repassword']));
        $mailadres=daddslashes(trim($postdata['email']));
        if(StrLenW2($username)>12 || StrLenW2($username)<3 || !$username) {
            $note =  "帐户名长度最多 6 个汉字或 12 个字符";
			justalert($note);
            $err = 1;
        }
        if (in_array($username,$deniedname)) {
            $note =   '账户名不能使用';
			justalert($note);
            $err = 1;
        }
		$uModel=D('Users');
        $user=$uModel->getUser("user_name='$username' OR mailadres='$mailadres'");
        if ($user) {
            $note =   "账户名或者邮箱地址已存在，不能使用";
			justalert($note);
            $err = 1;
        }
        if (StrLenW($pass1)<6 || StrLenW($pass1)>20) {
            $note =   "密码长度应该大于6个字符小于20个字符";
			justalert($note);
            $err = 1;
        }
        if ($pass1!=$pass2) {
            $note =   "两次输入的密码不一致";
			justalert($note);
            $err = 1;
        }
        if(!$mailadres) {
            $note =   "请填写电子邮件地址";
			justalert($note);
            $err = 1;
        }
        if(!strpos($mailadres,"@")) {
            $note =   "电子邮件格式不正确";
			justalert($note);
            $err = 1;
        }
		if($err)
		{
			$this->assign('postdata',$postdata);
			$this->display('adduser');
			exit;
		}
		$insert['user_name']=$username;
		$insert['nickname']=$username;
		$insert['password']=md5(md5($pass2));
		$insert['mailadres']=$mailadres;
		$insert['signupdate']=time();
		//$insert['isadmin']=1;
		$insert['userguide']=0;
		$insert['regmailauth']=1;
		
		$regid = $uModel->add($insert);
		//系统用户注册成功
		if($regid) {
			$Glkehu = D('Glkehu');
			$postdata['usertype'] = '系统用户';
			$postdata['addusername'] = $this->roleuser['user_name'];
			$postdata['editusername'] = $this->roleuser['user_name'];
			$postdata['time'] = time();
			$postdata['user_id'] = $regid;
			$Glkehu->add($postdata);
			//adminuser
			$Gladminuser = D('Gladminuser');
			$adminuser['user_id'] = $regid;
			$adminuser['user_name'] = $username;
			$Gladminuser->add($adminuser);
			//dump($Gladminuser);
			$rurl = SITE_ADMIN."Systemguanli/systemuser";
			doalert('添加成功',$rurl);
		}
		else
		{
            $note =   "注册失败";
			justalert($note);
			$this->assign('postdata',$postdata);
			$this->display('adduser');
		}
    }


    public function edituser() {
		
		$navlist = "系统管理 > 系统用户 > 修改用户信息";
		$this->assign('navlist',$navlist);
		
		$kehuID = $_GET['kehuID'];
		$Glkehu = D('Glkehu');
		$postdata = $Glkehu->where("`kehuID` = '$kehuID'")->find();
		$this->assign('postdata',$postdata);
		
		$gllvxingshe = D("gllvxingshe");
		$tcompany = $gllvxingshe->where("`lvxingsheID` = '$postdata[lvxingsheID]'")->find();
		$this->assign('tcompany',$tcompany);
		
		$companyAll = $gllvxingshe->findall();
		$this->assign('companyAll',$companyAll);
		
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$this->assign('departmentAll',$departmentAll);
		
		$mydepartment = $glbasedata->where("`id` = '$postdata[department]'")->find();
		$this->assign('mydepartment',$mydepartment);
		
		$jobAll = $glbasedata->where("`type` = '职位'")->findall();
		$this->assign('jobAll',$jobAll);
		
		$myjob = $glbasedata->where("`id` = '$postdata[role]'")->find();
		$this->assign('myjob',$myjob);
		
        $this->display();
    }



    public function dopostedituser() {
		
		$postdata = $_POST;
		$Glkehu = D('Glkehu');
		$kehu = $Glkehu->where("`kehuID` = '$postdata[kehuID]'")->find();
		
		$postdata['user_name'] = $kehu['user_name'];
		$postdata['editusername'] = $this->roleuser['user_name'];
		
		$Glkehu->save($postdata);
		
		$users = D('users');
		$user = $users->where("`user_name` = '$postdata[user_name]'")->find();
		$user['nickname'] = $postdata['realname'];
		$users->save($user);
		
		$rurl = SITE_ADMIN."Systemguanli/edituser/kehuID/".$postdata['kehuID'];
		doalert('修改成功',$rurl);
    }




    public function dopostaddusertosystem() {
		
		$postdata = $_POST;
		//检查
        $username=daddslashes(trim(strtolower($postdata['user_name'])));
        $mailadres=daddslashes(trim($postdata['email']));
		$uModel=D('Users');
        $user=$uModel->getUser("user_name='$username'");
        if (!$user) {
            $note =   "账户名不存在，添加失败";
			justalert($note);
            $err = 1;
        }
		$Glkehu=D('Glkehu');
        $kehuuser=$Glkehu->where("`user_name`='$username'")->find();
		
        if ($kehuuser) {
            $note =   "添加失败，该用户已经是系统用户";
			justalert($note);
            $err = 1;
        }
		if($err)
		{
			$this->assign('postdata',$postdata);
			$this->display('addusertosystem');
			exit;
		}
		//$user['isadmin']=1;
		$uModel->save($user);
		//系统用户注册成功
		$Glkehu = D('Glkehu');
		$postdata['email'] = $user['mailadres'];
		$postdata['usertype'] = '系统用户';
		$postdata['addusername'] = $this->roleuser['user_name'];
		$postdata['editusername'] = $this->roleuser['user_name'];
		$postdata['lianren'] = $postdata['realname'];
		$postdata['time'] = time();
		$postdata['user_id'] = $user['user_id'];
		$regid = $Glkehu->add($postdata);
		//adminuser
		$Gladminuser = D('Gladminuser');
		$adminuser['user_id'] = $user['user_id'];
		$adminuser['user_name'] = $user['user_name'];
		$Gladminuser->save($adminuser);
			
		
		if($regid) {
			$rurl = SITE_ADMIN."Systemguanli/systemuser";
			doalert('添加成功',$rurl);
		}
		else
		{
            $note =   "注册失败";
			justalert($note);
			$this->assign('postdata',$postdata);
			$this->display('addusertosystem');
		}
    }




    public function companyinfo() {
		$lvxingsheID = 1;
		$Gllvxingshe = D('Gllvxingshe');
		$postdata = $Gllvxingshe->where("`lvxingsheID` = '$lvxingsheID'")->find();
		
		$this->assign('postdata',$postdata);
        $this->display();
		
		
		
	}



    public function doposteditlvxingshe() {
		
		$postdata = $_POST;
		$postdata['lvxingsheID'] = 1;
		$postdata['admintype'] = '系统';
		$Gllvxingshe = D('Gllvxingshe');
		$lvxingshe = $Gllvxingshe->where("`lvxingsheID` = '$postdata[lvxingsheID]'")->find();
		$postdata['editusername'] = $this->roleuser['user_name'];
		
		$Gllvxingshe->save($postdata);
		$rurl = SITE_ADMIN."Systemguanli/companyinfo";
		doalert('修改成功',$rurl);
    }


    public function userlist() {
		$Glkehu = D('Glkehu');
		
		$type = $_POST['type'];
		$wheres = '';
		if (!empty($type)){
			$keyword = $_POST['tbKeyword'];
			if ($keyword){
				$wheres['_string'] = "user_name like '%".$keyword."%' OR realname like '%".$keyword."%' OR department like '%".$keyword."%'";
			}
		}
		$wheres['usertype'] = '系统用户';
		
		$kehuAll = $Glkehu->where($wheres)->order("time desc")->findall();
		$this->assign('kehuAll',$kehuAll);
        $this->display();
		
    }


    public function powermanage() {
		$Glkehu = D('Glkehu');
		$kehu = $Glkehu->where("`user_name` = '$_GET[user_name]'")->find();
		
		$Gladminuser = D('Gladminuser');
		$adminuser = $Gladminuser->where("`user_name` = '$kehu[user_name]'")->find();
		$this->assign('adminuser',$adminuser);
		$this->assign('adminpool',$adminuser['adminpool']);
		$this->assign('adminlevel',$adminuser['adminlevel']);
		$this->assign('department_list',unserialize($adminuser['department_list']));
		
		$adminuserkehu = $Glkehu->where("`user_name` = '$adminuser[edituser]'")->find();
		$this->assign('adminuserkehu',$adminuserkehu);
		
		$gllvxingshe = D('gllvxingshe');
		$companyAll = $gllvxingshe->where("`admintype` = '隶属'")->findall();	
		$companyinfo = $gllvxingshe->where("`lvxingsheID` = '$kehu[lvxingsheID]'")->find();	
		$this->assign('companyinfo',$companyinfo);
		$this->assign('companyAll',$companyAll);
		//获得部门列表
		$glbasedata = D('glbasedata');
		$departmentAll = $glbasedata->where("`type` = '部门'")->order('title desc')->findall();
		$this->assign('departmentAll',$departmentAll);
		
		
		$dep = $glbasedata->where("`id` = '$kehu[department]'")->find();
		$role = $glbasedata->where("`id` = '$kehu[role]'")->find();
		$kehu['department'] = $dep['title'];
		$kehu['role'] = $role['title'];
		$this->assign('kehu',$kehu);
        $this->display();
		
    }


	public function dopostSystemguanli()
	{
		$postdata = $_POST;	
		$Gladminuser = D('Gladminuser');
		$adminuser = $Gladminuser->where("`user_name` = '$postdata[user_name]'")->find();
		
		if(!$adminuser)
		{
			$rurl = SITE_ADMIN."Systemguanli";
			doalert('powermanage错误',$rurl);
		}
		foreach($postdata['itemlist'] as $item){
			if($adminpool)
			$adminpool .= ','.$item;
			else
			$adminpool .= $item;
		}
		$adminuser['adminpool'] = $adminpool;
		$adminuser['edituser'] = $this->adminuser['user_name'];
//		$saveinfo['adminuserID'] = $adminuser['adminuserID'];
//		$saveinfo['adminpool'] = $adminuser['adminpool'];
//		$saveinfo['edituser'] = $this->adminuser['user_name'];
		$Gladminuser = D('Gladminuser');
		$Gladminuser->save($adminuser);
		$rurl = SITE_ADMIN."Systemguanli/powermanage/user_name/".$postdata[user_name];
		doalert('修改成功',$rurl);
	}






	public function resetpwd()
	{
		
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		if($item['itemlist'] == null){
			doalert('没有选择','');
		}
		else
		{
			foreach($item['itemlist'] as $userID){
				$pass2 = '123123';
				$uModel=D('Users');
				$insert['user_id']= $userID;
				$insert['password']=md5(md5($pass2));
				$uModel->save($insert);
				
			}
		}
		doalert('密码已重置为123123','');
	}



	public function doislock()
	{
		if($_GET['type'] == null)
			doalert('错误','');
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		if($item['itemlist'] == null){
			doalert('没有选择','');
		}
		else
		{
			foreach($item['itemlist'] as $userID){
				$glkehu = D('glkehu');
				$data['islock'] = $_GET['type'];
				$glkehu->where("`user_id` = '$userID'")->save($data);
			}
		}
		doalert('设置成功'.$_GET['type'],'');
	}




	public function dopostadminlevel()
	{
		$postdata = $_POST;	
		$Gladminuser = D('Gladminuser');
		$adminuser = $Gladminuser->where("`user_name` = '$postdata[user_name]'")->find();
		if(!$adminuser)
		{
			$glkehu = D('glkehu');
			$roleuser = $glkehu->where("`user_name` = '$postdata[user_name]'")->find();
			if(roleuser){
				$newrecord['user_id'] = $roleuser['user_id'];
				$newrecord['user_name'] = $roleuser['user_name'];
				$Gladminuser->add($newrecord);
			}
			else	
			doalert('powermanage错误','');
		}
		
		foreach($postdata['itemlist'] as $item){
			if($adminlevel)
			$adminlevel .= ','.$item;
			else
			$adminlevel .= $item;
			
			if($item == '门市操作员')
			$isuse = 1;
		}

		$adminuser['adminlevel'] = $adminlevel;
		$adminuser['edituser'] = $this->roleuser['user_name'];
		$Gladminuser = D('Gladminuser');
		
		$adminuser['department_list'] = serialize($postdata['department_list']);
		
		$Gladminuser->save($adminuser);
		
		if($postdata['lvxingsheID'] != null && $isuse == 1){
			$glkehu = D('glkehu');
			$kehu = $glkehu->where("`user_name` = '$postdata[user_name]'")->find();
			$kehu['lvxingsheID'] = $postdata['lvxingsheID'];
			$glkehu->save($kehu);
		}
		
		$rurl = SITE_ADMIN."Systemguanli/powermanage/user_name/".$postdata[user_name];
		doalert('修改成功',$rurl);
	}



	public function deleteadmin()
	{
		$postdata = $_POST;
		foreach($_POST as $key => $value ){
			$item[$key] = $value;
		}
		if($item['itemlist'] == null){
			doalert('没有选择','');
		}
		else
		{
			foreach($item['itemlist'] as $userID){
				$Gladminuser = D('Gladminuser');
				$Gladminuser->where("`user_id` = '$userID'")->delete();
				
				$glkehu = D('glkehu');
				$glkehu->where("`user_id` = '$userID'")->delete();
			}
		}
		doalert('权限删除成功'.$_GET['type'],'');
	}




	public function locuslist()
	{
		$navlist = "权限管理 > 用户轨迹";
		$this->assign('navlist',$navlist);
		
		$gltempmessage = D('gltempmessage');
		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',30);
		$count = $gltempmessage->where($condition)->count();
		$p= new Page($count,100);
		//$rurl = SITE_ADMIN."Systemguanli/locuslist/p/";
		$page = $p->show();
        $messageAll = $gltempmessage->where($condition)->order("messageID DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
		$this->assign('page',$page);
		$this->assign('messageAll',$messageAll);
		$this->display();
		
		
	}



	public function newsnoticelist()
	{
		$navlist = "权限管理 > 系统管理 > 新闻公告";
		$this->assign('navlist',$navlist);
		
		$glmessage = D('glnews');
		
		//搜索
		foreach($_GET as $key => $value)
		{
			if($key == 'p')
			break;
			$condition[$key] = array('like','%'.$value.'%');
			$this->assign($key,$value);
		}
		$condition['type'] = '新闻公告';

		//查询分页
        import("@.ORG.Page");
        C('PAGE_NUMBERS',30);
		$count = $glmessage->where($condition)->count();
		$p= new Page($count,20);
		//$rurl = SITE_ADMIN."Systemguanli/newsnoticelist/p/";
		$page = $p->show();
        $messageAll = $glmessage->where($condition)->order("messageID DESC")->limit($p->firstRow.','.$p->listRows)->select();
		
		$this->assign('page',$page);
		$this->assign('messageAll',$messageAll);
		$this->display();
		
		
	}



	public function addnewsnotice()
	{
		$navlist = "权限管理 > 系统管理 > 添加新闻公告";
		$this->assign('navlist',$navlist);
		
		$glkehu = D("glkehu");
		$userAll = $glkehu->findall();
		$this->assign('userAll',$userAll);
		
		$messageID = $_GET['messageID'];
		$glmessage = D("glnews");
		$message = $glmessage->where("`messageID` = '$messageID'")->find();
		
		//拆分部门
		$jieshoutype_arr = explode(',',$message['jieshoutype']);
		$this->assign('jieshoutype_arr',$jieshoutype_arr);
		$this->assign('newsnotice',$message);
		
		$glbasedata = D("glbasedata");
		$departmentAll = $glbasedata->where("`type` = '部门'")->findall();
		$this->assign('departmentAll',$departmentAll);
		
		$this->display();
		
	}
	
	public function delnewsnotice()
	{
		
		$messageID = $_GET['messageID'];
		$glmessage = D("glnews");
		$message = $glmessage->where("`messageID` = '$messageID'")->delete();
		
		if ($message)
			doalert('删除成功！',SITE_ADMIN.'Systemguanli/newsnoticelist');
		else
			doalert('删除失败！',SITE_ADMIN.'Systemguanli/newsnoticelist');
	}



	public function dopostnewsnotice()
	{
		
		foreach($_POST as $key => $value)
		{
			$postdata[$key] = $value;
		}
		$postdata['time'] = time();
		//$postdata['islock'] = '未锁定';
		$postdata['username'] = $this->roleuser['user_name'];
		
		if($postdata['jieshouname']!=null)
		{
			$glkehu = D("glkehu");
			$kehu = $glkehu->where("`user_name` = '$postdata[jieshouname]'")->find();
			$postdata['realname'] = $kehu['realname'];
		}else{
			$postdata['realname'] = '';
		}
		
//		foreach($postdata['department'] as $department)
//		{
//				$postdata['jieshoutype'] = $department.
//		}
		
		if(!$postdata['title'])
		{
			justalert("请填写标题");
			gethistoryback();		
		}
		
		//合并接收部门
		$postdata['jieshoutype'] = implode(',',$postdata['jieshoutype']);
		
		$glmessage = D("glnews");
		if($postdata['messageID']!=null)
			$glmessage->save($postdata);
		else{
			$glmessage->add($postdata);
		}
			
		doalert('发布成功',SITE_ADMIN.'Systemguanli/newsnoticelist');
		
	}


	
	public function loglist()
	{
		$dir = getcwd();
		if($_GET['type'] == '轨迹'){
			$dir.='/data/log/';
			$dirpath = 'data/log/';
		}
		else{
			$dir.='/data/record/';
			$dirpath = 'data/record/';
		}
		
		$fileAll = getDirFiles($dir);
		
		$i=0;
		foreach($fileAll as $fileone){
			$b= '.txt'; 
			$c=explode($b,$fileone); 
			if(count($c)>1){
				foreach($c as $a){
					if($a){
						$filename = $dir.$a.'.txt';
						$fileList[$i]['dirpath'] = $dirpath;
						$fileList[$i]['localpath'] = $filename;
						$fileList[$i]['filename'] = $a.'.txt';
						$i++;
					}
				}
			}
		}
		$this->assign('fileList',$fileList);
		$this->assign('navlist','系统管理 > 日志下载 > '.$_GET['type'].'记录');
		
		$this->display();
		
	}
	
	
	public function logdownload()
	{	
		
		$filename=$_GET['link'];
		import("ORG.Net.Http"); 
		Http::download($filename); 
		

	}



	function cleantuntime()
	{
		$this->display('Error/showmsg');
		$dir = getcwd();
		
		$dijieruntime = $dir.'/GulianDijie/Runtime';
		dump($dijieruntime);
		deltree($dijieruntime);
		
		$dijieruntime = $dir.'/GulianAdmin/Runtime';
		dump($dijieruntime);
		deltree($dijieruntime);
		
		$dijieruntime = $dir.'/GulianMenshi/Runtime';
		dump($dijieruntime);
		deltree($dijieruntime);
		
		$dijieruntime = $dir.'/RbacAdmin/Runtime';
		dump($dijieruntime);
		deltree($dijieruntime);
		
	}


	public function copydownload()
	{
		$this->display('Error/showmsg');
		if($_GET['copy'] == 1){
			@unlink('data.zip');
			compressionDir('data','data.zip');
		}
		echo '<br/><a href="'.SITE_ADMIN.'Systemguanli/copydownload/copy/1">点击备份压缩data文件夹！！</a>';
		
		if(file_exists('data.zip'))
			echo '<br/><a href="'.ET_URL.'/data.zip">点击下载！！</a>';

	}


	public function leaderpaituan()
	{
		$navlist = "系统管理 > 系统管理 > 领队排团表";
		$this->assign('navlist',$navlist);
		
		$condition['type'] = '排团表';
		
		$glbasedata = D("glbasedata");
		import("@.ORG.Page");
		C('PAGE_NUMBERS',10);
		$count = $glbasedata->where($condition)->count();
		$p = new Page ( $count, 10 ); 
		$datalist=$glbasedata->limit($p->firstRow.','.$p->listRows)->where($condition)->order('value desc')->findAll(); 
		$p->setConfig('header','篇记录');
        $p->setConfig('prev',"上一页");
        $p->setConfig('next','下一页');
        $p->setConfig('first','首页');
        $p->setConfig('last','末页'); 
		$page = $p->show (SITE_ADMIN.'Systemguanli/leaderpaituan/p/');
        $this->assign ( "page", $page );
        $this->assign ( "datalist", $datalist );
		
		
        $this->display();
		
	}
	
	

	public function newpaituan()
	{
		$navlist = "系统管理 > 系统管理 > 新建排团表";
		$this->assign('navlist',$navlist);
		$id = $_GET['id'];
		if($id){
		$glbasedata = D("glbasedata");
		$data = $glbasedata->where("`id` = '$id' and `type` = '排团表'")->find();
		$this->assign('data',$data);
		}
        $this->display();
	}
	
	
	public function dopostnewpaituan()
	{
		foreach($_POST as $key => $value){
			$data[$key] = $value;
		}
		$data['type'] = '排团表';
		foreach($_FILES as $key => $value){
			$uplod = _dofileuplod();
			if($_FILES[$key]['name'] && $uplod != null)
			$data[$key] = $uplod;
			elseif($_FILES[$key]['name'] && $uplod == null)
			justalert('副本上传失败');
		}
		
		$glbasedata = D("glbasedata");
		if($data['id']){
			$data['edituser'] = $this->roleuser['user_name'];
			$olddata = $glbasedata->where("`id` = '$data[id]'")->find();
			if($olddata){
				unlink("data/".$olddata['pic_url']);
				$glbasedata->save($data);
			}
		}
		else{
			$data['pubdate'] = time();
			$data['adduser'] = $this->roleuser['user_name'];
			$data['edituser'] = $this->roleuser['user_name'];
			
			$glbasedata->add($data);
		}
        $this->redirect('/Systemguanli/leaderpaituan');
	}
	
	

	public function deletepaituan()
	{
		$id = $_GET['id'];
		if($id){
			$glbasedata = D("glbasedata");
			$data = $glbasedata->where("`id` = '$id'")->find();
			unlink("data/".$data['pic_url']);
			$glbasedata->where("`id` = '$id'")->delete();
		}
		doalert('删除成功','');
	}
	


	public function cleansystem()
	{
		
		if($this->roleuser['user_name'] != 'aaa'){
			$position = $_SERVER["PATH_INFO"];
			$this->display('Error/index');
			exit;
		}
		//线路与扩展表同步
//		$glxianlu = D('glxianlu');
//		$glxianlu_ext = D('glxianlu_ext');
//		$xianlu_extAll = $glxianlu_ext->findall();
//		foreach($xianlu_extAll as $xianlu_ext){
//			$haveone = $glxianlu->where("`xianluID` = '$xianlu_ext[xianluID]' and `guojing` = '境外'")->find();
//			if(!$haveone)
//				$glxianlu_ext->where("`xianlu_extID` = '$xianlu_ext[xianlu_extID]'")->delete();
//		}
		//线路价格同步
//		$glshoujia = D('glshoujia');
//		$shoujiaAll = $glshoujia->findall();
//		foreach($shoujiaAll as $shoujia){
//			$haveone = $glxianlu->where("`xianluID` = '$shoujia[xianluID]'")->find();
//			if(!$haveone)
//				$glxianlu->where("`xianluID` = '$xianlu[xianluID]'")->delete();
//		}
		//线路与用户同步，删除不存在用户的线路
//		$xianluAll = $glxianlu->findall();
//		$glkehu = D('glkehu');
//		foreach($xianluAll as $xianlu){
//			$haveone = $glkehu->where("`user_name` = '$xianlu[user_name]'")->find();
//			if(!$haveone)
//				$glxianlu->where("`xianluID` = '$xianlu[xianluID]'")->delete();
//		}
		//子团与线路同步
//		$glzituan = D("glzituan");
//		$zituanAll = $glzituan->findAll();
//		foreach($zituanAll as $zituan)
//		{
//			$haveone = $glxianlu->where("`xianluID` = '$zituan[xianluID]'")->find();
//			if(!$haveone)
//				$glzituan->where("`zituanID` = '$zituan[zituanID]'")->delete();
//		}
		//订单与子团同步,不存在子团的订单删除,准备状态团订单删除
//		$Gldingdan = D('gldingdan');
//		$dingdanAll = $Gldingdan->findall();
//		foreach($dingdanAll as $dingdan)
//		{
//			$zituan = $glzituan->where("`zituanID` = '$dingdan[zituanID]'")->find();
//			if(!$zituan){
//				$Gldingdan->where("`dingdanID` = '$dingdan[dingdanID]'")->delete();
//			}
//			elseif($zituan['zhuangtai'] != '报名' && $zituan['zhuangtai'] != '截止'){
//				$Gldingdan->where("`dingdanID` = '$dingdan[dingdanID]'")->delete();
//			}
//			
//		}
		
		//子团整体与线路创建用户名同步
//		$glzituan = D("glzituan");
//		foreach($xianluAll as $xianlu)
//		{
//			$zituanAll = $glzituan->where("`xianluID` = '$xianlu[xianluID]'")->findAll();
//			foreach($zituanAll as $zituan)
//			{
//				$zituan['user_name'] = $xianlu['user_name'];
//				$zituan['kind'] = $xianlu['kind'];
//				$glzituan->save($zituan);
//			}
//		}
		
		
		//地接团境外统一成国内和境外，增加kind的字段分类，国内和日本等。。。
/*		
		$dj_tuan = D("dj_tuan");
		$djtuanAll = $dj_tuan->findall();
		foreach($djtuanAll as $temp){
			if($temp['jingwai'] == '境外')
			{
				$temp['jingwai'] ='境外';
				$temp['kind'] ='日本';
			}
			else
				$temp['kind'] ='国内';
			$dj_tuan->save($temp);
			
		}
		
*/		
	
	
		//清理报账单，根据子团
/*		$glzituan = D("glzituan");
		$glbaozhang = D("glbaozhang");
		$baozhangAll = $glbaozhang->findAll();
		foreach($baozhangAll as $v)
		{
			$zituan = $glzituan->where("`zituanID` = '$v[zituanID]'")->find();
			if(!$zituan)
			{
				$glbaozhang->where("`baozhangID` = '$v[baozhangID]'")->delete();
			}
		}
*/	
		//清理报账单，根据地接团
//		$dj_tuan = D("dj_tuan");
//		$dj_baozhang = D("dj_baozhang");
//		$baozAll = $dj_baozhang->findAll();
//		foreach($baozAll as $v)
//		{
//			$djtuan = $dj_tuan->where("`djtuanID` = '$v[djtuanID]'")->find();
//			if(!$djtuan)
//			{
//				$glbaozhang->where("`baozhangID` = '$v[baozhangID]'")->delete();
//			}
//		}
		
		
		//订单type默认包团，根据user_name填写departmentID
//		$Gldingdan = D("dingdan_zituan");
//		$dingdanAll = $Gldingdan->findAll();
//		foreach($dingdanAll as $v)
//		{
//			if(!$v['type'])
//				$v['type'] = '包团';
//			$user = $glkehu->where("`user_name` = '$v[user_name]'")->find();
//				$v['departmentID'] = $user['department'];
//				$Gldingdan->save($v);
//		}
		//同步线路子团与创建人的部门与部门ID
//		$glbasedata = D("glbasedata");
//		$glkehu = D("glkehu");
//
//		$glxianlu = D("glxianlu");
//		$xianluall = $glxianlu->findall();
//		foreach($xianluall as $v){
//			$u = $glkehu->where("`user_name` = '$v[user_name]'")->find();
//			$d = $glbasedata->where("`id` = '$u[department]'")->find();
//			$v['departmentName'] = $d['title'];
//			$v['departmentID'] = $d['id'];
//			$glxianlu->save($v);
//		}
//
//		$glzituan = D("glzituan");
//		$xianluall = $glzituan->findall();
//		foreach($xianluall as $v){
//			$u = $glxianlu->where("`xianluID` = '$v[xianluID]'")->find();
//			$v['departmentName'] = $u['departmentName'];
//			$v['departmentID'] = $u['departmentID'];
//			$glzituan->save($v);
//		}
//
//		$dj_tuan = D("dj_tuan");
//		$xianluall = $dj_tuan->findall();
//		foreach($xianluall as $v){
//			$u = $glkehu->where("`user_name` = '$v[adduser]'")->find();
//			$d = $glbasedata->where("`id` = '$u[department]'")->find();
//			$v['departmentName'] = $d['title'];
//			$v['departmentID'] = $d['id'];
//			$dj_tuan->save($v);
//		}
//
//		$gldingdan = D("gldingdan");
//		$dingdanAll = $gldingdan->findall();
//		foreach($dingdanAll as $v){
//			$u = $glkehu->where("`user_name` = '$v[user_name]'")->find();
//			$d = $glbasedata->where("`id` = '$u[department]'")->find();
//			$v['departmentID'] = $d['id'];
//			$gldingdan->save($v);
//		}



		//同步订单审核
//		$Gldingdan = D("gldingdan");
//		$dall = $Gldingdan->findall();
//		foreach($dall as $v)
//		{
//			$v['check_status'] = '审核通过';
//			$Gldingdan->save($v);
//			}

		//同步提示消息来源
//		$glmessage = D("glmessage");
//		$glkehu = D("glkehu");
//		$glbasedata = D("glbasedata");
//		$dall = $glmessage->findall();
//		foreach($dall as $v)
//		{
//			$u = $glkehu->where("`user_name` = '$v[username]'")->find();
//			$v['departmentID'] = $u['department'];
//			$c = $glbasedata->where("`id` = '$v[departmentID]'")->find();
//			$v['departmentName'] = $c['title'];
//			$glmessage->save($v);
//		}

		//删除多余临时轨迹
//		$gltempmessage = D("gltempmessage");
//		$gltempmessage->where("`type` = '轨迹'")->delete();



		//同步提示消息来源
//		$glmessage = D("glmessage");
//		$mall = $glmessage->where("`content`= '提交审核申请'")->findall();
// 		foreach($mall as $v)
//		{
//			$v['status'] = '已忽略';
//			$glmessage->save($v);
//		}
		//删除临时订单
//		$Gldingdan = D("gldingdan");
//		$dall = $Gldingdan->findall();
//		foreach($dall as $v)
//		{
//			//if($v['user_name'] == 'aaa' || $v['user_name'] == 'bbb' || $v['user_name'] == 'eee' || $v['user_name'] == '')
//				$Gldingdan->where("`user_name` = 'aaa'")->delete();
//				$Gldingdan->where("`user_name` = 'bbb'")->delete();
//				$Gldingdan->where("`user_name` = 'eee'")->delete();
//				$Gldingdan->where("`user_name` = 'kkk'")->delete();
//				$Gldingdan->where("`user_name` is null")->delete();
//		}

/*
		//根据团员重置订单人数,及价格
		$Gldingdan = D("gldingdan");
		$gltuanyuan = D("gltuanyuan");
		
		$dall = $Gldingdan->findall();
		foreach($dall as $v)
		{
			$chengren = $gltuanyuan->where("`dingdanID` = '$v[dingdanID]' and `manorchild` = '成人'")->count();
			$ertong = $gltuanyuan->where("`dingdanID` = '$v[dingdanID]' and `manorchild` = '儿童'")->count();
			
			$v['chengrenshu'] = $chengren;
			$v['ertongshu'] = $ertong;
			$tuanyuanall = $gltuanyuan->where("`dingdanID` = '$v[dingdanID]'")->findall();
			$jiage = 0;
			foreach($tuanyuanall as $v)
			{
				$jiage += $v['jiaoqian'];
			}
			$v['jiage'] = $jiage;

			$Gldingdan->save($v);
		}
		
*/
		//线路同业开放
//		$glxianlu = D("glxianlu");
//		$x_a = $glxianlu->findall();
//		foreach($x_a as $v)
//		{
//			$v['openTongye'] = 0;
//			$v['openMenshi'] = 1;
//			$glxianlu->save($v);
//		}
//


		//根据用户重置线路旅行社ID
//		$glxianlu = D("glxianlu");
//		$glkehu = D("glkehu");
//		$x_a = $glxianlu->findall();
//		foreach($x_a as $v)
//		{
//			$u = $glkehu->where("`user_name` = '$v[user_name]'")->find();
//			$v['lvxingsheID'] = $u['lvxingsheID'];
//			$glxianlu->save($v);
//		}
//

		//重置订单状态
//	$gldingdan = D("gldingdan");
//	$ddall = $gldingdan->findall();
//	foreach($ddall as $v)
//	{
//		if($v['zhuangtai'] == '')
//			$v['zhuangtai'] = '占位';
//		$gldingdan->save($v);	
//	}
		//根据订单重置团员状态
		
//	$gldingdan = D("gldingdan");
//	$gltuanyuan = D("gltuanyuan");
//	$ddall = $gldingdan->findall();
//	foreach($ddall as $v)
//	{
//		
//		$tuanyuanall = $gltuanyuan->where("`dingdanID` = '$v[dingdanID]'")->findall();
//		foreach($tuanyuanall as $vb)
//		{
//				$vb['zhuangtai'] =  $v['zhuangtai'];
//			$gltuanyuan->save($vb);	
//		}
//	}
	
	
		//根据子团重置报账单,经办人
//	$gl_baozhang = D("gl_baozhang");
//	$glzituan = D("glzituan");
//	$baozhangall = $gl_baozhang->findall();
//	foreach($baozhangall as $v)
//	{
//		$zituan = $glzituan->where("`zituanID` = '$v[zituanID]'")->find();
//		
//		if(!$zituan)
//			$gl_baozhang->where("`zituanID` = '$v[zituanID]'")->delete();
//		else
//		{
//			$v['caozuoren'] = $zituan['user_name'];
//			$gl_baozhang->save($v);
//		}
//			
//		
//	}
	
	
		//团员内证件信息
//		$gltuanyuan = D("gltuanyuan");
//		$tuanyuanall = $gltuanyuan->findall();
//		foreach($tuanyuanall as $v)
//		{
//			if($v['huzhaohaoma'])
//			{
//				$v['zhengjiantype'] = '护照';
//				$v['zhengjianhaoma'] = $v['huzhaohaoma'];
//				$v['zhengjianyouxiaoqi'] = $v['hzyouxiaoriqi'];	
//			}
//			elseif($v['zhengjianhaoma'])
//			{
//				$v['zhengjiantype'] = '身份证';
//			}
//			$gltuanyuan->save($v);
//		}
	
	
	
		//根据报账单审核，重置子团状态
//	$gl_baozhang = D("gl_baozhang");
//	$glzituan = D("glzituan");
//	$baozhangall = $gl_baozhang->findall();
//	foreach($baozhangall as $v)
//	{
//		if($v['caiwuren'])
//		{
//			$zituan = $glzituan->where("`zituanID` = '$v[zituanID]'")->find();
//			$zituan['zhuangtai'] = '截止';
//			$glzituan->save($zituan);
//		}	
//	}
//	
//	$dj_baozhang = D("dj_baozhang");
//	$dj_tuan = D("dj_tuan");
//	$baozhangall = $dj_baozhang->findall();
//	foreach($baozhangall as $v)
//	{
//		if($v['financeperson'])
//		{
//			$djtuan = $dj_tuan->where("`djtuanID` = '$v[djtuanID]'")->find();
//			$djtuan['status'] = '截止';
//			$dj_tuan->save($djtuan);
//		}	
//	}
	
		//根据子团状态重置线路状态
//	$glzituan = D("glzituan");
//	$zituanall = $glzituan->Distinct(true)->field('xianluID')->select();
//	foreach($zituanall as $v)
//	{
//		F_xianlu_status_set($v['xianluID']) ;
//		
//	}
	
	
	
	
	
	
		echo "结束";
	}
	









}
?>