<?PHP 

add_action( 'init', 'add_flavor_custom_post' );

function add_flavor_custom_post(){

	register_post_type( 'flavorpost',
		array(
			'labels' => array(
				'name'               => __( 'Flavor', 'acg' ),
				'singular_name'      => __( 'Flavor', 'acg' ),
				'add_new'            => __( 'Add New Flavor', 'acg' ),
				'add_new_item'       => __( 'Add Flavor', 'acg' ),
				'new_item'           => __( 'Add Flavor', 'acg' ),
				'view_item'          => __( 'View Flavor', 'acg' ),
				'search_items'       => __( 'Search Flavor', 'acg' ),
				'edit_item'          => __( 'Edit Flavor', 'acg' ),
				'all_items'          => __( 'All Flavor', 'acg' ),
				'not_found'          => __( 'No Flavor found', 'acg' ),
				'not_found_in_trash' => __( 'No Flavor found in Trash', 'acg' )
			),

			'taxonomies'        => array('flavor-tax', 'flavor_tax'),
			'public'            => TRUE,
			'show_ui'           => TRUE,
			'capability_type'   => 'post',
			'hierarchical'      => FALSE,
			'rewrite'           => array('slug' => 'flavor-select', 'with_front' => FALSE),
			'query_var'         => TRUE,
			'supports'          => array('title', 'revisions', 'thumbnail'),
			'menu_position'     => 10,
			// 'register_meta_box_cb' => 'toolkit_hp_metabox',
			/* 'menu_icon' 		=> get_template_directory_uri() .'/images/equipment_icon.png', */
			'has_archive'       => TRUE,
			'show_in_nav_menus' => TRUE,
			'menu_icon'         => 'dashicons-businessman'
		)
	);
	
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name', 'acg' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'acg' ),
		'search_items'      => __( 'Search Category', 'acg' ),
		'all_items'         => __( 'All Categories', 'acg' ),
		'parent_item'       => __( 'Parent Category', 'acg' ),
		'parent_item_colon' => __( 'Parent Category:', 'acg' ),
		'edit_item'         => __( 'Edit Category', 'acg' ),
		'update_item'       => __( 'Update Category', 'acg' ),
		'add_new_item'      => __( 'Add New Category', 'acg' ),
		'new_item_name'     => __( 'New Category Name', 'acg' ),
		'menu_name'         => __( 'Categories', 'acg' )
	);

	register_taxonomy( 'flavor-tax', 'flavorpost', array(
		'hierarchical' => TRUE,
		'labels'       => $labels,
		'query_var'    => TRUE,
		'rewrite'      => array('slug' => 'category-flavorpost')
	) );
	
	
	
}



