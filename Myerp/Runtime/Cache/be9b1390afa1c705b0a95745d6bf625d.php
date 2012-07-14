<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript" src="__PUBLIC__/myerp/Thinkjs/Form/CheckForm_GP.js"></script>
    <div id="resultdiv" class="resultdiv"></div>
    <div id="resultdiv_2" class="resultdiv"></div>

  <form name="form1" id="form1">
    <input type="text" name="id" check="^\S+$" warning="id不能为空,且不能含有空格">
    <input type="button" onClick="CheckForm('form1','resultdiv_2')" />
    </form>