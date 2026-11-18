<?php
/**
 * The header for our theme.
 *
 * @package Selph_Theme
 */
?><!doctype html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="<?php echo esc_attr( get_theme_mod( 'selph_color_ink', '#0A2B3A' ) ); ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<script>document.documentElement.classList.add('js');</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'font-body text-base leading-relaxed text-ink antialiased' ); ?>>
<?php wp_body_open(); ?>

<a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-ink focus:px-4 focus:py-3 focus:text-white"><?php esc_html_e( 'Skip to main content', 'selph-theme' ); ?></a>

<?php
/* ------------------------------------------------------------------
 * Helpers for the Customizer-driven header settings.
 * ------------------------------------------------------------------ */
if ( ! function_exists( 'selph_get_logo_markup' ) ) {
	/**
	 * Returns the logo markup: image (with alt) or text.
	 */
	function selph_get_logo_markup(): string {
		$logo_type = get_theme_mod( 'selph_logo_type', 'text' );

		if ( 'image' === $logo_type ) {
			$attachment_id = (int) get_theme_mod( 'selph_logo_image_id', 0 );
			if ( $attachment_id > 0 ) {
				$alt = get_theme_mod( 'selph_logo_alt', get_bloginfo( 'name' ) );
				$img = wp_get_attachment_image(
					$attachment_id,
					'full',
					false,
					[
						'alt'   => $alt,
						'class' => 'h-10 w-auto',
					]
				);
				if ( $img ) {
					return $img;
				}
			}
			// Fallback to text if no image selected.
		}

		$site_name = get_theme_mod( 'selph_logo_text', get_bloginfo( 'name' ) );
		return '<span class="logo-text">' . esc_html( $site_name ) . '</span>';
	}
}

if ( ! function_exists( 'selph_get_cta_button' ) ) {
	/**
	 * Returns the markup for one CTA button based on its Customizer settings.
	 *
	 * @param int $index 1 or 2.
	 */
	function selph_get_cta_button( int $index ): string {
		if ( get_theme_mod( "selph_cta{$index}_hide", false ) ) {
			return '';
		}

		$text = get_theme_mod( "selph_cta{$index}_text", '' );
		if ( '' === $text ) {
			return '';
		}

		$style = get_theme_mod( "selph_cta{$index}_style", 'primary' );
		$type  = get_theme_mod( "selph_cta{$index}_type", 'page' );

		$url = '';
		if ( 'page' === $type ) {
			$page_id = (int) get_theme_mod( "selph_cta{$index}_page", 0 );
			if ( $page_id > 0 ) {
				$url = get_permalink( $page_id );
			}
		} else {
			$url = get_theme_mod( "selph_cta{$index}_url", '' );
		}

		if ( '' === $url ) {
			return '';
		}

		$class = 'primary' === $style ? 'nav-btn nav-btn-solid' : 'nav-btn nav-btn-outline';

		return sprintf(
			'<a class="%1$s" href="%2$s">%3$s</a>',
			esc_attr( $class ),
			esc_url( $url ),
			esc_html( $text )
		);
	}
}
?>

<?php
// Top bar — hide entirely if the Customizer toggle is off.
if ( ! get_theme_mod( 'selph_topbar_hide', false ) ) :
	$topbar_phone = get_theme_mod( 'selph_topbar_phone', '(555) 555-0100' );
	?>
	<div class="bg-ink text-sm text-white">
		<div class="wrap flex flex-wrap items-center justify-between gap-x-6 gap-y-1 py-1">

			<?php if ( $topbar_phone ) : ?>
				<a class="inline-block py-2 font-semibold underline-offset-4 hover:underline"
				   href="<?php echo esc_url( 'tel:' . preg_replace( '/[^\d\+]/', '', $topbar_phone ) ); ?>">
					<?php echo esc_html( $topbar_phone ); ?>
				</a>
			<?php else : ?>
				<span></span>
			<?php endif; ?>

			<div class="flex flex-wrap items-center gap-x-5">
				<?php if ( has_nav_menu( 'topbar_left' ) ) : ?>
					<?php
					wp_nav_menu(
						[
							'theme_location' => 'topbar_left',
							'container'      => false,
							'menu_class'     => 'flex flex-wrap items-center gap-x-5',
							'depth'          => 1,
							'fallback_cb'    => false,
							'link_before'    => '',
							'link_after'     => '',
							'walker'         => new Selph_Topbar_Walker(),
						]
					);
					?>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'topbar_right' ) ) : ?>
					<?php
					wp_nav_menu(
						[
							'theme_location' => 'topbar_right',
							'container'      => false,
							'menu_class'     => 'flex flex-wrap items-center gap-x-5',
							'depth'          => 1,
							'fallback_cb'    => false,
							'walker'         => new Selph_Topbar_Walker(),
						]
					);
					?>
				<?php endif; ?>
			</div>

		</div>
	</div>
