<?php
/**
 * Customizer: Hero section settings.
 *
 * @package Selph_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register hero section customizer controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function selph_customize_hero( WP_Customize_Manager $wp_customize ): void {

	/* -----------------------------------------------------------------
	 * Panel
	 * ----------------------------------------------------------------- */
	$wp_customize->add_section(
		'selph_hero',
		[
			'title'       => __( 'Front Page — Hero', 'selph-theme' ),
			'description' => __( 'Controls the hero banner on the front page. The side panel is a widget area: manage it under Appearance → Widgets → "Hero Side Panel".', 'selph-theme' ),
			'priority'    => 20,
		]
	);

	/* -----------------------------------------------------------------
	 * Helper to register a setting + control quickly.
	 * ----------------------------------------------------------------- */
	$add = static function (
		string $id,
		array $setting_args,
		array $control_args
	) use ( $wp_customize ) {
		$wp_customize->add_setting( $id, $setting_args );
		$wp_customize->add_control( $id, array_merge(
			[ 'section' => 'selph_hero' ],
			$control_args
		) );
	};

	/* -----------------------------------------------------------------
	 * Background image
	 * ----------------------------------------------------------------- */
	$wp_customize->add_setting( 'selph_hero_image_id', [
		'default'           => 0,
		'sanitize_callback' => 'absint',
	] );
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'selph_hero_image_id',
			[
				'label'       => __( 'Hero background image', 'selph-theme' ),
				'description' => __( 'Recommended: 1920×1280 or larger, landscape.', 'selph-theme' ),
				'section'     => 'selph_hero',
				'mime_type'   => 'image',
			]
		)
	);

	$add(
		'selph_hero_image_alt',
		[
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		],
		[
			'label'       => __( 'Hero image alt text', 'selph-theme' ),
			'description' => __( 'Describe the image for screen readers. Required if the image conveys meaning.', 'selph-theme' ),
			'type'        => 'text',
		]
	);

	/* -----------------------------------------------------------------
	 * Overlay intensity (0–100, applies to the darker gradient stop)
	 * ----------------------------------------------------------------- */
	$add(
		'selph_hero_overlay',
		[
			'default'           => 85,
			'sanitize_callback' => static function ( $v ) {
				return max( 0, min( 100, absint( $v ) ) );
			},
		],
		[
			'label'       => __( 'Overlay strength', 'selph-theme' ),
			'description' => __( '0 = no darkening, 100 = near black. Default 85.', 'selph-theme' ),
			'type'        => 'range',
			'input_attrs' => [
				'min'  => 0,
				'max'  => 100,
				'step' => 5,
			],
		]
	);

	/* -----------------------------------------------------------------
	 * Eyebrow (small kicker above the title)
	 * ----------------------------------------------------------------- */
	$add(
		'selph_hero_eyebrow',
		[
			'default'           => __( 'Your business community', 'selph-theme' ),
			'sanitize_callback' => 'sanitize_text_field',
		],
		[
			'label' => __( 'Eyebrow text', 'selph-theme' ),
			'type'  => 'text',
		]
	);

	/* -----------------------------------------------------------------
	 * Title (plain text; kept single-line to match design)
	 * ----------------------------------------------------------------- */
	$add(
		'selph_hero_title',
		[
			'default'           => __( 'Where local businesses grow together.', 'selph-theme' ),
			'sanitize_callback' => 'sanitize_text_field',
		],
		[
			'label'       => __( 'Hero title', 'selph-theme' ),
			'description' => __( 'Keep under about 60 characters for the design.', 'selph-theme' ),
			'type'        => 'textarea',
		]
	);

	/* -----------------------------------------------------------------
	 * Description
	 * ----------------------------------------------------------------- */
	$add(
		'selph_hero_description',
		[
			'default'           => __( 'Join the owners who meet, learn, and promote each other all year. Come to a mixer, find a neighbor in our directory, and put your business in front of the community.', 'selph-theme' ),
			'sanitize_callback' => 'wp_kses_post',
		],
		[
			'label' => __( 'Hero description', 'selph-theme' ),
			'type'  => 'textarea',
		]
	);

	/* -----------------------------------------------------------------
	 * Buttons (2). Each: label, link type (page|url|anchor), page, url, style.
	 * ----------------------------------------------------------------- */
	$pages = [ 0 => __( '— Select —', 'selph-theme' ) ];
	foreach ( get_pages( [ 'number' => 200 ] ) as $p ) {
		$pages[ $p->ID ] = $p->post_title;
	}

	foreach ( [ 1, 2 ] as $i ) {
		$add(
			"selph_hero_btn{$i}_label",
			[
				'default'           => 1 === $i
					? __( 'Join the chamber', 'selph-theme' )
					: __( 'See upcoming events', 'selph-theme' ),
				'sanitize_callback' => 'sanitize_text_field',
			],
			[
				'label' => sprintf( __( 'Button %d — Label', 'selph-theme' ), $i ),
				'type'  => 'text',
			]
		);

		$add(
			"selph_hero_btn{$i}_type",
			[
				'default'           => 1 === $i ? 'anchor' : 'anchor',
				'sanitize_callback' => static function ( $v ) {
					return in_array( $v, [ 'anchor', 'page', 'url' ], true ) ? $v : 'anchor';
				},
			],
			[
				'label'   => sprintf( __( 'Button %d — Link type', 'selph-theme' ), $i ),
				'type'    => 'radio',
				'choices' => [
					'anchor' => __( 'On-page anchor (#id)', 'selph-theme' ),
					'page'   => __( 'WordPress page', 'selph-theme' ),
					'url'    => __( 'Custom URL', 'selph-theme' ),
				],
			]
		);

		$add(
			"selph_hero_btn{$i}_anchor",
			[
				'default'           => 1 === $i ? '#join' : '#events',
				'sanitize_callback' => 'sanitize_text_field',
			],
			[
				'label'           => sprintf( __( 'Button %d — Anchor', 'selph-theme' ), $i ),
				'type'            => 'text',
				'active_callback' => static fn() => 'anchor' === get_theme_mod( "selph_hero_btn{$i}_type", 'anchor' ),
			]
		);

		$add(
			"selph_hero_btn{$i}_page",
			[
				'default'           => 0,
				'sanitize_callback' => 'absint',
			],
			[
				'label'           => sprintf( __( 'Button %d — Page', 'selph-theme' ), $i ),
				'type'            => 'select',
				'choices'         => $pages,
				'active_callback' => static fn() => 'page' === get_theme_mod( "selph_hero_btn{$i}_type", 'anchor' ),
			]
		);

		$add(
			"selph_hero_btn{$i}_url",
			[
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			],
			[
				'label'           => sprintf( __( 'Button %d — Custom URL', 'selph-theme' ), $i ),
				'type'            => 'url',
				'active_callback' => static fn() => 'url' === get_theme_mod( "selph_hero_btn{$i}_type", 'anchor' ),
			]
		);

		$add(
			"selph_hero_btn{$i}_style",
			[
				'default'           => 1 === $i ? 'primary' : 'light',
				'sanitize_callback' => static function ( $v ) {
					return in_array( $v, [ 'primary', 'light', 'quiet' ], true ) ? $v : 'primary';
				},
			],
			[
				'label'   => sprintf( __( 'Button %d — Style', 'selph-theme' ), $i ),
				'type'    => 'select',
				'choices' => [
					'primary' => __( 'Primary (solid)', 'selph-theme' ),
					'light'   => __( 'Light', 'selph-theme' ),
					'quiet'   => __( 'Quiet', 'selph-theme' ),
				],
			]
		);
	}

	/* -----------------------------------------------------------------
	 * Side panel: choose between widget area (HTML/shortcodes) or a
	 * single rich-text field. The widget area is preferred because it
	 * lets editors drop in any block, including Shortcode and Custom HTML.
	 * ----------------------------------------------------------------- */
	$add(
		'selph_hero_panel_mode',
		[
			'default'           => 'widgets',
			'sanitize_callback' => static function ( $v ) {
				return in_array( $v, [ 'widgets', 'html', 'none' ], true ) ? $v : 'widgets';
			},
		],
		[
			'label'       => __( 'Side panel source', 'selph-theme' ),
			'description' => __( 'Widgets: use Appearance → Widgets → "Hero Side Panel". HTML: enter markup/shortcodes below. None: hide the panel.', 'selph-theme' ),
			'type'        => 'radio',
			'choices'     => [
				'widgets' => __( 'Widget area (recommended)', 'selph-theme' ),
				'html'    => __( 'Custom HTML / shortcodes', 'selph-theme' ),
				'none'    => __( 'Hide panel', 'selph-theme' ),
			],
		]
	);

	$add(
		'selph_hero_panel_html',
		[
			'default'           => '',
			'sanitize_callback' => static function ( $value ) {
				// Allow post-level HTML and shortcodes; still strip scripts.
				return wp_kses_post( $value );
			},
		],
		[
			'label'           => __( 'Side panel HTML / shortcodes', 'selph-theme' ),
			'description'     => __( 'Shortcodes are executed. Scripts and event handlers are stripped.', 'selph-theme' ),
			'type'            => 'textarea',
			'active_callback' => static fn() => 'html' === get_theme_mod( 'selph_hero_panel_mode', 'widgets' ),
		]
	);
}
add_action( 'customize_register', 'selph_customize_hero' );