add_shortcode("flavor_widget_custom", "flavor_widget_custom");
function flavor_widget_custom(){
?>

        <div class="flavor_wd">
            <div class="flavor_nav">
                <h2 class="wg_title">FLAVOR SELECTOR</h2>
                <div class="onethird"><a data-filter="carbonated" class="gal_btn fl_btn_selected">CARBONATED</a></div>
                <div class="onethird"><a data-filter="frozen-carbonated-beverage" class="gal_btn">FROZEN CARBONATED BEVERAGE</a></div>
                <div class="onethird"><a data-filter="non-carbonated" class="gal_btn">NON-CARBONATED</a></div>
                
                
            </div>
            
            <div class="flavor_all">
            	<?PHP 
				$fl_args = array(
					'post_type' 		=> 'flavorpost',
					'posts_per_page' 	=> -1,
					'order' 			=> 'ASC',
					'orderby'   		=> 'post_date',
					
				);
				global $post;
				$all_flavors = new WP_Query( $fl_args );
				while ( $all_flavors->have_posts() ) : $all_flavors->the_post();
					
					$get_fl_cat = wp_get_post_terms( $post->ID, 'flavor-tax', array( 'fields' => 'slugs' ));
					
					$flavor_cat = $get_fl_cat[0];
					//echo $flavor_cat[0]->slug;
					if ( has_post_thumbnail() ) 
					{
					
					//echo "POST->ID ".$post->ID;
					 $itemImage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full', false );
  
				?>
                		<div class="fl_item_select <?PHP echo $flavor_cat;?>"><a data-flavor="<?PHP echo $post->ID;?>" class="fl_item_lnk "><img src="<?PHP echo $itemImage[0]; ?>" /></a></div>            
                <?PHP 
					}
				endwhile;				
				wp_reset_query();
				wp_reset_postdata();
				?>
            	
            </div>
            
            <?php /*?><div class="flavor_item">
                <div class="onethird">
                    <div class="nutrition_fc">
                        <h3>Nutrition Facts</h3>
                        <ul>
                            <li>Serving Size 12oz</li>
                            <li>Amount Per Serving</li>
                            <li>Calories 150</li>
                            <li>%Daily Value*</li>
                            <li>Total Fat og %%</li>
                            <li>Sodium 5mg 0%</li>
                            <li>Total Carb. 39g 0%</li>
                            <li>Sugars 39g</li>
                            <li>Protein 0g</li>
                        </ul>
                    </div>
                    
                </div>
                <div class="onethird">
                    <div class="flavor_img">
                        <img src="<?PHP echo get_template_directory_uri(); ?>/flavorwd/Black-Cherry.jpg" />
                    </div>
                </div>
                <div class="onethird">
                    <div class="other_info">
                        <p>INGREDIENTS: Filtered Water, Cane Sugar, Phosphoric Acid, Natural Flavor, Caramel Color, Caffeine</p>
                        <h3 class="baginbox textcenter">BAG-IN-BOX<br />PACK SIZES</h3>
                        <p>General Beverage Connector</p>
                        <p>5 Gallon Bag in Box<br />Pallet 50(10X5) 2500lbs.</p>
                        <p>3 Gallon Bag in Box<br />Pallet 70(10X7) 2100lbs.</p>
                    </div>
                </div>
            </div><?php */?>
             <div class="flavor_item" id="floavorData">
             
             </div>
        </div>
        <script>
        jQuery(document).ready( function() {
		   
		   var defaultLoad = jQuery(".fl_btn_selected").attr('data-filter');
		   jQuery(".fl_item_select").not('.'+defaultLoad).hide('3000');
		   jQuery('.fl_item_select').filter('.'+defaultLoad).show('3000');
		   
		   jQuery(".gal_btn").click(function(){
				var value = jQuery(this).attr('data-filter');        
			   
				if(jQuery(this).hasClass("fl_btn_selected")){
					jQuery('.fl_item_select').show('1000');	
					jQuery(this).removeClass("fl_btn_selected");
					return false;
				}
				if(value == "allshow")
				{
					jQuery('.fl_item_select').show('1000');
				}
				else
				{
					jQuery(".fl_item_select").not('.'+value).hide('3000');
					jQuery('.fl_item_select').filter('.'+value).show('3000');
					
				}
			
				if (jQuery(".gal_btn").removeClass("fl_btn_selected")) {
					jQuery(this).removeClass("fl_btn_selected");
				}	
				jQuery(this).addClass("fl_btn_selected");
				
				jQuery("#floavorData").html('');
				
				
			});
		   
		   jQuery("a.fl_item_lnk").click( function(e) {
			  e.preventDefault(); 
			  var ajaxurl = "<?PHP echo admin_url( 'admin-ajax.php' ); ?>";
			  var flavor_id = jQuery(this).attr("data-flavor");
			 // var nonce = jQuery(this).attr("data-nonce");
			  jQuery.ajax({
				 type : "post",
				 dataType : "html",
				 url : ajaxurl,
				 data : {action: "load_flavor_data", flavor_id : flavor_id},
				 success: function(response) {					
					   jQuery("#floavorData").html(response);	
					   jQuery("#floavorData").addClass("flavor_border");	
					   jQuery('html, body').animate({
							scrollTop: jQuery("#floavorData").offset().top
						}, 2000);				
				 }
			  });
		   });
		});
        </script>
        
<?PHP } 


