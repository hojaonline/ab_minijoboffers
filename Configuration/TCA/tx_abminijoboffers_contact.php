<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
return array(
	"ctrl" => Array (
		"title" => "LLL:EXT:ab_minijoboffers/locallang_db.xlf:tx_abminijoboffers_contact",
		"label" => "title",
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"default_sortby" => "ORDER BY title",
		"delete" => "deleted",
		"enablecolumns" => Array (
			"disabled" => "hidden",
		),
		"iconfile" => "EXT:ab_minijoboffers/icon_tx_abminijoboffers_contact.gif",
	),
	"interface" => Array (
		"showRecordFieldList" => "hidden,title,contact"
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "hidden, title, contact",
	),
	"columns" => Array (
		"hidden" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		"title" => Array (
			"exclude" => 0,
			"label" => "LLL:EXT:ab_minijoboffers/locallang_db.php:tx_abminijoboffers_contact.title",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"max" => "150",
			)
		),
		"contact" => Array (
			"exclude" => 0,
			"label" => "LLL:EXT:ab_minijoboffers/locallang_db.php:tx_abminijoboffers_contact.contact",
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "hidden;;1;;1-1-1, title;;;;2-2-2, contact;;;richtext[paste|bold|italic|underline|formatblock|class|left|center|right|orderedlist|unorderedlist|outdent|indent|link|image]:rte_transform[mode=ts];3-3-3")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);
				
