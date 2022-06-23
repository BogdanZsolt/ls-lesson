<?php

/**
	* Plugin Name: La Saphire Lesson
	* Plugin URI: https://zsoltbogdan.hu
	* Description: La Saphire Lesson Block Plugin.
	* Version: 1.0
	* Requires at least: 5.7
	* Requires PHP: 7.0
	* Author: Zsolt Bogdán
	* Author URI: https://zsoltbogdan.hu
	* License: GPL v2 or later
	* License URI: https://www.gnu.org/licenses/gpl-2.0.html
	* Text Domain: ls-lesson
	* Domain Path: /languages
 *
 * @package          La Saphire
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
*/

if( !defined( 'ABSPATH' ) ){
	exit;
}

if( !class_exists( 'LS_Lesson' ) ){
	class LS_Lesson {
		function __construct(){
			$this->define_constants();
			add_action( 'init', array( $this, 'la_saphire_lesson_block_init') );

			require_once( LS_LESSON_PATH . 'post-types/class.ls-lesson-cpt.php');
			$LS_Lesson_Post_Type = new LS_Lesson_Post_Type();
			add_action( 'init', array( $this, 'ls_lesson_plugin_register_template') );
		}

		public function define_constants(){
			define( 'LS_LESSON_PATH', plugin_dir_path( __FILE__ ) );
			define( 'LS_LESSON_URL', plugin_dir_url( __FILE__ ) );
			define( 'LS_LESSON_VERSION', '1.0.0' );
		}

		public static function activate(){
			update_option( 'rewrite_rules', '' );
		}

		public static function deactivate(){
			flush_rewrite_rules();
			unregister_post_type( 'ls-lesson' );
		}

		public static function uninstall(){

		}

		public function ls_blocks_render_ls_lesson_block($attributes){
			$args = array(
				'post_type'	=> 'ls-lesson',
				'posts_per_page' => $attributes['numberOfPosts'],
				'post_status' => 'public',
				'post_parent'	=> 0,
				'orderby'	=> $attributes['orderBy'],
				'order'	=> $attributes['order'],
			);

			$ls_lessons = get_posts($args);
			$posts = '<ul ' . get_block_wrapper_attributes() . '>';
			foreach($ls_lessons as $post){
				$title = $post->post_title;
				$title = $title ? $title : __('(No title)', 'latest-posts');
				$permalink = get_permalink($post);
				// $excerpt = get_the_excerpt($post);
				$posts .= '<li>';
				$posts .= '<a href="' . esc_url($permalink) . '">';
				if(has_post_thumbnail($post)){
					$posts .= get_the_post_thumbnail($post, 'large');
				}
				$posts .= '</a>';
				$posts .= '<h5>' . $title . '</h5>';
				// if(!empty($excerpt)){
				// 	$posts .= '<p>' . $excerpt . '</p>';
				// }
				$posts .= '</li>';
			}
			$posts .= '</ul>';
			return $posts;
		}

		public function la_saphire_lesson_block_init() {
			register_block_type_from_metadata( __DIR__, array(
				'render_callback' => array( $this, 'ls_blocks_render_ls_lesson_block' ),
			) );
		}

		public function ls_lesson_plugin_register_template(){
			$post_type_object = get_post_type_object( 'ls-lesson' );
			$post_type_object->template = array(
				array('ls-blocks/ls-video-meta')
			);
		}
	}
}

if( class_exists( 'LS_Lesson' ) ) {
	register_activation_hook( __FILE__, array( 'LS_Lesson', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'LS_Lesson', 'deactivate' ) );
	register_uninstall_hook( __FILE__, array( 'LS_Lesson', 'uninstall' ) );
	$ls_lesson = new LS_Lesson();
}