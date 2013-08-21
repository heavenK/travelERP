<?php

class VIPAction extends CommonAction{
	
    public function _myinit() {
		$this->assign("navposition",'会员管理');
	}
	
	
    public function index() {
		A("Method")->showDirectory("会员列表");
		$this->display('index');
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
        if ($inputFileName == '')
			A("Method")->ajaxUploadResult($_REQUEST,'文件未选择！',0);
        if (pathinfo($inputFileName,PATHINFO_EXTENSION) != 'csv')
			A("Method")->ajaxUploadResult($_REQUEST,'文件类型错误！',0);
		if(false === $this->is_file_encode_utf8($inputFileName))
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
				dump($record);
				dump($VIP);
				A("Method")->ajaxUploadResult($_REQUEST,'备份失败！',0);
			}
			//解析
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$consume['consume']['bank_type'] = $company['title'];
			foreach($sheetData as $v){
				$consume['consume']['cardNo'] = $v['A'];
				$consume['consume']['name'] = $v['B'];
				$consume['consume']['IDtype'] = $v['C'];
				$consume['consume']['IDNo'] = $v['D'];
				$consume['consume']['transactionNo'] = $v['E'];
				$consume['consume']['consumeAmount'] = $v['F'];
				$consume['consume']['consumeTime'] = $v['G'];
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
		if($string === iconv('UTF-8', 'UTF-8',  iconv('UTF-8', 'UTF-8', $string)))  return true;  
		return false;  
	}
	
	
	
	
	
}
?>