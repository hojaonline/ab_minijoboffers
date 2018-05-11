<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
return array(
	"ctrl" => Array (
		"title" => "LLL:EXT:ab_minijoboffers/locallang_db.xlf:tx_abminijoboffers_jobs",
		"label" => "bezeichner",
		"tstamp" => "tstamp",
		"crdate" => "crdate",
		"cruser_id" => "cruser_id",
		"versioning" => "1",
		"languageField" => "sys_language_uid",
		"transOrigPointerField" => "l18n_parent",
		"transOrigDiffSourceField" => "l18n_diffsource",
		"sortby" => "sorting",
		"delete" => "deleted",
		"enablecolumns" => Array (
			"disabled" => "hidden",
			"starttime" => "starttime",
			"endtime" => "endtime",
		),
		"iconfile" => "EXT:ab_minijoboffers/icon_tx_abminijoboffers_jobs.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, bezeichner, jobdatum, category, contact, beschreibung, aufgaben, anforderungen",
	),
	"columns" => Array (
		/*'sys_language_uid' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),*/
		'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ]
        ],
		'l18n_parent' => Array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_abminijoboffers_jobs',
				'foreign_table_where' => 'AND tx_abminijoboffers_jobs.pid=###CURRENT_PID### AND tx_abminijoboffers_jobs.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array (
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		"hidden" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.xlf:LGL.hidden",
			"config" => Array (
				"type" => "check",
				"default" => "0"
			)
		),
		'starttime' => array(
			'exclude' => 1,
			// 'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime', 
				'size' => 13,
				// 'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'behaviour'=>[
					'allowLanguageSynchronization'=>true,
				],
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		/*"endtime" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.php:LGL.endtime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0",
				"range" => Array (
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				)
			)
		),*/
		'endtime' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'size' => 13,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'behaviour' => [
					'allowLanguageSynchronization' => true,
				],
				'range' => array(
					"upper" => mktime(0,0,0,12,31,2020),
					"lower" => mktime(0,0,0,date("m")-1,date("d"),date("Y"))
				),
			),
		),
		"bezeichner" => Array (
			"exclude" => 0,
			"label" => "LLL:EXT:ab_minijoboffers/locallang_db.php:tx_abminijoboffers_jobs.bezeichner",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required,trim",
			)
		),
		"jobdatum" => Array (
			"exclude" => 0,
			"label" => "LLL:EXT:ab_minijoboffers/locallang_db.php:tx_abminijoboffers_jobs.jobdatum",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"category" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:ab_minijoboffers/locallang_db.php:tx_abminijoboffers_jobs.category",
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_abminijoboffers_cat",
				"foreign_table_where" => "AND tx_abminijoboffers_cat.pid=###CURRENT_PID### ORDER BY tx_abminijoboffers_cat.uid",
				"size" => 3,
				"minitems" => 0,
				"maxitems" => 5,
			)
		),
		"contact" => Array (
			"exclude" => 0,
			"label" => "LLL:EXT:ab_minijoboffers/locallang_db.php:tx_abminijoboffers_jobs.contact",
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_abminijoboffers_contact",
				"foreign_table_where" => "AND tx_abminijoboffers_contact.pid=###CURRENT_PID### ORDER BY tx_abminijoboffers_contact.uid",
				"size" => 1,
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"beschreibung" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:ab_minijoboffers/locallang_db.php:tx_abminijoboffers_jobs.beschreibung",
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
			)
		),
		"aufgaben" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:ab_minijoboffers/locallang_db.php:tx_abminijoboffers_jobs.aufgaben",
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
			)
		),
		"anforderungen" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:ab_minijoboffers/locallang_db.php:tx_abminijoboffers_jobs.anforderungen",
			"config" => Array (
				"type" => "text",
				"cols" => "30",
				"rows" => "5",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, bezeichner, jobdatum, category, contact, beschreibung;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/tx_abminijoboffers/rte/], aufgaben;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/tx_abminijoboffers/rte/], anforderungen;;;richtext[cut|copy|paste|formatblock|textcolor|bold|italic|underline|left|center|right|orderedlist|unorderedlist|outdent|indent|link|table|image|line|chMode]:rte_transform[mode=ts_css|imgpath=uploads/tx_abminijoboffers/rte/]")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "starttime, endtime")
	)
);
