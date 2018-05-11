<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2004 Andre Bilsing (ab@t3werk.de)
 *
 *  Compatibility Fixes added by HOJA.M.A <hoja.ma@pitsolutions.com> for 8 LTS Upgrade
 *
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

/**
 * Plugin 'Job Offers' for the 'ab_minijoboffers' extension.
 *
 * @author    Andre Bilsing <ab@t3werk.de>
 */
class tx_abminijoboffers_pi1 extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin
{
    var $prefixId = "tx_abminijoboffers_pi1";                       // Same as class name
    var $scriptRelPath = "pi1/class.tx_abminijoboffers_pi1.php";    // Path to this script relative to the extension dir.
    var $extKey = "ab_minijoboffers";                               // The extension key.
    var $templateCode;
    var $lCode;

    /**
     * @param $content
     * @param $conf
     * @return multiple
     */
    public function main($content, $conf)
    {
        $code = $this->cObj->data["select_key"];
        switch (true) {
            case ($code == 'ALL'):
                if (strstr($this->cObj->currentRecord, "tt_content")) {
                    $conf["pidList"] = $this->cObj->data["pages"];
                    $conf["recursive"] = $this->cObj->data["recursive"];
                }
                break;
            case (preg_match("/^(\d+,)+\d+$|^\d+$/", $code)):
                if (strstr($this->cObj->currentRecord, "tt_content")) {
                    $conf["pidList"] = $this->cObj->data["pages"];
                    $conf["recursive"] = $this->cObj->data["recursive"];
                    $conf["catlist"] = explode(",", $code);
                }
                break;
            default:
                if (strstr($this->cObj->currentRecord, "tt_content")) {
                    $conf["pidList"] = $this->cObj->data["pages"];
                    $conf["recursive"] = $this->cObj->data["recursive"];
                }
                break;
        }
        return $this->listView($content, $conf);
        //return $this->pi_wrapInBaseClass($this->listView($content,$conf));
    }

