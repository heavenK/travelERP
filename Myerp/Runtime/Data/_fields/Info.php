<?php
return array ( 0 => 'infoID', 1 => 'typeName', 2 => 'time', 3 => 'islock', 4 => 'user_name', 5 => 'user_id', 6 => 'departmentName', 7 => 'departmentID', 8 => 'status', 9 => 'title', '_autoinc' => true, '_pk' => 'infoID', '_type' => array ( 'infoID' => 'int(11)', 'typeName' => 'varchar(20)', 'time' => 'int(11)', 'islock' => 'enum(\'未锁定\',\'锁定\')', 'user_name' => 'varchar(20)', 'user_id' => 'int(11)', 'departmentName' => 'varchar(50)', 'departmentID' => 'varchar(50)', 'status' => 'varchar(50)', 'title' => 'varchar(255)', ), ); ?>