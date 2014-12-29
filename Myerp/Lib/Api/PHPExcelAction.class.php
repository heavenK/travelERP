<?php


class PHPExcelAction extends Action {
   


    public function _myinit() {
        
     }


    public function get_bzd_info($datatype,$relation,$where) {
        if($datatype == '子团'){
            //优化查询
            if($where){
                $class_name = 'ViewZituan';
                $order = 'chutuanriqi desc';
                $where = A("Method")->_orderZituan($where,$datatype);
            }
            $where['datatype'] = $datatype;
        }
        $where = A("Method")->_facade($class_name,$where);//过滤搜索项
        //$chanpin = D($class_name)->relation($relation)->where($where)->order($order)->select();
        //$chanpin = D($class_name)->where($where)->order($order)->select();
        dump(123123123);
        dump($where);
        dump($chanpin);
        dump($class_name);
        dump(D($class_name));
        //dump(D($class_name));
        exit;
        return  $chanpin;
    }


    public function bzd_exl($datalist='') {

        $filename = 'bzd.xlsx';

        /*处理数据*/
        /*项目*/
        $list['key'][] = '团号';
        $list['key'][] = '产品名称';
        $list['key'][] = '出团日期';
        $list['key'][] = '操作人';
        $list['key'][] = '操作部门';
        $list['key'][] = '名额';
        //$list['key'][] = '报名数';
        //$list['key'][] = '剩余';
        //$list['key'][] = '收入款';
        //$list['key'][] = '支出款';
        //$list['key'][] = '盈亏';
        /*数据*/
        foreach($datalist as $v){
                $dat['tuanhao'] = $v['tuanhao'];
                $dat['title_copy'] = $v['title_copy'];
                $dat['chutuanriqi'] = $v['chutuanriqi'];
                $dat['user_name'] = $v['user_name'];
                $dat['bumen_copy'] = $v['bumen_copy'];
                $dat['renshu'] = $v['renshu'];
                //$dat['bms'] = number_format($v['queren_num']).'/'.number_format($v['zhanwei_num']);
                //$dat['shengyu_num'] = $v['shengyu_num'];
                //$dat['yingshou_copy'] = number_format($v[baozhang]['yingshou_copy']);
                //$dat['yingfu_copy'] = number_format($v[baozhang]['yingfu_copy']);
                //$dat['yk'] = number_format($v[baozhang]['yingshou_copy']-$v[baozhang]['yingfu_copy']);
                $list['datalist'][] = $dat;
        }

        $this->wirteToExcel($list,$filename);

    }




    public function wirteToExcel($data,$filename='') {

        import('Lib.ORG.PHPExcel.Classes.PHPExcel',APP_PATH,'.php');
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("neconano");
        
        // Add some data
        $n = 1;
        $k = 'A';
		$keylist = $data['key'];
		$datalist = $data['datalist'];
        foreach($keylist as $v){
            $objPHPExcel->setActiveSheetIndex(0)->setAutoSize(true)->setCellValue($k.$n, $v);
            $k++;
        }
       $n = '2';
       foreach($datalist as $vol){
            $k = 'A';
           foreach($vol as $val){
               $objPHPExcel->setActiveSheetIndex(0)->setAutoSize(true)->setCellValue($k.$n, $val);
               $k++;
           }
           $n++;
       }

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

		// Save Excel 2007 file
//		$callStartTime = microtime(true);
//		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//		$objWriter->save($file_path);

        // Save Excel 2007 file
        $callStartTime = microtime(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($filename);

        header ("Location: "."http://".$_SERVER['HTTP_HOST'].'/'.$filename);


    }









    public function test($file_path) {
        
        import('Lib.ORG.PHPExcel.Classes.PHPExcel',APP_PATH,'.php');
        
        // Create new PHPExcel object
        //echo date('H:i:s') , " Create new PHPExcel object<br>";
        $objPHPExcel = new PHPExcel();
        
        // Set document properties
        //echo date('H:i:s') , " Set document properties<br>";
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("PHPExcel Test Document")
        ->setSubject("PHPExcel Test Document")
        ->setDescription("Test document for PHPExcel, generated using PHP classes.")
        ->setKeywords("office PHPExcel php")
        ->setCategory("Test result file");
        
        
        // Add some data
        //echo date('H:i:s') , " Add some data<br>";
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Hello')
        ->setCellValue('B2', 'world!')
        ->setCellValue('C1', 'Hello')
        ->setCellValue('D2', 'world!');
        
        // Miscellaneous glyphs, UTF-8
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A4', 'Miscellaneous glyphs')
        ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
        
        
        $objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
        $objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);
        
        
        // Rename worksheet
        //echo date('H:i:s') , " Rename worksheet<br>";
        $objPHPExcel->getActiveSheet()->setTitle('Simple');
        
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        
        
        // Save Excel 2007 file
        //echo date('H:i:s') , " Write to Excel2007 format<br>";
        $callStartTime = microtime(true);
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        //$pt = 'F:\Myerp\travelERP\111.xlsx';
        
        $objWriter->save($file_path);
        //$callEndTime = microtime(true);
        //$callTime = $callEndTime - $callStartTime;
        
        //echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME));
        //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds<br>";
        // Echo memory usage
        //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB<br>";
        
        
        // Save Excel 95 file
        //echo date('H:i:s') , " Write to Excel5 format<br>";
        //$callStartTime = microtime(true);
        
        //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter->save(str_replace('.php', '.xls', __FILE__));
        //$callEndTime = microtime(true);
        //$callTime = $callEndTime - $callStartTime;
        
        //echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME));
        //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds<br>";
        // Echo memory usage
        //echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB<br>";
        
        
        // Echo memory peak usage
        //echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB<br>";
        
        // Echo done
        //echo date('H:i:s') , " Done writing files<br>";
        //echo 'Files have been created in ' , getcwd();        
        
        
    
    
    }




public function test2(){

		import('Lib.ORG.PHPExcel.Classes.PHPExcel',APP_PATH,'.php');
        //require_once dirname(__FILE__) . '/../ORG/PHPExcel/Classes/PHPExcel.php';



		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");
		
		
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Hello')
					->setCellValue('B2', 'world!')
					->setCellValue('C1', 'Hello')
					->setCellValue('D2', 'world!');
		
		// Miscellaneous glyphs, UTF-8
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A4', 'Miscellaneous glyphs')
					->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="01simple.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;

}










}