/**
 * Register the widget area used by the hero side panel.
 */
add_action( 'widgets_init', 'selph_register_hero_widget_area' );
function selph_register_hero_widget_area(): void {
	register_sidebar(
		[
			'name'          => __( 'Hero Side Panel', 'selph-theme' ),
			'id'            => 'selph-hero-panel',
			'description'   => __( 'Appears in the hero on the front page. Use a Custom HTML or Shortcode block.', 'selph-theme' ),
			'before_widget' => '<section id="%1$s" class="hero-panel-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="scroll-mt-nav text-xl font-extrabold text-deep">',
			'after_title'   => '</h2>',
		]
	);
}

/**
 * Resolve a hero button into a URL string.
 *
 * @param int $i Button index (1 or 2).
 * @return string
 */
function selph_hero_button_url( int $i ): string {
	$type = get_theme_mod( "selph_hero_btn{$i}_type", 'anchor' );

	if ( 'page' === $type ) {
		$page_id = (int) get_theme_mod( "selph_hero_btn{$i}_page", 0 );
		return $page_id ? (string) get_permalink( $page_id ) : '';
	}

	if ( 'url' === $type ) {
		return (string) get_theme_mod( "selph_hero_btn{$i}_url", '' );
	}

	return (string) get_theme_mod( "selph_hero_btn{$i}_anchor", 1 === $i ? '#join' : '#events' );
}

/**
 * Render the hero side panel according to the chosen mode.
 *
 * @return void
 */
function selph_render_hero_panel(): void {
	$mode = get_theme_mod( 'selph_hero_panel_mode', 'widgets' );

	if ( 'none' === $mode ) {
		return;
	}

	if ( 'html' === $mode ) {
		$html = get_theme_mod( 'selph_hero_panel_html', '' );
		if ( '' === trim( (string) $html ) ) {
			return;
		}
		// Wrap in the same visual shell as the widget area for consistent styling.
		echo '<aside class="hero-in d4 rounded-2xl bg-white/95 p-6 shadow-xl ring-1 ring-white/20 backdrop-blur-sm" aria-labelledby="this-month">';
		echo do_shortcode( wp_kses_post( $html ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- do_shortcode after kses.
		echo '</aside>';
		return;
	}

	// Widget mode.
	if ( ! is_active_sidebar( 'selph-hero-panel' ) ) {
		return;
	}
	echo '<aside class="hero-in d4 rounded-2xl bg-white/95 p-6 shadow-xl ring-1 ring-white/20 backdrop-blur-sm" aria-labelledby="this-month">';
	dynamic_sidebar( 'selph-hero-panel' );
	echo '</aside>';
}