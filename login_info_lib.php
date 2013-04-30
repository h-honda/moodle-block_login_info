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
 *
 * @package   block_login_info
 * @copyright 2012 Human Science Co., Ltd. Hiroshi Honda  {@link http://www.science.co.jp/}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class login_info_lib{

  protected function getLastLoginTime(){
    global $USER,$DB;

    $ret = $DB->get_record('user',array('id'=>$USER->id));
    return $ret;
  }

  function getMessage(){
    global $USER;

    if(!isset($USER)) return get_string('nologin','block_login_info');;

    $ret = $this->getLastLoginTime();
    if($ret === false) return get_string('nologin','block_login_info');

    $period = ($ret->lastlogin == 0)? 0:$ret->lastaccess - $ret->lastlogin;

    if($period < 0) return "error";

    //first access
    $a = new stdClass;
    $a->lastname = $USER->lastname;
    $a->firstname = $USER->firstname;
    if($period == 0) return get_string('firstaccess','block_login_info',$a);

    //1day
    if($period <= 86400) return get_string('dayaccess','block_login_info');

    //1week
    if($period <= 604800) return get_string('weekaccess','block_login_info');

    //1month
    if($period <= 2592000) return get_string('monthaccess','block_login_info');

    //other
    return get_string('dummyaccess','block_login_info');
  }
}
