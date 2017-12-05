<?php
global $wp_query;
$image_width = get_option('product_image_width');
/*
 * Most functions called in this page can be found in the wpsc_query.php file
 */
?>
<div id="default_products_page_container" class="wrap wpsc_container container">

<?php wpsc_output_breadcrumbs(); ?>

	<?php do_action('wpsc_top_of_products_page'); // Plugin hook for adding things to the top of the products page, like the live search ?>
	<?php if(wpsc_display_categories()): ?>
	  <?php if(wpsc_category_grid_view()) :?>
			<div class="wpsc_categories wpsc_category_grid group">
				<?php wpsc_start_category_query(array('category_group'=> get_option('wpsc_default_category'), 'show_thumbnails'=> 1)); ?>
					<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_grid_item  <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>">
						<?php wpsc_print_category_image(); ?>
					</a>
					<?php wpsc_print_subcategory("", ""); ?>
				<?php wpsc_end_category_query(); ?>

			</div><!--close wpsc_categories-->
	  <?php else:?>
			<ul class="wpsc_categories">

				<?php wpsc_start_category_query(array('category_group'=>get_option('wpsc_default_category'), 'show_thumbnails'=> get_option('show_category_thumbnails'))); ?>
						<li>
							<?php wpsc_print_category_image(); ?>

							<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_link <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>"><?php wpsc_print_category_name(); ?></a>
							<?php if(wpsc_show_category_description()) :?>
								<?php wpsc_print_category_description("<div class='wpsc_subcategory'>", "</div>"); ?>
							<?php endif;?>

							<?php wpsc_print_subcategory("<ul>", "</ul>"); ?>
						</li>
				<?php wpsc_end_category_query(); ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>
<?php // */ ?>

	<?php if(wpsc_display_products()): ?>

		<?php if(wpsc_is_in_category()) : ?>
			<div class="wpsc_category_details">
				<?php if(wpsc_show_category_thumbnails()) : ?>
					<img src="<?php echo wpsc_category_image(); ?>" alt="<?php echo wpsc_category_name(); ?>" />
				<?php endif; ?>

				<?php if(wpsc_show_category_description() &&  wpsc_category_description()) : ?>
					<?php echo wpsc_category_description(); ?>
				<?php endif; ?>
			</div><!--close wpsc_category_details-->
		<?php endif; ?>
		<?php if(wpsc_has_pages_top()) : ?>
			<div class="wpsc_page_numbers_top">
				<?php wpsc_pagination(); ?>
			</div><!--close wpsc_page_numbers_top-->
		<?php endif; ?>


		<div class="wpsc_default_product_list">
		<?php /** start the product loop here */?>
		<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>

            <div class="polaroid-tile">
                
			<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 polaroid product_view_<?php echo wpsc_the_product_id(); ?> <?php echo wpsc_category_class(); ?> group">
				
				<?php if(wpsc_show_thumbnails()) :?>
					<div class="imagecol col-center-block" style="width:100%; float:none;" id="imagecol_<?php echo wpsc_the_product_id(); ?>">
						<?php if(wpsc_the_product_thumbnail()) :
						?>
							
								<img class="img-responsive" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(); ?>"/>

						<?php else: ?>
								<a href="<?php echo esc_url( wpsc_the_product_permalink() ); ?>">
								<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php esc_attr_e( 'No Image', 'wp-e-commerce' ); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/noimage.png" width="<?php echo get_option('product_image_width'); ?>" height="<?php echo get_option('product_image_height'); ?>" />
								</a>
						<?php endif; ?>
						<?php
						if(gold_cart_display_gallery()) :
							echo gold_shpcrt_display_gallery(wpsc_the_product_id(), true);
						endif;
						?>
					</div><!--close imagecol-->
                
                <div class="polaroid-text">
                <h2 class="prodtitle entry-title col-xs-8" style="font-size: 20px;">
                            <?php 
                                $title = wpsc_the_product_title();
                                trim_title($title, 20);
                            ?>
							<?php if(get_option('hide_name_link') == 1) : ?>
								<?php echo $title; ?>
							<?php else: ?>
								<a class="wpsc_product_title" href="<?php echo esc_url( wpsc_the_product_permalink() ); ?>"><?php echo $title; ?></a>
							<?php endif; ?>
						</h2>
				<?php endif; ?>
					<div class="productcol col-xs-2">
						<?php
							do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post);
							do_action('wpsc_product_addons', wpsc_the_product_id());
						?>
						<!-- <div class="wpsc_description">
							<?php echo wpsc_the_product_description(); ?>
                        </div>close wpsc_description-->

						<?php if(wpsc_the_product_additional_description()) : ?>
						<div class="additional_description_container">
								<img class="additional_description_button"  src="<?php echo WPSC_CORE_THEME_URL; ?>wpsc-images/icon_window_expand.gif" alt="<?php esc_html_e( 'Additional Description', 'wp-e-commerce' ); ?>" /><a href="<?php echo esc_url( wpsc_the_product_permalink() ); ?>" class="additional_description_link"><?php esc_html_e('More Details', 'wp-e-commerce'); ?>
							</a>
							<div class="additional_description">
								<p><?php echo wpsc_the_product_additional_description(); ?></p>
							</div><!--close additional_description-->
						</div><!--close additional_description_container-->
						<?php endif; ?>

						<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') : ?>
							<?php $action =  wpsc_product_external_link(wpsc_the_product_id()); ?>
						<?php else: ?>
						<?php $action = wpsc_this_page_url(); ?>
						<?php endif; ?>
						<form class="product_form"  enctype="multipart/form-data" action="<?php echo esc_url( $action ); ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_<?php echo wpsc_the_product_id(); ?>" >
						<?php do_action ( 'wpsc_product_form_fields_begin' ); ?>		
							<div class="wpsc_product_price">
								
									<?php wpsc_the_product_price_display( array( 'price_text' => '%s' ) ); ?>
							</div><!--close wpsc_product_price-->

							<input type="hidden" value="add_to_cart" name="wpsc_ajax_action"/>
							<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id"/>

							<!-- END OF QUANTITY OPTION -->
							
						
						</form><!--close product_form-->

						<?php if((get_option('hide_addtocart_button') == 0) && (get_option('addtocart_or_buynow')=='1')) : ?>
							<?php echo wpsc_buy_now_button(wpsc_the_product_id()); ?>
						<?php endif ; ?>

						<?php echo wpsc_product_rater(); ?>


					<?php // */ ?>
				</div><!--close productcol-->
                    
                    
                </div>
                    
                </div>
			<?php if(wpsc_product_on_special()) : ?><span class="sale"><?php _e('Sale', 'wp-e-commerce'); ?></span><?php endif; ?>
		</div><!--close default_product_display-->

		<?php endwhile; ?>
		<?php /** end the product loop here */?>
		</div>
		<?php if(wpsc_product_count() == 0):?>
			<h3><?php  _e('There are no products in this group.', 'wp-e-commerce'); ?></h3>
		<?php endif ; ?>
	    <?php do_action( 'wpsc_theme_footer' ); ?>

		<?php if(wpsc_has_pages_bottom()) : ?>
			<div class="wpsc_page_numbers_bottom">
				<?php wpsc_pagination(); ?>
			</div><!--close wpsc_page_numbers_bottom-->
		<?php endif; ?>
	<?php endif; ?>
</div><!--close default_products_page_container-->
