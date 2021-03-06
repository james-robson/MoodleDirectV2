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

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once($CFG->dirroot.'/mod/turnitintooltwo/turnitintooltwo_form.class.php');

class turnitintooltwo_view {

    /**
     * Abstracted version of print_header() / header()
     *
     * @param object $cm The moodle course module object for this instance
     * @param object $course The course object for this activity
     * @param string $title Appears at the top of the window
     * @param string $heading Appears at the top of the page
     * @param string $navigation Array of $navlinks arrays (keys: name, link, type) for use as breadcrumbs links
     * @param string $focus Indicates form element to get cursor focus on load eg  inputform.password
     * @param string $meta Meta tags to be added to the header
     * @param boolean $cache Should this page be cacheable?
     * @param string $button HTML code for a button (usually for module editing)
     * @param string $menu HTML code for a popup menu
     * @param boolean $usexml use XML for this page
     * @param string $bodytags This text will be included verbatim in the <body> tag (useful for onload() etc)
     * @param bool $return If true, return the visible elements of the header instead of echoing them.
     * @return mixed If return=true then string else void
     */
    public function output_header($cm, $course, $url, $title = '', $heading = '', $navigation = array(),
                            $focus = '', $meta = '', $cache = true, $button = '',
            $menu = null, $usexml = false, $bodytags = '', $return = false) {
        global $PAGE, $OUTPUT;

        $cmid = ($cm != null) ? $cm->id : null;
        $courseid = ($course != null) ? $course->id : null;

        foreach ($navigation as $nav) {
            $PAGE->navbar->add($nav["title"], $nav["url"]);
        }

        if (!is_null($cmid) && $button != '') {
            $PAGE->set_button($OUTPUT->update_module_button($cm->id, "turnitintooltwo"));
        }

        $PAGE->set_url($url);
        $PAGE->set_title($title);
        $PAGE->set_heading($heading);

        if ($return) {
            return $OUTPUT->header();
        } else {
            echo $OUTPUT->header();
        }
    }

    /**
     * Load the Javascript and CSS components for page
     *
     * @global type $PAGE
     * @global type $CFG
     */
    public function load_page_components($hidebg = false) {
        global $PAGE, $CFG;
        if ($hidebg) {
            $cssurl = new moodle_url('/mod/turnitintooltwo/css/hide_bg.css');
            $PAGE->requires->css($cssurl);
        }
        $cssurl = new moodle_url('/mod/turnitintooltwo/css/styles.css');
        $PAGE->requires->css($cssurl);
        $cssurl = new moodle_url('/mod/turnitintooltwo/css/jquery.dataTables.css');
        $PAGE->requires->css($cssurl);
        $cssurl = new moodle_url('/mod/turnitintooltwo/css/jquery-ui-1.8.4.custom.css');
        $PAGE->requires->css($cssurl);
        $cssurl = new moodle_url('/mod/turnitintooltwo/css/colorbox.css');
        $PAGE->requires->css($cssurl);
        $cssurl = new moodle_url('/mod/turnitintooltwo/css/jqueryui-editable.css');
        $PAGE->requires->css($cssurl);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/jquery-1.8.2.min.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/jquery.dataTables.min.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/jquery-ui-1.10.2.custom.min.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/jquery.dataTables.plugins.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/turnitintooltwo.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/turnitintooltwo_extra.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/turnitintooltwo_settings.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/jquery.dataTables.columnFilter.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/jquery.colorbox-min.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/jquery.cookie.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/jqueryui-editable.min.js');
        $PAGE->requires->js($jsurl, true);
        $jsurl = new moodle_url('/mod/turnitintooltwo/scripts/moment.min.js');
        $PAGE->requires->js($jsurl, true);

        // Javascript i18n strings.
        $PAGE->requires->string_for_js('close', 'turnitintooltwo');
        $PAGE->requires->string_for_js('nointegration', 'turnitintooltwo');
        $PAGE->requires->string_for_js('sprevious', 'turnitintooltwo');
        $PAGE->requires->string_for_js('snext', 'turnitintooltwo');
        $PAGE->requires->string_for_js('sprocessing', 'turnitintooltwo');
        $PAGE->requires->string_for_js('szerorecords', 'turnitintooltwo');
        $PAGE->requires->string_for_js('sinfo', 'turnitintooltwo');
        $PAGE->requires->string_for_js('ssearch', 'turnitintooltwo');
        $PAGE->requires->string_for_js('slengthmenu', 'turnitintooltwo');
        $PAGE->requires->string_for_js('semptytable', 'turnitintooltwo');
        $PAGE->requires->string_for_js('resubmissiongradewarn', 'turnitintooltwo');
    }

    /**
     * Output the Menu in the settings area as an HTML list
     *
     * @global type $CFG
     * @param obj $module
     * @return output the menu as an HTML list
     */
    public function draw_settings_menu($module, $cmd) {
        global $CFG, $OUTPUT;

        $tabs = array();

        $tabs[] = new tabobject('settings', $CFG->wwwroot.'/admin/settings.php?section=modsettingturnitintooltwo',
                        get_string('settings', 'turnitintooltwo'), get_string('settings', 'turnitintooltwo'), false);

        $tabs[] = new tabobject('viewreport', $CFG->wwwroot.'/mod/turnitintooltwo/settings_extras.php?cmd=viewreport',
                        get_string('showusage', 'turnitintooltwo'), get_string('showusage', 'turnitintooltwo'), false);

        $tabs[] = new tabobject('savereport', $CFG->wwwroot.'/mod/turnitintooltwo/settings_extras.php?cmd=savereport',
                        get_string('saveusage', 'turnitintooltwo'), get_string('saveusage', 'turnitintooltwo'), false);

        $tabs[] = new tabobject('apilog', $CFG->wwwroot.'/mod/turnitintooltwo/settings_extras.php?cmd=apilog',
                        get_string('logs'), get_string('logs'), false);

        $tabs[] = new tabobject('unlinkusers', $CFG->wwwroot.'/mod/turnitintooltwo/settings_extras.php?cmd=unlinkusers',
                        get_string('unlinkusers', 'turnitintooltwo'), get_string('unlinkusers', 'turnitintooltwo'), false);

        $tabs[] = new tabobject('files', $CFG->wwwroot.'/mod/turnitintooltwo/settings_extras.php?cmd=files',
                        get_string('files', 'turnitintooltwo'), get_string('files', 'turnitintooltwo'), false);

        $tabs[] = new tabobject('courses', $CFG->wwwroot.'/mod/turnitintooltwo/settings_extras.php?cmd=courses',
                        get_string('coursebrowser', 'turnitintooltwo'), get_string('coursebrowser', 'turnitintooltwo'), false);

        $selected = ($cmd == 'activitylog') ? 'apilog' : $cmd;

        // Read the LTI launch form in the output buffer and put in link to test Turnitin connection.
        ob_start();
        print_tabs(array($tabs), $selected);
        $settingstabs = ob_get_contents();
        ob_end_clean();

        return $settingstabs;
    }

    /**
     * Prints the tab link menu across the top of the activity module
     *
     * @param object $cm The moodle course module object for this instance
     * @param object $selected The query string parameter to determine the page we are on
     * @param array $notice
     */
    public function draw_tool_tab_menu($cm, $selected) {
        global $CFG;

        $tabs = array();
        if (has_capability('mod/turnitintooltwo:grade', context_module::instance($cm->id))) {
            $tabs[] = new tabobject('submissions', $CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.'&do=submissions',
                    get_string('allsubmissions', 'turnitintooltwo'), get_string('allsubmissions', 'turnitintooltwo'), false);

            $tabs[] = new tabobject('tutors', $CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.'&do=tutors',
                    get_string('turnitintutors', 'turnitintooltwo'), get_string('turnitintutors', 'turnitintooltwo'), false);

            $tabs[] = new tabobject('students', $CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.'&do=students',
                    get_string('turnitinstudents', 'turnitintooltwo'), get_string('turnitinstudents', 'turnitintooltwo'), false);
        } else {
            $tabs[] = new tabobject('submissions', $CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.'&do=submissions',
                    get_string('mysubmissions', 'turnitintooltwo'), get_string('mysubmissions', 'turnitintooltwo'), false);
        }

        print_tabs(array($tabs), $selected);
    }

    /**
     * Configure html for a notice to be shown at the top of the screen if required
     *
     * @param type $notice
     * @return mixed html containing notice
     */
    public function show_notice($notice) {
        global $OUTPUT;

        return $OUTPUT->box($notice["message"], 'generalbox', $notice["type"]);
    }

    public function show_digital_receipt($digitalreceipt) {
        global $OUTPUT;

        $receipt = html_writer::tag('p', get_string('submissionuploadsuccess', 'turnitintooltwo'),
                                        array('class' => 'bold', 'id' => 'upload_success'));

        $receipt .= html_writer::tag('h2', get_string('digitalreceipt', 'turnitintooltwo'),
                                        array("id" => "digital_receipt"));
        $receipt .= html_writer::tag('p', html_writer::tag('span',
                                            get_string('turnitinsubmissionid', 'turnitintooltwo').":",
                                                            array('class' => 'bold'))." ".
                                            html_writer::tag('span', $digitalreceipt["tii_submission_id"],
                                                            array('class' => 'tii_submission_id')));
        $receipt .= html_writer::tag('p', get_string('submissionextract', 'turnitintooltwo').":", array('class' => 'bold'));
        $receipt .= html_writer::tag('span', html_writer::tag('p', $digitalreceipt["extract"]), array('class' => 'extract_text'));

        $icon = $OUTPUT->box($OUTPUT->pix_icon('icon', get_string('turnitin', 'turnitintooltwo'),
                                                    'mod_turnitintooltwo'), 'centered_div');
        $output = $OUTPUT->box($icon.$receipt, 'generalbox', 'digital_receipt');

        return $output;
    }

