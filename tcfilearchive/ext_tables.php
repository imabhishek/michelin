<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$TCA["tx_tcfilearchive_content"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:tcfilearchive/locallang_db.xml:tx_tcfilearchive_content',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_tcfilearchive_content.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "title, type, path",
	)
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array('LLL:EXT:tcfilearchive/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');


t3lib_extMgm::addStaticFile($_EXTKEY,"pi1/static/","Filearchive");


if (TYPO3_MODE=="BE")	$TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_tcfilearchive_pi1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_tcfilearchive_pi1_wizicon.php';
?>