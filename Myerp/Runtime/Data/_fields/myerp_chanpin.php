<?php
return array ( 0 => 'chanpinID', 1 => 'typeID', 2 => 'typeName', 3 => 'time', 4 => 'islock', 5 => 'vlaue', 6 => 'user_name', 7 => 'user_id', 8 => 'ispub', 9 => 'departmentName', 10 => 'departmentID', 11 => 'status', 12 => 'title', '_autoinc' => true, '_pk' => 'chanpinID', '_type' => array ( 'chanpinID' => 'int(11)', 'typeID' => 'int(11)', 'typeName' => 'varchar(20)', 'time' => 'int(11)', 'islock' => 'enum(\'未锁定\',\'锁定\')', 'vlaue' => 'int(11)', 'user_name' => 'varchar(20)', 'user_id' => 'int(11)', 'ispub' => 'enum(\'未发布\',\'已发布\')', 'departmentName' => 'varchar(50)', 'departmentID' => 'varchar(50)', 'status' => 'enum(\'等待审核\',\'报名\',\'截止\',\'审核不通过\',\'准备\')', 'title' => 'varchar(255)', ), ); ?>