<?php
/**
 * Single Product tabs
 * 
 * Responsive Design:
 * - Desktop (>= 768px): Sleek horizontal tab navigation bar matching Figma.
 * - Mobile (< 768px): Clean vertical Accordion with all items closed by default,
 *   expanding smoothly on tap to prevent text clipping and horizontal overflow.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * @package Dharmgyan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper w-full">
		<!-- Desktop Horizontal Tabs (Hidden on Mobile) -->
		<ul class="tabs wc-tabs hidden md:flex items-center justify-center gap-8 lg:gap-10 border-b border-[#E3E3E3] pb-2 mb-8" role="tablist">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
					<a href="#tab-<?php echo esc_attr( $key ); ?>">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<!-- Tab Panels (Structured for Desktop Panels & Mobile Accordion) -->
		<div class="product-tabs-panels-wrapper flex flex-col w-full max-w-[1200px] mx-auto">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<div class="product-tab-accordion-item w-full border-b border-[#EAE3DC] md:border-b-0">
					
					<!-- Mobile Accordion Trigger Button (Hidden on Desktop) -->
					<button type="button" 
							class="mobile-accordion-toggle md:hidden w-full flex items-center justify-between py-4 px-2 text-left font-serif text-[17px] sm:text-[18px] text-[#242424] font-normal transition-colors cursor-pointer focus:outline-none" 
							aria-expanded="false" 
							aria-controls="tab-<?php echo esc_attr( $key ); ?>"
							data-target="#tab-<?php echo esc_attr( $key ); ?>">
						<span class="accordion-title font-medium tracking-wide"><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></span>
						<span class="accordion-icon-wrap w-7 h-7 rounded-full bg-[#FAF7F2] border border-[#EAE3DC] flex items-center justify-center text-[#888888] transition-all duration-300">
							<svg class="accordion-chevron w-4 h-4 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<polyline points="6 9 12 15 18 9"></polyline>
							</svg>
						</span>
					</button>

					<!-- Panel Content -->
					<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
						<div class="tab-panel-inner pb-6 md:pb-0 pt-2 md:pt-0">
							<?php
							if ( isset( $product_tab['callback'] ) ) {
								call_user_func( $product_tab['callback'], $key, $product_tab );
							}
							?>
						</div>
					</div>

				</div>
			<?php endforeach; ?>
		</div>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

<?php endif; ?>
