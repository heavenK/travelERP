<?php
class DebugAction extends Action {
	
	public function index() {
		
		//$file_path = 'F:\Myerp\travlERP\111.xlsx';
	
		//dump($_SERVER['HTTP_HOST']);

		//header ("Location: ".'http://www.4.com/111.xlsx');
           
		//exit;
		//$filename = 'F:\Myerp\travlERP\111.xlsx';
	


		A2("PHPExcel","Api")->wirteToExcel_21();
		//A2("PHPExcel","Api")->bzd_exl();
		
exit;

		//A2("PHPExcel","Api")->test2();
		
		
		//A2("PHPExcel","Api")->wirteToExcel($file_path);
		
		//A2("PHPExcel","Api")->test($file_path);
		
		//$file_path = 'F:\Myerp\travelERP\222.xlsx';
		//$this->PHPExcel_tofile($file_path);
		
	}

	
	
	
	
	
	
	
	
	
}
?>