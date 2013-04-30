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

require_once 'login_info_lib.php';

class block_login_info extends block_base {
  function init() {
    $this->title = get_string('pluginname', 'block_login_info');
  }

  function get_content() {
    global $CFG;
    if ($this->content !== NULL) {
      return $this->content;
    }

    $this->content = new stdClass;

    $obj = new login_info_lib();
    $message = $obj->getMessage();

    $base_url = $CFG->wwwroot.'/blocks/login_info/';

    $device = get_device_type();
    $jquery = <<<JQ
<script type="text/javascript" src="{$base_url}js/jquery.js"></script>
JQ;
    if( ($device == 'mobile') || ($device == 'tablet') ) $jquery = '';

    $this->content->text = <<< HTML
    <!-- ThickBox 3 -->
{$jquery}
<script type="text/javascript" src="{$base_url}js/thickbox/thickbox.js"></script>
<link rel="stylesheet" href="{$base_url}js/thickbox/thickbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{$base_url}style.css" type="text/css" media="all" />
<!-- /ThickBox 3 -->
<div id="log_meg_small">
<a href="#TB_inline?height=200&width=300&inlineId=mycontent&modal=true" class="thickbox">
<img width="45px" height="80px" id="teacher_img" alt="teacher" src="{$base_url}teacher.png" />
{$message}</a>
</div>
<div id="mycontent">
<p><img id="teacher_img" alt="teacher" src="{$base_url}teacher.png" />
<div id="msg">
{$message}
</div>
</p>
<div id="myclose">
<input type="submit" value="close" onclick="tb_remove()" />
</div>
</div>

HTML;
    $this->content->footer = '';

    return $this->content;
  }

}
?>
