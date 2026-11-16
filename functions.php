<?php
/**
 * Selph Theme — asset loading.
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
 * Version every asset by file modification time so cache busting
 * is automatic during development and after deploys.
 *
 * @param string $path Filesystem path relative to the theme root.
 */
function selph_asset_version( string $path ): string {
    $file = get_template_directory() . $path;
    return file_exists( $file ) ? (string) filemtime( $file ) : wp_get_theme()->get( 'Version' );
}

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

    // Page-specific files, loaded ONLY where their condition is true.
    // To add one: create src/css/your-page.css, add it to build.mjs,
    // and register a line here.
    $page_styles = [
        'selph-home'    => [ 'assets/css/home.css', 'is_front_page' ],
        'selph-page'    => [ 'assets/css/page.css', 'is_page' ],
        'selph-single'  => [ 'assets/css/single.css', 'is_singular' ],
        'selph-archive' => [ 'assets/css/archive.css', 'selph_is_archive_context' ],
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
    }
}

/**
 * Archive context covers post archives, blog home, search results,
 * and the custom document CPT archive from the site-functionality plugin.
 */
function selph_is_archive_context(): bool {
    return is_archive() || is_home() || is_search() || is_post_type_archive( 'document' );
}
