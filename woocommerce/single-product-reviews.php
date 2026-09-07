<?php
/**
 * Display single product reviews (comments) - Pixel-Perfect Spiritual Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

global $product;

if (!comments_open()) {
    return;
}
?>

<div id="reviews" class="woocommerce-Reviews max-w-5xl mx-auto font-body">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Side: Existing Reviews List (5 or 6 cols) -->
        <div id="comments" class="lg:col-span-6 space-y-4">
            <h3 class="font-serif text-xl md:text-[22px] text-[#111111] font-normal leading-tight flex items-center gap-2 mb-4">
                <span><?php esc_html_e('Customer Reviews', 'dharmgyan'); ?></span>
                <?php
                $count = $product->get_review_count();
                if ($count > 0) {
                    echo '<span class="text-sm font-body text-[#CC5600] font-semibold bg-[#FFF1E5] px-2.5 py-0.5 rounded-full">(' . esc_html($count) . ')</span>';
                }
                ?>
            </h3>

            <?php if (have_comments()): ?>
                <ol class="commentlist space-y-4">
                    <?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'woocommerce_comments'))); ?>
                </ol>

                <?php
                if (get_comment_pages_count() > 1 && get_option('page_comments')):
                    echo '<nav class="woocommerce-pagination pt-4">';
                    paginate_comments_links(
                        apply_filters(
                            'woocommerce_comment_pagination_args',
                            array(
                                'prev_text' => '&larr; Previous',
                                'next_text' => 'Next &rarr;',
                                'type'      => 'list',
                            )
                        )
                    );
                    echo '</nav>';
                endif;
                ?>
            <?php else: ?>
                <div class="no-reviews-box p-6 bg-[#FCFAF7] border border-[#EAE3DC] rounded-[6px] text-center">
                    <div class="w-12 h-12 rounded-full bg-[#FFF1E5] text-[#CC5600] flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-bold text-[#242424] mb-1"><?php esc_html_e('No Reviews Yet', 'dharmgyan'); ?></h4>
                    <p class="text-xs text-[#666666] leading-relaxed">
                        <?php esc_html_e('Be the first to share your sacred blessings and review this divine item.', 'dharmgyan'); ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Side: Write a Review Form (6 or 7 cols) -->
        <div class="lg:col-span-6">
            <?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())): ?>
                <div id="review_form_wrapper" class="bg-white border border-[#EAE3DC] rounded-[6px] p-6 shadow-2xs">
                    <div id="review_form">
                        <?php
                        $commenter    = wp_get_current_commenter();
                        $comment_form = array(
                            'title_reply'         => have_comments() ? esc_html__('Add a Review', 'dharmgyan') : esc_html__('Write a Review', 'dharmgyan'),
                            'title_reply_to'      => esc_html__('Leave a Reply to %s', 'dharmgyan'),
                            'title_reply_before'  => '<h3 id="reply-title" class="comment-reply-title font-serif text-lg md:text-[20px] text-[#111111] font-normal mb-3">',
                            'title_reply_after'   => '</h3>',
                            'comment_notes_after' => '',
                            'label_submit'        => esc_html__('Submit Review', 'dharmgyan'),
                            'logged_in_as'        => '',
                            'comment_field'       => '',
                            'class_submit'        => 'submit-review-btn inline-flex items-center justify-center bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-sm px-6 py-2.5 rounded-[4px] transition-all cursor-pointer shadow-sm',
                        );

                        $name_email_required = (bool) get_option('require_name_email', 1);
                        $fields              = array(
                            'author' => array(
                                'label'        => __('Your Name', 'dharmgyan'),
                                'type'         => 'text',
                                'value'        => $commenter['comment_author'],
                                'required'     => $name_email_required,
                                'autocomplete' => 'name',
                            ),
                            'email'  => array(
                                'label'        => __('Your Email', 'dharmgyan'),
                                'type'         => 'email',
                                'value'        => $commenter['comment_author_email'],
                                'required'     => $name_email_required,
                                'autocomplete' => 'email',
                            ),
                        );

                        $comment_form['fields'] = array();

                        foreach ($fields as $key => $field) {
                            $field_html  = '<p class="comment-form-' . esc_attr($key) . ' mb-3">';
                            $field_html .= '<label for="' . esc_attr($key) . '" class="block text-xs font-semibold text-[#333333] mb-1 font-body">' . esc_html($field['label']);

                            if ($field['required']) {
                                $field_html .= '&nbsp;<span class="required text-[#CC5600]">*</span>';
                            }

                            $field_html .= '</label><input id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" type="' . esc_attr($field['type']) . '" autocomplete="' . esc_attr($field['autocomplete']) . '" value="' . esc_attr($field['value']) . '" class="w-full h-10 px-3 bg-white border border-[#D4D4D4] focus:border-[#CC5600] rounded-[4px] text-xs text-[#242424] outline-none font-body transition-colors" ' . ($field['required'] ? 'required' : '') . ' /></p>';

                            $comment_form['fields'][$key] = $field_html;
                        }

                        $account_page_url = wc_get_page_permalink('myaccount');
                        if ($account_page_url) {
                            $comment_form['must_log_in'] = '<p class="must-log-in text-xs text-[#666666] mb-3">' . sprintf(esc_html__('You must be %1$slogged in%2$s to post a review.', 'dharmgyan'), '<a href="' . esc_url($account_page_url) . '" class="text-[#CC5600] font-semibold underline">', '</a>') . '</p>';
                        }

                        if (wc_review_ratings_enabled()) {
                            $comment_form['comment_field'] = '<div class="comment-form-rating mb-3">
                                <label for="rating" id="comment-form-rating-label" class="block text-xs font-semibold text-[#333333] mb-1.5 font-body">' . esc_html__('Your Rating', 'dharmgyan') . (wc_review_ratings_required() ? '&nbsp;<span class="required text-[#CC5600]">*</span>' : '') . '</label>
                                <select name="rating" id="rating" required class="bg-white border border-[#D4D4D4] rounded-[4px] px-3 py-1.5 text-xs text-[#242424] focus:border-[#CC5600] outline-none">
                                    <option value="">' . esc_html__('Select Rating…', 'dharmgyan') . '</option>
                                    <option value="5">★★★★★ (5 - Perfect)</option>
                                    <option value="4">★★★★☆ (4 - Good)</option>
                                    <option value="3">★★★☆☆ (3 - Average)</option>
                                    <option value="2">★★☆☆☆ (2 - Not that bad)</option>
                                    <option value="1">★☆☆☆☆ (1 - Very poor)</option>
                                </select>
                            </div>';
                        }

                        $comment_form['comment_field'] .= '<p class="comment-form-comment mb-4">
                            <label for="comment" class="block text-xs font-semibold text-[#333333] mb-1 font-body">' . esc_html__('Your Review', 'dharmgyan') . '&nbsp;<span class="required text-[#CC5600]">*</span></label>
                            <textarea id="comment" name="comment" cols="45" rows="4" placeholder="' . esc_attr__('Write your honest experience with this devotional product…', 'dharmgyan') . '" class="w-full p-3 bg-white border border-[#D4D4D4] focus:border-[#CC5600] rounded-[4px] text-xs text-[#242424] outline-none font-body transition-colors" required></textarea>
                        </p>';

                        comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
                        ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="p-6 bg-[#FCFAF7] border border-[#EAE3DC] rounded-[6px] text-center">
                    <p class="text-xs text-[#666666] font-body"><?php esc_html_e('Only verified buyers who have purchased this product may leave a review.', 'dharmgyan'); ?></p>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
