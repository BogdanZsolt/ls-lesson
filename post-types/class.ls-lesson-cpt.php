<?php

if(!class_exists( 'LS_Lesson_Post_Type') ){
	class LS_Lesson_Post_Type {
		function __construct(){
			add_action( 'init', array( $this, 'create_post_type') );
			add_action( 'init', array( $this, 'register_meta_boxes' ) );
			add_filter( 'post_row_actions', array( $this, 'post_row_actions' ), 10, 2 );
		}

		public function create_post_type(){
			register_post_type(
				'ls-lesson',
				array(
					'label'	=> __( 'Ls Lesson', 'ls-lesson' ),
					'description'	=> __( 'Ls Lessons', 'ls-lesson' ),
					'labels'	=> array(
						'name' => __( 'Lessons', 'ls-lesson' ),
						'singular_name'	=> __( 'Lesson', 'ls-lesson' ),
						'add_new_item' => __( 'Add New Lesson', 'ls-lesson' ),
						'edit item'	=> __( 'Edit Lesson', 'ls-lesson'),
						'all_items'	=> __( 'All Lessons', 'ls-lesson' ),
					),
					'public'	=> true,
					'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes' ),
					'hierarchical'	=> true,
					'show_ui'	=> true,
					'show_in_menu' => true,
					'menu_position'	=> 5,
					'show_in_admin_bar'	=> true,
					'show_in_nav_menus'	=> true,
					'can_export'	=> true,
					'has_archive'	=> true,
					'exclude_from_search'	=> false,
					'publicly_queryable'	=> true,
					'show_in_rest'	=> true,
					'menu_icon'	=> 'dashicons-welcome-learn-more'
				)
			);
		}

		public function register_meta_boxes(){
			register_post_meta(
				'ls-lesson',
				'_ls_lesson_video',
				array(
					'single'	=> false,
					'type'	=> 'string',
					'show_in_rest'	=>	true,
					'sanitize_callback' => 'esc_url_raw',
					'auth_callback' => function(){
						return current_user_can( 'edit_posts' );
					}
				)
			);
		}

		public function post_row_actions( $actions, $post ){
			if( $post->post_type === 'ls-lesson' ){
				$actions['id'] = 'ID: ' . $post->ID;
			}
			return $actions;
		}
	}
}