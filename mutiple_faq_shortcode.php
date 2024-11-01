<?php
add_shortcode('multi_faq','asp_faq_shortcode');
/**
*intializing multi_faq shortcode function
*/
function asp_faq_shortcode($atts)
{
		$color = get_option('multifaq_color');
		if($color!='')
		{
		?>
		<style>
		.newHeadingColor
		{
			background-color: <?php echo $color; ?>  !important;
			background-image: none !important;
		}
		</style>
		<?php 
		}

		
		
		?>
     
        
        <?php
		if(isset($atts['cat_name']) && $atts['cat_name']!='')
				$args =  array(
					'post_type' => 'asp_faq',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'asp_faq_cat' => $atts['cat_name'],
					'posts_per_page' => $atts['limit']		
				);
		else if(isset($atts['tag_name']) && $atts['tag_name']!='')
				$args =  array(
					'post_type' => 'asp_faq',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'asp_faq_tag' => $atts['tag_name'],
					'posts_per_page' => $atts['limit']		
				);
		else
				$args =  array(
					'post_type' => 'asp_faq',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'posts_per_page' => $atts['limit']		
				);
	// WP_Query
	$heading = get_option('multifaq_htype');
	if($heading==""){ $heading = "h1";}
	$loop = new WP_Query($args);
	 $out='<div class="accordion">';
	 while ( $loop->have_posts() ) : $loop->the_post(); 
	 if($color!='')
		{
			$out.='<'.$heading.' class="heading_accordion newHeadingColor">'.get_the_title().'</'.$heading.'>';
		}
	 else
	 {
				$out.='<'.$heading.' class="heading_accordion">'.get_the_title().'</'.$heading.'>';
	 }
				$out.= '<div class="content_accordion"><p>'.get_the_content().'</p></div>';

				endwhile; // end of the loop.
	$out.= '</div>';
	
	wp_reset_query();
	return $out;
}

//Single FAQ Shortcode intiailizing
add_shortcode('single_faq','single_aspfaq_shortcode');


/**
*intializing single shortcode function
*/
function single_aspfaq_shortcode($atts)
{
	
		$color = get_option('multifaq_color');
		if($color!='')
		{
		?>
		<style>
		.newHeadingColor
		{
			background-color: <?php echo $color; ?>  !important;
			background-image: none !important;
		}
		</style>
		<?php 
		}
		
		
		
				$args =  array(
					'post_type' => 'asp_faq',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'p' => "".$atts['id']."",
					'posts_per_page' => 1
					
				);
	// WP_Query
	$output;
	$heading = get_option('multifaq_htype');
	if($heading==""){ $heading = "h1";}
	$loop = new WP_Query($args);
	 while ( $loop->have_posts() ) : $loop->the_post(); 
	 if($color !='')
	 {
		 $output.= '<'.$heading.' class="singleHeading newHeadingColor">'.get_the_title().'</'.$heading.'>';
		 }
		 
	else
	{
		$output.= '<'.$heading.' class="singleHeading">'.get_the_title().'</'.$heading.'>';
		}
				$output.= '<div class="single_content"><p>'.get_the_content().'</p></div>';

				endwhile; // end of the loop.
	wp_reset_query();
	return $output;
}

//All FAQs list Shortcode intiailizing
add_shortcode('list_faq','list_aspfaq_shortcode');
/**
*intializing list shortcode function
*/
function list_aspfaq_shortcode($atts)
{
		if(isset($atts['cat_name']) && $atts['cat_name']!='')
				$args =  array(
					'post_type' => 'asp_faq',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'asp_faq_cat' => $atts['cat_name'],
					'posts_per_page' => $atts['limit']		
				);
		else if(isset($atts['tag_name']) && $atts['tag_name']!='')
				$args =  array(
					'post_type' => 'asp_faq',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'asp_faq_tag' => $atts['tag_name'],
					'posts_per_page' => $atts['limit']		
				);
		else
				$args =  array(
					'post_type' => 'asp_faq',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'posts_per_page' => $atts['limit']		
				);
	// WP_Query 
	$output;
	$heading = get_option('multifaq_htype');
	if($heading==""){ $heading = "h1";}
	$loop = new WP_Query($args);
	 while ( $loop->have_posts() ) : $loop->the_post(); 
				$output.= '<'.$heading.' class="singleHeading  newHeadingColor" style="margin-bottom:5px;"><a href="'.get_permalink().'">'.get_the_title().'</a></'.$heading.'>';

				endwhile; // end of the loop.
	wp_reset_query();
	return $output;
}
?>