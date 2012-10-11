<?php
return array(
    'core'         =>   array(
        THINK_PATH.'Common/functions.php', // 标准模式函数库
        CORE_PATH.'Core/Log.class.php',    // 日志处理类
//        CORE_PATH.'Core/Dispatcher.class.php', // URL调度类
        CORE_PATH.'Core/App.class.php',   // 应用程序类
//        CORE_PATH.'Core/Action.class.php', // 控制器类
        CORE_PATH.'Core/View.class.php',  // 视图类
			
			
//        CORE_PATH.'Core/Behavior.class.php',  
//        CORE_PATH.'Core/Cache.class.php',  
//        CORE_PATH.'Core/Db.class.php', 
//        CORE_PATH.'Core/Think.class.php',  
//        CORE_PATH.'Core/ThinkException.class.php',  
//        CORE_PATH.'Core/Widget.class.php',  
			
        MODE_PATH.'Mycore/Action.class.php',
		MODE_PATH.'Mycore/Model.class.php',	
		MODE_PATH.'Mycore/RelationModel.class.php',
        MODE_PATH.'Mycore/Db.class.php',
		
        MODE_PATH.'Mycore/Dispatcher.class.php', // URL调度类
    ),


);