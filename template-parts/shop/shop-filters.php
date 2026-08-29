<?php
/**
 * Shop Sidebar Filter Component - Pixel-Perfect Figma 1:4229
 *
 * @package Dharmgyan
 */

// Fetch Categories dynamically from WooCommerce
$product_categories = get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'parent'     => 0,
));

// Check if currently on a category archive
$current_cat_slug = '';
if (is_product_category()) {
    $current_term = get_queried_object();
    $current_cat_slug = $current_term ? $current_term->slug : '';
}

// Get min and max prices from active WooCommerce products
global $wpdb;
$price_query = $wpdb->get_row("
    SELECT MIN(CAST(meta_value AS DECIMAL(10,2))) as min_price, MAX(CAST(meta_value AS DECIMAL(10,2))) as max_price
    FROM {$wpdb->postmeta}
    WHERE meta_key = '_price' AND meta_value > 0
");

$store_min_price = $price_query && $price_query->min_price ? floor($price_query->min_price) : 500;
$store_max_price = $price_query && $price_query->max_price ? ceil($price_query->max_price) : 25000;
?>

<div class="filter-sidebar-panel w-full bg-white border border-[#EAE3DC] rounded-[5px] p-5 shadow-xs font-body text-[#444444]">

    <!-- Sidebar Header with Working Clear All Button -->
    <div class="flex items-center justify-between pb-3.5 mb-3 border-b border-[#E5E5E5]">
        <div class="flex items-center gap-2 text-[#111111] font-semibold text-base font-body">
            <svg class="w-4 h-4 text-[#CC5600]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="4" y1="21" x2="4" y2="14"></line>
                <line x1="4" y1="10" x2="4" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12" y2="3"></line>
                <line x1="20" y1="21" x2="20" y2="16"></line>
                <line x1="20" y1="12" x2="20" y2="3"></line>
                <line x1="1" y1="14" x2="7" y2="14"></line>
                <line x1="9" y1="8" x2="15" y2="8"></line>
                <line x1="17" y1="16" x2="23" y2="16"></line>
            </svg>
            <span><?php esc_html_e('Filters', 'dharmgyan'); ?></span>
        </div>
        <button type="button" class="btn-clear-all-filters text-xs font-semibold text-[#CC5600] hover:text-[#B34B00] transition-colors cursor-pointer focus:outline-none">
            <?php esc_html_e('Clear All', 'dharmgyan'); ?>
        </button>
    </div>

    <!-- 1. Collection / Categories Accordion -->
    <div class="filter-accordion-item border-b border-[#E5E5E5] py-3.5">
        <button type="button" class="filter-accordion-toggle w-full flex items-center justify-between text-left group focus:outline-none cursor-pointer" aria-expanded="true">
            <span class="font-bold text-sm text-[#3A3A3A] group-hover:text-[#CC5600] transition-colors"><?php esc_html_e('Collection', 'dharmgyan'); ?></span>
            <svg class="w-3.5 h-3.5 text-[#3A3A3A] transform transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="filter-accordion-content mt-3 space-y-2 max-h-60 overflow-y-auto pr-1 scrollbar-thin">
            <?php if (!empty($product_categories) && !is_wp_error($product_categories)): ?>
                <?php foreach ($product_categories as $cat): ?>
                    <?php 
                    if ($cat->slug === 'uncategorized') continue;
                    $is_checked = ($current_cat_slug === $cat->slug);
                    $count_display = $cat->count > 0 ? $cat->count : 0;
                    ?>
                    <label class="flex items-center justify-between group cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                        <div class="flex items-center gap-2.5">
                            <input 
                                type="checkbox" 
                                name="category_filter[]" 
                                value="<?php echo esc_attr($cat->slug); ?>" 
                                class="filter-category-checkbox w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 transition cursor-pointer"
                                <?php checked($is_checked, true); ?>
                            />
                            <span class="font-normal"><?php echo esc_html($cat->name); ?></span>
                        </div>
                        <span class="text-xs text-[#555555] font-body">(<?php echo esc_html($count_display); ?>)</span>
                    </label>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- 2. Product Type Accordion -->
    <div class="filter-accordion-item border-b border-[#E5E5E5] py-3.5">
        <button type="button" class="filter-accordion-toggle w-full flex items-center justify-between text-left group focus:outline-none cursor-pointer" aria-expanded="true">
            <span class="font-bold text-sm text-[#3A3A3A] group-hover:text-[#CC5600] transition-colors"><?php esc_html_e('Product Type', 'dharmgyan'); ?></span>
            <svg class="w-3.5 h-3.5 text-[#3A3A3A] transform transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="filter-accordion-content mt-3 space-y-2">
            <label class="flex items-center justify-between group cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="product_type_filter[]" value="wall-art" class="filter-type-checkbox w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer" />
                    <span>Wall Art</span>
                </div>
                <span class="text-xs text-[#555555]">(28)</span>
            </label>
            <label class="flex items-center justify-between group cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="product_type_filter[]" value="home-decor" class="filter-type-checkbox w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer" />
                    <span>Home Decor</span>
                </div>
                <span class="text-xs text-[#555555]">(10)</span>
            </label>
        </div>
    </div>

    <!-- 3. Price Accordion (Min/Max inputs + Range Slider matching Figma) -->
    <div class="filter-accordion-item border-b border-[#E5E5E5] py-3.5">
        <button type="button" class="filter-accordion-toggle w-full flex items-center justify-between text-left group focus:outline-none cursor-pointer" aria-expanded="true">
            <span class="font-bold text-sm text-[#3A3A3A] group-hover:text-[#CC5600] transition-colors"><?php esc_html_e('Price', 'dharmgyan'); ?></span>
            <svg class="w-3.5 h-3.5 text-[#3A3A3A] transform transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="filter-accordion-content mt-3 space-y-3">
            
            <!-- Min & Max Numeric Inputs -->
            <div class="flex items-center gap-2">
                <div class="flex-1 relative">
                    <input 
                        type="number" 
                        placeholder="<?php echo esc_attr($store_min_price); ?>" 
                        min="<?php echo esc_attr($store_min_price); ?>" 
                        max="<?php echo esc_attr($store_max_price); ?>" 
                        value="<?php echo esc_attr($store_min_price); ?>" 
                        class="filter-min-price-input w-full px-2.5 py-1 text-xs text-[#444444] border border-[#CCCCCC] rounded-[3px] focus:border-[#CC5600] focus:outline-none text-center"
                    />
                </div>
                <span class="text-[#717171] text-xs font-bold">-</span>
                <div class="flex-1 relative">
                    <input 
                        type="number" 
                        placeholder="<?php echo esc_attr($store_max_price); ?>" 
                        min="<?php echo esc_attr($store_min_price); ?>" 
                        max="<?php echo esc_attr($store_max_price); ?>" 
                        value="<?php echo esc_attr($store_max_price); ?>" 
                        class="filter-max-price-input w-full px-2.5 py-1 text-xs text-[#444444] border border-[#CCCCCC] rounded-[3px] focus:border-[#CC5600] focus:outline-none text-center"
                    />
                </div>
            </div>

            <!-- Price Slider Bar -->
            <div class="relative py-1">
                <input 
                    type="range" 
                    min="<?php echo esc_attr($store_min_price); ?>" 
                    max="<?php echo esc_attr($store_max_price); ?>" 
                    value="<?php echo esc_attr($store_max_price); ?>" 
                    step="50" 
                    class="price-range-slider-input w-full accent-[#383838] cursor-pointer"
                />
            </div>

            <!-- Price Range Text Label Display -->
            <div class="flex items-center justify-between text-xs text-[#717171] font-body">
                <span>₹ <?php echo number_format($store_min_price, 2); ?></span>
                <span>₹ <?php echo number_format($store_max_price, 2); ?></span>
            </div>

        </div>
    </div>

    <!-- 4. Shape Accordion (Figma Section @ y=973) -->
    <div class="filter-accordion-item border-b border-[#E5E5E5] py-3.5">
        <button type="button" class="filter-accordion-toggle w-full flex items-center justify-between text-left group focus:outline-none cursor-pointer" aria-expanded="true">
            <span class="font-bold text-sm text-[#3A3A3A] group-hover:text-[#CC5600] transition-colors"><?php esc_html_e('Shape', 'dharmgyan'); ?></span>
            <svg class="w-3.5 h-3.5 text-[#3A3A3A] transform transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="filter-accordion-content mt-3 space-y-2 max-h-56 overflow-y-auto pr-1 scrollbar-thin">
            <label class="flex items-center justify-between group cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="shape_filter[]" value="horizontal" class="filter-shape-checkbox w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer" />
                    <span>Horizontal Wall Hanging</span>
                </div>
                <span class="text-xs text-[#555555]">(103)</span>
            </label>
            <label class="flex items-center justify-between group cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="shape_filter[]" value="round" class="filter-shape-checkbox w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer" />
                    <span>Round</span>
                </div>
                <span class="text-xs text-[#555555]">(30)</span>
            </label>
            <label class="flex items-center justify-between group cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="shape_filter[]" value="set-of-2" class="filter-shape-checkbox w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer" />
                    <span>Set of 2 Wall Art</span>
                </div>
                <span class="text-xs text-[#555555]">(4)</span>
            </label>
            <label class="flex items-center justify-between group cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="shape_filter[]" value="set-of-3" class="filter-shape-checkbox w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer" />
                    <span>Set of 3 Wall Art</span>
                </div>
                <span class="text-xs text-[#555555]">(116)</span>
            </label>
            <label class="flex items-center justify-between group cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="shape_filter[]" value="set-of-4" class="filter-shape-checkbox w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer" />
                    <span>Set of 4 Wall Art</span>
                </div>
                <span class="text-xs text-[#555555]">(16)</span>
            </label>
            <label class="flex items-center justify-between group cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="shape_filter[]" value="square" class="filter-shape-checkbox w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer" />
                    <span>Square Wall Decor</span>
                </div>
                <span class="text-xs text-[#555555]">(153)</span>
            </label>
            <label class="flex items-center justify-between group cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="shape_filter[]" value="vertical" class="filter-shape-checkbox w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer" />
                    <span>Vertical Wall Art</span>
                </div>
                <span class="text-xs text-[#555555]">(390)</span>
            </label>
        </div>
    </div>

    <!-- 5. Availability Accordion -->
    <div class="filter-accordion-item py-3.5">
        <button type="button" class="filter-accordion-toggle w-full flex items-center justify-between text-left group focus:outline-none cursor-pointer" aria-expanded="true">
            <span class="font-bold text-sm text-[#3A3A3A] group-hover:text-[#CC5600] transition-colors"><?php esc_html_e('Availability', 'dharmgyan'); ?></span>
            <svg class="w-3.5 h-3.5 text-[#3A3A3A] transform transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </button>
        <div class="filter-accordion-content mt-3 space-y-2">
            <label class="flex items-center gap-2.5 cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <input 
                    type="checkbox" 
                    class="filter-status-in-stock w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer"
                />
                <span><?php esc_html_e('In Stock Only', 'dharmgyan'); ?></span>
            </label>
            <label class="flex items-center gap-2.5 cursor-pointer text-xs md:text-[13px] text-[#222222] hover:text-[#CC5600] transition-colors select-none py-0.5">
                <input 
                    type="checkbox" 
                    class="filter-status-on-sale w-3.5 h-3.5 rounded text-[#CC5600] focus:ring-[#CC5600] border-gray-300 cursor-pointer"
                />
                <span><?php esc_html_e('On Sale Only', 'dharmgyan'); ?></span>
            </label>
        </div>
    </div>

    <!-- Mobile Drawer Action Buttons (Visible only on mobile inside drawer) -->
    <div class="pt-4 flex items-center gap-2.5 lg:hidden border-t border-[#E5E5E5] mt-2">
        <button 
            type="button" 
            class="btn-apply-filters flex-1 bg-[#CC5600] hover:bg-[#B34B00] text-white text-xs font-semibold py-2.5 px-4 rounded-[4px] shadow-sm transition-colors cursor-pointer text-center"
        >
            <?php esc_html_e('Apply Filters', 'dharmgyan'); ?>
        </button>
        <button 
            type="button" 
            class="btn-clear-all-filters bg-gray-100 hover:bg-gray-200 text-[#444444] text-xs font-medium py-2.5 px-4 rounded-[4px] transition-colors cursor-pointer text-center"
        >
            <?php esc_html_e('Reset', 'dharmgyan'); ?>
        </button>
    </div>

</div>
