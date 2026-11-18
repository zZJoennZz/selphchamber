<?php
/**
 * Selph Theme functions and definitions.
 *
 * style.css intentionally contains ONLY the theme header (no CSS rules).
 * All compiled CSS lives in /assets/css and is split:
 *   - globals.css on every request
 *   - one page-specific file per template condition
 *
 * @package Selph_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme setup.
 */
add_action( 'after_setup_theme', 'selph_theme_setup' );
function selph_theme_setup(): void {
	register_nav_menus(
		[
			'primary'     => __( 'Primary Menu', 'selph-theme' ),
			'topbar_left' => __( 'Top Bar — Left', 'selph-theme' ),
			'topbar_right'=> __( 'Top Bar — Right', 'selph-theme' ),
		]
	);
	load_theme_textdomain( 'selph-theme', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		[
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		]
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );

	// Optional: register a primary menu once the hardcoded nav is converted.
	// register_nav_menus(
	// 	[
	// 		'primary' => __( 'Primary Menu', 'selph-theme' ),
	// 	]
	// );
}

/**
 * Version every asset by file modification time so cache busting
 * is automatic during development and after deploys.
 *
 * @param string $path Filesystem path relative to the theme root.
 */
function selph_asset_version( string $path ): string {
	$file = get_template_directory() . $path;
	return file_exists( $file ) ? (string) filemtime( $file ) : wp_get_theme()->get( 'Version' );
}

/**
 * Pages without a dark hero get a solid header from the start,
 * so white nav links are never rendered on a white background.
 */
add_filter( 'body_class', function ( array $classes ): array {
	if ( ! is_front_page() ) {
		$classes[] = 'has-solid-header';
	}
	return $classes;
} );

/**
 * Whether the Selph Chamber Helpers plugin is active.
 */
function selph_has_helpers(): bool {
	return class_exists( '\Selph_Chamber_Helpers\Plugin' );
}

/**
 * Enqueue styles and scripts.
 */
add_action( 'wp_enqueue_scripts', 'selph_enqueue_assets' );
function selph_enqueue_assets(): void {
	// Required for theme recognition; carries no CSS rules.
	wp_enqueue_style(
		'selph-theme-header',
		get_stylesheet_uri(),
		[],
		selph_asset_version( '/style.css' )
	);

	// Globals: preflight + tokens + shared components — every page.
	wp_enqueue_style(
		'selph-globals',
		get_template_directory_uri() . '/assets/css/globals.css',
		[ 'selph-theme-header' ],
		selph_asset_version( '/assets/css/globals.css' )
	);
	$last_style_handle = 'selph-globals';

	// Page-specific files, loaded ONLY where their condition is true.
	$page_styles = [
		'selph-frontpage' => [ 'assets/css/frontpage.css', 'is_front_page' ],
		'selph-page'      => [ 'assets/css/page.css', 'is_page' ],
		'selph-single'    => [ 'assets/css/single.css', 'is_singular' ],
		'selph-archive'   => [ 'assets/css/archive.css', 'selph_is_archive_context' ],
	];

	foreach ( $page_styles as $handle => [ $path, $condition ] ) {
		if ( ! call_user_func( $condition ) ) {
			continue;
		}
		wp_enqueue_style(
			$handle,
			get_template_directory_uri() . '/' . $path,
			[ 'selph-globals' ],
			selph_asset_version( '/' . $path )
		);
		$last_style_handle = $handle;
	}

	wp_add_inline_style( $last_style_handle, selph_global_colors_css() );

	// Main front-end script (mobile menu, dropdowns, reveal, quotes).
	$js_path = '/assets/js/main.js';
	if ( file_exists( get_template_directory() . $js_path ) ) {
		wp_enqueue_script(
			'selph-main',
			get_template_directory_uri() . $js_path,
			[],
			selph_asset_version( $js_path ),
			[
				'in_footer' => true,
				'strategy'  => 'defer',
			]
		);
	}
}

/**
 * Archive context covers post archives, blog home, search results,
 * and the custom document CPT archive from the site-functionality plugin.
 */
function selph_is_archive_context(): bool {
	return is_archive() || is_home() || is_search() || is_post_type_archive( 'document' );
}

require_once get_template_directory() . '/inc/class-selph-walkers.php';
require_once get_template_directory() . '/inc/class-selph-customizer-hero.php';

/**
 * Theme palette defaults shared by the Customizer and front-end styles.
 *
 * @return array<string, array{label: string, default: string}>
 */
