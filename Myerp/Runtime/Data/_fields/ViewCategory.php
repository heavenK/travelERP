<?php
return array ( 0 => 'systemID', 1 => 'parentID', 2 => 'time', 3 => 'islock', 4 => 'user_name', 5 => 'departmentID', 6 => 'status', 7 => 'title', 8 => 'type', '_autoinc' => false, '_type' => array ( 'systemID' => 'int(11)', 'parentID' => 'int(11)', 'time' => 'int(11)', 'islock' => 'enum(\'未锁定\',\'锁定\')', 'user_name' => 'varchar(20)', 'departmentID' => 'int(11)', 'status' => 'enum(\'等待审核\',\'报名\',\'截止\',\'审核不通过\',\'准备\')', 'title' => 'varchar(30)', 'type' => 'varchar(30)', ), ); ?>