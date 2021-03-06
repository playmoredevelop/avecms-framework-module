<?php

if(!defined('BASE_DIR')) exit;

define('FW_MODULE_PATH', realpath(dirname(__FILE__)));
define('FW_MODULE_ALIAS', 'avecms_framework_module');

if (defined('ACP')) {
	$modul = [
		'ModuleName'			=> "Framework",
		'ModuleSysName'			=> "avecms_framework_module",
		'ModuleVersion'			=> FW_VERSION,
		'ModuleDescription'		=> "Управление и настройка фреймворка из админки. Генерация административных функций по моделям.",
		'ModuleAutor'			=> "Playmore",
		'ModuleCopyright'		=> "&copy; Playmore 2017",
		'ModuleStatus'			=> 1,
		'ModuleIsFunction'		=> 0,
		'ModuleTemplate'		=> 0,
		'ModuleAdminEdit'		=> 1,
		'ModuleFunction'		=> 'framework',
		'ModuleTag'				=> null,
		'ModuleTagLink'			=> null,
		'ModuleAveTag'			=> null,
		'ModulePHPTag'			=> null
	];
}

/*
array (
  'do' => 'modules',
  'action' => 'modedit',
  'mod' => 'framework',
  'moduleaction' => '1',
  'cp' => 'i3fdnsaca0p49l1p92hbqafsd6',
) */

$action = snippets()->request->get('moduleaction', false);

if($action AND defined('ACP')){
	
	($action === '1') AND $action = 'index';

	require 'admin.methods.php';

	$data = call_controller('admin.methods', $action);
	
	$render = snippets()->render;
		
	if(is_array($data)){
		foreach($data as $key => $value){
			$render->{$key} = $value;
		}
	}

	$filenames = [
		'content' => $action.'Action.php',
		'layout' => '_layout.view.php',
	];

	$path = FW_MODULE_PATH.'/views/';

	$render->content = $render->file($path.$filenames['content']);
	$render->action = $action;
	
	foreach([
		'author' => '&copy; Playmore 2018',
		'header' => 'Фреймворк',
	] as $key => $value){
		$render->{$key} = $value;
	}

	Framework\CMS::getAveTemplate()->assign('content', $render->file($path.$filenames['layout']));
}