    /**
     * Do the list view, use the template
     *
     * @param   string   Content
     * @param   string   global Extension configuration
     * @return  multiple
     */
    public function listView($content, $conf)
    {
        $this->conf = $conf;           // Setting the TypoScript passed to this function in $this->conf
        $this->pi_setPiVarDefaults();
        $this->pi_loadLL();            // Loading the LOCAL_LANG values
        $this->pi_USER_INT_obj = 1;    // Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!
        $this->lConf = $this->conf["listView."];

        if ($this->piVars["showUid"]) {    // If a single element should be displayed:
            $this->internal["currentTable"] = "tx_abminijoboffers_jobs";
            $this->internal["currentRow"] = $this->pi_getRecord("tx_abminijoboffers_jobs", $this->piVars["showUid"]);
            $content = $this->singleView($content, $conf);
            return $content;
        } else {
            $this->internal["orderByList"] = "sorting,jobdatum,uid,bezeichner";
            $this->internal["orderBy"] = "sorting";
            $this->internal["descFlag"] = 0;
            $this->internal["currentTable"] = "tx_abminijoboffers_jobs";
            if (is_array($this->conf["catlist"])) {
                $cat_and = "( 1=2 ";
                foreach ($this->conf["catlist"] as $cat_id) {
                    $cat_and .= "OR uid = '" . $cat_id . "' ";
                }
                $cat_and .= ") ";
            } else {
                $cat_and = "1=1 ";
            }
            $cat_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('cat_name, uid', "tx_abminijoboffers_cat", $cat_and . $this->cObj->enableFields("tx_abminijoboffers_cat"), '', 'sorting', '');
            // Get all jobs
            if (is_int($GLOBALS['TSFE']->sys_language_content)) {
                $jobs_and .= " sys_language_uid = '" . $GLOBALS['TSFE']->sys_language_content . "'";
            } else {
                $jobs_and .= " 1=1";
            }
            $jobs_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', "tx_abminijoboffers_jobs", $jobs_and . $this->cObj->enableFields("tx_abminijoboffers_jobs"), '', 'sorting', '');

             // Get the template
            $this->templateCode = $this->cObj->fileResource($this->conf["templateFile"]);
            while ($cat_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($cat_res)) {
                // Get the parts out of the template
                $t = array();
                $t["total"] = $this->cObj->getSubpart($this->templateCode, "###JOBOFFERS_LISTVIEW###");
                $t["jobs_row"] = $this->cObj->getSubpart($t["total"], "###JOBOFFERS_TABLE_ROW###");
                $t["jobs_item"] = $this->cObj->getSubpart($t["jobs_row"], "###JOBOFFERS_TABLE_ITEM###");
                $t["cat_row"] = $this->cObj->getSubpart($t["total"], "###JOBOFFERS_CAT_TABLE_ROW###");
                $t["cat_item"] = $this->cObj->getSubpart($t["cat_row"], "###JOBOFFERS_CATEGORY_ITEM###");

                $category_row = '';
                $markerArray = array();
                $markerArray["###CATEGORY_NAME###"] = $cat_row['cat_name'];
                $category_row .= $this->cObj->substituteMarkerArrayCached($t["cat_item"], $markerArray, array(), array());

                $subpartArray = array();
                $subpartArray["###CATEGORY_ROW###"] = $category_row;

                $item_counter = 0;
                while ($this->internal['currentRow'] = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($jobs_res)) {
                    $cat_id = explode(",", $this->internal['currentRow']['category']);
                    if (!in_array($cat_row['uid'], $cat_id)) {
                        continue;
                    } elseif ($item_counter == 0) {
                        $content_table .=
                            $this->cObj->substituteMarkerArrayCached($t["cat_row"],
                                array(), $subpartArray, array());
                    }
                    $content_row = '';
                    $markerArray = array();
                    $markerArray["###JOBOFFERS_DATE###"] = $this->getFieldContent("jobdatum");
                    $markerArray["###JOBOFFERS_LINK###"] = $this->getFieldContent("bezeichner_link");
                    $content_row .= $this->cObj->substituteMarkerArrayCached($t["jobs_item"],
                        $markerArray, array(), array());

                    // Create one row
                    $subpartArray = array();
                    $subpartArray["###CONTENT_ROW###"] = $content_row;
                    $content_table .=
                        $this->cObj->substituteMarkerArrayCached($t["jobs_row"],
                            array(), $subpartArray, array());
                    $item_counter++;
                }
                
                if ($GLOBALS['TYPO3_DB']->sql_num_rows($jobs_res) != 0) {
                    $GLOBALS['TYPO3_DB']->sql_data_seek($jobs_res, 0);
                }
            }

            // Create the whole table
            $subpartArray = array();
            $subpartArray["###CONTENT###"] = $content_table;
            $content .=
                $this->cObj->substituteMarkerArrayCached($t["total"],
                    array(), $subpartArray, array());

            // Return the created table
            return $content;
            //return $this->pi_wrapInBaseClass($content);
        }
    }

