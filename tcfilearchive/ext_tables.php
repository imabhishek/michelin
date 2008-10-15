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
?>