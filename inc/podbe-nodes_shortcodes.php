<?php
/**
 * Shortcodes
 * @dev Michael McCouman Jr.
 */


############################## PODNODES VON PODBE ########################################
#
/**
 * [podbe-node slug="podunion-magazin"] ... [/podbe-node]
 */
function podbe_node_shortcode( $atts, $content = null ) {
  
  //GLOBAL VARS
  global $suche;
  
  //VARS
  extract( 
  	shortcode_atts( 
  		array( 
  			'slug' => '', 				//podunion-magazin	
  		), 
  	$atts ) 
  );
  
  //SLUG
  if($slug){
  	$slug_out = esc_attr($slug);
  } else {
  	$slug_out = 'ERROR';
  }
  
  
  //JSON READ
  $host_node = 'https://raw.githubusercontent.com/Podbe/Podbe-PodNode/master/Nodes';
  $jsonfile = file_get_contents($host_node.'/'.$slug_out.'.json');
  $suche = json_decode($jsonfile,TRUE);
  
  //Ausgabe
  return do_shortcode($content);
}
add_shortcode( 'podbe-node', 'podbe_node_shortcode' );



/**
 * [pn 
 		url="1"
 		title="1"
 		cover="1"
 	]
 */
function podbe_node_url_shortcode( $atts ) {
  
  	//GLOBAL VARS
  	global $suche;

  	//VARS
  	extract( 
  		shortcode_atts( 
  			array(
  				'url' => '', 					//$suche['post']['url'];
  				'title' => '', 					//$suche['post']['title'];
  				'cover' => '', 					//$suche['post']['podcast'][0]['podcast_cover'];
  			), 
  		$atts ) 
  	);
    
  	if(esc_attr($url) == '1'){
  		$pn_url_out = $suche['post']['url'];
  	} 
	if(esc_attr($title) == '1'){
  		$pn_title_out = $suche['post']['title'];
  	}
  	if(esc_attr($cover) == '1'){
  		$pn_cover_out = $suche['post']['podcast'][0]['cover'];
  	}
  	/*
  	weitere folgen
  	...
  	...
  	*/

  	//Ausgabe
  	return 
  			$pn_url_out.''.
  			$pn_title_out.''.
  			$pn_cover_out ;
}
add_shortcode( 'pn', 'podbe_node_url_shortcode' );

/**
 * [cover width="300"]
 */
function img_helper_shortcode( $atts ) {

  //VARS
  extract( 
  	shortcode_atts( 
  		array( 
  			'width' => '300', 		//width = 300px
  		), 
  	$atts ) 
  );
  
  if(esc_attr($width)){
  	$width_out = esc_attr($width);
  } 

  //Ausgabe
  return '<img src="' . do_shortcode('[pn cover="1"]') . '" style="width:'.$width_out.'px;" title="' . do_shortcode('[pn title="1"]') . '">';
}
add_shortcode( 'cover', 'img_helper_shortcode' );
?>