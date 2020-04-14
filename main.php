<?php
/**
 * Plugin Name: SoccerPlayerSearch
 * Plugin URI: http://www.mywebsite.com/my-first-plugin
 * Description: The very first plugin that I have ever created.
 * Version: 1.0
 * Author: Your Name
 * Author URI: http://www.mywebsite.com
 */

add_filter( 'the_content', 'filter_index' );

function filter_index( $content ) {
 
  // Check if we're inside the main loop in a single post page.
  $page_link = get_page_link();
  $path_comp = explode('/', wp_parse_url($page_link).path);

  if (count($page_comp) < 2) {
    return $content;
  }
  if ($page_comp[1] == 'competition') {
    $criteria = array();
    if (count($page_comp) > 2) {
      $content = replace_search_bar($content, $criteria);
    }
    if (count($page_comp) > 3 && $page_comp[2] != '') { 
      $criteria['country'] = intval($page_comp[2]);
      $content = replace_search_bar($content, $criteria);
    }
    if (count($page_comp) > 4 && $page_comp[3] != '') {
      $criteria['competition'] = intval($page_comp[3]);
      $content = replace_search_bar($content, $criteria);
    }
    if (count($page_comp) > 5 && $page_comp[4] != '') {
      $criteria['club'] = intval($page_comp[4]);
      $content = replace_search_bar($content, $criteria);
    }
    if (count($page_comp) > 6 && $page_comp[5] != '') {
      $criteria['player'] = intval($page_comp[5]);
      $content = replace_player_details($content, $criteria);
    }
    return filter_competition($page_comp);
  }
  return $content;
}

function str_replace_first($from, $to, $content) {
    $from = '/'.preg_quote($from, '/').'/';
    return preg_replace($from, $to, $content, 1);
}

function replace_search_bar($html, $criteria) {
  $search_str = '<input class=\"tdb-search-form-input\" type=\"text\" value=\"\" name=\"s\" id=\"s\">';
  $replace_str = '<select> <option value=0>Select Country</option> <option value=1>Albania</option> <option value=2>Algeria</option> </select>';
  str_replace_first($search_str, $replace_str, $html);
  return $html;
}

function replace_player_details($html, $criteria) {
  $search_str = '<input class=\"tdb-search-form-input\" type=\"text\" value=\"\" name=\"s\" id=\"s\">';
  $replace_str = '<select> <option value=0>Select Country</option> <option value=1>Albania</option> <option value=2>Algeria</option> </select>';
  str_replace_first($search_str, $replace_str, $html);
  return $html;
}