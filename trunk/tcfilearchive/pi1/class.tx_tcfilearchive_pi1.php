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

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Filearchive' for the 'tcfilearchive' extension.
 *
 * @author	Claus Bruun <cb@typoconsult.dk>
 * @package	TYPO3
 * @subpackage	tx_tcfilearchive
 */
class tx_tcfilearchive_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_tcfilearchive_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_tcfilearchive_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'tcfilearchive';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf)	{
		$this->conf=$conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		
		
		// Add the css file
		$includeFiles = "\t" . '<link href="' . t3lib_extMgm::siteRelPath($this->extKey) . 'res/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />';
		// Add the js file
		$includeFiles .= "\n\t" . '<script type="text/javascript" src="' . t3lib_extMgm::siteRelPath($this->extKey)  . 'res/jqueryFileTree.js"></script>';
		$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] = $includeFiles;
		
		
		$content = $this->renderFileTree();
		
	
		return $this->pi_wrapInBaseClass($content);
	}
	
	
	/**
	 * Render the file tree
	 *
	 * @return	The content that is displayed on the website
	 */
	function renderFileTree()	{
		
		
		// Add specific JS
		$javascript = "
jQuery(document).ready( function() {
	jQuery('#fileTreeDemo_" . $this->cObj->data['uid'] . "').fileTree({ root: 'fileadmin/', script: '/index.php?eID=tcfilearchive' }, function(file) { 
		alert(file);
	});
});
</script>




		<style type='text/css'>
			.demo {
				width: 200px;
				height: 200px;
				border-top: solid 1px #BBB;
				border-left: solid 1px #BBB;
				border-bottom: solid 1px #FFF;
				border-right: solid 1px #FFF;
				background: #FFF;
				overflow: scroll;
				padding: 5px;
			}
		</style>




";

		$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] .= "\n" . '<script type="text/javascript">' . $javascript . "</script>";

		
		$content = '<div id="fileTreeDemo_' . $this->cObj->data['uid'] . '" class="demo">heps</div>';

		return $content;
		
	}
	
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tcfilearchive/pi1/class.tx_tcfilearchive_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/tcfilearchive/pi1/class.tx_tcfilearchive_pi1.php']);
}

?>