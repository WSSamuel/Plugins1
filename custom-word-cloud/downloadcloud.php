<?php
/*
Copyright 2010 Bryan Nielsen

This script is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This script is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// download image using passed id value
if( isset($_GET['id']) ) {
  // make sure id is cleaned up for use as a filename
  $id = str_replace(array('..', '/'), '', $_GET['id']);

  if( file_exists(dirname(__FILE__).'/cache/'.$id.'.png') ) {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=".dirname(__FILE__).'/cache/'.$id.'.png');
    header("Content-Type: image/png");
    header("Content-Transfer-Encoding: binary");
    
    // Read the file from disk
    readfile(dirname(__FILE__).'/cache/'.$id.'.png');
  }
  else {
    echo "error<br>";
    echo dirname(__FILE__).'/cache/'.$id.'.png';
  }
}

?>
