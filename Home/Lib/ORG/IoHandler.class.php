<?php
class IoHandler
{
	function IoHandler()
	{
	}

	function Compare($file1, $file2)
	{
		if (md5_file($file1) == md5_file($file2))
		{
			Return true;
		}
		else
		{
			Return false;
		}
	}

	function SizeConvert($filesize)
	{
		if ($filesize >= 1073741824)
		{
			$filesize = round($filesize / 1073741824 , 2) . "G";
		}elseif ($filesize >= 1048576)
		{
			$filesize = round($filesize / 1048576, 2) . "M";
		}elseif ($filesize >= 1024)
		{
			$filesize = round($filesize / 1024, 2) . "k";
		}
		else
		{
			$filesize = $filesize . "b";
		}
		Return $filesize;
	}
	function ConvertSize($filesize)
	{
		Return IoHandler::SizeConvert($filesize);
	}

	function ReadDir($dir, $children = 0)
	{
		if(is_dir($dir) === false)Return false;;
		$dir = rtrim(str_replace("\\", "/", $dir), "/") ;
		$dirfp = @opendir($dir);
		if ($dirfp === false)
		{
			trigger_error("{$dir}目录名不存在或者无效,请检查您的目录设置!<br>", E_USER_NOTICE);
			Return false;
		}
		while (false !== ($file = readdir($dirfp)))
		{
			if ($file != '.' and $file != '..')
			{
				$abspath = $dir . '/' . $file;
				if (is_file($abspath) !== false)
				{
					$files[] = $abspath ;
				}
				if(is_dir($abspath) !== false)
				{
					if ($children == '1')
					{
						$files = array_merge((array) $files, (array) IoHandler::ReadDir($abspath, $children));
					}
				}
			}
		}
		closedir($dirfp);
		return (array) $files;
	}

	function ReadFile($file_name)
	{
		if (is_readable($file_name) != false)
		{
			if (function_exists('file_get_contents') != false)
			{
				$file_contents = file_get_contents($file_name);
				Return $file_contents;
			}
			else
			{
				$file_handler = @fopen($file_name, 'r');
				if ($file_handler)
				{
					$file_contents = @fread($file_handler, filesize($file_name));
					fclose($file_handler);
					Return $file_contents;
				}
				else
				{
					Return false;
				}
			}
		}
		else
		{
			Return false;
		}
	}

	function WriteFile($file_name, $file_contents, $mode = 'wb')
	{
		if (($mode == 'w' || $mode == 'wb') && function_exists('file_put_contents'))
		{
			Return file_put_contents($file_name, $file_contents);
		}
		else
		{
			$file_handler = @fopen($file_name, $mode);
			if ($file_handler)
			{
				$len=fwrite($file_handler, $file_contents);
				fclose($file_handler);
				Return $len;
			}
			else
			{
				Return false;
			}
		}
	}


	function GetDiskList()
	{
		if (strpos(PHP_OS, 'WIN') === false)
		{
			Return false;
		}
		$disks = range('c', 'w');
		foreach($disks as $disk)
		{
			$disk = $disk . ":";
			if (is_dir($disk) !== false && disk_total_space($disk) > 0)
			{
				$disk_list[] = $disk;
			}
		}
		Return $disk_list;
	}

	function GetDiskSpace($disk_name, $convert_size = false)
	{
		if (is_dir($disk_name) === false)
		{
			Return false;
		}
		$disk_space['total'] = (float)disk_total_space($disk_name);
		$disk_space['free'] = (float)disk_free_space($disk_name);
		$disk_space['used'] = $disk_space['total'] - $disk_space['free'];
		@$disk_space['percent'] = (float)round($disk_space['used'] / $disk_space['total'] * 100);
		if ($convert_size === false)
		{
			Return $disk_space;
		}
		$disk_space['total'] = IoHandler::ConvertSize($disk_space['total']);
		$disk_space['free'] = IoHandler::ConvertSize($disk_space['free']);
		$disk_space['used'] = IoHandler::ConvertSize($disk_space['used']);
		$disk_space['percent'] = $disk_space['percent'] . '%';
		Return $disk_space;
	}

	function GetPatternFiles($path, $pattern)
	{
		if (is_dir($path) == false)
		{
			Return false;
		}
		$file_pattern = rtrim($path, '/') . "/"."*.{" . str_replace("|", ",", $pattern) . "}";
		$file_list = glob($file_pattern, GLOB_BRACE);
		if (count($file_list) == 0)
		{
			Return false;
		}
		Return $file_list;
	}

	function CopyFile($from, $to)
	{
		$copy_count = 0;

		if (is_string($from))
		{
			if (copy($from, $to . '/' . IoHandler::BaseName($from)))
			{
				$copy_count = 1;
				Return $copy_count;
			}
		}
		else
		{
			if (is_array($from))
			{
				if (is_dir($to) == false)
				{
					if (IoHandler::MakeDir($to) == false)
					{
						Return $copy_count;
					}
				}
				foreach($from as $file_name)
				{
					if (copy($file_name, $to . '/' . IoHandler::BaseName($file_name)))
					{
						$copy_count++;
					}
				}
			}
		}
		Return $copy_count;
	}


