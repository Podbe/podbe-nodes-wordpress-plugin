<?php

############################## PODNODES SUBSCRIPE BUTTON VON PODLOVE ############
#
/**
 * [psb slug="test-slug-podcastname" button="big" color="121212"]
 	oder
   [psb button="big" color="121212"] //pageseite von podbe
 */
function podbe_node_psb_shortcode( $atts ) {
  
  //GLOBAL VARS
  global $suche;
  
  //VARS
  extract( 
  	shortcode_atts( 
  		array( 
  			'slug' => 'test-slug-podcastname', 				//podunion-magazin
  			'button' => '',									//small, medium, big, big auto, big-logo
  			'cdn' => '',									//podlove, podbe
  		), 
  	$atts ) 
  );
  
  //SLUG
  if ($slug) {
  	$slug_out = esc_attr($slug);
  	$host_podnode = 'https://raw.githubusercontent.com/Podbe/Podbe-PodNode/master/Nodes';
  	$podnode_psb_json = file_get_contents($host_podnode.'/'.$slug_out.'.json');
  	$suche_psb = json_decode($podnode_psb_json,TRUE);
  } else {
  	$slug_out = 'ERROR';
  	$page_link_json = file_get_contents(get_permalink().'?json=1');
  	$suche_psb = json_decode($page_link_json,TRUE);
  }
  
  //CDNs
  if ( esc_attr($cdn) == "" ){
  	$cdn_out = "https://cdn.podlove.org/subscribe-button/";
  } elseif ( esc_attr($cdn) == "podlove" ){
  	$cdn_out = "https://cdn.podlove.org/subscribe-button/";
  } elseif ( esc_attr($cdn) == "podbe" ){
  	$cdn_out = "http://cdn.podbe.de/subscribe-button/dist/";
  }
  
  //Button Size
  if ( esc_attr($button) == "small" ){
  	$psb_out = 'small';
  	$id_out = '1';
  } elseif ( esc_attr($button) == "medium" ){
  	$psb_out = 'medium';
  	$id_out = '2';
  } elseif ( esc_attr($button) == "big" ){
  	$psb_out = 'big';
  	$id_out = '3';
  } elseif ( esc_attr($button) == "big auto" ){
  	$psb_out = 'big auto';
  	$id_out = '4';
  } elseif ( esc_attr($button) == "big-logo" ){
  	$psb_out = 'big-logo';
  	$id_out = '5';
  } else {
  	$psb_out = 'big';
  	$id_out = '0';
  }
	
	//Json Array
  	$podcast_data = array(
		'title' => $suche_psb["post"]["title"],
		'subtitle' => $suche_psb["post"]["podcast"][0]["subtitle"],
		'description' => $suche_psb["post"]["podcast"][0]["description"],
		'cover' => $suche_psb["post"]["podcast"][0]["cover"],
		'feeds' => $suche_psb["post"]["podcast_feeds"][0]["standard"]
	);
	
	//Out
 	return "<script>button_".$id_out.'_'.md5($suche_psb["post"]["title"])." = ".json_encode($podcast_data)."</script>			
	<script class='podlove-subscribe-button' src='".$cdn_out."javascripts/app.js' 
	data-language='de' data-size='".$psb_out."' data-json-data='button_".$id_out.'_'.md5($suche_psb["post"]["title"])."'></script>";

}
add_shortcode( 'psb', 'podbe_node_psb_shortcode' );

?>