pfadmin
=======

a web admin tool for plain framework(use laravel administrator)

editor: zend studio, tab size: 4.

change the packet Laravel Administrator code: 
	file: \Frozennode\Administrator\Config\Model\Config.php
	changes: add before save config for it, same as settings config.
	file: \Frozennode\Administrator\Config\Settings\Config.php views\templates\edit.php
	changes: add a button for edit packet json data button, options add 'editdata'.

cn:
  更改了Laravel Administrator
  	文件：\Frozennode\Administrator\Config\Model\Config.php
  	改变：增加了保存前的回调，就像setting配置一样
  	file: \Frozennode\Administrator\Config\Settings\Config.php views\templates\edit.php
  	改变：增加了一个编辑网络包的json数据按钮
  	