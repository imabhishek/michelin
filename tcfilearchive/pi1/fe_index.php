<?php

// Exit, if script is called directly (must be included via eID in index_ts.php)
if (!defined ('PATH_typo3conf')) 	die ('Could not access this script directly!');


require_once(PATH_tslib.'class.tslib_fe.php');
// require_once(PATH_t3lib.'class.t3lib_page.php');
// require_once(PATH_t3lib.'class.t3lib_userauth.php');
// require_once(PATH_tslib.'class.tslib_feuserauth.php');
// require_once(PATH_tslib.'class.tslib_content.php');
// require_once(PATH_t3lib.'class.t3lib_tstemplate.php');
// require_once(PATH_t3lib.'class.t3lib_cs.php');
// require_once(PATH_t3lib.'class.t3lib_stdgraphic.php');
// require_once(PATH_tslib.'class.tslib_gifbuilder.php');


// Create instance of TSFE
$temp_TSFEclassName = t3lib_div::makeInstanceClassName('tslib_fe');
$TSFE = new $temp_TSFEclassName(
		$TYPO3_CONF_VARS,
		t3lib_div::_GP('id'),
		t3lib_div::_GP('type'),
		t3lib_div::_GP('no_cache'),
		t3lib_div::_GP('cHash')
);

// Initiation
$TSFE->connectToDB();
// $TSFE->initFEuser();
// $TSFE->checkAlternativeIdMethods();
// $TSFE->clear_preview();
// $TSFE->determineId();
// $TSFE->makeCacheHash();
// $TSFE->getCompressedTCarray();
// $TSFE->initTemplate();
// $TSFE->getConfigArray();
// $TSFE->convPOSTCharset();


$obj = t3lib_div::makeInstance('tx_tcfilearchive_fe_index');

echo $obj->getFiles();



exit();




class tx_tcfilearchive_fe_index { 


	/*
	 * Get the files
	 */
	function getFiles() {
				
		$_POST['dir'] = urldecode($_POST['dir']);
		
		if( file_exists($root . $_POST['dir']) ) {
			$files = scandir($root . $_POST['dir']);
			natcasesort($files);
			if( count($files) > 2 ) { /* The 2 accounts for . and .. */
				echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
				// All dirs
				foreach( $files as $file ) {
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
						echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
					}
				}
				// All files
				foreach( $files as $file ) {
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {
						$ext = preg_replace('/^.*\./', '', $file);
						echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
					}
				}
				echo "</ul>";	
			}
		}
				
		
		
	}




	/*
	 * Do the setup bit
	 */
	function tx_tcfilearchive_fe_index() {
		
		// Handle incoming in one place 
		// Take appropiate Security measures 
		$this->gets = array(
							'eID' => t3lib_div::_GET('eID'),
							'path' => intval(t3lib_div::_GET('uid')),
							'key' => intval(t3lib_div::_GET('key')),
							);
		
		// Check key

		return true;
	}

}
?>