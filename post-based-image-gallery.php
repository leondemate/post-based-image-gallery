<?php
/**
 * @package Post_Based_Image_Gallery
 * @version 1.0.0
 */

/**
 * Plugin Name: Post Based Image Gallery
 * Plugin URI: https://github.com/leondemate/post-based-image-gallery
 * Description: This plugin manages and generates image galleries.
 * Author: Carlos E. Alvarez
 * Version: 1.0.0
 * Requires at least: 6.8.2
 * License: GPL v3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Powered by: https://www.aomath.com
 */

// Do not load directly.
if ( ! defined( 'ABSPATH' ) ) {
    die();
}

/**
 * The isValidPost function.
 *
 * It accepts a post id and it decides if it is a valid post.
 *
 * @param int $post_id.
 * @return boolean.
 */
function isValidPost($post_id = null) {
    return $post_id and is_numeric($post_id);
}

/**
 * The hasValidTag function.
 *
 * It accepts a post id and it decides if it is a valid image gallery element.
 *
 * @param int $post_id.
 * @param int $element.
 * @return boolean.
 */
function hasValidTag($post_id = null, $element = '') {
    if ( !isValidPost($post_id) or !strlen($element) ) {
        return false;
    }
    $tags = wp_get_post_tags($post_id);
    foreach ($tags as $tag) {
        if ( $tag->slug === $element ) {
            return true;
        }
    }
}

/**
 * The modal_col function.
 *
 * It accepts a string and it creates a Bootstrap column.
 *
 * @param string $content.
 * @return string Bootstrap html column output.
 */
function modal_col($content = '') {
    $html = '';
    $html .= '<div class="col-xs-12 col-md-12 col-lg-6">';
    $html .=     $content;
    $html .= '</div>';
    return $html;
}

/**
 * The modal_col function.
 *
 * It accepts 2 strings and it creates the modal code.
 *
 * @param string $content.
 * @param string $image.
 * @return string html code.
 */
function modal_body($content = '', $image = null) {
    $html = '';
    if ($image) {
        $html .= modal_col($image);
    }
    $html .= modal_col($content);
    return $html;
}

/**
 * The modal function.
 *
 * Accepts a title and will display a box.
 *
 * @param string $id      Modal id.
 * @param string $content Content.
 * @param string $image   Image.
 * @return string Bootstrap html modal output.
 */
function modal($id = '', $content = '', $image = null) {
    $html = '';
    $html .= '<div class="modal modal-xl fade" id="imageModal-' . $id . '" tabindex="-1" aria-labelledby="imageModalLabel-' . $id . '" aria-hidden="true">';
    $html .= '    <div class="modal-dialog modal-dialog-centered">';
    $html .= '        <div class="modal-content">';
    $html .= '            <div class="modal-body">';
    $html .= '                <div class="row">';
    $html .=                      modal_body($content, $image);
    $html .= '                </div>';
    $html .= '            </div>';
    $html .= '        </div>';
    $html .= '    </div>';
    $html .= '</div>';
    return $html;
}

/**
 * The [image_gallery_item] shortcode.
 *
 * Accepts a post id and will display a link and a optional modal.
 *
 * @param array  $atts    Shortcode attributes. Default empty.
 * @param string $content Shortcode content. Default null.
 * @param string $tag     Shortcode tag (name). Default empty.
 * @return string Shortcode output.
 */
function image_gallery_item_shortcode( $atts = [], $content = null, $tag = '' ) {
    $attr_post_id = isset($atts['post_id']) ? $atts['post_id'] : 0;
    $image = '';
    $modal = '';
    if ( isValidPost($attr_post_id) ) {
        if (get_the_ID() == $attr_post_id) {
            return $content;
        }
        if ( hasValidTag($attr_post_id, 'image-gallery-item') ) {
            $attr_class = isset($atts['class']) ? $atts['class'] : '';
            $attr_modal = isset($atts['modal']) ? $atts['modal'] : false;

            $post = get_post($attr_post_id);
            $post_content = apply_filters('the_content', $post->post_content);
            $post_thumbnail = get_the_post_thumbnail( $post->ID, 'full' );
            $post_link = get_permalink($attr_post_id);

            $attributes = 'href="' . $post_link . '"';
            if ( $attr_modal ) {
                $attributes .= 'type="button" data-bs-toggle="modal" data-bs-target="#imageModal-' . $attr_post_id . '"';
                $modal = modal($attr_post_id, $post_content, $post_thumbnail);
            }

            $image .= '<div class="' . $attr_class . '">';
            $image .= '<a ' . $attributes . '>';
            $image .=     $post_thumbnail;
            $image .= '</a>';
            $image .= '</div>';
        }

    }
    return $image . $modal . $content;
}

/**
 * The [image_gallery] shortcode.
 *
 * Accepts a post id and will display a box.
 *
 * @param array  $atts    Shortcode attributes. Default empty.
 * @param string $content Shortcode content. Default null.
 * @param string $tag     Shortcode tag (name). Default empty.
 * @return string Shortcode output.
 */
function image_gallery_shortcode( $atts = [], $content = null, $tag = '' ) {
    $attr_post_id = isset($atts['post_id']) ? $atts['post_id'] : 0;
    $post_content = '';
    if ( isValidPost($attr_post_id) ) {
        $post = get_post($attr_post_id);
        if ( hasValidTag($attr_post_id, 'image-gallery') ) {
            $post_content = $post ? preg_replace("/<br\s*\/?\>/i", "", apply_filters('the_content', $post->post_content)) : '';
        }
    }
    return $post_content . $content;
}

/**
 * Central location to create all shortcodes.
 */
function image_gallery_shortcodes_init() {
    add_shortcode( 'image_gallery', 'image_gallery_shortcode' );
    add_shortcode( 'image_gallery_item', 'image_gallery_item_shortcode' );
}

add_action( 'init', 'image_gallery_shortcodes_init' );
