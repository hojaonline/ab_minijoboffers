<?php
if (!defined ("TYPO3_MODE")) 	die ("Access denied.");
$TCA["tt_content"]["types"]["list"]["subtypes_excludelist"][$_EXTKEY."_pi1"]="layout";
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(Array("LLL:EXT:ab_minijoboffers/locallang_db.xlf:tt_content.list_type_pi1", $_EXTKEY."_pi1"),"list_type");