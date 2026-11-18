<?php
/**
 * Nav menu walkers that match the existing hardcoded markup classes.
 *
 * @package Selph_Theme
 */

if ( ! class_exists( 'Selph_Topbar_Walker' ) ) {
	class Selph_Topbar_Walker extends Walker_Nav_Menu {
		public function start_lvl( &$output, $depth = 0, $args = null ) {}
		public function end_lvl( &$output, $depth = 0, $args = null ) {}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$classes = [ 'inline-block', 'py-2', 'underline-offset-4', 'hover:underline' ];
			if ( in_array( 'menu-item-has-children', (array) $item->classes, true ) ) {
				// Flat top bar — no dropdowns.
			}
			$output .= '<li>';
			$output .= '<a class="' . esc_attr( implode( ' ', $classes ) ) . '" href="' . esc_url( $item->url ) . '">';
			$output .= esc_html( $item->title );
			$output .= '</a>';
		}

		public function end_el( &$output, $item, $depth = 0, $args = null ) {
			$output .= '</li>';
		}
	}
}

if ( ! class_exists( 'Selph_Primary_Walker' ) ) {
	/**
	 * Primary menu walker.
	 *
	 * - Top level (depth 0): uses the same `nav-link` chrome.
	 * - Parent items: rendered as a <button> + <ul data-sub> pattern identical
	 *   to the original hardcoded markup so `.group` / `group-data-[open=true]`
	 *   JS keeps working with no CSS changes.
	 */
	class Selph_Primary_Walker extends Walker_Nav_Menu {
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			if ( 0 === $depth ) {
				$output .= '<ul class="mb-3 ml-1 hidden border-l-4 border-mint pl-2 font-medium text-ink group-data-[open=true]:block lg:invisible lg:absolute lg:left-0 lg:top-full lg:z-30 lg:mb-0 lg:ml-0 lg:mt-0 lg:block lg:min-w-[260px] lg:translate-y-2 lg:rounded-xl lg:border-0 lg:bg-white lg:p-2 lg:opacity-0 lg:shadow-lg lg:ring-1 lg:ring-ink/15 lg:transition lg:duration-200 lg:ease-out lg:group-data-[open=true]:visible lg:group-data-[open=true]:translate-y-0 lg:group-data-[open=true]:opacity-100" data-sub-list>';
			} else {
				$output .= '<ul class="ml-2 border-l border-ink/10 pl-2">';
			}
		}

		public function end_lvl( &$output, $depth = 0, $args = null ) {
			$output .= '</ul>';
		}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$has_children = in_array( 'menu-item-has-children', (array) $item->classes, true );

			if ( 0 === $depth ) {
				if ( $has_children ) {
					$sub_id = 'sub-' . (int) $item->ID;
					$output .= '<li class="group relative border-b border-white/20 lg:border-0" data-sub>';
					$output .= '<button type="button" class="nav-link flex min-h-[48px] w-full items-center justify-between gap-2 rounded-lg px-1 py-3 transition-colors lg:min-h-[44px] lg:w-auto lg:py-2" aria-expanded="false" aria-controls="' . esc_attr( $sub_id ) . '">';
					$output .= esc_html( $item->title );
					$output .= '<svg aria-hidden="true" viewBox="0 0 20 20" class="h-4 w-4 shrink-0 transition-transform duration-200 group-data-[open=true]:rotate-180" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 8l5 5 5-5"/></svg>';
					$output .= '</button>';
					// Attach id to the next <ul> via the walker.
					add_filter( 'nav_menu_submenu_attributes', function ( $atts, $args, $current_depth ) use ( $sub_id ) {
						if ( 0 === $current_depth ) {
							$atts['id'] = $sub_id;
						}
						return $atts;
					}, 10, 3 );
				} else {
					$output .= '<li class="border-b border-white/20 lg:border-0">';
					$output .= '<a class="nav-link flex min-h-[48px] items-center rounded-lg px-1 py-3 transition-colors lg:min-h-[44px] lg:py-2" href="' . esc_url( $item->url ) . '">';
					$output .= esc_html( $item->title );
					$output .= '</a>';
				}
				return;
			}

			// Depth >= 1: simple dropdown link matching the hover style.
			$output .= '<li>';
			$output .= '<a class="block rounded-lg px-3 py-2.5 transition-all duration-150 hover:translate-x-1 hover:bg-mint/60" href="' . esc_url( $item->url ) . '">';
			$output .= esc_html( $item->title );
			$output .= '</a>';
		}

		public function end_el( &$output, $item, $depth = 0, $args = null ) {
			$output .= '</li>';
		}
	}
}