    /**
     * Do the single view, use the template
     *
     * @param   string   Content
     * @param   string   global Extension configuration
     * @see substituteSingleView()
     * @return multiple
     */
    public function singleView($content, $conf)
    {
        $this->conf = $conf;
        $this->pi_setPiVarDefaults();
        $this->pi_loadLL();
        $this->pi_USER_INT_obj = 1;    // Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!
        $this->lConf = $this->conf["singleView."];    // Local settings for the listView function

        // This sets the title of the page for use in indexed search results:
        if ($this->internal["currentRow"]["title"]) $GLOBALS["TSFE"]->indexedDocTitle = $this->internal["currentRow"]["title"];

        // Get the template
        $this->templateCode = $this->cObj->fileResource($this->conf["templateFile"]);

        // Get the parts out of the template
        $t = array();
        $t["total"] = $this->cObj->getSubpart($this->templateCode, "###JOBOFFERS_SINGLEVIEW###");
        $t["title"] = $this->cObj->getSubpart($t["total"], "###TITLE_ROW###");
        $t["date"] = $this->cObj->getSubpart($t["total"], "###DATE_ROW###");
        $t["desc"] = $this->cObj->getSubpart($t["total"], "###DESCRIPTION_ROW###");
        $t["tasks"] = $this->cObj->getSubpart($t["total"], "###TASKS_ROW###");
        $t["demands"] = $this->cObj->getSubpart($t["total"], "###DEMANDS_ROW###");
        $t["contact"] = $this->cObj->getSubpart($t["total"], "###CONTACT_ROW###");

        $content_row = '';

        // Substitute Title
        $markerArray = array();
        $content_row .= $this->substituteSingleView($t["title"], 'TITLE', 'bezeichner');
        $content_row .= $this->substituteSingleView($t["date"], 'DATE', 'jobdatum');
        $content_row .= $this->substituteSingleView($t["desc"], 'DESCRIPTION', 'beschreibung');
        $content_row .= $this->substituteSingleView($t["tasks"], 'TASKS', 'aufgaben');
        $content_row .= $this->substituteSingleView($t["demands"], 'DEMANDS', 'anforderungen');
        $content_row .= $this->substituteSingleView($t["contact"], 'CONTACT', 'contact');

        // Create the whole table
        $subpartArray = array();
        $subpartArray["###CONTENT###"] = $content_row;
        $content .=
            $this->cObj->substituteMarkerArrayCached($t["total"],
                array(), $subpartArray, array());

        $content .= '<br /><div class="btn">' .
            $this->pi_list_linkSingle($this->pi_getLL("back", "Back"), 0) . '</div>' .
            $this->pi_getEditPanel();
        return $content;
    }

    /**
     * Substitue the Template Marker with DB Values
     *
     * @param   array    template code
     * @param   string   First part of marker name
     * @param   string   DB Field Name
     * @return  multiple
     */
    public function substituteSingleView($code, $prefix, $db_field)
    {
        $markerArray = array();
        $key = '###' . $prefix . '_KEY###';
        $value = '###' . $prefix . '_VALUE###';
        $style = '###SVIEW_TDSTYLE###';
        $ll = 'listFieldHeader_' . $db_field;
        $markerArray[$key] = $this->pi_getLL($ll);
        $markerArray[$value] = $this->getFieldContent($db_field);
        $markerArray[$style] = $this->lConf['tdstyle'];
        return $this->cObj->substituteMarkerArrayCached($code,
            $markerArray, array(), array());
    }

    /**
     * Return the db content from $this->internal["currentRow"].
     *
     * @param string db field
     * @return multiple
     */
    public function getFieldContent($fN)
    {
        switch ($fN) {
            case "bezeichner_link":
                return $this->pi_list_linkSingle($this->internal["currentRow"]["bezeichner"], $this->internal["currentRow"]["uid"], 1);    // The "1" means that the display of single items is CACHED! Set to zero to disable caching.
                break;
            case "jobdatum":
                if ($this->lConf['date_stdWrap.'] != '') {
                    return $this->cObj->stdWrap($this->internal['currentRow']['jobdatum'], $this->lConf['date_stdWrap.']);
                } else {
                    return date('d.m.Y', $this->internal['currentRow']['jobdatum']);
                }
                break;
            case "beschreibung":
                return $this->pi_RTEcssText($this->internal["currentRow"]["beschreibung"]);
                break;
            case "aufgaben":
                return $this->pi_RTEcssText($this->internal["currentRow"]["aufgaben"]);
                break;
            case "anforderungen":
                return $this->pi_RTEcssText($this->internal["currentRow"]["anforderungen"]);
                break;
            case "contact":
                $contact_and = "uid = '" . $this->internal["currentRow"]["contact"] . "'";
                $contact_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', "tx_abminijoboffers_contact", $contact_and . $this->cObj->enableFields("tx_abminijoboffers_contact"), '', '', '');
                $contact_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($contact_res);
                return $this->pi_RTEcssText($contact_row["contact"]);
            case "fusszeile":
                return $this->lConf['footer_text'];
                break;
            default:
                return $this->internal["currentRow"][$fN];
                break;
        }
    }
}

if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/ab_minijoboffers/pi1/class.tx_abminijoboffers_pi1.php"]) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/ab_minijoboffers/pi1/class.tx_abminijoboffers_pi1.php"]);
}