add_action("wp_ajax_load_flavor_data", "load_flavor_data");
add_action("wp_ajax_nopriv_load_flavor_data", "load_flavor_data");
function load_flavor_data() {

	$flavorID = $_POST['flavor_id'];
	$flavorData = get_post($flavorID);
	
	
	$itemImage = wp_get_attachment_image_src( get_post_thumbnail_id( $flavorID ), 'full', false );
	
	
	$serving_size = get_post_meta( $flavorID, 'serving_size', true ) ;
	$per_servings = get_post_meta( $flavorID, 'amount_per_servings', true ) ;
	$daily_value = get_post_meta( $flavorID, 'daily_value', true ) ;
	$calories = get_post_meta( $flavorID, 'calories', true ) ;
	$total_fat = get_post_meta( $flavorID, 'total_fat', true ) ;
	$sodium = get_post_meta( $flavorID, 'sodium', true ) ;
	$total_carbs = get_post_meta( $flavorID, 'total_carbs', true ) ;
	$sugars = get_post_meta( $flavorID, 'sugars', true ) ;
	$protien = get_post_meta( $flavorID, 'protien', true ) ;	
	
	$ingredients = get_post_meta( $flavorID, 'ingredients', true ) ;
	
	$gallon_5 = get_post_meta( $flavorID, '5_gallon', true ) ;
	$gallon_3 = get_post_meta( $flavorID, '3_gallon', true ) ;
	
	if(!empty($calories)){ $calories = $calories;}else{ $calories="0";}
	?>
    	<div class="onethird">
            <div class="nutrition_fc">
                <h3>Nutrition Facts</h3>
                <ul>                    
                    
                    <?PHP if(!empty($serving_size)){?> <li>Serving Siz <?PHP echo $serving_size; ?>oz</li> <?PHP } ?>
                   	<?PHP if(!empty($per_servings)){?> <li>Amount Per Serving <?PHP echo $per_servings; ?></li> <?PHP } ?>
					<li>Calories <?PHP echo $calories; ?></li> 
                   
                    <?PHP if(!empty($daily_value)){?> <li>%Daily Value* <?PHP echo $daily_value; ?></li> <?PHP } ?>
                    <?PHP if(!empty($total_fat)){?> <li>Total Fat <?PHP echo $total_fat; ?></li> <?PHP } ?>
                    
                    <?PHP if(!empty($sodium)){?> <li>Sodium <?PHP echo $sodium; ?></li> <?PHP } ?>
                    
                    <?PHP if(!empty($total_carbs)){?> <li>Total Carb. <?PHP echo $total_carbs; ?></li> <?PHP } ?>
                    
                    <?PHP if(!empty($sugars)){?> <li>Sugars <?PHP echo $sugars; ?></li> <?PHP } ?>
                    <?PHP if(!empty($protien)){?> <li>Protein <?PHP echo $protien; ?>g</li> <?PHP } ?>
                    
                </ul>
            </div>
            
        </div>
        <div class="onethird">
            <div class="flavor_img">
                <img src="<?PHP echo $itemImage[0]; ?>" />
            </div>
        </div>
        <div class="onethird">
            <div class="other_info">
                <p>INGREDIENTS: <?PHP if(!empty($ingredients)){ echo $ingredients; } ?></p>
                <h3 class="baginbox textcenter">BAG-IN-BOX<br />PACK SIZES</h3>
                <p>General Beverage Connector</p>
                <?PHP //if(!empty($gallon_5)){?>                
                	<p>5 Gallon Bag in Box<br />Pallet 50(10X5) 2500lbs.</p>
                <?PHP //} ?>
                <?PHP // if(!empty($gallon_3)){ ?>
                	<p>3 Gallon Bag in Box<br />Pallet 80(10X8) 2400lbs.</p>
                 <?PHP //} ?>
            </div>
        </div>
    <?PHP
	die();

}
   


?>