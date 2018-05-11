<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('

	# ***************************************************************************************
	# CONFIGURATION of RTE in table "tx_abminijoboffers_jobs", field "beschreibung"
	# ***************************************************************************************
RTE.config.tx_abminijoboffers_jobs.beschreibung {
  hidePStyleItems = H1, H4, H5, H6
  proc.exitHTMLparser_db=1
  proc.exitHTMLparser_db {
    keepNonMatchedTags=1
    tags.font.allowedAttribs= color
    tags.font.rmTagIfNoAttrib = 1
    tags.font.nesting = global
  }
}
');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('

	# ***************************************************************************************
	# CONFIGURATION of RTE in table "tx_abminijoboffers_jobs", field "aufgaben"
	# ***************************************************************************************
RTE.config.tx_abminijoboffers_jobs.aufgaben {
  hidePStyleItems = H1, H4, H5, H6
  proc.exitHTMLparser_db=1
  proc.exitHTMLparser_db {
    keepNonMatchedTags=1
    tags.font.allowedAttribs= color
    tags.font.rmTagIfNoAttrib = 1
    tags.font.nesting = global
  }
}
');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('

	# ***************************************************************************************
	# CONFIGURATION of RTE in table "tx_abminijoboffers_jobs", field "anforderungen"
	# ***************************************************************************************
RTE.config.tx_abminijoboffers_jobs.anforderungen {
  hidePStyleItems = H1, H4, H5, H6
  proc.exitHTMLparser_db=1
  proc.exitHTMLparser_db {
    keepNonMatchedTags=1
    tags.font.allowedAttribs= color
    tags.font.rmTagIfNoAttrib = 1
    tags.font.nesting = global
  }
}
');

  ## Extending TypoScript from static template uid=43 to set up userdefined tag:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY,"editorcfg","
	tt_content.CSS_editor.ch.tx_abminijoboffers_pi1 = < plugin.tx_abminijoboffers_pi1.CSS_editor
",43);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43($_EXTKEY,"pi1/class.tx_abminijoboffers_pi1.php","_pi1","list_type",0);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript($_EXTKEY,"setup","
	tt_content.shortcut.20.0.conf.tx_abminijoboffers_jobs = < plugin.".\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getCN($_EXTKEY)."_pi1
	tt_content.shortcut.20.0.conf.tx_abminijoboffers_jobs.CMD = singleView
",43);
?>