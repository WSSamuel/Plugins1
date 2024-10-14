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

final class wordcount {
/**
 * Object constructor
 *
 */
  function __construct() {
  }

  function countwords($content, $parameters) {
    if( $content ) {
      if( isset($parameters['word_limit']) ) $limit = $parameters['word_limit'];
      else $limit = 30;

      if( isset($parameters['exclude_words']) ) $exclude_words = $parameters['exclude_words'];
      else $exclude_words = array(' these ', ' which ', ' them ', ' when ', ' have ', ' there ', ' with ', ' their ', ' that ', ' they ', ' them ');

      if( isset($parameters['charlist']) ) $charlist = $parameters['charlist'];
      else $charlist = '';

      $freqData = array();

      foreach( $exclude_words as $ew ) {
        $content = preg_replace('/$'.trim($ew).'[ ,.;><?!]/i', ' ', $content);
        $content = preg_replace('/[ ,.;><?!]'.trim($ew).'[ ,.;><?!]/i', ' ', $content);
      }

      // Get individual words and build a frequency table
      foreach( str_word_count( $content, 1, $charlist ) as $word ) {
        if( strlen($word) > 3 ) {
          // For each word found in the frequency table, increment its value by one
          array_key_exists( $word, $freqData ) ? $freqData[ $word ]++ : $freqData[ $word ] = 0;
        }
      }

      arsort($freqData);
      if( count($freqData) > $limit ) $freqData = array_slice($freqData, 0, $limit);

      return $freqData;
    }
  }
}
?>
