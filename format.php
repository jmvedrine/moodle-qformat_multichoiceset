<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Code for changing multichoice to multichoiceset when importing Moodle XML.
 *
 * @package    qformat_multichoiceset
 * @copyright  Jean-Michel Vedrine
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/format/xml/format.php');

/**
 * Importer for multichoiceset question format.
 *
 * See http://docs.moodle.org/en/Moodle_XML_format for a description of the format.
 *
 * @copyright  1999 onwards Martin Dougiamas {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qformat_multichoiceset extends qformat_xml {

    public function provide_import() {
        return true;
    }

    public function provide_export() {
        return false;
    }

    // Override to change question type to multichoiceset.
    public function import_multichoice($question) {
        $qo = parent::import_multichoice($question);
        if (array_key_exists('multichoiceset', core_component::get_plugin_list('qtype'))) {
            $qo->qtype = 'multichoiceset';
            for ($k = 0; $k < count($qo->answer); $k++) {
                if (!empty($qo->fraction[$k]) && (float)$qo->fraction[$k] >= 0.000001) {
                    $qo->correctanswer[$k] = true;
                    $qo->fraction[$k] = 1.0;
                } else {
                    $qo->correctanswer[$k] = false;
                    $qo->fraction[$k] = 0.0;
                }
            }
        }
        return $qo;
    }
}