    /**
     * Warning display to indicate duplicated assignments, normally as a result of a backup and restore
     *
     * @param object $cm The moodle course module object for this instance
     * @param object $turnitintooltwo The turnitin assignment data object
     * @return mixed Returns HTML duplication warning if the logged in users has grade rights otherwise null
     */
    public function show_duplicate_assignment_warning($turnitintooltwoassignment, $parts) {
        global $CFG, $OUTPUT;

        $dups = array();
        $output = '';
        foreach ($parts as $part) {
            $dupparts = $turnitintooltwoassignment->get_duplicate_parts($part->tiiassignid, $part->turnitintooltwoid);
            $dups = array_merge($dups, $dupparts);
        }
        if (count($dups) > 0) {
            $output .= $OUTPUT->box_start('generalbox boxaligncenter notepost', 'warning');
            $output .= html_writer::tag("h3", get_string('notice'), array("class" => "error"));
            $output .= html_writer::tag("p", get_string('duplicatesfound', 'turnitintooltwo'));

            $listcourses = array();
            foreach ($dups as $duppart) {
                $listcourses[] = html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$duppart->cm_id,
                                    $duppart->course_name.' (' . $duppart->course_shortname . ') - '.
                                        $duppart->tool_name.' - ' . $duppart->partname);
            }
            $output .= html_writer::alist($listcourses);
            $output .= $OUTPUT->box_end();
        }
        return $output;
    }

    /**
     * Outputs the HTML for the submission form
     *
     * @global object $CFG
     * @global object $OUTPUT
     * @param object $cm The moodle course module object for this instance
     * @param object $turnitintooltwoassignment The turnitintooltwo object for this activity
     * @param int $partid The part id being submitted to
     * @param int $userid The user id who the submission is for
     * @param array $turnitintooltwofileuploadoptions upload options for the file manager
     * @return string returns the HTML of the form
     */
    public function show_submission_form($cm, $turnitintooltwoassignment, $partid, $turnitintooltwofileuploadoptions,
                                $viewcontext = "box", $userid = 0) {
        global $CFG, $OUTPUT, $USER;

        $output = "";
        $config = turnitintooltwo_admin_config();
        $istutor = has_capability('mod/turnitintooltwo:grade', context_module::instance($cm->id));

        // Check if the submitting user has accepted the EULA
        $eulaaccepted = false;
        if ($userid == $USER->id) {
            $user = new turnitintooltwo_user($userid, "Learner");
            $coursedata = $turnitintooltwoassignment->get_course_data($turnitintooltwoassignment->turnitintooltwo->course);
            $user->join_user_to_class($coursedata->turnitin_cid);
            $eulaaccepted = $user->get_accepted_user_agreement();
        }

        $parts = $turnitintooltwoassignment->get_parts_available_to_submit();
        if (!empty($parts)) {

            $elements = array();
            $elements[] = array('header', 'submitpaper', get_string('submitpaper', 'turnitintooltwo'));

            $elements[] = array('hidden', 'submissionassignment', $turnitintooltwoassignment->turnitintooltwo->id);
            $elements[] = array('hidden', 'action', 'submission');

            if ($istutor || $eulaaccepted) {
                // Upload type.
                switch ($turnitintooltwoassignment->turnitintooltwo->type) {
                    case 0:
                        $options = $this->get_filetypes(false);
                        $elements[] = array('select', 'submissiontype', get_string('submissiontype', 'turnitintooltwo'),
                                                                                                'submissiontype', $options);
                        break;
                    case 1:
                    case 2:
                        $elements[] = array('hidden', 'submissiontype', $turnitintooltwoassignment->turnitintooltwo->type);
                        break;
                }

                // User id if applicable.
                if ($istutor) {
                    $elements[] = array('hidden', 'studentsname', $userid);
                }

                // Submission Title.
                $elements[] = array('text', 'submissiontitle', get_string('submissiontitle', 'turnitintooltwo'), 'submissiontitle', '',
                                    'required', get_string('submissiontitleerror', 'turnitintooltwo'), PARAM_TEXT);

                // Submission Part(s).
                if ($partid == 0) {
                    $options = array();
                    foreach ($parts as $part) {
                        $options[$part->id] = $part->partname;
                    }
                    $elements[] = array('select', 'submissionpart', get_string('submissionpart', 'turnitintooltwo'),
                                                                                            'submissionpart', $options);
                } else {
                    $elements[] = array('hidden', 'submissionpart', $partid);
                }

                // File input for uploads.
                if ($turnitintooltwoassignment->turnitintooltwo->type == 0 OR $turnitintooltwoassignment->turnitintooltwo->type == 1) {
                    $elements[] = array('filemanager', 'submissionfile', get_string('filetosubmit', 'turnitintooltwo'),
                                                                        'filetosubmit', $turnitintooltwofileuploadoptions);
                }

                // Textarea.
                if ($turnitintooltwoassignment->turnitintooltwo->type == 0) {
                    $elements[] = array('textarea', 'submissiontext', get_string('texttosubmit', 'turnitintooltwo'), 'texttosubmit');
                } else if ($turnitintooltwoassignment->turnitintooltwo->type == 2) {
                    $elements[] = array('textarea', 'submissiontext', get_string('texttosubmit', 'turnitintooltwo'), 'texttosubmit', '',
                                    'required', get_string('submissiontexterror', 'turnitintooltwo'), PARAM_TEXT);
                }

                // Show agreement if applicable.
                if ($istutor OR empty($config->agreement) ) {
                    $elements[] = array('hidden', 'agreement', 1);
                    $customdata["checkbox_label_after"] = false;
                } else {
                    $elements[] = array('advcheckbox', 'agreement', $config->agreement, null, array(0, 1),
                                    'required', get_string('copyrightagreementerror', 'turnitintooltwo'), PARAM_INT);
                    $customdata["checkbox_label_after"] = true;
                }
            }

            // Output a link for the student to accept the turnitin licence agreement.
            $noscriptula = "";
            if ($userid == $USER->id) {
                if (!$eulaaccepted) {

                    $ula = html_writer::tag('div', get_string('turnitinula', 'turnitintooltwo'), array('class' => 'turnitin_ula'));
                    $noscriptula = html_writer::tag('noscript',
                                            $this->output_dv_launch_form("useragreement", 0, $user->tii_user_id, "Learner",
                                            get_string('turnitinula', 'turnitintooltwo'), false)." ".
                                                get_string('noscriptula', 'turnitintooltwo'),
                                            array('class' => 'warning turnitin_ula_noscript'));
                    $elements[] = array('html', $ula);
                }
            }

            $customdata["elements"] = $elements;
            $customdata["show_cancel"] = false;

            // Get any previous submission to determine if this is a resubmission.
            $prevsubmission = $turnitintooltwoassignment->get_user_submissions($userid,
                                        $turnitintooltwoassignment->turnitintooltwo->id, $partid);
            $customdata["submit_label"] = (count($prevsubmission) == 0) ?
                                            get_string('addsubmission', 'turnitintooltwo') :
                                            get_string('resubmission', 'turnitintooltwo');
            $customdata["disable_form_change_checker"] = true;

            $optionsform = new turnitintooltwo_form($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.
                                                    '&do=submitpaper&view_context='.$viewcontext, $customdata);
            $output .= $noscriptula;
            $output .= $OUTPUT->box($optionsform->display(), "submission_form_container");

            $turnitincomms = new turnitintooltwo_comms();
            $turnitincall = $turnitincomms->initialise_api();

            $customdata = array("disable_form_change_checker" => true,
                                "elements" => array(array('html', $OUTPUT->box('', '', 'useragreement_inputs'))));
            $eulaform = new turnitintooltwo_form($turnitincall->getApiBaseUrl().TiiLTI::EULAENDPOINT, $customdata,
                                                    'POST', $target = '_blank', array('id' => 'eula_launch'));
            $output .= $OUTPUT->box($eulaform->display(), '', 'useragreement_form');
        }

        return $output;
    }

    /**
     * Outputs the file type array for acceptable file type uploads
     *
     * @param boolean $setup True if the call is from the assignment activity setup screen
     * @param array The array of filetypes ready for the modform parameter
     */
    public function get_filetypes($setup = true) {
        $output = array(
            1 => get_string('fileupload', 'turnitintooltwo'),
            2 => get_string('textsubmission', 'turnitintooltwo')
        );
        if ($setup) {
            $output[0] = get_string('anytype', 'turnitintooltwo');
        }
        ksort($output);
        return $output;
    }

    /**
     * Output the table structures with headings for the Submission inbox, they will be populated via Ajax
     *
     * @global type $CFG
     * @global type $OUTPUT
     * @global type $USER
     * @param type $cm
     * @param type $turnitintooltwoassignment
     * @return type
     */
    public function init_submission_inbox($cm, $turnitintooltwoassignment, $partdetails, $turnitintooltwouser) {
        global $CFG, $OUTPUT, $USER;
        $config = turnitintooltwo_admin_config();

        // Output user role to hidden var for use in jQuery calls.
        $output = $OUTPUT->box($turnitintooltwouser->get_user_role(), '', 'user_role');
        $output .= $OUTPUT->box($turnitintooltwoassignment->turnitintooltwo->id, '', 'assignment_id');

        if ($turnitintooltwouser->get_user_role() == 'Learner') {
            $output .= html_writer::tag('noscript', get_string('noscriptsummary', 'turnitintooltwo'), array("class" => "warning"));
        }

        $origreportenabled = ($turnitintooltwoassignment->turnitintooltwo->studentreports) ? 1 : 0;
        $grademarkenabled = ($config->usegrademark && $turnitintooltwoassignment->turnitintooltwo->usegrademark) ? 1 : 0;

        // Do the table headers.
        $cells = array();
        $cells["part"] = new html_table_cell('part');
        $cells["checkbox"] = new html_table_cell('&nbsp;');
        $cells["student"] = new html_table_cell(get_string('student', 'turnitintooltwo'));
        $cells["student"]->attributes['class'] = 'left';
        $cells["title"] = new html_table_cell(get_string('submissiontitle', 'turnitintooltwo'));
        $cells["title"]->attributes['class'] = 'left';
        $cells["paper_id"] = new html_table_cell(get_string('objectid', 'turnitintooltwo'));
        $cells["paper_id"]->attributes['class'] = 'right';
        $cells["submitted_date"] = new html_table_cell(get_string('submitted', 'turnitintooltwo'));
        $cells["submitted_date"]->attributes['class'] = 'right';
        if (($turnitintooltwouser->get_user_role() == 'Instructor') ||
                ($turnitintooltwouser->get_user_role() == 'Learner' && $origreportenabled)) {
            $cells["report_raw"] = new html_table_cell();
            $cells["report_raw"]->attributes['class'] = 'raw_data';
            $cells["report"] = new html_table_cell(get_string('submissionorig', 'turnitintooltwo'));
            $cells["report"]->attributes['class'] = 'right';
        }
        if ($grademarkenabled) {
            $cells["grade_raw"] = new html_table_cell();
            $cells["grade_raw"]->attributes['class'] = 'raw_data';
            $cells["grade"] = new html_table_cell(get_string('submissiongrade', 'turnitintooltwo'));
            $cells["grade"]->id = "grademark";
            $cells["grade"]->attributes['class'] = 'right';
            if (count($partdetails) > 1 || $turnitintooltwoassignment->turnitintooltwo->grade < 0) {
                $cells["overallgrade"] = new html_table_cell(get_string('overallgrade', 'turnitintooltwo'));
                $cells["overallgrade"]->attributes['class'] = 'right';
            }
        }
        if (has_capability('mod/turnitintooltwo:grade', context_module::instance($cm->id))) {
            $cells["student_read"] = new html_table_cell('&nbsp;');
        }
        $cells["upload"] = new html_table_cell('&nbsp;');
        $cells["upload"]->attributes['class'] = "noscript_hide";

        $cells["download"] = new html_table_cell('&nbsp;');
        $cells["delete"] = new html_table_cell('&nbsp;');
        $tableheaders = $cells;

        $tables = "";
        $output .= $OUTPUT->box_start('', 'tabs');
        $tabitems = array();
        $i = 0;

        foreach ($partdetails as $partid => $partobject) {
            if (!empty($partid)) {
                $i++;

                $tabitems[$i] = html_writer::link("#tabs-".$partid, $partobject->partname);
                $tables .= html_writer::tag('h2', $partobject->partname, array('class' => 'js_hide'));
                $tables .= $OUTPUT->box_start('part_table', 'tabs-'.$partid);

                $exportorigfileszip = "";
                $exportgrademarkzip = "";
                if ($turnitintooltwouser->get_user_role() == 'Instructor') {
                    // Output icon to download zip file of selected submissions in original format.
                    $exportorigfileszip = $OUTPUT->box($OUTPUT->pix_icon('file',
                                                get_string('downloadorigfileszip', 'turnitintooltwo'), 'mod_turnitintooltwo').
                                                    get_string('downloadorigfileszip', 'turnitintooltwo'),
                                                'zip_open origchecked_zip_open', 'origchecked_zip_'.$partobject->tiiassignid);
                    // Put in div placeholder for launch form.
                    $exportorigfileszip .= $OUTPUT->box('', 'launch_form', 'origchecked_zip_form_'.$partobject->tiiassignid);

                    // Output icon to download zip file of submissions in pdf format.
                    $exportgrademarkzip = html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.
                                                        $cm->id.'&part='.$partid.'&do=export_pdfs&view_context=box_solid',
                                                        $OUTPUT->pix_icon('file-pdf',
                                                            get_string('downloadgrademarkzip', 'turnitintooltwo'),
                                                                'mod_turnitintooltwo').
                                                            get_string('downloadgrademarkzip', 'turnitintooltwo'),
                                            array("class" => "gmpdfzip_box", "id" => "gmpdf_zip_".$partobject->tiiassignid));
                }

                // Include download links and info table.
                $tables .= $OUTPUT->box($exportorigfileszip.$exportgrademarkzip, '', 'zip_downloads');
                $tables .= $this->get_submission_inbox_part_details($cm, $turnitintooltwoassignment, $partdetails, $partid);

                // Construct submissions table.
                $table = new html_table();
                $table->id = $partid;
                $table->attributes['class'] = 'submissionsDataTable';
                $table->head = $tableheaders;

                // Populate inbox if user is a student incase they do not have javascript enabled.
                if ($turnitintooltwouser->get_user_role() == 'Learner') {
                    $submission = current($this->get_submission_inbox($cm, $turnitintooltwoassignment, $partdetails, $partid));

                    // If not logged in as a tutor then refresh submissions.
                    $turnitintooltwoassignment->refresh_submissions($partobject);

                    $j = 0;
                    $cells = array();
                    foreach ($submission as $cell) {
                        $cells[$j] = new html_table_cell($cell);
                        if ($j == 2 || $j == 3) {
                            $cells[$j]->attributes['class'] = "left";
                        } else if ($j == 4 || $j == 5) {
                            $cells[$j]->attributes['class'] = "right";
                        } else if (($j == 6 && $origreportenabled) || ($j == 6 && !$origreportenabled && $grademarkenabled) ||
                                    ($j == 8 && $origreportenabled && $grademarkenabled)) {
                            $cells[$j]->attributes['class'] = "raw_data";
                        } else {
                            $cells[$j]->attributes['class'] = "centered_cell";
                        }

                        if ((count($submission) == 14 && $j == 9) || (count($submission) == 13 && $j == 8)) {
                            $cells[$j]->attributes['class'] = "noscript_hide";
                        }

                        $j++;
                    }
                    $rows[0] = new html_table_row($cells);
                    $table->data = $rows;
                }

                $tables .= html_writer::table($table);
                $tables .= $OUTPUT->box_end(true);

                // Link to open Turnitin Messages inbox.
                $messagesinbox = '';
                if ($turnitintooltwouser->get_user_role() == 'Instructor') {
                    $messagesinbox = html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.
                                                        '&user='.$turnitintooltwouser->id.'&do=loadmessages&view_context=box',
                                                    $OUTPUT->pix_icon('messages', get_string('messagesinbox', 'turnitintooltwo'),
                                                        'mod_turnitintooltwo').' '.get_string('messagesinbox', 'turnitintooltwo').
                                                            ' ('.html_writer::tag('span', '', array('class' => 'messages_amount')).
                                                                html_writer::tag('span', $OUTPUT->pix_icon('loading',
                                                                get_string('turnitinloading', 'turnitintooltwo'), 'mod_turnitintooltwo'),
                                                                array('class' => 'messages_loading messages_loading_span')).')',
                                                array("class" => "messages_inbox"));
                }

                // Link to refresh submissions with latest data from Turnitin.
                $refreshlink = html_writer::tag('div', $OUTPUT->pix_icon('refresh',
                                                get_string('turnitinrefreshsubmissions', 'turnitintooltwo'),
                                                        'mod_turnitintooltwo')." ".
                                                    get_string('turnitinrefreshsubmissions', 'turnitintooltwo'),
                                                        array('class' => 'refresh_link', 'id' => 'refresh_'.$partid));

                $output .= $OUTPUT->box($messagesinbox.$refreshlink, '', 'tii_table_functions');
            }
        }

        $output .= html_writer::alist($tabitems, array("id" => "part_tabs_menu"));

        $output .= $tables;
        $output .= $OUTPUT->box_end(true);

        return $output;
    }

    /**
     * Construct table with part details
     *
     * @global type $OUTPUT
     * @global type $CFG
     * @param type $cm
     * @param type $turnitintooltwoassignment
     * @param type $partdetails
     * @param type $partid
     * @return type
     */
    private function get_submission_inbox_part_details($cm, $turnitintooltwoassignment, $partdetails, $partid) {
        global $OUTPUT, $CFG;

        $config = turnitintooltwo_admin_config();
        $table = new html_table();
        $rows = array();

        $istutor = has_capability('mod/turnitintooltwo:grade', context_module::instance($cm->id));

        $cells = array();
        $cells[0] = new html_table_cell(get_string('title', 'turnitintooltwo'));
        $cells[0]->attributes['class'] = 'left';
        $cells[1] = new html_table_cell(get_string('dtstart', 'turnitintooltwo'));
        $cells[2] = new html_table_cell(get_string('dtdue', 'turnitintooltwo'));
        $cells[3] = new html_table_cell(get_string('dtpost', 'turnitintooltwo'));
        $cells[4] = new html_table_cell(get_string('marksavailable', 'turnitintooltwo'));
        if ($istutor) {
            $cells[5] = new html_table_cell(get_string('downloadexport', 'turnitintooltwo'));
            $cells[6] = new html_table_cell('');
        }
        $partsheaders = $cells;

        $cells = array();
        // Link to show intro/summary.
        $links = "";
        if (!empty($turnitintooltwoassignment->turnitintooltwo->intro)) {
            $hidetext = $OUTPUT->pix_icon('icon-hide', get_string('hidesummary', 'turnitintooltwo'), 'mod_turnitintooltwo',
                                        array('class' => 'hide_summary_'.$turnitintooltwoassignment->turnitintooltwo->id));
            $showtext = $OUTPUT->pix_icon('icon-show', get_string('showsummary', 'turnitintooltwo'), 'mod_turnitintooltwo',
                                        array('class' => 'show_summary_'.$turnitintooltwoassignment->turnitintooltwo->id));
            $links = html_writer::link('javascript:void(0)', $showtext.$hidetext , array('class' => 'toggle_summary'));
        }

        // Allow part name to be editable if a tutor is logged in.
        $textfield = $partdetails[$partid]->partname;
        if ($istutor) {
            $textfield = html_writer::link('#', $partdetails[$partid]->partname,
                                            array('class' => 'editable_text editable_text_'.$partid,
                                                'data-type' => 'text', 'data-pk' => $partid, 'data-name' => 'partname',
                                                'id' => 'part_name_'.$partid,
                                                'data-params' => "{ 'assignment': ".
                                                                    $turnitintooltwoassignment->turnitintooltwo->id.", ".
                                                                    "'action': 'edit_field', 'sesskey': '".sesskey()."' }"));
        }
        $cells[0] = new html_table_cell($links.$turnitintooltwoassignment->turnitintooltwo->name." (".$textfield.") ");

        // Allow start date field to be editable if a tutor is logged in.
        $datefield = userdate($partdetails[$partid]->dtstart, '%d %h %Y - %H:%M');
        if ($istutor) {
            $datefield = html_writer::link('#', $datefield,
                                            array('class' => 'editable_date editable_date_'.$partid,
                                                'data-pk' => $partid, 'data-name' => 'dtstart', 'id' => 'date_start_'.$partid,
                                                'data-params' => "{ 'assignment': ".
                                                                    $turnitintooltwoassignment->turnitintooltwo->id.", ".
                                                                    "'action': 'edit_field', 'sesskey': '".sesskey()."' }"));
        }
        $cells[1] = new html_table_cell($datefield);
        $cells[1]->attributes['class'] = 'data';

        // Allow due date field to be editable if a tutor is logged in.
        $datefield = userdate($partdetails[$partid]->dtdue, '%d %h %Y - %H:%M');
        if ($istutor) {
            $datefield = html_writer::link('#', $datefield,
                                            array('class' => 'editable_date editable_date_'.$partid,
                                                'data-pk' => $partid, 'data-name' => 'dtdue', 'id' => 'date_due_'.$partid,
                                                'data-params' => "{ 'assignment': ".
                                                                    $turnitintooltwoassignment->turnitintooltwo->id.", ".
                                                                    "'action': 'edit_field', 'sesskey': '".sesskey()."' }"));
        }
        $cells[2] = new html_table_cell($datefield);
        $cells[2]->attributes['class'] = 'data';

        // Allow post date field to be editable if a tutor is logged in.
        $datefield = userdate($partdetails[$partid]->dtpost, '%d %h %Y - %H:%M');
        if ($istutor) {
            $datefield = html_writer::link('#', $datefield,
                                            array('class' => 'editable_date editable_date_'.$partid,
                                                'data-pk' => $partid, 'data-name' => 'dtpost', 'id' => 'date_post_'.$partid,
                                                'data-params' => "{ 'assignment': ".
                                                                    $turnitintooltwoassignment->turnitintooltwo->id.", ".
                                                                    "'action': 'edit_field', 'sesskey': '".sesskey()."' }"));
        }
        $cells[3] = new html_table_cell($datefield);
        $cells[3]->attributes['class'] = 'data';

        // Show Rubric view if applicable to students.
        $rubricviewlink = '';
        if (!$istutor && $config->usegrademark && !empty($turnitintooltwoassignment->turnitintooltwo->rubric)) {
            $rubricviewlink .= $OUTPUT->box_start('row_rubric_manager', '');
            $rubricviewlink .= html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.
                                                    '&part='.$partid.'&do=rubricview&view_context=box', '',
                                                array('class' => 'rubric_view_launch', 'id' => 'rubric_view_launch',
                                                    'title' => get_string('launchrubricview', 'turnitintooltwo')));
            $rubricviewlink .= html_writer::tag('span', '', array('class' => 'launch_form', 'id' => 'rubric_view_form'));
            $rubricviewlink .= $OUTPUT->box_end(true);
        }

        // Allow marks to be editable if a tutor is logged in.
        $textfield = $partdetails[$partid]->maxmarks.$rubricviewlink;
        if ($istutor) {
            $textfield = html_writer::link('#', $partdetails[$partid]->maxmarks,
                                            array('class' => 'editable_text editable_text_'.$partid, 'id' => 'marks_'.$partid,
                                                'data-type' => 'text', 'data-pk' => $partid, 'data-name' => 'maxmarks',
                                                'data-params' => "{ 'assignment': ".
                                                                    $turnitintooltwoassignment->turnitintooltwo->id.", ".
                                                                    "'action': 'edit_field', 'sesskey': '".sesskey()."' }"));
        }
        $cells[4] = new html_table_cell($textfield);
        $cells[4]->attributes['class'] = 'data';

        if ($istutor) {
            $links = "--";
            // Only show export links if there has been submissions and anonymous marking is still enforced.
            if ($turnitintooltwoassignment->count_submissions($cm, $partid) > 0
                    && (($turnitintooltwoassignment->turnitintooltwo->anon == 0)
                        || ($turnitintooltwoassignment->turnitintooltwo->anon > 0 && $partdetails[$partid]->dtpost > time()))) {

                // Output icon to download zip file of submissions in original format.
                $exportoriginalzip = $OUTPUT->box_start('row_export_orig', '');
                $exportoriginalzip .= $OUTPUT->box($OUTPUT->pix_icon('file',
                                        get_string('downloadorigzip', 'turnitintooltwo'), 'mod_turnitintooltwo'),
                                        'zip_open orig_zip_open', 'orig_zip_'.$partdetails[$partid]->tiiassignid);
                // Put in div placeholder for launch form.
                $exportoriginalzip .= $OUTPUT->box('', 'launch_form', 'orig_zip_form_'.$partdetails[$partid]->tiiassignid);
                $exportoriginalzip .= $OUTPUT->box_end(true);

                // Output icon to download zip file of submissions in pdf format.
                $exportpdfzip = html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.
                                        $cm->id.'&part='.$partid.'&do=export_pdfs&view_context=box_solid',
                                        $OUTPUT->pix_icon('file-pdf', get_string('downloadpdfzip', 'turnitintooltwo'),
                                                                        'mod_turnitintooltwo'),
                                        array("class" => "downloadpdf_box",
                                                "id" => "download_".$partdetails[$partid]->tiiassignid));

                // Output icon to download excel spreadsheet of grades.
                $exportxlszip = $OUTPUT->box_start('row_export_xls', '');
                $exportxlszip .= $OUTPUT->box($OUTPUT->pix_icon('file-xls',
                                            get_string('downloadgradexls', 'turnitintooltwo'), 'mod_turnitintooltwo'),
                                            'zip_open xls_inbox_open', 'xls_inbox_'.$partdetails[$partid]->tiiassignid);
                // Put in div placeholder for launch form.
                $exportxlszip .= $OUTPUT->box('', 'launch_form', 'xls_inbox_form_'.$partdetails[$partid]->tiiassignid);
                $exportxlszip .= $OUTPUT->box_end(true);

                $links = $exportxlszip.$exportpdfzip.$exportoriginalzip;
            }

            $cells[5] = new html_table_cell($links);
            $cells[5]->attributes['class'] = 'export_data';

            // Show feature links (rubric and quickmark).
            if ($config->usegrademark) {
                // Rubric Manager.
                $rubricmanagerlink = $OUTPUT->box_start('row_rubric_manager', '');
                $rubricmanagerlink .= html_writer::link($CFG->wwwroot.
                                        '/mod/turnitintooltwo/extras.php?cmd=rubricmanager&view_context=box', '',
                                                array('class' => 'rubric_manager_launch', 'id' => 'rubric_manager_inbox_launch',
                                                    'title' => get_string('launchrubricmanager', 'turnitintooltwo')));
                $rubricmanagerlink .= html_writer::tag('span', '', array('class' => 'launch_form', 'id' => 'rubric_manager_form'));
                $rubricmanagerlink .= $OUTPUT->box_end(true);

                // Quickmark Manager.
                $quickmarkmanagerlink = $OUTPUT->box_start('row_quickmark_manager', '');
                $quickmarkmanagerlink .= html_writer::link($CFG->wwwroot.
                                            '/mod/turnitintooltwo/extras.php?cmd=quickmarkmanager&view_context=box', '',
                                                array('class' => 'quickmark_manager_launch',
                                                        'title' => get_string('launchquickmarkmanager', 'turnitintooltwo')));
                $quickmarkmanagerlink .= html_writer::tag('span', '', array('class' => 'launch_form',
                                                                            'id' => 'quickmark_manager_form'));
                $quickmarkmanagerlink .= $OUTPUT->box_end(true);

                $cells[6] = new html_table_cell($rubricmanagerlink.$quickmarkmanagerlink);
                $cells[6]->attributes['class'] = 'rubric_qm';
            }
        }
        $rows['part_details'] = new html_table_row($cells);

        // Show summary box.
        if (!empty($turnitintooltwoassignment->turnitintooltwo->intro)) {
            $cells = array();
            $intro = html_writer::tag('div', get_string("turnitintooltwointro", "turnitintooltwo").": ".
                        $turnitintooltwoassignment->turnitintooltwo->intro, array("class" => "introduction"));

            $cells[0] = new html_table_cell($intro);
            $cells[0]->attributes['class'] = 'introduction_cell';
            $cells[0]->colspan = ($config->usegrademark) ? '7' : '6';

            $rows['intro'] = new html_table_row($cells);
        }

        // Show Peermark row if enabled.
        if ($config->enablepeermark) {

            $cells = array();
            // Show Peermark hide/show links.
            $hidetext = $OUTPUT->pix_icon('icon-hide', get_string('hidepeermark', 'turnitintooltwo'), 'mod_turnitintooltwo',
                                        array('class' => 'hide_peermarks_'.$turnitintooltwoassignment->turnitintooltwo->id));
            $showtext = $OUTPUT->pix_icon('icon-show', get_string('showpeermark', 'turnitintooltwo'), 'mod_turnitintooltwo',
                                        array('class' => 'show_peermarks_'.$turnitintooltwoassignment->turnitintooltwo->id));
            $links = html_writer::link('javascript:void(0)', $showtext.$hidetext , array('class' => 'toggle_peermarks js_hide'));

            // Peermark Settings Link.
            $peermarkmanagerlink = "";
            if ($istutor) {
                $peermarkmanagerlink .= $OUTPUT->box_start('row_peermark_manager', '');
                $peermarkmanagerlink .= html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.
                                                            '&part='.$partid.'&do=peermarkmanager&view_context=box', '',
                                                        array('class' => 'peermark_manager_launch',
                                                            'id' => 'peermark_manager_'.$partid,
                                                            'title' => get_string('launchpeermarkmanager', 'turnitintooltwo')));
                $peermarkmanagerlink .= html_writer::tag('span', '', array('class' => 'launch_form',
                                                                    'id' => 'peermark_manager_form'));
                $peermarkmanagerlink .= $OUTPUT->box_end(true);
            }

            // Peermark Reviews Link.
            $peermarkreviewslink = $OUTPUT->box_start('row_peermark_reviews', '');
            $peermarkreviewslink .= html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.
                                                        '&part='.$partid.'&do=peermarkreviews&view_context=box', '',
                                                    array('class' => 'peermark_reviews_launch',
                                                        'title' => get_string('launchpeermarkreviews', 'turnitintooltwo')));
            $peermarkreviewslink .= html_writer::tag('span', '', array('class' => 'launch_form', 'id' => 'peermark_reviews_form'));
            $peermarkreviewslink .= $OUTPUT->box_end(true);

            // If logged in as a student then show peermark data straightaway as they may have javascript disabled.
            $count = ($istutor) ? 0 : count($partdetails[$partid]->peermark_assignments);

            // Build peermark header row.
            if ($istutor || $count > 0) {
                $cells[0] = new html_table_cell($links.html_writer::tag('div',
                                                get_string('peermarkassignments', 'turnitintooltwo').' ('.
                                                    html_writer::tag('span', $count, array('class' => 'peermark_count')).
                                                    html_writer::tag('span', $OUTPUT->pix_icon('loading',
                                                        get_string('turnitinloading', 'turnitintooltwo'), 'mod_turnitintooltwo'),
                                                    array('class' => 'peermark_loading peermark_loading_span')).')',
                                                    array('class' => 'peermark_header')).$peermarkreviewslink.$peermarkmanagerlink);
                $cells[0]->attributes['class'] = 'peermarks';
                $cells[0]->colspan = ($config->usegrademark) ? '7' : '6';
                $rows['peermark'] = new html_table_row($cells);

                $peermarktable = ($istutor) ? '' : $this->show_peermark_assignment($partdetails[$partid]->peermark_assignments);
                $cells[0] = new html_table_cell(html_writer::tag('div', $peermarktable,
                                                    array("class" => "peermark_assignments_container")).
                                                html_writer::tag('div', $OUTPUT->pix_icon('loading',
                                                    get_string('turnitinloading', 'turnitintooltwo'), 'mod_turnitintooltwo'),
                                                        array('class' => 'peermark_loading peermark_loading_row')));
                $cells[0]->attributes['class'] = 'peermark_assignments_cell';
                $cells[0]->colspan = ($config->usegrademark) ? '7' : '6';
                $rows['peermark_assignments'] = new html_table_row($cells);
            }
        }

        $table->attributes['class'] = 'partDetails';
        $table->head = $partsheaders;

        $table->data = $rows;

        $output = html_writer::table($table);

        return $output;
    }

    public function show_peermark_assignment($peermarkassignments, $updating = false) {
        global $OUTPUT;

        $table = new html_table();
        $rows = array();

        // Headers.
        $cells = array();
        $cells[0] = new html_table_cell(get_string('title', 'turnitintooltwo'));
        $cells[0]->attributes['class'] = 'left';
        $cells[1] = new html_table_cell(get_string('dtstart', 'turnitintooltwo'));
        $cells[2] = new html_table_cell(get_string('dtdue', 'turnitintooltwo'));
        $cells[3] = new html_table_cell(get_string('dtpost', 'turnitintooltwo'));
        $cells[4] = new html_table_cell(get_string('marksavailable', 'turnitintooltwo'));
        $cells[5] = new html_table_cell(get_string('noofreviewsrequired', 'turnitintooltwo'));
        $table->head = $cells;

        foreach ($peermarkassignments as $peermarkassignment) {
            $cells = array();

            // Show Peermark Instructions hide/show links.
            if (!empty($peermarkassignment->instructions)) {
                $hidetext = $OUTPUT->pix_icon('icon-hide', get_string('hidepeermark', 'turnitintooltwo'), 'mod_turnitintooltwo',
                                    array('class' => 'hide_peermark_instructions',
                                        'id' => 'hide_peermark_instructions_'.$peermarkassignment->tiiassignid));
                $showtext = $OUTPUT->pix_icon('icon-show', get_string('showpeermark', 'turnitintooltwo'), 'mod_turnitintooltwo',
                                    array('class' => 'show_peermark_instructions',
                                        'id' => 'show_peermark_instructions_'.$peermarkassignment->tiiassignid));
                $links = html_writer::link('javascript:void(0)', $showtext.$hidetext ,
                                    array('class' => 'toggle_peermark_instructions js_hide'));
            } else {
                $links = html_writer::tag('div', '', array('class' => 'peermark_instructions_spacer'));
            }

            $cells[0] = new html_table_cell($links.$peermarkassignment->title);
            $cells[1] = new html_table_cell(userdate($peermarkassignment->dtstart,
                                                    get_string('strftimedatetimeshort', 'langconfig')));
            $cells[1]->attributes['class'] = 'data';
            $cells[2] = new html_table_cell(userdate($peermarkassignment->dtdue,
                                                    get_string('strftimedatetimeshort', 'langconfig')));
            $cells[2]->attributes['class'] = 'data';
            $cells[3] = new html_table_cell(userdate($peermarkassignment->dtpost,
                                                    get_string('strftimedatetimeshort', 'langconfig')));
            $cells[3]->attributes['class'] = 'data';
            $cells[4] = new html_table_cell($peermarkassignment->maxmarks);
            $cells[4]->attributes['class'] = 'data';
            $cells[5] = new html_table_cell($peermarkassignment->distributed_reviews + $peermarkassignment->selected_reviews +
                                                                                            $peermarkassignment->self_review);
            $cells[5]->attributes['class'] = 'data';
            $rows[] = $cells;

            // Put instructions row in if applicable.
            if (!empty($peermarkassignment->instructions)) {
                $cells = array();
                $peermarkinstructions = html_writer::tag('div', get_string("instructions", "auth").": ".
                                                            $peermarkassignment->instructions,
                                                    array("class" => "peermark_instructions", "id" =>
                                                        "peermark_instructions_".$peermarkassignment->tiiassignid));

                $cells[0] = new html_table_cell($peermarkinstructions);
                $cells[0]->colspan = '6';
                $cells[0]->attributes['class'] = 'peermark_instructions_cell';
                $rows[] = $cells;
            }
        }

        $table->data = $rows;
        $table->attributes['class'] = 'peermarkDetails';
        $output = html_writer::table($table);

        return $output;
    }

    /**
     * Get the row for this submission in the inbox table
     *
     * @global object $CFG
     * @global type $OUTPUT
     * @param type $cm
     * @param type $turnitintooltwoassignment
     * @param type $parts
     * @param type $partid
     * @param type $submission
     * @param type $useroverallgrades
     * @param type $istutor
     * @return type
     */
    public function get_submission_inbox_row($cm, $turnitintooltwoassignment, $parts, $partid, $submission,
                                            &$useroverallgrades, $istutor, $context = 'all') {
        global $CFG, $OUTPUT, $USER, $DB;
        $config = turnitintooltwo_admin_config();

        if (!$istutor) {
            $user = new turnitintooltwo_user($USER->id, "Learner");
        }

        $checkbox = "&nbsp;";
        if (!empty($submission->submission_objectid) && $istutor) {
            $checkbox = html_writer::checkbox('check_'.$submission->submission_objectid, $submission->submission_objectid,
                                        false, '', array("class" => "inbox_checkbox"));
        }

        if ($turnitintooltwoassignment->turnitintooltwo->anon) {
            if (empty($submission->submission_unanon) AND $parts[$partid]->dtpost > time() AND
                                                    !empty($submission->submission_objectid)) {
                // Anonymous marking is on, postdate has not passed and a submission has been made.
                $studentname = html_writer::link('.unanonymise_form',
                                        get_string('anonenabled', 'turnitintooltwo'),
                                        array("class" => "unanonymise", "id" => "submission_".$submission->submission_objectid));

            } else if (($parts[$partid]->dtpost <= time() OR !empty($submission->submission_unanon)) AND
                    empty($submission->nmoodle)) {
                // Post date has passed or anonymous marking disabled for user and user is a moodle user.
                $studentname = html_writer::link(
                                $CFG->wwwroot."/user/view.php?id=".$submission->userid."&course="
                                    .$turnitintooltwoassignment->turnitintooltwo->course,
                                $submission->lastname.", ".$submission->firstname);
            } else if (($parts[$partid]->dtpost <= time() OR
                            !empty($submission->submission_unanon)) AND !empty($submission->nmoodle)) {
                // Post date has passed or anonymous marking disabled for user and user is a NON moodle user.
                $studentname = html_writer::tag("span",
                                    $submission->lastname.", ".$submission->firstname." (".
                                            get_string('nonmoodleuser', 'turnitintooltwo').")",
                                    array("class" => "italic"));
            } else {
                // User has not made a submission.
                $studentname = html_writer::tag("span", get_string('anonenabled', 'turnitintooltwo'), array("class" => "italic"));
            }
        } else {
            if (empty($submission->nmoodle)) {
                $studentname = html_writer::link($CFG->wwwroot."/user/view.php?id=".$submission->userid."&course=".
                                                        $turnitintooltwoassignment->turnitintooltwo->course,
                                                        $submission->lastname.", ".$submission->firstname);
            } else if (!empty($submission->nmoodle) && substr($submission->userid, 0, 3) != 'nm-') {
                // Moodle User not enrolled on this course as a student.
                $studentname = html_writer::link($CFG->wwwroot."/user/view.php?id=".$submission->userid."&course=".
                                        $turnitintooltwoassignment->turnitintooltwo->course,
                                        $submission->lastname.", ".$submission->firstname." (".
                                            get_string('nonenrolledstudent', 'turnitintooltwo').")", array("class" => "italic"));
            } else {
                // Non Moodle user.
                $studentname = html_writer::tag("span", $submission->lastname.", ".$submission->firstname." (".
                                                get_string('nonmoodleuser', 'turnitintooltwo').")", array("class" => "italic"));
            }
        }

        $title = (!empty($submission->submission_title)) ? $submission->submission_title : "--";
        $objectid = (!empty($submission->submission_objectid)) ? $submission->submission_objectid : "--";

        // Show date of submission or link to submit if it didn't work.
        if (empty($submission->submission_objectid) AND !empty($submission->id)) {

            $modified = html_writer::link($CFG->wwwroot."/mod/turnitintooltwo/view.php?id=".$cm->id."&action=manualsubmission".
                                            "&sub=".$submission->id.'&sesskey='.sesskey(),
                                                $OUTPUT->pix_icon('icon-sml', get_string('submittoturnitin', 'turnitintooltwo'),
                                                    'mod_turnitintooltwo')." ".get_string('submittoturnitin', 'turnitintooltwo'));

        } else if (empty($submission->submission_objectid)) {
            $modified = "--";
        } else {
            $modified = userdate($submission->submission_modified, get_string('strftimedatetimeshort', 'langconfig'));
        }

        // Show Originality score with link to open document viewer.
        if ( !empty($submission->id) && is_null($submission->submission_score) && $submission->submission_orcapable == 0 ) {
            // Don't show if there is no OR score and submission is not OR capable
            $rawscore = -1;
            $score = '--';
        } else if (!empty($submission->id) && !empty($submission->submission_objectid) &&
                ($istutor || $turnitintooltwoassignment->turnitintooltwo->studentreports)) {
            $score = $OUTPUT->box_start('row_score origreport_open', 'origreport_'.$submission->submission_objectid.
                                                                                    '_'.$partid.'_'.$submission->userid);
            // Show score.
            if (is_null($submission->submission_score)) {
                $score .= $OUTPUT->box('&nbsp;', 'score_colour score_colour_');
                $score .= $OUTPUT->box(get_string('pending', 'turnitintooltwo'), 'origreport_score');
                $rawscore = -1;
            } else {
                // Put EN flag if translated matching is on and that is the score used.
                $transmatch = ($submission->submission_transmatch == 1) ? 'EN' : '&nbsp;';
                $score .= $OUTPUT->box($transmatch, 'score_colour score_colour_'.round($submission->submission_score, -1));
                $score .= $OUTPUT->box($submission->submission_score.'%', 'origreport_score');
                $rawscore = $submission->submission_score;
            }

            // Put in div placeholder for DV launch form.
            $score .= $OUTPUT->box('', 'launch_form', 'origreport_form_'.$submission->submission_objectid);
            $score .= $OUTPUT->box_end(true);
        } else {
            $rawscore = -1;
            $score = '--';
        }

        // Show grade and link to DV.
        if ($config->usegrademark && $turnitintooltwoassignment->turnitintooltwo->usegrademark) {
            if (isset($submission->submission_objectid) && ($istutor || (!$istutor && $parts[$partid]->dtpost < time()))) {
                $submissiongrade = (!empty($submission->submission_grade)) ? $submission->submission_grade : '';

                if (empty($submission->submission_grade) || ($submission->submission_gmimaged == 0 && !$istutor)) {
                    $submissiongrade = "--";
                }

                $class = ($istutor && $turnitintooltwoassignment->turnitintooltwo->usegrademark && $submissiongrade != "--"
                            && $turnitintooltwoassignment->turnitintooltwo->reportgenspeed == 1) ? " graded_warning" : "";
                // Output grademark icon.
                $grade = $OUTPUT->box($OUTPUT->pix_icon('icon-edit',
                                        get_string('launchgrademark', 'turnitintooltwo'), 'mod_turnitintooltwo'),
                                        'grademark_open'.$class, 'grademark_'.$submission->submission_objectid.'_'.$partid.
                                                                                    '_'.$submission->userid);
                // Show grade.
                $grade .= $OUTPUT->box(html_writer::tag('span', $submissiongrade, array("class" => "grade"))
                                ."/".$parts[$partid]->maxmarks, 'grademark_grade');
                // Put in div placeholder for DV launch form.
                $grade .= $OUTPUT->box('', 'launch_form', 'grademark_form_'.$submission->submission_objectid);
                $rawgrade = ($submissiongrade == "--") ? -1 : $submissiongrade;

            } else if (!isset($submission->submission_objectid) && empty($submission->id) && $istutor ) {
                // Allow nothing submission if no submission has been made and this is a tutor
                $grade = $OUTPUT->box(get_string('submitnothingwarning', 'turnitintooltwo'),'nothingsubmit_warning', '');
                $grade .= $OUTPUT->box($OUTPUT->pix_icon('icon-edit-grey',
                                        get_string('submitnothing', 'turnitintooltwo'), 'mod_turnitintooltwo'),
                                        'submit_nothing', 'submitnothing_0_'.$partid.'_'.$submission->userid);
                $rawgrade = -1;
            } else {
                $rawgrade = -1;
                $grade = $OUTPUT->box('--', '');
            }

            // Show average grade if more than 1 part.
            if (count($parts) > 1 || $turnitintooltwoassignment->turnitintooltwo->grade < 0) {
                $overallgrade = '--';
                if ($submission->nmoodle != 1 && ($istutor || (!$istutor && $parts[$partid]->dtpost < time()))) {
                    if (!isset($useroverallgrades[$submission->userid])) {
                        $usersubmissions = $turnitintooltwoassignment->get_user_submissions($submission->userid,
                                                                                $turnitintooltwoassignment->turnitintooltwo->id);
                        $useroverallgrades[$submission->userid] = $turnitintooltwoassignment->get_overall_grade($usersubmissions);
                    }

                    if ($turnitintooltwoassignment->turnitintooltwo->grade == 0 ||
                                                    $useroverallgrades[$submission->userid] === '--') {
                        $overallgrade = '--';
                    } else if ($turnitintooltwoassignment->turnitintooltwo->grade < 0) { // Scale.
                        $scale = $DB->get_record('scale', array('id' => $turnitintooltwoassignment->turnitintooltwo->grade * -1));
                        $scalearray = explode(",", $scale->scale);
                        $overallgrade = $scalearray[$useroverallgrades[$submission->userid] - 1];
                    } else {
                        $overallgrade = round($useroverallgrades[$submission->userid] /
                                                    $turnitintooltwoassignment->turnitintooltwo->grade * 100, 1).'%';
                    }

                    if ($overallgrade != '--') {
                        $overallgrade = html_writer::tag("span", $overallgrade,
                                                            array("class" => "overallgrade_".$submission->userid));
                    }
                }
            }
        }

        // Indicate whether student has seen grademark image.
        if ($istutor) {
            if (isset($submission->submission_objectid)) {
                $submissionattempts = (!empty($submission->submission_attempts)) ? $submission->submission_attempts : 0;
                if ($submissionattempts > 0) {
                    $studentread = $OUTPUT->pix_icon('icon-student-read',
                                        get_string('student_read', 'turnitintooltwo').' '.userdate($submissionattempts),
                                        'mod_turnitintooltwo', array("class" => "student_read_icon"));
                } else {
                    $studentread = $OUTPUT->pix_icon('icon-dot', get_string('student_notread', 'turnitintooltwo'),
                                        'mod_turnitintooltwo', array("class" => "student_dot_icon"));
                }
            } else {
                $studentread = "--";
            }
        }

        // Upload Submission.
        if ((!isset($submission->submission_objectid) || $turnitintooltwoassignment->turnitintooltwo->reportgenspeed != 0) &&
                    (time() < $parts[$partid]->dtdue || $turnitintooltwoassignment->turnitintooltwo->allowlate == 1) &&
                    empty($submission->nmoodle) && time() > $parts[$partid]->dtstart) {

            if (empty($submission->submission_objectid)) {
                $submission->submission_objectid = 0;
            }

            $uploadtext = (!$istutor) ? html_writer::tag('span', get_string('submitpaper', 'turnitintooltwo')) : '';

            $upload = html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.'&part='.$partid.'&user='.
                                        $submission->userid.'&do=submitpaper&view_context=box_solid', $uploadtext.
                                        $OUTPUT->pix_icon('file-upload', get_string('submittoturnitin', 'turnitintooltwo'),
                                            'mod_turnitintooltwo'),
                                        array("class" => "upload_box", "id" => "upload_".$submission->submission_objectid.
                                                            "_".$partid."_".$submission->userid));
        } else {
            $upload = "&nbsp;";
        }

        // Download submission in original format.
        if (!empty($submission->submission_objectid) && !empty($submission->id) && !$submission->submission_acceptnothing) {
            $download = $OUTPUT->box($OUTPUT->pix_icon('file-download', get_string('downloadsubmission', 'turnitintooltwo'),
                                        'mod_turnitintooltwo'), 'download_original_open',
                                        'downloadoriginal_'.$submission->submission_objectid."_".$partid."_".$submission->userid);
            $download .= $OUTPUT->box('', 'launch_form', 'downloadoriginal_form_'.$submission->submission_objectid);

            // Add in LTI launch form incase Javascript is disabled.
            if (!$istutor) {
                $download .= html_writer::tag('noscript', $this->output_dv_launch_form("downloadoriginal",
                                                $submission->submission_objectid, $user->tii_user_id, "Learner",
                                                get_string('downloadsubmission', 'turnitintooltwo')));
            }
        } else {
            $download = "--";
        }

        // Delete Link.
        $delete = "--";
        if ($istutor) {
            if (!empty($submission->id)) {
                $fnd = array("\n", "\r");
                $rep = array('\n', '\r');
                $confirmstring = (empty($submission->submission_objectid)) ? 'deleteconfirm' : 'turnitindeleteconfirm';
                $string = str_replace($fnd, $rep, get_string($confirmstring, 'turnitintooltwo'));

                $attributes = array("onclick" => "return confirm('".$string."');");
                $delete = html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.'&action=deletesubmission&'.
                                            'sub='.$submission->id.'&sesskey='.sesskey(),
                        $OUTPUT->pix_icon('delete', get_string('deletesubmission', 'turnitintooltwo'), 'mod_turnitintooltwo'),
                                                        $attributes);
            }
        } else {
            if (empty($submission->submission_objectid) && !empty($submission->id)) {
                $fnd = array("\n", "\r");
                $rep = array('\n', '\r');
                $string = str_replace($fnd, $rep, get_string('deleteconfirm', 'turnitintooltwo'));

                $attributes = array("onclick" => "return confirm('".$string."');");
                $delete = html_writer::link($CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.$cm->id.'&action=deletesubmission&'.
                                            'sub='.$submission->id.'&sesskey='.sesskey(),
                        $OUTPUT->pix_icon('delete', get_string('deletesubmission', 'turnitintooltwo'),
                                                        'mod_turnitintooltwo'), $attributes);
            }
        }

        $data = array($partid, $checkbox, $studentname, $title, $objectid, $modified);
        if (($istutor) || (!$istutor && $turnitintooltwoassignment->turnitintooltwo->studentreports)) {
            if ($context == 'all') {
                $data[] = (int)$rawscore;
            }
            $data[] = $score;
        }
        if ($config->usegrademark AND $turnitintooltwoassignment->turnitintooltwo->usegrademark == 1) {
            if ($context == 'all') {
                $data[] = (int)$rawgrade;
            }
            $data[] = $grade;
            if (count($parts) > 1 || $turnitintooltwoassignment->turnitintooltwo->grade < 0) {
                $data[] = $overallgrade;
            }
        }
        if ($istutor) {
            $data[] = $studentread;
        }
        $data[] = $upload;
        $data[] = $download;
        $data[] = $delete;

        return $data;
    }

    /**
     * Return submission inbox in a JSON array
     *
     * @global type $CFG
     * @global type $OUTPUT
     * @param object $cm
     * @param object $turnitintooltwoassignment
     * @param int $partid
     * @return array inbox data
     */
    public function get_submission_inbox($cm, $turnitintooltwoassignment, $parts, $partid, $start = 0) {
        $useroverallgrades = array();

        $istutor = has_capability('mod/turnitintooltwo:grade', context_module::instance($cm->id));

        if ($start == 0) {
            $submissions = $turnitintooltwoassignment->get_submissions($cm, $partid);
            $_SESSION["submissions"][$partid] = $submissions[$partid];
        }

        $submissiondata = array();

        $i = -1;
        $j = 0;

        foreach ($_SESSION["submissions"][$partid] as $submission) {
            $i++;

            if ($i < $start) {
                continue;
            } else {

                $data = $this->get_submission_inbox_row($cm, $turnitintooltwoassignment, $parts, $partid, $submission,
                                                        $useroverallgrades, $istutor);
                $submissiondata[] = $data;
                $j++;
            }

            if ($j == TURNITINTOOLTWO_SUBMISSION_GET_LIMIT) {
                break;
            }
        }

        return $submissiondata;
    }

    /**
     * Show the form to allow tutor to reveal the name of a student who has submitted
     * to an assignment that has anonymous marking enabled
     *
     * @return output
     */
    public function show_unanonymise_form() {
        $output = html_writer::tag("span", get_string('revealdesc', 'turnitintooltwo'), array("id" => "unanonymise_desc"));

        $elements = array();
        $elements[] = array('textarea', 'anonymous_reveal_reason', get_string('revealreason', 'turnitintooltwo'),
                                '', array(), 'required', get_string('revealerror', 'turnitintooltwo'), PARAM_TEXT);
        $elements[] = array('hidden', 'assignment_id', '');
        $elements[] = array('hidden', 'submission_id', '');
        $elements[] = array('button', 'reveal', get_string('reveal', 'turnitintooltwo'));

        $customdata["elements"] = $elements;
        $customdata["hide_submit"] = true;
        $customdata["disable_form_change_checker"] = true;
        $optionsform = new turnitintooltwo_form('', $customdata);

        return html_writer::tag('div', $output.$optionsform->display(), array('class' => 'unanonymise_form'));
    }

    /**
     * Return the output for a form to launch the document viewer, it is then submitted
     * on load via Javascript
     *
     * @param str $type the type of document viewer that needs to be opened
     * @param int $submissionid the Turnitin submission id
     * @param int $userid the Turnitin user id
     * @param str $userrole the role the user has on Turnitin in the course/class
     * @param str $buttonstring string for the submit button
     * @return output form
     */
    public static function output_dv_launch_form($type, $submissionid, $userid, $userrole,
                                                $buttonstring = "Submit", $ltireturn = false) {
        // Initialise Comms Object.
        $turnitincomms = new turnitintooltwo_comms();
        $turnitincall = $turnitincomms->initialise_api();

        // Construct LTI Form Launcher.
        $lti = new TiiLTI();
        if ($type != "useragreement") {
            $lti->setSubmissionId($submissionid);
        }
        $lti->setUserId($userid);
        $lti->setRole($userrole);
        $lti->setButtonText($buttonstring);

        switch ($type) {
            case "useragreement":
                $ltifunction = "outputUserAgreementForm";
                break;

            case "downloadoriginal":
                $ltifunction = "outputDownloadOriginalFileForm";
                break;

            case "default":
                $lti->setFormTarget("dvWindow");
                $ltifunction = "outputDVDefaultForm";
                break;

            case "origreport":
                $lti->setFormTarget("dvWindow");
                $ltifunction = "outputDVReportForm";
                break;

            case "grademark":
                $lti->setFormTarget("dvWindow");
                $ltifunction = "outputDVGradeMarkForm";
                break;
        }

        if ($ltireturn == false) {
            // Read the LTI launch form in the output buffer.
            ob_start();
            $turnitincall->$ltifunction($lti, $ltireturn);
            $launchdv = ob_get_contents();
            ob_end_clean();

            return $launchdv;
        } else {
            $lti->setAsJson(true);
            return $turnitincall->$ltifunction($lti, $ltireturn);
        }
    }

    /**
     * Return the output for a form to launch a zip or xls download, it is then submitted
     * on load via Javascript
     *
     * @param str $type the type of download that needs to be launched
     * @param int $partid the Turnitin id of the assignment part
     * @param int $userid the Turnitin user id
     * @param str $buttonstring string for the submit button
     * @return output form
     */
    public static function output_download_launch_form($type, $userid, $partid, $submissionids = array(),
                                                        $buttonstring = "Submit") {
        // Initialise Comms Object.
        $turnitincomms = new turnitintooltwo_comms();
        $turnitincall = $turnitincomms->initialise_api();

        // Construct LTI Form Launcher.
        $lti = new TiiLTI();
        $lti->setAssignmentId($partid);
        $lti->setUserId($userid);
        $lti->setRole("Instructor");
        $lti->setButtonText($buttonstring);

        if (!empty($submissionids)) {
            $lti->setSubmissionIds($submissionids);
        }

        switch ($type) {
            case "orig_zip":
                $ltifunction = "outputDownloadZipForm";
                break;

            case "pdf_zip":
                $ltifunction = "outputDownloadPDFZipForm";
                $lti->setFormTarget('');
                break;

            case "xls_inbox":
                $ltifunction = "outputDownloadXLSForm";
                break;

            case "origchecked_zip":
                $ltifunction = "outputDownloadZipForm";
                break;

            case "gmpdf_zip":
                $ltifunction = "outputDownloadGradeMarkZipForm";
                $lti->setFormTarget('');
                break;

        }

        // Read the LTI launch form in the output buffer.
        ob_start();
        $turnitincall->$ltifunction($lti);
        $launchdownload = ob_get_contents();
        ob_end_clean();

        return $launchdownload;
    }

    /**
     * Return the output for a form to launch the relevant LTi function
     * It is then submitted on load via Javascript
     *
     * @param string $userrole either Instructor or Learner
     * @param int $userid
     * @return output form
     */
    public function output_lti_form_launch($type, $userrole, $partid = 0) {
        global $USER, $CFG;
        // Initialise Comms Object.
        $turnitincomms = new turnitintooltwo_comms();
        $turnitincall = $turnitincomms->initialise_api();

        $user = new turnitintooltwo_user($USER->id, $userrole);

        $lti = new TiiLTI();
        $lti->setUserId($user->tii_user_id);
        $lti->setRole($userrole);
        $lti->setFormTarget('');

        switch ($type) {
            case "messages_inbox":
                $ltifunction = "outputMessagesForm";
                break;

            case "rubric_manager":
                $ltifunction = "outputRubricManagerForm";
                break;

            case "rubric_view":
                $lti->setAssignmentId($partid);
                $ltifunction = "outputRubricViewForm";
                break;

            case "quickmark_manager":
                $ltifunction = "outputQuickmarkManagerForm";
                break;

            case "peermark_manager":
                $lti->setAssignmentId($partid);
                $ltifunction = "outputPeerMarkSetupForm";
                break;

            case "peermark_reviews":
                $lti->setAssignmentId($partid);
                $ltifunction = "outputPeerMarkReviewForm";
                break;
        }

        ob_start();
        $turnitincall->$ltifunction($lti);
        $rubricform = ob_get_contents();
        ob_end_clean();

        return $rubricform;
    }

    /**
     * Return a table containing all the assignments in the relevant course
     *
     * @global type $CFG
     * @global type $OUTPUT
     * @param obj $course the moodle course data
     * @return output
     */
    public function show_assignments($course) {
        global $CFG, $OUTPUT, $USER;

        $turnitintooltwos = turnitintooltwo_assignment::get_all_assignments_in_course($course);

        $table = new html_table();
        $table->id = "dataTable";
        $rows = array();

        // Do the table headers.
        $cells = array();
        if ($course->format == "weeks") {
            $cells["weeks"] = new html_table_cell(get_string("week"));
        } else if ($course->format == "topics") {
            $cells["topics"] = new html_table_cell(get_string("topic"));
        }
        $cells["name"] = new html_table_cell(get_string("name"));
        $cells["start_date"] = new html_table_cell(get_string("dtstart", "turnitintooltwo"));
        $cells["number_of_parts"] = new html_table_cell(get_string("numberofparts", "turnitintooltwo"));
        $cells["submissions"] = new html_table_cell(get_string("submissions", "turnitintooltwo"));
        $table->head = $cells;

        $i = 1;
        foreach ($turnitintooltwos as $turnitintooltwo) {

            $cm = get_coursemodule_from_id('turnitintooltwo', $turnitintooltwo->coursemodule, $course->id);
            $turnitintooltwoassignment = new turnitintooltwo_assignment($turnitintooltwo->id, $turnitintooltwo);

            if ($course->format == "weeks" || $course->format == "topics") {
                $cells[$course->format] = new html_table_cell($turnitintooltwoassignment->turnitintooltwo->section);
                $cells[$course->format]->attributes["class"] = "centered_cell";
            }

            // Show links dimmed if the mod is hidden.
            $attributes["class"] = (!$turnitintooltwo->visible) ? 'dimmed' : '';
            $linkurl = $CFG->wwwroot.'/mod/turnitintooltwo/view.php?id='.
                            $turnitintooltwoassignment->turnitintooltwo->coursemodule.'&do=submissions';

            $cells["name"] = new html_table_cell(html_writer::link($linkurl, $turnitintooltwo->name, $attributes));
            $cells["start_date"] = new html_table_cell(userdate($turnitintooltwoassignment->get_start_date(),
                                                            get_string('strftimedatetimeshort', 'langconfig')));
            $cells["start_date"]->attributes["class"] = "centered_cell";

            $cells["number_of_parts"] = new html_table_cell(count($turnitintooltwoassignment->get_parts()));
            $cells["number_of_parts"]->attributes["class"] = "centered_cell";

            if (has_capability('mod/turnitintooltwo:grade', context_module::instance($cm->id))) {
                $noofsubmissions = $turnitintooltwoassignment->count_submissions($cm, 0);
            } else {
                $noofsubmissions = count($turnitintooltwoassignment->get_user_submissions($USER->id,
                                                        $turnitintooltwoassignment->turnitintooltwo->id));
            }
            $cells["submissions"] = new html_table_cell(html_writer::link($linkurl, $noofsubmissions, $attributes));
            $cells["submissions"]->attributes["class"] = "centered_cell";

            $rows[$i] = new html_table_row($cells);
            $i++;
        }

        $table->data = $rows;
        return $OUTPUT->box(html_writer::table($table), 'generalbox boxaligncenter');
    }

    /**
     * Initialise the table that will show a list of tutors or students that are enrolled on
     * a particular course. Accessible from the assignment summary screen.
     *
     * @global type $OUTPUT
     * @param type $role the user role to view a list of
     * @return output
     */
    public function init_tii_member_by_role_table($cm, $turnitintooltwoassignment, $role = "Learner") {
        global $OUTPUT;

        $_SESSION["ajax"]["tii_role"] = $role;
        $cellheader = ($role == "Instructor") ? get_string('turnitintutors', 'turnitintooltwo') :
                                                get_string('turnitinstudents', 'turnitintooltwo');
        $output = "";
        $enrollink = "";
        $enrollingcontainer = "";

        if (has_capability('mod/turnitintooltwo:grade', context_module::instance($cm->id))) {

            // Link to enrol all students on course.
            if ($role == "Learner") {
                $enrollink = $OUTPUT->box($OUTPUT->pix_icon('enrolicon',
                                                    get_string('turnitinenrolstudents', 'turnitintooltwo'),
                                                    'mod_turnitintooltwo')." ".
                                                        get_string('turnitinenrolstudents', 'turnitintooltwo'), 'enrol_link');

                $enrollingcontainer = $OUTPUT->box($OUTPUT->pix_icon('loader',
                                                    get_string('enrolling', 'turnitintooltwo'),
                                                    'mod_turnitintooltwo')." ".
                                                        get_string('enrolling', 'turnitintooltwo'), 'enrolling_container');
            }
            $output = $OUTPUT->box($enrollingcontainer.$enrollink, '');

            // Output user role to hidden var for use in jQuery calls.
            $output .= $OUTPUT->box($role, '', 'user_role');
            $output .= $OUTPUT->box($turnitintooltwoassignment->turnitintooltwo->id, '', 'assignment_id');

            $table = new html_table();
            $table->attributes["class"] = "enrolledMembers";

            // Do the table headers.
            $cells = array();
            $cells[0] = new html_table_cell("&nbsp;");
            $cells[0]->attributes["class"] = "narrow";
            $cells[1] = new html_table_cell($cellheader);
            $table->head = $cells;

            $output = $OUTPUT->box($output.html_writer::table($table), 'generalbox boxaligncenter', 'members');
        }

        return $output;
    }

    /**
     * Show Tutors/Students enrolled on a particular course with Turnitin
     *
     * @global type $CFG
     * @global type $OUTPUT
     * @global type $DB
     * @param type $cm course module data
     * @param type $turnitintooltwoassignment the assignment object
     * @param array $members of the course in Turnitin
     * @return array $memberdata in a format to be shown as rows in a datatable
     */
    public function get_tii_members_by_role($cm, $turnitintooltwoassignment, $members, $role = "Learner") {
        global $CFG, $DB, $OUTPUT;

        switch ($role) {
            case "Learner":
                $removestr = get_string('turnitinstudentsremove', 'turnitintooltwo');
                $removeaction = "removestudent";
                $do = "students";
                break;
            case "Instructor":
                $removestr = get_string('turnitintutorsremove', 'turnitintooltwo');
                $removeaction = "removetutor";
                $do = "tutors";
                break;
        }

        $memberdata = array();
        foreach ($members as $k => $v) {
            $membermoodleid = turnitintooltwo_user::get_moodle_user_id($k);
            if ($membermoodleid > 0) {
                $user = $DB->get_record('user', array('id' => $membermoodleid));

                $deleteurl = new moodle_url($CFG->wwwroot."/mod/turnitintooltwo/view.php",
                                            array('id' => $cm->id, 'do' => $do, 'sesskey' => sesskey(),
                                                'action' => $removeaction, 'membership_id' => $v['membership_id']));

                $attributes["onclick"] = 'return confirm(\''.$removestr.'\');';
                $link = html_writer::link($deleteurl, $OUTPUT->pix_icon('delete', $removestr, 'mod_turnitintooltwo'),
                                                                                                        $attributes);
                $userdetails = html_writer::link($CFG->wwwroot.'/user/view.php?id='.$membermoodleid.
                                                    '&course='.$turnitintooltwoassignment->turnitintooltwo->course,
                                                    $v['lastname'].', '.$v['firstname']).' ('.$user->username.')';
                $memberdata[] = array($link, $userdetails);
            }
        }

        return $memberdata;
    }

    /**
     * Show a form with a dropdown box to allow tutors who are enrolled in Moodle
     * on this course to be added to this course in Turnitin
     *
     * @global type $CFG
     * @global type $OUTPUT
     * @param obj $cm course module data
     * @param array $tutors tutors who are currently enrolled with Turnitin
     * @return output
     */
    public function show_add_tii_tutors_form($cm, $tutors) {
        global $CFG, $OUTPUT;

        $moodletutors = get_users_by_capability(context_module::instance($cm->id), 'mod/turnitintooltwo:grade',
                                                        'u.id, u.firstname, u.lastname, u.username');

        // Populate elements array which will generate the form elements
        // Each element is in following format: (type, name, label, helptext (minus _help), options (if select).
        $elements = array();
        $elements[] = array('header', 'add_tii_tutors', get_string('turnitintutorsadd', 'turnitintooltwo'));

        $options = array();
        foreach ($moodletutors as $k => $v) {
            $availabletutor = new turnitintooltwo_user($v->id, "Instructor", false);

            if (array_key_exists($availabletutor->tii_user_id, $tutors)) {
                unset($moodletutors[$k]);
            } else {
                $options[$availabletutor->id] = $availabletutor->lastname.', '.$availabletutor->firstname.
                                                                    ' ('.$availabletutor->username.')';
            }
        }

        if (count($options) == 0) {
            $elements[] = array('static', 'turnitintutors', get_string('turnitintutors', 'turnitintooltwo').": ",
                                    '', get_string('turnitintutorsallenrolled', 'turnitintooltwo'));
            $customdata["hide_submit"] = true;
        } else {
            $elements[] = array('select', 'turnitintutors', get_string('turnitintutors', 'turnitintooltwo'), '', $options);
            $elements[] = array('hidden', 'action', 'addtutor');
            $customdata["show_cancel"] = false;
            $customdata["submit_label"] = get_string('turnitintutorsadd', 'turnitintooltwo');

        }
        $customdata["elements"] = $elements;
        $form = new turnitintooltwo_form($CFG->wwwroot.'/mod/turnitintooltwo/view.php'.'?id='.$cm->id.'&do=tutors', $customdata);

        $output = $OUTPUT->box($form->display(), 'generalbox boxaligncenter', 'general');
        return $output;
    }
}