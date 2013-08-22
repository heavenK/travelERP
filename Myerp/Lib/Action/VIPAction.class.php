<?php

class VIPAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'会员管理');
		if($this->user['title'] != 'aaa'){
			$role = A("Method")->_checkRolesByUser('业务','银行',1);
			if(!$role){
				$this->display('Index:error');
				exit;
			}
		}
	}
	
	
    public function index() {
		A("Method")->showDirectory("会员列表");
		$this->display('index');
    }
	
    public function uploadHistory() {
		$this->assign("navposition",'信息');
		A("Method")->showDirectory("上传记录查询");
		$ViewVIPRecord = D("ViewVIPRecord");
		$where['user_name'] = $this->user['title'];
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
		$count = $ViewVIPRecord->where($where)->count();
		$pagenum = 20;
		$p= new Page($count,$pagenum);
		$page = $p->show();
        $list = $ViewVIPRecord->where($where)->limit($p->firstRow.','.$p->listRows)->select();
		$data['list'] = $list;
		$data['page'] = $page;
		$this->assign("data",$data);
		$this->display('uploadHistory');
    }
	
	
	//获得记录
    public function bankFileUpload() {
		$this->assign("navposition",'信息');
		A("Method")->showDirectory("消费记录上传");
		$this->display('bankfileupload');
    }
	
	
	//获得记录
    public function dopost_bankFileUpload() {
		C('TOKEN_ON',false);
		Vendor ( 'Excel.PHPExcel' );
		$inputFileType = 'CSV';
		$inputFileName = $_FILES['attachment']['name'];
		$inputFile = $_FILES["attachment"]["tmp_name"];
        if ($inputFileName == '')
			A("Method")->ajaxUploadResult($_REQUEST,'文件未选择！',0);
        if (pathinfo($inputFileName,PATHINFO_EXTENSION) != 'csv')
			A("Method")->ajaxUploadResult($_REQUEST,'文件类型错误！',0);
		if(false === $this->is_file_encode_utf8($inputFile))
			A("Method")->ajaxUploadResult($_REQUEST,'文件非utf8编码！',0);
		//上传附件
		$savepath = './Data/BankFiles/'; 
		$ViewDepartment = D("ViewDepartment");
		$ComID = A("Method")->_getComIDbyUser();
		$company = $ViewDepartment->where("`systemID` = '$ComID'")->find();
		if($company['title'] == '中国银行')
			$savepath .= 'BankOfChina/';
		elseif($company['title'] == '中国农业银行')
			$savepath .= 'ABChina/';
		else
			A("Method")->ajaxUploadResult($_REQUEST,'银行配置错误！',0);
		//文件
		copy($_FILES["attachment"]["tmp_name"],$savepath.$inputFileName);
		if($filepath = A("Method")->_upload($savepath)){
			$VIP = D("VIP");
			//操作记录
			$record['record']['filename_upload'] = $inputFileName;
			$record['record']['filename_record'] = $filepath;
			$record['record']['bank_type'] = $company['title'];
			if(false === $VIP->relation("record")->myRcreate($record)){
				A("Method")->ajaxUploadResult($_REQUEST,'备份失败！',0);
			}
			//解析
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($savepath.$inputFileName);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$consume['consume']['bank_type'] = $company['title'];
			$ViewVIPConsume = D("ViewVIPConsume");
			foreach($sheetData as $v){
				$consume['consume']['cardNo'] = $v['A'];
				$consume['consume']['name'] = $v['B'];
				$consume['consume']['IDtype'] = $v['C'];
				$consume['consume']['IDNo'] = $v['D'];
				$consume['consume']['transactionNo'] = $v['E'];
				$consume['consume']['consumeAmount'] = $v['F'];
				$consume['consume']['consumeTime'] = $v['G'];
				//对比
				$where['transactionNo'] = $consume['consume']['transactionNo'];
				$tc = $ViewVIPConsume->where($where)->find();
				if($tc)
					continue;
				if(false === $VIP->relation("consume")->myRcreate($consume)){
					A("Method")->ajaxUploadResult($_REQUEST,'解析失败！',0);
				}
			}
			A("Method")->ajaxUploadResult($_REQUEST,'上传成功',1);
		}
		else
			A("Method")->ajaxUploadResult($_REQUEST,'上传失败！',0);
    }
	
	
	function is_file_encode_utf8($file){
		$string = file_get_contents($file);
		if(chr(239).chr(187).chr(191) == substr($string, 0, 3)) return true;  
		if($string === iconv('UTF-8', 'UTF-8',  iconv('UTF-8', 'UTF-8', $string)))  return true;  
		return false;  
//		$string = file_get_contents($file);  
//		if(chr(239).chr(187).chr(191) == substr($string, 0, 3)) return 'UTF-8 BOM';  
//		if($string === iconv('UTF-8', 'UTF-8',  iconv('UTF-8', 'UTF-8', $string)))  return 'UTF-8';  
//		if($string === iconv('UTF-8', 'ASCII',  iconv('ASCII', 'UTF-8', $string)))   return 'ASCII';  
//		if($string === iconv('UTF-8', 'GB2312', iconv('GB2312', 'UTF-8', $string)))  return 'GB2312';  
//		return '无法识别';		
	}
	
	
	
	
	
}
?>