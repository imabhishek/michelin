<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE')	{
		
	t3lib_extMgm::addModule('web','txtcprojectM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
}


// Configure pagetype

$PAGES_TYPES[71] = array (
		'type' => "LLL:EXT:tcproject/locallang_db.xml:tx_tcproject_project",
		'icon' => t3lib_extMgm::extRelPath('tcproject')."projectSpace.gif",
		'allowedTables' => 'pages,tt_content',
		'onlyAllowedTables' => '1'
);
$TCA["pages"]["columns"]["doktype"]["config"]["items"][] = array(  
	0 => "LLL:EXT:tcproject/locallang_db.xml:tx_tcproject_project",
	1 => 71,
	2 => 'EXT:tcproject/projectSpace.gif'
);

$TCA['pages']['types']['71']['showitem'] = 'title;;;;2-2-2,--div--;LLL:typo3conf/ext_locallang.xml:tab_advanced;;;,doktype,--div--;LLL:typo3conf/ext_locallang.xml:tab_access;;;';


?>