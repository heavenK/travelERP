<?php
return array ( 0 => 'chanpinID', 1 => 'parentID', 2 => 'time', 3 => 'islock', 4 => 'user_name', 5 => 'departmentID', 6 => 'status', 7 => 'tuanhao', 8 => 'chutuanriqi', 9 => 'baomingjiezhi', 10 => 'renshu', 11 => 'adultxiuzheng', 12 => 'childxiuzheng', '_autoinc' => false, '_type' => array ( 'chanpinID' => 'int(11)', 'parentID' => 'int(11)', 'time' => 'int(11)', 'islock' => 'enum(\'未锁定\',\'锁定\')', 'user_name' => 'varchar(20)', 'departmentID' => 'int(11)', 'status' => 'enum(\'等待审核\',\'报名\',\'截止\',\'审核不通过\',\'准备\')', 'tuanhao' => 'varchar(50)', 'chutuanriqi' => 'varchar(50)', 'baomingjiezhi' => 'int(11)', 'renshu' => 'int(11)', 'adultxiuzheng' => 'int(11)', 'childxiuzheng' => 'int(11)', ), ); ?>