	function DeleteFile($file)
	{

		if('' == trim($file)) return ;

		$delete = @unlink($file);

				clearstatcache();
		$filesys = eregi_replace("/","\\",$file);
		if(is_file($filesys) and file_exists($filesys))
		{
			$delete = @system("del $filesys");
			clearstatcache();
			if(file_exists($file))
			{
				$delete = @chmod($file, 0777);
				$delete = @unlink($file);
				$delete = @system("del $filesys");
			}
		}
		clearstatcache();
		if(file_exists($file))
		{
			return false;
		}
		else
		{
			return true;
		}
	}


	function MakeDir($dir_name, $mode = 0777)
	{
		if(false!==strpos($dir_name,'\\'))
    	{
    		$dir_name = str_replace("\\", "/", $dir_name);
    	}
    	if(false!==strpos($dir_name,'/'.'/'))
    	{
    		$dir_name = preg_replace("#(/"."/+)#", "/", $dir_name);
    	}
    	if (is_dir($dir_name))
    	{
    		return true;
    	}

        $dirs = '';
        $_dir_name = $dir_name;
    	$dir_name = explode("/", $dir_name);
        if('/'==$_dir_name{0})
        {
            $dirs = '/';
        }

    	foreach($dir_name as $dir)
    	{
    		$dir = trim($dir);
            if ('' != $dir)
            {
                $dirs .= $dir;

                if ('..' == $dir || '.' == $dir)
                {

                    $dirs .= '/';

                    continue;
                }
            }
            else
            {
                continue;
            }

            $dirs .= '/';

            if (!is_dir($dirs))
    		{
    			if(!mkdir($dirs, $mode))
    			{
    				return false;
    			}
    		}
    	}
    	return true;
	}


	function ClearDir($dir_name)
	{
		clearstatcache();
		if(is_dir($dir_name) == false)Return false;
		$dir_handle = opendir($dir_name);
		while(($file = readdir($dir_handle)) !== false)
		{
			if($file != '.' and $file != "..")
			{
				clearstatcache();
				if(is_dir($dir_name . '/' . $file))
				{
					IoHandler::RemoveDir($dir_name . '/' . $file);
				}
				if(is_file($dir_name . '/' . $file))
				{
					@unlink($dir_name . '/' . $file);
				}
			}
		}
		closedir($dir_handle);
		Return true;
	}


	function RemoveDir($dir_name)
	{
		clearstatcache();
		if(is_dir($dir_name) == false)Return false;
		$dir_handle = opendir($dir_name);
		while(($file = readdir($dir_handle)) !== false)
		{
			if($file != '.' and $file != "..")
			{
				clearstatcache();
				if(is_dir($dir_name . '/' . $file))
				{
					IoHandler::RemoveDir($dir_name . '/' . $file);
				}
				if(is_file($dir_name . '/' . $file))
				{
					IoHandler::DeleteFile($dir_name . '/' . $file);
				}
			}
		}
		closedir($dir_handle);
		rmdir($dir_name);
		Return true;
	}

	function CopyDir($from, $to, $children = true)
	{
		if(is_dir($from) == false)Return false;
		if(is_dir($to) == false)
		{
			if(IoHandler::MakeDir($to) == false)
			{
				Return false;
			}
		}
		$from_handle = opendir($from);
		while(($file = readdir($from_handle)) !== false)
		{
			if($file != '.' and $file != '..')
			{
				$from_abs_path = $from . '/' . $file;
				$to_abs_path = $to . '/' . $file;
				if(is_dir($from_abs_path) != false and $children == true)
				{
					IoHandler::MakeDir($to_abs_path);
					IoHandler::CopyDir($from_abs_path, $to_abs_path, $children);
				}
				if(is_file($from_abs_path) != false)
				{
					if(copy($from_abs_path, $to_abs_path) == false)
					{
						Return false;
					}
				}
			}
		}
		closedir($from_handle);
		Return true;
	}

	function FilePermission($file_name)
	{
		Return substr(base_convert(fileperms($file_name), 10, 8), -4);
	}

	function BaseName($path, $suffix = false)
	{
		$name = trim($path);
		$name = str_replace('\\', '/', $name);
		if(strpos($name, '/') !== false)
		{
			$name = substr(strrchr($path, '/'), 1);
		}
		else
		{
			$name = ltrim($path, '.');
		}
		if($suffix)
		{
			$suffix = strrchr($name, '.');
			$name = str_replace($suffix, '', $name);
		}
		return $name;
	}

	function updateFileArray($file, $name, $array)
	{

		$out = "<?php\n";
		foreach($array as $key => $val)
		{
			$out .= "\${$name}['{$key}'] = '{$val}';\n";
		}
		$out .= '?>';
		if(IoHandler::WriteFile($file, $out, "wb"))
		{
			Return true;
		}
		else
		{
			Return false;
		}
	}

	function ReadDiskSpace($drive)
	{
		$disk_space['size']['total'] = disk_total_space($drive);
		$disk_space['size']['free'] = disk_free_space($drive);
		$disk_space['size']['used'] = $disk_space['size']['total'] - $disk_space['size']['free'];
		$disk_space['size_converted']['used'] = IoHandler::SizeConvert($disk_space['size']['total'] - $disk_space['size']['free']);
		$disk_space['size_converted']['total'] = IoHandler::SizeConvert($disk_space['size']['total']);
		$disk_space['size_converted']['free'] = IoHandler::SizeConvert($disk_space['size']['free']);
		Return $disk_space;
	}
}
?>