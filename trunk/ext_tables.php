<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE')	{
		
	t3lib_extMgm::addModule('web','txtcprojectM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
}


// Configure pagetype

$PAGES_TYPES[71] = array (
		'type' => "LLL:EXT:tcblog2/locallang_db.xml:tx_tcproject_project",
		'icon' => t3lib_extMgm::extRelPath('tcproject')."projectSpace.gif",
		'allowedTables' => 'tt_content',
		'onlyAllowedTables' => '1'
);
$TCA["pages"]["columns"]["doktype"]["config"]["items"][] = array(  
	0 => "LLL:EXT:tcblog2/locallang_db.xml:tx_tcproject_project",
	1 => 71,
	2 => 'EXT:tcproject/projectSpace.gif'
);

$TCA['pages']['types']['71']['showitem'] = 'doktype;;;button;1-1-1, hidden, nav_hide, title;;;;2-2-2, --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, starttime, endtime, fe_login_mode, fe_group, extendToSubpages, --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended, tx_templavoila_ds;;;;1-1-1, tx_templavoila_to, tx_templavoila_next_ds, tx_templavoila_next_to, tx_templavoila_flex;;;;1-1-1';




?>