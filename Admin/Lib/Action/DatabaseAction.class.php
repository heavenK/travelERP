<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename DatabaseAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class DatabaseAction extends Action {
    var $_startrow;
    var $_bakcomplete;
    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $model=new Model();
        $pre=C('DB_PREFIX');
        $table = $model->query("SHOW TABLE STATUS LIKE '$pre%'");

        $this->assign('table',$table);
        $this->assign('position','数据库管理 -> 数据库备份');
        $this->display();
    }

    public function export() {
        $model=new Model();
        $pre=C('DB_PREFIX');
        $filename=$_REQUEST['filename'];
        $expottype=$_REQUEST['expottype'];
        $usezip=$_REQUEST['usezip'];
        $volume=$_REQUEST['volume'];
        $sizelimit=intval($_REQUEST['sizelimit']);
        $sizelimit=$sizelimit<=0?2048:$sizelimit;
        $tableid = intval($_REQUEST['tableid']);
        $startfrom = intval($_REQUEST['startfrom']);
        $extendin = intval($_REQUEST['extendin']);

        if(!$filename || preg_match("/(\.)(exe|jsp|asp|aspx|cgi|fcgi|pl)(\.|$)/i", $filename)) {
            msgreturn('很抱歉，备份的文件名有误',SITE_URL.'/admin.php?s=/Database');
		}

        if($expottype == 'exportall') {
            $table = $model->query("SHOW TABLE STATUS LIKE '$pre%'");
            foreach($table as $val) {
                $tables[]=$val['Name'];
            }
		} else {
            $tables=$_POST['tables'];
        }

        if( !is_array($tables) || empty($tables)) {
            msgreturn('很抱歉，您还没有选择要备份的数据表',SITE_URL.'/admin.php?s=/Database');
        }

        $volume = intval($volume) + 1;
		$idstring = '# Identify: '.base64_encode(date('Y-m-d H:i:s').",".ET_VESION.",$volume")."\n";
        $sqldump = '';

        $this->_bakcomplete = TRUE;
        for(; $this->_bakcomplete && $tableid < count($tables) && strlen($sqldump) + 500 < $sizelimit * 1000; $tableid++) {
            $sqldump .= $this->sqldumptable($tables[$tableid],$sizelimit,$extendin,$startfrom, strlen($sqldump));
            if($this->_bakcomplete) {
                $startfrom = 0;
            }
        }

        $filename=str_replace(array('/', '\\', '.'), '', $filename);
        $backupfilename=ET_ROOT.'/Public/backup/'.$filename;
        $dumpfile = $backupfilename."-%s".'.sql';
        @unlink($dumpfile);

	    !$this->_bakcomplete && $tableid--;
        if(trim($sqldump)) {
            $sqldump = "$idstring".
                "# <?exit();?>\n".
                "# EasyTalk Multi-Volume Data Dump Vol.".$volume."\n".
                "# Version: EasyTalk ".ET_VESION."\n".
                "# Time: ".date('Y-m-d H:i:s')."\n".
                "# Table Prefix: ".$pre."\n".
                "#\n".
                "# EasyTalk Home: http://www.nextsns.com\n".
                "# Please visit our website for newest infomation about EasyTalk\n".
                "# --------------------------------------------------------\n\n\n".
                "$setnames".
                $sqldump;
            $dumpfilename = sprintf($dumpfile, $volume);
            @$fp = fopen($dumpfilename, 'wb');
            @flock($fp, 2);
            @touch('./Public/backup/index.htm');
            if(@!fwrite($fp, $sqldump)) {
                @fclose($fp);
                msgreturn('很抱歉，'.$sqldump.' 文件不可写入！',SITE_URL.'/admin.php?s=/Database');
            } else {
                fclose($fp);
                if($usezip == 1) {
                    import("@.ORG.zip");
                    $zip = new zipfile();
                    $zipfilename = str_replace('.sql','',$dumpfilename).'.zip';
                    $this->listfiles($zip,$dumpfilename);
                    $fp = fopen($zipfilename, 'w');
                    if(@fwrite($fp, $zip->file()) !== FALSE) {
                        @unlink($dumpfilename);
                    }
                    fclose($fp);
                }
                unset($sqldump, $zip);
                msgreturn('数据库第 '.$volume.' 卷备份成功，页面自动跳转！',SITE_URL.'/admin.php?s=/Database/export&filename='.rawurlencode($filename).'&expottype='.rawurlencode($expottype).'&usezip='.$usezip.'&volume='.$volume.'&sizelimit='.$sizelimit.'&startfrom='.rawurlencode($this->_startrow).'&tableid='.rawurlencode($tableid).'&extendin='.$extendin);
            }
        } else {
            $volume--;
            for($i = 1; $i <= $volume; $i++) {
                $filename = sprintf($usezip == 1 ? $backupfilename."-%s".'.zip' : $dumpfile, $i);
                $filelist .= "<p>$filename</p>";
            }
            msgreturn('数据库备份完成'.str_replace(ET_ROOT,'',$filelist),SITE_URL.'/admin.php?s=/Database');
        }
    }
    private function sqldumptable($table, $sizelimit ,$extentin,$startfrom = 0, $currsize = 0) {
        $offset = 300;
        $tabledump = '';
        $tablefields = array();

        $query = mysql_query("SHOW FULL COLUMNS FROM $table", 'SILENT');
        if(!$query && mysql_errno() == 1146) {
            return;
        } else {
            while($fieldrow = mysql_fetch_array($query)) {
                $tablefields[] = $fieldrow;
            }
        }
        if(!$startfrom) {
            $tabledump = "DROP TABLE IF EXISTS `$table`;\n";
            $query = mysql_query("SHOW CREATE TABLE ".$table);
            $data=mysql_fetch_array($query);
            $create=$data['Create Table'];
            $create=str_replace('CREATE TABLE','CREATE TABLE IF NOT EXISTS',$create);
            $tabledump .= $create.";\n\n";
        }

        $tabledumped = 0;
        $numrows = $offset;
        $firstfield = $tablefields[0];

        if ($extentin==0) {
            while($currsize + strlen($tabledump) + 500 < $sizelimit * 1000 && $numrows == $offset) {
                if($firstfield['Extra'] == 'auto_increment') {
                    $selectsql = "SELECT * FROM $table WHERE $firstfield[Field] > $startfrom LIMIT $offset";
                } else {
                    $selectsql = "SELECT * FROM $table LIMIT $startfrom, $offset";
                }
                $tabledumped = 1;
                $rows = mysql_query($selectsql);
                $numfields = mysql_num_fields($rows);
                $numrows = mysql_num_rows($rows);
                while($row = mysql_fetch_row($rows)) {
                    $comma = $t = '';
                    for($i = 0; $i < $numfields; $i++) {
                        $t .= $comma.'\''.mysql_escape_string($row[$i]).'\'';
                        $comma = ',';
                    }
                    if(strlen($t) + $currsize + strlen($tabledump) + 500 < $sizelimit * 1000) {
                        if($firstfield['Extra'] == 'auto_increment') {
                            $startfrom = $row[0];
                        } else {
                            $startfrom++;
                        }
                        $tabledump .= "INSERT INTO `$table` VALUES ($t);\n";
                    } else {
                        $this->_bakcomplete = FALSE;
                        break 2;
                    }
                }
            }
        } else {
            while($currsize + strlen($tabledump) + 500 < $sizelimit * 1000 && $numrows == $offset) {
                if($firstfield['Extra'] == 'auto_increment') {
                    $selectsql = "SELECT * FROM $table WHERE $firstfield[Field] > $startfrom LIMIT $offset";
                } else {
                    $selectsql = "SELECT * FROM $table LIMIT $startfrom, $offset";
                }
                $tabledumped = 1;
                $rows = mysql_query($selectsql);
                $numfields = mysql_num_fields($rows);
                if($numrows = mysql_num_rows($rows)) {
                    $t1 = $comma1 = '';
                    while($row = mysql_fetch_row($rows)) {
                        $t2 = $comma2 = '';
                        for($i = 0; $i < $numfields; $i++) {
                            $t2 .= $comma2.'\''.mysql_escape_string($row[$i]).'\'';
                            $comma2 = ',';
                        }
                        if(strlen($t1) + $currsize + strlen($tabledump) + 500 < $sizelimit * 1000) {
                            if($firstfield['Extra'] == 'auto_increment') {
                                $startfrom = $row[0];
                            } else {
                                $startfrom++;
                            }
                            $t1 .= "$comma1 ($t2)";
                            $comma1 = ',';
                        } else {
                            $tabledump .= "INSERT INTO $table VALUES $t1;\n";
                            $this->_bakcomplete = FALSE;
                            break 2;
                        }
                    }
                    $tabledump .= "INSERT INTO $table VALUES $t1;\n";
                }
            }
        }
        $this->_startrow = $startfrom;
        $tabledump .= "\n";
        return $tabledump;
    }

    private function listfiles($ZIP,$dir="."){
        if(is_file("$dir")){
            if(realpath($ZIP ->gzfilename)!=realpath("$dir")){
                $ZIP -> addfile(implode('',file("$dir")),basename($dir));
            }
        }
    }

    public function import() {
        $exportlog = array();
		if(is_dir(ET_ROOT.'/Public/backup')) {
			$dir = dir(ET_ROOT.'/Public/backup');
			while($entry = $dir->read()) {
				$entry = './Public/backup/'.$entry;
				if(is_file($entry)) {
                    preg_match("/(.*?)-([0-9])\.(sql|zip)/i",basename($entry),$num);
					if($num[3]=='sql' || $num[3]=='zip') {
						$_exportlog[$num[1]][$num[2]] = array(
                            'num' => $num[2],
                            'type' => $num[3],
							'filename' => $entry,
							'dateline' => date('Y-m-d H:i',filemtime($entry)),
							'size' => round(filesize($entry)/1024, 2)
						);
					}
				}
			}
			$dir->close();
		}
        rsort($_exportlog);
        foreach ($_exportlog as $key=>$val) {
            sort($val);
            foreach ($val as $val2) {
                $exportlog[]=$val2;
            }
        }
        $this->assign('sqldata',$exportlog);
        $this->assign('position','数据库管理 -> 数据库还原');
        $this->display();
    }

    public function doimport() {
        $method = $_GET['method'];
        $sqlname = base64_decode($_GET['sqlfile']);
        $sqlfile = ET_ROOT.'/Public/backup/'.$sqlname;
        $model=new Model();

		if($method == 'serversql' || $method == 'serverzip') {
            if ($method == 'serverzip' && file_exists($sqlfile)) {
                import("@.ORG.zip");
                $unzip = new SimpleUnzip();
                $unzip->ReadFile($sqlfile);
                if($unzip->Count() == 0 || $unzip->GetError(0) != 0 || !preg_match("/\.sql$/i", $importfile = $unzip->GetName(0))) {
                    msgreturn('zip文件读取出错',SITE_URL.'/admin.php?s=/Database/import');
                }
                $sqlfilecount = 0;
                foreach($unzip->Entries as $entry) {
                    if(preg_match("/\.sql$/i", $entry->Name)) {
                        $fp = fopen('./Public/backup/'.$entry->Name, 'w');
                        fwrite($fp, $entry->Data);
                        fclose($fp);
                        $sqlfilecount++;
                    }
                }
                if(!$sqlfilecount) {
                    msgreturn('zip文件解压出错',SITE_URL.'/admin.php?s=/Database/import');
                }
                $sqlfile=str_replace('.zip','.sql',$sqlfile);
            }

            if($sqldump = @file($sqlfile)) {
                $sqldump=implode('',$sqldump);
                $identify = explode(',', base64_decode(preg_replace("/^# Identify:\s*(\w+).*/s", "\\1", $sqldump)));
                $dumpvolume = intval($identify[2]);
            } else {
                $this->deleteDir('./Home/Runtime/Data/site.php');//clearcache
                msgreturn('数据库备份文件导入完成！',SITE_URL.'/admin.php?s=/Database/import');
            }

            $sqlquery = $this->splitsql($sqldump);
			unset($sqldump);

			foreach($sqlquery as $sql) {
				if($sql != '') {
					$model->query($sql);
					if(mysql_error() && mysql_errno()!=1062) {
                        msgreturn('数据导入失败，错误原因：<br/>'.mysql_error(),SITE_URL.'/admin.php?s=/Database/import');
					}
				}
			}

            if ($method == 'serverzip') {
                @unlink($sqlfile);
            }

			$filenext = preg_replace("/-($dumpvolume)(\..+)$/", "-".($dumpvolume + 1)."\\2", $sqlname);

            msgreturn('已经成功导入第 '.$dumpvolume.' 卷备份，页面自动跳转！',SITE_URL.'/admin.php?s=/Database/doimport/sqlfile/'.base64_encode($filenext).'/method/'.$method);
		} else {
            msgreturn('未知的导入文件',SITE_URL.'/admin.php?s=/Database/import');
        }
    }

    private function splitsql($sql) {
        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach($queriesarray as $query) {
            $queries = explode("\n", trim($query));
            foreach($queries as $query) {
                $ret[$num] .= $query[0] == "#" ? NULL : $query;
            }
            $num++;
        }
        return($ret);
    }

    public function delimport() {
        $delete=$_REQUEST['delsql'];
        if(is_array($delete)) {
			foreach($delete as $filename) {
				@unlink('./Public/backup/'.str_replace(array('/', '\\'), '', $filename));
			}
		} else {
            @unlink('./Public/backup/'.str_replace(array('/', '\\'), '', base64_decode($delete)));
        }
        msgreturn('选定的文件删除成功',SITE_URL.'/admin.php?s=/Database/import');
    }

    public function downsql() {
        $filename=base64_decode($_GET['filename']);
        $file='./Public/backup/'.str_replace(array('/', '\\'), '', $filename);
        if (file_exists($file)){
            $filetype = trim(substr(strrchr($filename, '.'), 1));
            $filesize = filesize($file);
            header('Cache-control: max-age=31536000');
            header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
            header('Content-Encoding: none');
            header('Content-Length: '.$filesize);
            header('Content-Disposition: attachment; filename='.$filename);
            header('Content-Type: '.$filetype);
            readfile($file);
        } else {
            msgreturn('该文件不存在！',SITE_URL.'/admin.php?s=/Database/import');
        }
    }

    public function optimize() {
        $totalsize=0;
        $model=new Model();
        $pre=C('DB_PREFIX');
        $mysqlvs=$model->query('SELECT VERSION()');
        $tabletype = intval($mysqlvs[0]['VERSION()']) > '4.1' ? 'Engine' : 'Type';
        $table = $model->query("SHOW TABLE STATUS LIKE '$pre%'", 'SILENT');
        foreach($table as $val) {
            if($val['Data_free'] && $val[$tabletype] == 'MyISAM') {
                $checked = $val[$tabletype] == 'MyISAM' ? 'checked' : 'disabled';
                $tbdata[]=array(
                    "<input class=\"checkbox\" type=\"checkbox\" name=\"optimizetables[]\" value=\"$val[Name]\" $checked>",
                    $val['Name'],
                    $val[$tabletype],
                    $val['Rows'],
                    $val['Data_length'],
                    $val['Index_length'],
                    $val['Data_free'],
                );
                $totalsize += $val['Data_length'] + $val['Index_length'];
            }
        }

        $this->assign('tbdata',$tbdata);
        $this->assign('totalsize',$totalsize);
        $this->assign('position','数据库管理 -> 数据库优化');
        $this->display();
    }

    public function dooptimize() {
        $optimizetables = $_POST['optimizetables'];
        $pre=C('DB_PREFIX');
        $model=new Model();

        $table = $model->query("SHOW TABLE STATUS LIKE '$pre%'", 'SILENT');
        foreach($table as $val) {
            if(is_array($optimizetables) && in_array($val['Name'], $optimizetables)) {
                $model->query("OPTIMIZE TABLE $val[Name]");
            }
        }

        msgreturn('恭喜您，数据库优化成功',SITE_URL.'/admin.php?s=/Database/optimize');
    }

    private function deleteDir($dirName){
        if(!is_dir($dirName)){
            @unlink($dirName);
            return false;
        }
        $handle = @opendir($dirName);
        while(($file = @readdir($handle)) !== false){
            if($file != '.' && $file != '..'){
                $dir = $dirName . '/' . $file;
                is_dir($dir) ? $this->deleteDir($dir) : @unlink($dir);
            }
        }
        closedir($handle);
        return rmdir($dirName);
    }
}
?>