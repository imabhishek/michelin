<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Claus Bruun <cb@typoconsult.dk>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


	// DEFAULT initialization of a module [BEGIN]
unset($MCONF);
require_once('conf.php');
require_once($BACK_PATH.'init.php');
require_once($BACK_PATH.'template.php');

$LANG->includeLLFile('EXT:tcproject/mod1/locallang.xml');
require_once(PATH_t3lib.'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]



/**
 * Module 'Project Space' for the 'tcproject' extension.
 *
 * @author	Claus Bruun <cb@typoconsult.dk>
 * @package	TYPO3
 * @subpackage	tx_tcproject
 */
class  tx_tcproject_module1 extends t3lib_SCbase {
	
	var $pageinfo;

	
	
	/**
	 * Create a new project space
	 *
	 * @return	boolean success
	 */
	function createSpace()	{

		// Change title on this
		$newTitle = trim(t3lib_div::_GP('title'));
		if($newTitle != "") {

			// Use the TCEmain for copying the template
			$tce = t3lib_div::makeInstance('t3lib_TCEmain');
			$tce->stripslashes_values = 0;
			$tce->copyTree = 4;
			$tce->copyWhichTables = "*";
			$cmd['pages'][$this->templateUid]['copy'] = -1 * $this->templateUid;
			$tce->start(array(), $cmd);
			$tce->process_cmdmap();

			// This is our new page
			$newPage = $tce->copyMappingArray_merged['pages'][$this->templateUid];
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery("pages", "uid='" . $newPage . "'", array('title' => $newTitle, 'hidden' => 0));
			
			t3lib_BEfunc::getSetUpdateSignal('updatePageTree');
			
			// Redirect to edit mode
			$goTo = $this->doc->backPath . 'alt_doc.php?returnUrl=' . rawurlencode(t3lib_div::getIndpEnv("REQUEST_URI"));
			$goTo .= '&edit[pages][' . $newPage . ']=edit';

			// All good: redirect to edit page
			header('Location: ' . $goTo);
			exit();
			
		} else {
			 $this->error[] = $GLOBALS['LANG']->getLL('titleError');
			return false;	
		}

		
		
		return true;
	}
	
	
	/**
	 * Render the success message with information about the newly created space
	 *
	 * @return	string the information
	 */
	function renderSpaceInfo() {
		return "<br><b>" . t3lib_div::_GP('title') . "</b> " . $GLOBALS['LANG']->getLL('information');
	}
	

	
	
	/**
	 * Render the formula for creating a space
	 *
	 * @return	string the form
	 */
	function renderForm()	{

		$fields[] = $this->renderField( $GLOBALS['LANG']->getLL('settings'), 'divider', '');
		$fields[] = $this->renderField( $GLOBALS['LANG']->getLL('spaceTitle'), 'text', 'title');
	
		if(count($this->error) > 0) {
			$form .= "<span style='display:block;color:red;font-weight:bold;padding:10px;'>" .
							 implode("<br />", $this->error) . 
					 "</span>";	
		}

		$form .= "<form action=" . t3lib_div::getThisUrl() . "><table border='0' cellpadding='7'>";
		$form .= implode("\n", $fields);
		$form .= "<tr><td colspan='2' align='right'>" .
				 "<input type='hidden' name='formPosted' value='1'>" . 
				 "<input type='submit' value='" . $GLOBALS['LANG']->getLL('createSpace') . "'></td></tr></table></form>";

		return $form;
	}
	
	


	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$label: field label
	 * @param	string		$type: field type
	 * @param	string		$name: filed name
	 *
	 * @return	The content that is displayed on the website
	 */
	function renderField($label, $type, $name) {

		switch($type) {
	
			case 'divider':
				$field =  "<tr><td colspan='2'><b>" . $label . "</b></td></tr>";
			break;
	
			default:
				$field =  "<input type='" . $type . "' name='" . $name . "' value='" . t3lib_div::_GP($name) . "'>";
				$field =  "<tr><td>" . $label . "</td><td>" . $field . "</td></tr>";
		}

		return $field;
	}






	
	
	/**
	 * check that the configured tmpl page exists 
	 * @return	void
	 */
	function checkTemplatePage()	{
		
		// Get the record
		$template = t3lib_BEfunc::getRecord('pages', $this->templateUid);

		if($template['doktype'] != '71') {
			return false;	
		}
		
		return true;
	}
	
	
	
	/**
	 * Initializes the Module
	 * @return	void
	 */
	function init()	{
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
		parent::init();
	}

	
	
	/**
	 * Main function of the module. Write the content to $this->content
	 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
	 *
	 * @return	[type]		...
	 */
	function main()	{
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

		// Access check!
		// The page will show only if there is a valid page and if this page may be viewed by the user
		$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);

	
			// Draw the header.
		$this->doc = t3lib_div::makeInstance('mediumDoc');
		$this->doc->backPath = $BACK_PATH;
		$this->doc->form='<form action="" method="POST">';

			// JavaScript
		$this->doc->JScode = '
			<script language="javascript" type="text/javascript">
				script_ended = 0;
				function jumpToUrl(URL)	{
					document.location = URL;
				}
			</script>
		';
		$this->doc->postCode='
			<script language="javascript" type="text/javascript">
				script_ended = 1;
				if (top.fsMod) top.fsMod.recentIds["web"] = 0;
			</script>
		';

		$headerSection = $this->doc->getHeader('pages',$this->pageinfo,$this->pageinfo['_thePath']).'<br />'.$LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.path').': '.t3lib_div::fixed_lgd_pre($this->pageinfo['_thePath'],50);

		$this->content.=$this->doc->startPage($LANG->getLL('title'));
		$this->content.=$this->doc->header($LANG->getLL('title'));
		$this->content.=$this->doc->divider(5);

		// Render content:
		$this->moduleContent();

		// ShortCut
		if ($BE_USER->mayMakeShortcut())	{
			$this->content.=$this->doc->spacer(20).$this->doc->section('',$this->doc->makeShortcutIcon('id',implode(',',array_keys($this->MOD_MENU)),$this->MCONF['name']));
		}

		$this->content.=$this->doc->spacer(10);

	}
	

	/**
	 * Prints out the module HTML
	 *
	 * @return	void
	 */
	function printContent()	{

		$this->content.=$this->doc->endPage();
		echo $this->content;
	}

	
	/**
	 * Generates the module content
	 *
	 * @return	void
	 */
	function moduleContent() {

		// Check that we can get the template page
		$this->templateUid = intval($GLOBALS['MCONF']['uidOfTemplate']);
		
		if(!$this->checkTemplatePage()) {
			return $GLOBALS['LANG']->getLL('errorNoTemplate');
		}

		// What to do?
		if(t3lib_div::_GP('formPosted')) {
			if($this->createSpace()) {
				$this->content .= $this->renderSpaceInfo();
			} else {
				$this->content .= $this->renderForm();
			}
		} else {
			$this->content .= $this->renderForm();	
		}
	}
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tcproject/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tcproject/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_tcproject_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>