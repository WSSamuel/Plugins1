<?php
/*
Copyright 2010 Bryan Nielsen
bnielsen1965@gmail.com

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

final class wordcloud {
/**
 * Object constructor
 *
 */
  function __construct() {
  }

  /*
   * words is a 'word' => count associative array of the taxonomy
   */
  function makecloud($words, $parameters) {
    if( count($words) == 0 ) return FALSE;

    $canvassize=2048; // working canvas size
    $fn = (isset($parameters['filename']) ? $parameters['filename'] : 'wc.png');
    $width=(isset($parameters['width']) ? intval($parameters['width']) : 640);
    if( $width > $canvassize ) $width = $canvassize;
    $height=(isset($parameters['height']) ? intval($parameters['height']) : 480);
    if( $height > $canvassize ) $height = $canvassize;
    $rinc=0.5; // radius increment factor
    $tinc=5; // theta increment factor
    $radius=1; // starting radius for each word
    $theta=0.0; // starting theta for each word
    if( $parameters['angle'] == 'random' ) $angle = 'random';
    else $angle = intval($parameters['angle']);
    if( $parameters['double_angle'] == 'true' ) $doubleangle = TRUE;
    else $doubleangle = FALSE;
    if( isset($parameters['fontfile']) ) $ttffile = dirname(__FILE__).'/fonts/'.$parameters['fontfile'];
    else $ttffile = dirname(__FILE__).'/fonts/DejaVuSansMono-Roman.ttf';
    $minfs = 10; // minimum font size
    $maxfs = 50; // maximum font size
    if( isset($parameters['margin']) ) $margin = $parameters['margin'];
    else $margin = 5; // margin around each word
    $imgmargin = 15; // margin around the cropped canvas area
    $rt = (float)$width / $height; // ratio of width and height for ellipse

    $img = imagecreatetruecolor($canvassize, $canvassize);

    // create the color palette
    if( isset($parameters['palette']) ) $colorpalette = explode(',', $parameters['palette']);
    else $colorpalette = explode(',', '#ffffff, #000000');

    $colors = array();
    foreach($colorpalette as $c) {
      $c = str_replace(array(' ', '#'), '', $c);
      if( strlen($c) == 3 ) {
        $c = $c[0].$c[0].$c[1].$c[1].$c[2].$c[2];
      }

      if( strlen($c) == 6 ) {
        $red = hexdec(substr($c, 0, 2));
        $green = hexdec(substr($c, 2, 2));
        $blue = hexdec(substr($c, 4, 2));
        $colors[] = imagecolorallocate($img, $red, $green, $blue);
      }
    }

    if( count($colors) < 2 ) {
      $colors[0] = imagecolorallocate($img, 255, 255, 255);
      $colors[1] = imagecolorallocate($img, 0, 0, 0);
    }

    imagefill($img, 0, 0, $colors[0]);

    // calculate placement for each word
    $place = array();

    // shuffle
    $keys = array_keys($words);
    $vals = array_values($words);
    $ind = array_keys($keys);
    shuffle($ind);
    $words = array();
    foreach( $ind as $k => $c ) {
      $words[$keys[$c]] = $vals[$c];
    }

    // determine font size per word count
    $minc = min($words);
    $maxc = max($words);
    $rangec = $maxc - $minc;
    if( $rangec > 0 ) $fppercount = ($maxfs - $minfs) / $rangec;
    else $fppercount = 0;

    foreach( $words as $word => $count ) {
      // start at center of image
      $x = $canvassize / 2;
      $y = $canvassize / 2;
      $r = $radius;
      $t = $theta;

      // need to scale font based on min and max count
      $fontsize = $minfs + $count * $fppercount;

      if( $doubleangle ) $at = rand(0, 1); // double angles
      else $at = 0;
      if( $angle === 'random' ) $fontangle = rand(0, 359);
      else $fontangle = $angle;
      $fontangle -= $at * $fontangle * 2;

      //$fontangle =  rand(0, 24) * 15;

      // find bounding limits of word before rotation
      $bbox = imagettfbbox($fontsize, 0, $ttffile, $word);

/* y
 * |  box[6], box[7]                             box[4], box[5]
 * |    *------------------------------------------------*
 * |    |                                                |
 * |    |                                                |
 * |    |   * (base point)                               |
 * |    |                                                |
 * 0     *------------------------------------------------*
 *   box[0], box[1]                              box[2], box[3]
 *
 *      0-----------------------------------------------------x
 *
 * Note: y coordinates are opposite of image coordinates!
 *
 */

      // add margins to box
      $bbox[0] -= $margin;
      $bbox[1] += $margin;
      $bbox[2] += $margin;
      $bbox[3] += $margin;
      $bbox[4] += $margin;
      $bbox[5] -= $margin;
      $bbox[6] -= $margin;
      $bbox[7] -= $margin;

      // translate the bounding box
      $bbox = $this->translatebox($bbox, 0, 0, $fontangle);

      // spiral through the image looking for placement
      while( ($x >= 0 && $x < $canvassize) || ($y >= 0 && $y < $canvassize) ) {

        $x = ($rt * $r) * cos(deg2rad($t)) + $canvassize / 2;
        $y = (1 / $rt * $r) * sin(deg2rad($t)) + $canvassize / 2;;
        $r += $rinc;
        $t += $tinc;
        if( $t >= 360 ) {
          $t = 0;
          //$r += $rinc;
        }

        for( $i = 0; $i < 4; $i++ ) {
          $box[$i * 2] = $x + $bbox[$i * 2];
          $box[$i * 2 + 1] = $y + $bbox[$i * 2 + 1];
        }

        if( $this->placeclear($place, $box) ) {
          $nbbox = imagettftext($img, $fontsize, $fontangle, $x, $y, $colors[1 + rand(0, count($colors) - 2)], $ttffile, $word);
          for( $i = 0; $i < 8; $i++ ) $box[$i] = round($box[$i]);
          $box['word'] = $word;
          $place[] = $box;
          break;
        }
      }
    }

// determine bounds of word cloud image from placement
    $minx = NULL;
    $miny = NULL;
    $maxx = NULL;
    $maxy = NULL;
    foreach( $place as $p ) {
      for( $i = 0; $i < 4; $i++ ) {
        if( is_null($minx) ) $minx = $p[$i * 2];
        else if( $p[$i * 2] < $minx ) $minx = $p[$i * 2];

        if( is_null($maxx) ) $maxx = $p[$i * 2];
        else if( $p[$i * 2] > $maxx ) $maxx = $p[$i * 2];

        if( is_null($miny) ) $miny = $p[$i * 2 + 1];
        else if( $p[$i * 2 + 1] < $miny ) $miny = $p[$i * 2 + 1];

        if( is_null($maxy) ) $maxy = $p[$i * 2 + 1];
        else if( $p[$i * 2 + 1] > $maxy ) $maxy = $p[$i * 2 + 1];
      }
    }

    $minx -= $imgmargin;
    $maxx += $imgmargin;
    $miny -= $imgmargin;
    $maxy += $imgmargin;

    $img2 = imagecreatetruecolor($width, $height);
    imagefill($img2, 0, 0, $colors[0]);

    $wpercent = (float)$width / ($maxx - $minx);
    $hpercent = (float)$height / ($maxy - $miny);
    $scale = ($wpercent < $hpercent ? $wpercent : $hpercent);
    $newwidth = $scale * ($maxx - $minx);
    $newheight = $scale * ($maxy - $miny);
    $newx = ($width - $newwidth) / 2;
    $newy = ($height - $newheight) / 2;

    imagecopyresampled($img2, $img, $newx, $newy, $minx, $miny, $newwidth, $newheight, $maxx - $minx, $maxy - $miny);

    // scale place boxes
    for( $i1 = 0; $i1 < count($place); $i1++ ) {
      for( $i2 = 0; $i2 < 4; $i2++ ) {
        // scale x
        $place[$i1][$i2 * 2] = ($place[$i1][$i2 * 2] - $minx) * $scale + $newx;
        // scale y
        $place[$i1][$i2 * 2 + 1] = ($place[$i1][$i2 * 2 + 1] - $miny) * $scale + $newy;
      }
    }

    imagepng($img2, $fn);
    imagedestroy($img);
    imagedestroy($img2);

    return $place; // return the array of word placement
//    return TRUE;
  }


  function placeclear($places, $box) {
    $clear = TRUE;

    // check for collision with each existing placement
    foreach( $places as $p ) {
      if( $this->collision($box, $p) ) { //['box']) ) {
        $clear = FALSE;
        break;
      }
    }

    return $clear;
  }


  function collision($box1, $box2) {
    // do a quick bounding box test first
    $inbox = TRUE;
    $left1 = min($box1[0], $box1[2], $box1[4], $box1[6]);
    $right1 = max($box1[0], $box1[2], $box1[4], $box1[6]);

    $top1 = min($box1[1], $box1[3], $box1[5], $box1[7]);
    $bottom1 = max($box1[1], $box1[3], $box1[5], $box1[7]);

    $left2 = min($box2[0], $box2[2], $box2[4], $box2[6]);
    $right2 = max($box2[0], $box2[2], $box2[4], $box2[6]);

    $top2 = min($box2[1], $box2[3], $box2[5], $box2[7]);
    $bottom2 = max($box2[1], $box2[3], $box2[5], $box2[7]);

    if( $bottom1 < $top2 ) $inbox = FALSE;
    if( $top1 > $bottom2 ) $inbox = FALSE;
    if( $right1 < $left2 ) $inbox = FALSE;
    if( $left1 > $right2 ) $inbox = FALSE;

    // if inside the bounding box then do the next test
    if( $inbox ) {
      // test if box1 is inside box2
      if( $left1 >= $left2 && $right1 <= $right2 &&
          $bottom1 <= $bottom2 && $top1 >= $top2 ) return TRUE;

      // test if box2 is inside box1
      if( $left2 >= $left1 && $right2 <= $right1 &&
          $bottom2 <= $bottom1 && $top2 >= $top1 ) return TRUE;

      // test each line segment for intersection with lines of other box
      for( $i = 0; $i < 4; $i++ ) {
        // box1 line segment to test
        $l1 = array();
        $l1['p1'] = array('x' => $box1[$i * 2], 'y' => $box1[$i * 2 + 1]);
        if( $i < 3 ) {
          $l1['p2'] = array('x' => $box1[($i + 1) * 2], 'y' => $box1[($i + 1) * 2 + 1]);
        }
        else {
          $l1['p2'] = array('x' => $box1[0], 'y' => $box1[1]);
        }

        for( $i2 = 0; $i2 < 4; $i2++ ) {
          // box2 line segment to test
          $l2 = array();
          $l2['p1'] = array('x' => $box2[$i2 * 2], 'y' => $box2[$i2 * 2 + 1]);
          if( $i2 < 3 ) {
            $l2['p2'] = array('x' => $box2[($i2 + 1) * 2], 'y' => $box2[($i2 + 1) * 2 + 1]);
          }
          else {
            $l2['p2'] = array('x' => $box2[0], 'y' => $box2[1]);
          }

          if( $this->linesintersect($l1, $l2) ) return TRUE;
        }
      }
    }

    return FALSE;
  }


  function linesintersect($l1, $l2) {
    $clocka = $this->check_tri_clock_dir($l1['p1'], $l1['p2'], $l2['p1']);
    $clockb = $this->check_tri_clock_dir($l1['p1'], $l1['p2'], $l2['p2']);
    if( $clocka != $clockb ) {
      $clocka = $this->check_tri_clock_dir($l2['p1'], $l2['p2'], $l1['p1']);
      $clockb = $this->check_tri_clock_dir($l2['p1'], $l2['p2'], $l1['p2']);
      if( $clocka != $clockb ) {
        return TRUE;
      }
    }
    return FALSE;
  }

  function check_tri_clock_dir($p1, $p2, $p3) {
    $test = ((($p2['x'] - $p1['x']) * ($p3['y'] - $p1['y'])) - (($p3['x'] - $p1['x']) * ($p2['y'] - $p1['y']))); 
    if ($test > 0) return 1; //COUNTER_CLOCKWISE
    else if($test < 0) return -1; //CLOCKWISE
    else return 0; //LINE
  }


  function translatebox($box, $bx, $by, $angle) {
    $tbox = array();

    $tp = $this->translatepoint($box[0], $box[1], $bx, $by, $angle);
    $tbox[0] = $tp['x'];
    $tbox[1] = $tp['y'];

    $tp = $this->translatepoint($box[2], $box[3], $bx, $by, $angle);
    $tbox[2] = $tp['x'];
    $tbox[3] = $tp['y'];

    $tp = $this->translatepoint($box[4], $box[5], $bx, $by, $angle);
    $tbox[4] = $tp['x'];
    $tbox[5] = $tp['y'];

    $tp = $this->translatepoint($box[6], $box[7], $bx, $by, $angle);
    $tbox[6] = $tp['x'];
    $tbox[7] = $tp['y'];

    return $tbox;
  }


  function translatepoint($x, $y, $bx, $by, $angle) {
    $dx = $x - $bx;
    $dy = $y - $by;
    $angle *= -1;

    $rx = $dx * cos(deg2rad($angle)) - $dy * sin(deg2rad($angle));
    $ry = $dy * cos(deg2rad($angle)) + $dx * sin(deg2rad($angle));

    return array('x' => $bx + $rx, 'y' => $by + $ry);
  }
}
?>
