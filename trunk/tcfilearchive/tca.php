<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_tcfilearchive_content"] = array (
	"ctrl" => $TCA["tx_tcfilearchive_content"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "title,type,path"
	),
	"feInterface" => $TCA["tx_tcfilearchive_content"]["feInterface"],
	"columns" => array (
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:tcfilearchive/locallang_db.xml:tx_tcfilearchive_content.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"type" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:tcfilearchive/locallang_db.xml:tx_tcfilearchive_content.type",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:tcfilearchive/locallang_db.xml:tx_tcfilearchive_content.type.I.0", "0"),
					Array("LLL:EXT:tcfilearchive/locallang_db.xml:tx_tcfilearchive_content.type.I.1", "1"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"path" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:tcfilearchive/locallang_db.xml:tx_tcfilearchive_content.path",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "title;;;;2-2-2, type;;;;3-3-3, path")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);
?>