function selph_global_color_palette(): array {
	return [
		'deep'  => [ 'label' => __( 'Deep blue', 'selph-theme' ), 'default' => '#0E7EA6' ],
		'sky'   => [ 'label' => __( 'Sky blue', 'selph-theme' ), 'default' => '#27C2F8' ],
		'teal'  => [ 'label' => __( 'Teal', 'selph-theme' ), 'default' => '#8BDCE0' ],
		'mint'  => [ 'label' => __( 'Mint', 'selph-theme' ), 'default' => '#A1E4DB' ],
		'lime'  => [ 'label' => __( 'Lime', 'selph-theme' ), 'default' => '#E9F8CD' ],
		'ink'   => [ 'label' => __( 'Ink', 'selph-theme' ), 'default' => '#0A2B3A' ],
		'paper' => [ 'label' => __( 'Paper / white', 'selph-theme' ), 'default' => '#FFFFFF' ],
		'cloud' => [ 'label' => __( 'Cloud', 'selph-theme' ), 'default' => '#F6F9FA' ],
	];
}

/**
 * Register global palette controls in the Customizer.
 */
add_action( 'customize_register', 'selph_customize_global_colors' );
function selph_customize_global_colors( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_section(
		'selph_global_colors',
		[
			'title'       => __( 'Global Colors', 'selph-theme' ),
			'description' => __( 'Set the theme-wide palette used by backgrounds, text, buttons, and links.', 'selph-theme' ),
			'priority'    => 30,
		]
	);

	foreach ( selph_global_color_palette() as $slug => $color ) {
		$setting_id = "selph_color_{$slug}";
		$wp_customize->add_setting(
			$setting_id,
			[
				'default'           => $color['default'],
				'sanitize_callback' => 'sanitize_hex_color',
				'transport'         => 'refresh',
			]
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$setting_id,
				[
					'label'   => $color['label'],
					'section' => 'selph_global_colors',
				]
			)
		);
	}
}

/**
 * Create runtime overrides for the theme-wide color tokens.
 */
function selph_global_colors_css(): string {
	$properties = [];

	foreach ( selph_global_color_palette() as $slug => $color ) {
		$setting = get_theme_mod( "selph_color_{$slug}", $color['default'] );
		$value   = sanitize_hex_color( $setting );
		$properties[] = '--color-' . $slug . ':' . ( $value ?: $color['default'] );
	}

	$properties[] = '--color-white:var(--color-paper)';
	$properties[] = '--ring-focus:3px solid var(--color-ink)';

	return ':root{' . implode( ';', $properties ) . '}';
}


/**
 * Customizer: Header settings.
 */
