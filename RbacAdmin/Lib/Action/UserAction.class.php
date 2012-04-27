<?php
// 后台用户模块
class UserAction extends CommonAction {
	function _filter(&$map){
		$map['user_name'] = array('like',"%".$_POST['account']."%");
	}

    public function role()
    {
        //读取系统的用户列表
        $user    =   D("glkehu");
		$list2=$user->field('user_id,user_name')->findAll();
		foreach ($list2 as $vo){
			$userList[$vo['user_id']]	=	$vo['user_name'];
		}
		
		$this->assign('userList',$userList);
		$group    =   D("Role");
        $list=$group->field('id,name')->findAll();
		foreach ($list as $vo){
			$groupList[$vo['id']]	=	$vo['name'];
		}
		$this->assign("groupList",$groupList);

        //获取当前用户组信息
        $userId =  isset($_GET['id'])?$_GET['id']:'';
		$userGroupList = array();
		if(!empty($userId)) {
			$this->assign("selectUserId",$userId);
			//获取当前用户的组列表.
			$list	=	$group->query('select b.id,b.name from role_user as a ,role as b where a.role_id=b.id and  a.user_id='.$userId.' ');

			foreach ($list as $vo){
				$userGroupList[$vo['id']]	=	$vo['id'];
			}

		}
		$this->assign('userGroupList',$userGroupList);
		
        $this->display();

        return;
    }

    public function setRole()
    {
        $id     = $_POST['userGroupId'];
		$userId	=	$_POST['userId'];
		
		$group_user    =   D("Role_user");
		
		$group_user->where("`user_id` = $userId")->delete();
		
		foreach($id as $groupId){
			$datas['role_id'] = $groupId;
			$datas['user_id'] = $userId;
			
			$result = $group_user->add($datas);
		}
		
		//$group->delGroupUser($groupId);
		//$result = $group->setGroupUsers($groupId,$id);
		if($result===false) {
			$this->error('授权失败！');
		}else {
			$this->success('授权成功！');
		}
    }

	protected function addRole($userId) {
		//新增用户自动加入相应权限组
		$RoleUser = M("RoleUser");
		$RoleUser->user_id	=	$userId;
        // 默认加入网站编辑组
        $RoleUser->role_id	=	3;
		$RoleUser->add();
	}

    //重置密码
    public function resetPwd()
    {
    	$id  =  $_POST['id'];
        $password = $_POST['password'];
        if(''== trim($password)) {
        	$this->error('密码不能为空！');
        }
        $User = M('User');
		$User->password	=	md5($password);
		$User->id			=	$id;
		$result	=	$User->save();
        if(false !== $result) {
            $this->success("密码修改为$password");
        }else {
        	$this->error('重置密码失败！');
        }
    }
}
?>