<?php endif; ?>

<header id="site-header" class="relative">
	<div class="wrap flex flex-wrap items-center justify-between gap-x-4 gap-y-2 py-3 lg:py-4">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 font-display text-lg font-extrabold leading-tight sm:text-xl">
			<?php
			// Show the site mark (icon) only when no custom logo image is used.
			if ( 'image' !== get_theme_mod( 'selph_logo_type', 'text' ) || ! get_theme_mod( 'selph_logo_image_id', 0 ) ) :
				?>
				<span aria-hidden="true" class="grid h-10 w-10 place-items-center rounded-full bg-sky text-ink shadow-sm ring-2 ring-white/40">
					<svg viewBox="0 0 32 32" class="h-6 w-6" fill="none" aria-hidden="true"><path d="M16 4c-4.4 0-8 3.2-8 7.2 0 5.6 8 12.8 8 12.8s8-7.2 8-12.8C24 7.2 20.4 4 16 4z" fill="var(--color-ink)"/><circle cx="16" cy="11.2" r="2.8" fill="var(--color-sky)"/></svg>
				</span>
			<?php endif; ?>
			<?php echo selph_get_logo_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped internally. ?>
		</a>

		<button id="menu-btn" type="button" class="menu-btn-border inline-flex min-h-[48px] min-w-[48px] items-center justify-center rounded-lg border-2 px-3 font-semibold transition-colors hover:bg-white/10 lg:hidden" aria-expanded="false" aria-controls="site-nav" aria-label="<?php esc_attr_e( 'Toggle menu', 'selph-theme' ); ?>">
			<span class="hamburger-icon" aria-hidden="true"><span></span><span></span><span></span></span>
		</button>

		<nav id="site-nav" aria-label="<?php esc_attr_e( 'Main navigation', 'selph-theme' ); ?>" class="hidden w-full data-[open=true]:block lg:block lg:w-auto">
			<div class="flex flex-col lg:flex-row lg:items-center lg:gap-x-2 xl:gap-x-4">

				<?php if ( has_nav_menu( 'primary' ) ) : ?>
					<?php
					wp_nav_menu(
						[
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'flex flex-col text-base font-semibold lg:flex-row lg:items-center lg:gap-x-2 lg:text-[15px] xl:gap-x-4',
							'depth'          => 2,
							'fallback_cb'    => false,
							'walker'         => new Selph_Primary_Walker(),
						]
					);
					?>
				<?php else : ?>
					<ul class="flex flex-col text-base font-semibold lg:flex-row lg:items-center lg:gap-x-2 lg:text-[15px] xl:gap-x-4">
						<li class="border-b border-white/20 lg:border-0">
							<a class="nav-link flex min-h-[48px] items-center rounded-lg px-1 py-3 transition-colors lg:min-h-[44px] lg:py-2" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'selph-theme' ); ?></a>
						</li>
					</ul>
				<?php endif; ?>

				<?php
				$cta1 = selph_get_cta_button( 1 );
				$cta2 = selph_get_cta_button( 2 );
				if ( $cta1 || $cta2 ) :
					?>
					<div class="flex flex-col gap-2 border-b border-white/20 py-4 lg:flex-row lg:items-center lg:gap-2 lg:border-0 lg:py-0 lg:pl-2">
						<?php echo $cta1; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built internally. ?>
						<?php echo $cta2; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built internally. ?>
					</div>
				<?php endif; ?>

			</div>
		</nav>
	</div>
</header>