add_action( 'customize_register', 'selph_customize_header' );
function selph_customize_header( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_section(
		'selph_header',
		[
			'title'    => __( 'Header', 'selph-theme' ),
			'priority' => 25,
		]
	);

	/* ---------- Logo ---------- */
	$wp_customize->add_setting( 'selph_logo_type', [
		'default'           => 'text',
		'sanitize_callback' => function ( $v ) {
			return in_array( $v, [ 'text', 'image' ], true ) ? $v : 'text';
		},
	] );
	$wp_customize->add_control( 'selph_logo_type', [
		'label'   => __( 'Logo type', 'selph-theme' ),
		'section' => 'selph_header',
		'type'    => 'radio',
		'choices' => [
			'text'  => __( 'Text', 'selph-theme' ),
			'image' => __( 'Image', 'selph-theme' ),
		],
	] );

	$wp_customize->add_setting( 'selph_logo_text', [
		'default'           => get_bloginfo( 'name' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'selph_logo_text', [
		'label'           => __( 'Logo text', 'selph-theme' ),
		'section'         => 'selph_header',
		'type'            => 'text',
		'active_callback' => fn() => 'text' === get_theme_mod( 'selph_logo_type', 'text' ),
	] );

	$wp_customize->add_setting( 'selph_logo_image_id', [
		'default'           => 0,
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'selph_logo_image_id',
			[
				'label'           => __( 'Logo image', 'selph-theme' ),
				'section'         => 'selph_header',
				'mime_type'       => 'image',
				'active_callback' => fn() => 'image' === get_theme_mod( 'selph_logo_type', 'text' ),
			]
		)
	);

	$wp_customize->add_setting( 'selph_logo_alt', [
		'default'           => get_bloginfo( 'name' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'selph_logo_alt', [
		'label'           => __( 'Logo image alt text', 'selph-theme' ),
		'description'     => __( 'Required for accessibility. Describe the logo.', 'selph-theme' ),
		'section'         => 'selph_header',
		'type'            => 'text',
		'active_callback' => fn() => 'image' === get_theme_mod( 'selph_logo_type', 'text' ),
	] );

	/* ---------- Top bar ---------- */
	$wp_customize->add_setting( 'selph_topbar_hide', [
		'default'           => false,
		'sanitize_callback' => 'wp_validate_boolean',
	] );
	$wp_customize->add_control( 'selph_topbar_hide', [
		'label'   => __( 'Hide the top bar', 'selph-theme' ),
		'section' => 'selph_header',
		'type'    => 'checkbox',
	] );

	$wp_customize->add_setting( 'selph_topbar_phone', [
		'default'           => '(555) 555-0100',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'selph_topbar_phone', [
		'label'       => __( 'Top bar phone number', 'selph-theme' ),
		'description' => __( 'Leave empty to hide. Menus are managed in Appearance → Menus.', 'selph-theme' ),
		'section'     => 'selph_header',
		'type'        => 'text',
	] );

	/* ---------- CTA 1 & CTA 2 ---------- */
	$pages = [ 0 => __( '— Select —', 'selph-theme' ) ];
	foreach ( get_pages( [ 'number' => 200 ] ) as $p ) {
		$pages[ $p->ID ] = $p->post_title;
	}

	foreach ( [ 1, 2 ] as $i ) {
		$wp_customize->add_setting( "selph_cta{$i}_hide", [
			'default'           => false,
			'sanitize_callback' => 'wp_validate_boolean',
		] );
		$wp_customize->add_control( "selph_cta{$i}_hide", [
			'label'   => sprintf( __( 'Hide CTA %d', 'selph-theme' ), $i ),
			'section' => 'selph_header',
			'type'    => 'checkbox',
		] );

		$wp_customize->add_setting( "selph_cta{$i}_text", [
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		] );
		$wp_customize->add_control( "selph_cta{$i}_text", [
			'label'   => sprintf( __( 'CTA %d — Label', 'selph-theme' ), $i ),
			'section' => 'selph_header',
			'type'    => 'text',
		] );

		$wp_customize->add_setting( "selph_cta{$i}_style", [
			'default'           => 'primary',
			'sanitize_callback' => function ( $v ) {
				return in_array( $v, [ 'primary', 'secondary' ], true ) ? $v : 'primary';
			},
		] );
		$wp_customize->add_control( "selph_cta{$i}_style", [
			'label'   => sprintf( __( 'CTA %d — Style', 'selph-theme' ), $i ),
			'section' => 'selph_header',
			'type'    => 'select',
			'choices' => [
				'primary'   => __( 'Primary (solid)', 'selph-theme' ),
				'secondary' => __( 'Secondary (outline)', 'selph-theme' ),
			],
		] );

		$wp_customize->add_setting( "selph_cta{$i}_type", [
			'default'           => 'page',
			'sanitize_callback' => function ( $v ) {
				return in_array( $v, [ 'page', 'url' ], true ) ? $v : 'page';
			},
		] );
		$wp_customize->add_control( "selph_cta{$i}_type", [
			'label'   => sprintf( __( 'CTA %d — Link type', 'selph-theme' ), $i ),
			'section' => 'selph_header',
			'type'    => 'radio',
			'choices' => [
				'page' => __( 'WordPress page', 'selph-theme' ),
				'url'  => __( 'Custom URL', 'selph-theme' ),
			],
		] );

		$wp_customize->add_setting( "selph_cta{$i}_page", [
			'default'           => 0,
			'sanitize_callback' => 'absint',
		] );
		$wp_customize->add_control( "selph_cta{$i}_page", [
			'label'           => sprintf( __( 'CTA %d — Page', 'selph-theme' ), $i ),
			'section'         => 'selph_header',
			'type'            => 'select',
			'choices'         => $pages,
			'active_callback' => fn() => 'page' === get_theme_mod( "selph_cta{$i}_type", 'page' ),
		] );

		$wp_customize->add_setting( "selph_cta{$i}_url", [
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		] );
		$wp_customize->add_control( "selph_cta{$i}_url", [
			'label'           => sprintf( __( 'CTA %d — Custom URL', 'selph-theme' ), $i ),
			'section'         => 'selph_header',
			'type'            => 'url',
			'active_callback' => fn() => 'url' === get_theme_mod( "selph_cta{$i}_type", 'page' ),
		] );
	}
}