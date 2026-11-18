<?php
/**
 * Front page template.
 *
 * @package Selph_Theme
 */

get_header();
?>
<?php
/* ---------------------------------------------------------------
 * Hero — all content is editable via
 * Appearance → Customize → Front Page — Hero.
 * --------------------------------------------------------------- */
$hero_img_id    = (int) get_theme_mod( 'selph_hero_image_id', 0 );
$hero_img_alt   = get_theme_mod( 'selph_hero_image_alt', '' );
$hero_overlay   = (int) get_theme_mod( 'selph_hero_overlay', 85 );
$hero_eyebrow   = get_theme_mod( 'selph_hero_eyebrow', __( 'Your business community', 'selph-theme' ) );
$hero_title     = get_theme_mod( 'selph_hero_title', __( 'Where local businesses grow together.', 'selph-theme' ) );
$hero_desc      = get_theme_mod( 'selph_hero_description', '' );
$hero_panel     = get_theme_mod( 'selph_hero_panel_mode', 'widgets' );

$hero_btn1_label = get_theme_mod( 'selph_hero_btn1_label', __( 'Join the chamber', 'selph-theme' ) );
$hero_btn1_url   = selph_hero_button_url( 1 );
$hero_btn1_style = get_theme_mod( 'selph_hero_btn1_style', 'primary' );

$hero_btn2_label = get_theme_mod( 'selph_hero_btn2_label', __( 'See upcoming events', 'selph-theme' ) );
$hero_btn2_url   = selph_hero_button_url( 2 );
$hero_btn2_style = get_theme_mod( 'selph_hero_btn2_style', 'light' );

// Fallback image if none is set yet.
$hero_src = $hero_img_id
	? wp_get_attachment_image_url( $hero_img_id, 'full' )
	: 'https://images.pexels.com/photos/8761637/pexels-photo-8761637.jpeg?auto=compress&cs=tinysrgb&w=1920';

// Inline overlay intensity — 0..100 -> 0..0.95 alpha.
$overlay_start = max( 0, min( 95, $hero_overlay ) );
$overlay_end   = max( 0, $overlay_start - 20 );
$overlay_css   = sprintf(
	'--hero-a-start:%d%%;--hero-a-end:%d%%;',
	$overlay_start,
	$overlay_end
);
?>
<main id="main">

	<section id="hero" class="relative min-h-[70vh] overflow-hidden" aria-labelledby="hero-title">
		<div class="absolute inset-0">
			<img
				src="<?php echo esc_url( $hero_src ); ?>"
				alt="<?php echo esc_attr( $hero_img_alt ); ?>"
				class="h-full w-full object-cover object-center"
				width="1920" height="1280" fetchpriority="high" decoding="async">
			<div class="absolute inset-0 hero-overlay" style="<?php echo esc_attr( $overlay_css ); ?>"></div>
			<div class="absolute inset-0 bg-gradient-to-t from-ink/50 via-transparent to-ink/30"></div>
		</div>

		<div class="hero-inner relative wrap grid items-center gap-10 pb-20 lg:grid-cols-[1.15fr_1fr] lg:pb-28">
			<div>
				<?php if ( '' !== trim( (string) $hero_eyebrow ) ) : ?>
					<p class="hero-in d1 text-sm font-semibold uppercase tracking-[0.18em] text-teal"><?php echo esc_html( $hero_eyebrow ); ?></p>
				<?php endif; ?>

				<h1 id="hero-title" class="hero-in d1 mt-3 max-w-[16ch] text-4xl font-extrabold leading-[1.05] text-white sm:text-5xl lg:text-6xl"><?php echo esc_html( $hero_title ); ?></h1>

				<?php if ( '' !== trim( (string) $hero_desc ) ) : ?>
					<div class="hero-in d2 mt-6 max-w-[56ch] text-lg text-white/90"><?php echo wp_kses_post( $hero_desc ); ?></div>
				<?php endif; ?>

				<div class="hero-in d3 mt-8 flex flex-wrap gap-4">
					<?php if ( $hero_btn1_url && '' !== trim( (string) $hero_btn1_label ) ) : ?>
						<a class="btn btn-<?php echo esc_attr( $hero_btn1_style ); ?>" href="<?php echo esc_url( $hero_btn1_url ); ?>"><?php echo esc_html( $hero_btn1_label ); ?></a>
					<?php endif; ?>
					<?php if ( $hero_btn2_url && '' !== trim( (string) $hero_btn2_label ) ) : ?>
						<a class="btn btn-<?php echo esc_attr( $hero_btn2_style ); ?>" href="<?php echo esc_url( $hero_btn2_url ); ?>"><?php echo esc_html( $hero_btn2_label ); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<?php selph_render_hero_panel(); ?>
		</div>
	</section>

	<section class="py-14 lg:py-16" aria-labelledby="quick-title">
		<div class="wrap">
			<div class="max-w-2xl">
				<h2 id="quick-title" data-reveal class="text-3xl font-extrabold text-deep sm:text-4xl"><?php esc_html_e( 'Find what you need', 'selph-theme' ); ?></h2>
				<p data-reveal style="--d:.06s" class="mt-3 text-lg text-ink/80"><?php esc_html_e( 'Quick paths to networking, promotion, growth, and community resources.', 'selph-theme' ); ?></p>
			</div>
			<ul class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
				<?php
				$quick_links = [
					[ 'Network', 'Mixers, luncheons, and after hours', 'events', 'bg-mint', '<circle cx="12" cy="12" r="3"/><circle cx="5" cy="6" r="2"/><circle cx="19" cy="6" r="2"/><circle cx="12" cy="20" r="2"/><path d="M7 7l3 3M17 7l-3 3M12 15v3"/>' ],
					[ 'Promote', 'Spotlights, sponsorships, and ribbon cuttings', 'news', 'bg-teal', '<path d="M4 10v4h3l7 4V6L7 10z"/><path d="M17 9a4 4 0 0 1 0 6"/>' ],
					[ 'Grow', 'Leadership and training for owners', 'leadership', 'bg-lime', '<path d="M4 19h16M6 15l4-4 3 3 5-6"/><path d="M15 8h3v3"/>' ],
					[ 'Find a business', 'Search the member directory', 'directory', 'bg-mint', '<circle cx="11" cy="11" r="6"/><path d="M20 20l-4-4"/>' ],
					[ 'Event calendar', 'See what is happening this month', 'events', 'bg-teal', '<rect x="4" y="5" width="16" height="15" rx="2"/><path d="M4 10h16M9 3v4M15 3v4"/>' ],
					[ 'Community guide', 'Our towns, economy, and members', 'guide', 'bg-lime', '<path d="M5 4h10a3 3 0 0 1 3 3v13H8a3 3 0 0 1-3-3z"/><path d="M8 17h10"/>' ],
					[ 'Economic development', 'Regional insight and resources', 'economic-development', 'bg-mint', '<path d="M3 21h18M5 21V8l7-4 7 4v13M9 21v-6h6v6M9 10h.01M15 10h.01"/>' ],
					[ 'Relocate here', 'Explore the area and plan your move', 'economic-development', 'bg-teal', '<path d="M3 10.5 12 4l9 6.5M5 9v11h14V9M9 20v-6h6v6"/>' ],
				];
				foreach ( $quick_links as $index => $quick_link ) :
					?>
					<li data-reveal style="--d:<?php echo esc_attr( number_format( ( $index % 4 ) * 0.05, 2 ) ); ?>s">
						<a href="#<?php echo esc_attr( $quick_link[2] ); ?>" class="group flex h-full flex-col rounded-2xl border border-ink/10 bg-white p-6 shadow-sm ring-1 ring-ink/5 transition duration-200 hover:-translate-y-1 hover:border-deep/20 hover:shadow-md">
							<span class="grid h-12 w-12 place-items-center rounded-xl <?php echo esc_attr( $quick_link[3] ); ?> transition-transform duration-300 group-hover:scale-110"><svg aria-hidden="true" viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="var(--color-ink)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $quick_link[4]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Inline SVG path data is a theme constant. ?></svg></span>
							<span class="mt-5 font-display text-lg font-bold leading-tight"><?php echo esc_html( $quick_link[0] ); ?></span>
							<span class="mt-1.5 text-sm text-ink/75"><?php echo esc_html( $quick_link[1] ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section class="bg-deep py-12 text-white" aria-label="<?php esc_attr_e( 'The chamber at a glance', 'selph-theme' ); ?>">
		<dl class="wrap grid grid-cols-2 gap-8 text-center lg:grid-cols-4">
			<div data-reveal class="flex flex-col-reverse"><dt class="mt-1"><?php esc_html_e( 'Member businesses', 'selph-theme' ); ?></dt><dd class="font-display text-5xl font-extrabold">430+</dd></div>
			<div data-reveal style="--d:.08s" class="flex flex-col-reverse"><dt class="mt-1"><?php esc_html_e( 'Events each year', 'selph-theme' ); ?></dt><dd class="font-display text-5xl font-extrabold">60</dd></div>
			<div data-reveal style="--d:.16s" class="flex flex-col-reverse"><dt class="mt-1"><?php esc_html_e( 'Communities served', 'selph-theme' ); ?></dt><dd class="font-display text-5xl font-extrabold">6</dd></div>
			<div data-reveal style="--d:.24s" class="flex flex-col-reverse"><dt class="mt-1"><?php esc_html_e( 'Serving business since', 'selph-theme' ); ?></dt><dd class="font-display text-5xl font-extrabold">1974</dd></div>
		</dl>
	</section>

	<section id="festival" class="scroll-mt-nav py-14 lg:py-16" aria-labelledby="feat-title">
		<div class="wrap">
			<div data-reveal class="grid overflow-hidden rounded-3xl bg-lime lg:grid-cols-[1fr_1.2fr]">
				<div class="relative min-h-[220px] lg:min-h-0">
					<img src="https://images.pexels.com/photos/2774556/pexels-photo-2774556.jpeg?auto=compress&cs=tinysrgb&w=800" alt="<?php esc_attr_e( 'Crowd enjoying an outdoor community festival', 'selph-theme' ); ?>" class="absolute inset-0 h-full w-full object-cover" loading="lazy" width="800" height="600">
					<div class="absolute inset-0 bg-ink/55"></div>
					<div class="relative grid h-full place-items-center p-8 text-center text-white">
						<p>
							<span class="block text-sm font-semibold"><?php esc_html_e( 'Featured event, 2027', 'selph-theme' ); ?></span>
							<span class="mt-1 block font-display text-5xl font-extrabold leading-none"><?php esc_html_e( 'Apr 17 to 19', 'selph-theme' ); ?></span>
						</p>
					</div>
				</div>
				<div class="p-6 sm:p-8">
					<h2 id="feat-title" class="text-3xl font-extrabold"><?php esc_html_e( 'Community Festival', 'selph-theme' ); ?></h2>
					<p class="mt-2 max-w-[60ch]"><?php esc_html_e( 'Three days of live music, local food, and a market with member vendors up and down Main Street.', 'selph-theme' ); ?></p>
					<ul class="mt-4 grid gap-1 text-sm sm:grid-cols-3">
						<li><strong><?php esc_html_e( 'Friday', 'selph-theme' ); ?></strong><br><?php esc_html_e( '4 to 10 p.m.', 'selph-theme' ); ?></li>
						<li><strong><?php esc_html_e( 'Saturday', 'selph-theme' ); ?></strong><br><?php esc_html_e( '10 a.m. to 10 p.m.', 'selph-theme' ); ?></li>
						<li><strong><?php esc_html_e( 'Sunday', 'selph-theme' ); ?></strong><br><?php esc_html_e( 'Noon to 6 p.m.', 'selph-theme' ); ?></li>
					</ul>
					<div class="mt-6 flex flex-wrap gap-3">
						<a class="btn btn-primary" href="#events"><?php esc_html_e( 'Learn more', 'selph-theme' ); ?></a>
						<a class="btn btn-quiet" href="#contact"><?php esc_html_e( 'Volunteer to help', 'selph-theme' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="why-join" class="scroll-mt-nav py-16 lg:py-20" aria-labelledby="why-title">
		<div class="wrap">
			<h2 data-reveal id="why-title" class="max-w-[24ch] text-3xl font-extrabold text-deep sm:text-4xl"><?php esc_html_e( 'What membership gets your business', 'selph-theme' ); ?></h2>
			<p data-reveal style="--d:.08s" class="mt-4 max-w-[60ch] text-lg"><?php esc_html_e( 'Our members get connections, customers, and a stronger voice in the community.', 'selph-theme' ); ?></p>
			<div class="mt-10 grid gap-x-10 gap-y-10 md:grid-cols-3">
				<article data-reveal class="group border-t-4 border-sky pt-5">
					<div aria-hidden="true" class="mb-4 grid h-16 w-16 place-items-center rounded-2xl bg-lime transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-110">
						<svg viewBox="0 0 40 40" class="h-9 w-9" fill="none" stroke="var(--color-ink)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 36s11-9.5 11-19a11 11 0 0 0-22 0c0 9.5 11 19 11 19z" fill="var(--color-sky)"/><circle cx="20" cy="17" r="4" fill="var(--color-paper)"/></svg>
					</div>
					<h3 class="text-xl font-bold"><?php esc_html_e( 'Be found by neighbors', 'selph-theme' ); ?></h3>
					<p class="mt-2"><?php esc_html_e( 'Your business listing appears in a searchable directory that customers use to find local help.', 'selph-theme' ); ?></p>
				</article>
				<article data-reveal style="--d:.12s" class="group border-t-4 border-teal pt-5">
					<div aria-hidden="true" class="mb-4 grid h-16 w-16 place-items-center rounded-2xl bg-teal transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-110">
						<svg viewBox="0 0 40 40" class="h-9 w-9" fill="none" stroke="var(--color-ink)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="13" cy="14" r="5" fill="var(--color-sky)"/><circle cx="27" cy="14" r="5" fill="var(--color-paper)"/><path d="M4 33c0-6 4-10 9-10s9 4 9 10M18 33c0-6 4-10 9-10s9 4 9 10"/></svg>
					</div>
					<h3 class="text-xl font-bold"><?php esc_html_e( 'Meet people who buy local', 'selph-theme' ); ?></h3>
					<p class="mt-2"><?php esc_html_e( 'Monthly mixers, ribbon cuttings, and a yearly gala put you in the room with other owners.', 'selph-theme' ); ?></p>
				</article>
				<article data-reveal style="--d:.24s" class="group border-t-4 border-mint pt-5">
					<div aria-hidden="true" class="mb-4 grid h-16 w-16 place-items-center rounded-2xl bg-mint transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-110">
						<svg viewBox="0 0 40 40" class="h-9 w-9" fill="none" stroke="var(--color-ink)" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 5l4.6 9.4 10.4 1.5-7.5 7.3 1.8 10.3L20 28.6 10.7 33.5l1.8-10.3L5 15.9l10.4-1.5z" fill="var(--color-sky)"/></svg>
					</div>
					<h3 class="text-xl font-bold"><?php esc_html_e( 'Get seen all year', 'selph-theme' ); ?></h3>
					<p class="mt-2"><?php esc_html_e( 'Sponsor placements rotate fairly across the site, so every tier gets real exposure.', 'selph-theme' ); ?></p>
				</article>
			</div>
			<h3 data-reveal class="mt-14 text-2xl font-extrabold"><?php esc_html_e( 'Seven reasons members stay', 'selph-theme' ); ?></h3>
			<ol class="mt-6 grid gap-x-10 gap-y-8 md:grid-cols-2 lg:grid-cols-3">
				<?php
				$reasons = [
					[ 'Connections', 'The owners you meet here become customers, partners, and friends.' ],
					[ 'Credibility', 'Our name on your door tells shoppers that you are invested here.' ],
					[ 'Resources', 'Get answers from peers who have faced the same problems you have.' ],
					[ 'A voice', 'We follow local and state issues and speak up for business at city hall.' ],
					[ 'Visibility', 'Ribbon cuttings, sponsorships, and events put your name in front of the public.' ],
					[ 'Giving back', 'Scholarships and service projects strengthen the town your business depends on.' ],
					[ 'Business intelligence', 'Stay informed about local issues, regional opportunities, and changes that may affect your business.' ],
				];
				foreach ( $reasons as $index => $reason ) :
					?>
					<li data-reveal style="--d:<?php echo esc_attr( ( $index % 3 ) * 0.1 ); ?>s" class="flex gap-4">
						<span aria-hidden="true" class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-deep font-display text-lg font-bold text-white"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
						<div>
							<h4 class="font-bold"><?php echo esc_html( $reason[0] ); ?></h4>
							<p class="text-[15px]"><?php echo esc_html( $reason[1] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
			<aside data-reveal class="mt-12 overflow-hidden rounded-2xl bg-lime sm:flex" aria-labelledby="new-title">
				<div class="relative hidden w-48 shrink-0 sm:block lg:w-56">
					<img src="https://images.pexels.com/photos/3184291/pexels-photo-3184291.jpeg?auto=compress&cs=tinysrgb&w=600" alt="<?php esc_attr_e( 'Professionals networking at a business event', 'selph-theme' ); ?>" class="h-full w-full object-cover" loading="lazy" width="400" height="300">
				</div>
				<div class="p-6 sm:p-8">
					<h3 id="new-title" class="text-xl font-bold"><?php esc_html_e( 'New to the area?', 'selph-theme' ); ?></h3>
					<p class="mt-2 max-w-[70ch]"><?php esc_html_e( 'Join us at the next new member luncheon. Guests are welcome, and lunch is on us for first-time visitors.', 'selph-theme' ); ?></p>
					<a class="link mt-3 inline-block" href="#events"><?php esc_html_e( 'See the luncheon date', 'selph-theme' ); ?></a>
				</div>
			</aside>
		</div>
	</section>

	<section id="events" class="scroll-mt-nav bg-teal py-16 lg:py-20" aria-labelledby="events-title">
		<div class="wrap grid gap-10 lg:grid-cols-[1fr_1.4fr]">
			<div data-reveal>
				<h2 id="events-title" class="text-3xl font-extrabold sm:text-4xl"><?php esc_html_e( 'Events all year long', 'selph-theme' ); ?></h2>
				<p class="mt-4 max-w-[48ch] text-lg"><?php esc_html_e( 'From morning mixers to the holiday parade, there is always a reason to get together. Register online in a few taps.', 'selph-theme' ); ?></p>
				<a class="btn btn-primary mt-6" href="#this-month"><?php esc_html_e( 'View the full calendar', 'selph-theme' ); ?></a>
				<div class="mt-8 overflow-hidden rounded-2xl shadow-md ring-1 ring-ink/10">
					<img src="https://images.pexels.com/photos/1181406/pexels-photo-1181406.jpeg?auto=compress&cs=tinysrgb&w=800" alt="<?php esc_attr_e( 'Business professionals networking at a conference reception', 'selph-theme' ); ?>" class="aspect-[16/10] w-full object-cover" loading="lazy" width="800" height="500">
				</div>
			</div>
			<div data-reveal style="--d:.12s" class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-ink/10">
				<h3 class="text-xl font-extrabold text-deep"><?php esc_html_e( 'Looking ahead', 'selph-theme' ); ?></h3>
				<ul class="mt-4 divide-y divide-ink/10">
					<li class="-mx-2 flex items-baseline justify-between gap-4 rounded-lg px-2 py-3 transition-colors duration-200 hover:bg-lime/70">
						<span><span class="font-semibold"><?php esc_html_e( 'Business after hours', 'selph-theme' ); ?></span><br><span class="text-sm"><?php esc_html_e( 'Wednesday, December 10, 5:30 p.m.', 'selph-theme' ); ?></span></span>
						<a class="link text-sm" href="#this-month"><?php esc_html_e( 'Details', 'selph-theme' ); ?><span class="sr-only"> <?php esc_html_e( 'for business after hours', 'selph-theme' ); ?></span></a>
					</li>
					<li class="-mx-2 flex items-baseline justify-between gap-4 rounded-lg px-2 py-3 transition-colors duration-200 hover:bg-lime/70">
						<span><span class="font-semibold"><?php esc_html_e( 'Ribbon cutting at Cedar and Sage Cafe', 'selph-theme' ); ?></span><br><span class="text-sm"><?php esc_html_e( 'Friday, December 12, 10:00 a.m.', 'selph-theme' ); ?></span></span>
						<a class="link text-sm" href="#this-month"><?php esc_html_e( 'Details', 'selph-theme' ); ?><span class="sr-only"> <?php esc_html_e( 'for the ribbon cutting', 'selph-theme' ); ?></span></a>
					</li>
					<li class="-mx-2 flex items-baseline justify-between gap-4 rounded-lg px-2 py-3 transition-colors duration-200 hover:bg-lime/70">
						<span><span class="font-semibold"><?php esc_html_e( 'State of the community breakfast', 'selph-theme' ); ?></span><br><span class="text-sm"><?php esc_html_e( 'Thursday, January 8, 7:30 a.m.', 'selph-theme' ); ?></span></span>
						<a class="link text-sm" href="#this-month"><?php esc_html_e( 'Register', 'selph-theme' ); ?><span class="sr-only"> <?php esc_html_e( 'for the breakfast', 'selph-theme' ); ?></span></a>
					</li>
					<li class="-mx-2 flex items-baseline justify-between gap-4 rounded-lg px-2 py-3 transition-colors duration-200 hover:bg-lime/70">
						<span><span class="font-semibold"><?php esc_html_e( 'Annual awards gala', 'selph-theme' ); ?></span><br><span class="text-sm"><?php esc_html_e( 'Saturday, February 14, 6:30 p.m.', 'selph-theme' ); ?></span></span>
						<a class="link text-sm" href="#this-month"><?php esc_html_e( 'Get tickets', 'selph-theme' ); ?><span class="sr-only"> <?php esc_html_e( 'for the awards gala', 'selph-theme' ); ?></span></a>
					</li>
				</ul>

				<?php if ( selph_has_helpers() ) : ?>
					<div class="mt-8 border-t border-ink/10 pt-6">
						<h4 class="font-bold text-deep"><?php esc_html_e( 'Live calendar from our membership system', 'selph-theme' ); ?></h4>
						<div class="mt-3">
							<?php
							// Paste the real GrowthZone / ChamberMaster widget between the shortcode tags
							// on a real project, or leave empty until the widget code is available.
							echo do_shortcode( '[selph_ams_widget][/selph_ams_widget]' );
							?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="bg-lime py-16 lg:py-20" aria-labelledby="quote-title">
		<div class="wrap max-w-4xl">
			<h2 id="quote-title" data-reveal class="text-3xl font-extrabold sm:text-4xl"><?php esc_html_e( 'What members say', 'selph-theme' ); ?></h2>
			<div id="quotes" role="group" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Member testimonials', 'selph-theme' ); ?>" aria-live="polite" class="mt-8 min-h-[13rem]">
				<figure data-slide class="hero-in">
					<blockquote class="font-display text-2xl font-bold leading-snug sm:text-3xl"><?php esc_html_e( '“We found our first three wholesale customers at one morning mixer. The staff remembers your name and your business.”', 'selph-theme' ); ?></blockquote>
					<figcaption class="mt-5 text-lg"><strong><?php esc_html_e( 'Maria Delgado', 'selph-theme' ); ?></strong>, <?php esc_html_e( 'Delgado Family Bakery', 'selph-theme' ); ?></figcaption>
				</figure>
				<figure data-slide class="hero-in">
					<blockquote class="font-display text-2xl font-bold leading-snug sm:text-3xl"><?php esc_html_e( '“The ribbon cutting brought in more people in one afternoon than a month of ads. I would join again tomorrow.”', 'selph-theme' ); ?></blockquote>
					<figcaption class="mt-5 text-lg"><strong><?php esc_html_e( 'Daniel Ortiz', 'selph-theme' ); ?></strong>, <?php esc_html_e( 'Prairie Savings Bank', 'selph-theme' ); ?></figcaption>
				</figure>
				<figure data-slide class="hero-in">
					<blockquote class="font-display text-2xl font-bold leading-snug sm:text-3xl"><?php esc_html_e( '“Leadership Selph changed how I think about my town and my team. Every owner should take the class.”', 'selph-theme' ); ?></blockquote>
					<figcaption class="mt-5 text-lg"><strong><?php esc_html_e( 'Priya Nair', 'selph-theme' ); ?></strong>, <?php esc_html_e( 'Sunrise Medical Clinic', 'selph-theme' ); ?></figcaption>
				</figure>
			</div>
			<div class="mt-6 flex items-center gap-2">
				<button id="q-prev" type="button" class="grid h-11 w-11 place-items-center rounded-full border-2 border-ink transition-colors hover:bg-ink hover:text-white" aria-label="<?php esc_attr_e( 'Previous testimonial', 'selph-theme' ); ?>">
					<svg aria-hidden="true" viewBox="0 0 20 20" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4l-6 6 6 6"/></svg>
				</button>
				<div class="flex">
					<button type="button" data-dot class="group grid h-11 w-11 place-items-center" aria-label="<?php esc_attr_e( 'Show testimonial 1', 'selph-theme' ); ?>"><span class="h-3.5 w-3.5 rounded-full border-2 border-ink transition-colors group-aria-[current=true]:bg-ink"></span></button>
					<button type="button" data-dot class="group grid h-11 w-11 place-items-center" aria-label="<?php esc_attr_e( 'Show testimonial 2', 'selph-theme' ); ?>"><span class="h-3.5 w-3.5 rounded-full border-2 border-ink transition-colors group-aria-[current=true]:bg-ink"></span></button>
					<button type="button" data-dot class="group grid h-11 w-11 place-items-center" aria-label="<?php esc_attr_e( 'Show testimonial 3', 'selph-theme' ); ?>"><span class="h-3.5 w-3.5 rounded-full border-2 border-ink transition-colors group-aria-[current=true]:bg-ink"></span></button>
				</div>
				<button id="q-next" type="button" class="grid h-11 w-11 place-items-center rounded-full border-2 border-ink transition-colors hover:bg-ink hover:text-white" aria-label="<?php esc_attr_e( 'Next testimonial', 'selph-theme' ); ?>">
					<svg aria-hidden="true" viewBox="0 0 20 20" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M8 4l6 6-6 6"/></svg>
				</button>
			</div>
		</div>
	</section>

	<section id="directory" class="scroll-mt-nav py-16 lg:py-20" aria-labelledby="dir-title">
		<div class="wrap">
			<h2 data-reveal id="dir-title" class="text-3xl font-extrabold text-deep sm:text-4xl"><?php esc_html_e( 'Find a local member business', 'selph-theme' ); ?></h2>
			<form data-reveal style="--d:.08s" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="mt-6 flex max-w-2xl flex-col gap-3 sm:flex-row sm:items-end">
				<div class="flex-1">
					<label for="dir-q" class="block font-semibold"><?php esc_html_e( 'Business name or category', 'selph-theme' ); ?></label>
					<input id="dir-q" name="s" type="search" placeholder="<?php esc_attr_e( 'For example, plumber or bakery', 'selph-theme' ); ?>" class="mt-1 min-h-[48px] w-full rounded-lg border-2 border-ink/60 bg-white px-4 text-base transition-colors placeholder:text-ink/60 focus:border-deep">
				</div>
				<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Search the directory', 'selph-theme' ); ?></button>
			</form>
			<ul data-reveal style="--d:.16s" id="categories" class="scroll-mt-nav mt-8 flex flex-wrap gap-3" aria-label="<?php esc_attr_e( 'Popular categories', 'selph-theme' ); ?>">
				<li><a class="inline-flex min-h-[44px] items-center rounded-full border-2 border-ink/30 px-4 font-semibold transition duration-200 hover:-translate-y-0.5 hover:border-ink hover:bg-mint" href="#directory"><?php esc_html_e( 'Restaurants', 'selph-theme' ); ?></a></li>
				<li><a class="inline-flex min-h-[44px] items-center rounded-full border-2 border-ink/30 px-4 font-semibold transition duration-200 hover:-translate-y-0.5 hover:border-ink hover:bg-mint" href="#directory"><?php esc_html_e( 'Home services', 'selph-theme' ); ?></a></li>
				<li><a class="inline-flex min-h-[44px] items-center rounded-full border-2 border-ink/30 px-4 font-semibold transition duration-200 hover:-translate-y-0.5 hover:border-ink hover:bg-mint" href="#directory"><?php esc_html_e( 'Health and wellness', 'selph-theme' ); ?></a></li>
				<li><a class="inline-flex min-h-[44px] items-center rounded-full border-2 border-ink/30 px-4 font-semibold transition duration-200 hover:-translate-y-0.5 hover:border-ink hover:bg-mint" href="#directory"><?php esc_html_e( 'Professional services', 'selph-theme' ); ?></a></li>
			</ul>
		</div>
	</section>

	<section id="news" class="scroll-mt-nav bg-mint/50 py-16 lg:py-20" aria-labelledby="news-title">
		<div class="wrap">
			<h2 id="news-title" data-reveal class="text-3xl font-extrabold sm:text-4xl"><?php esc_html_e( 'News and spotlights', 'selph-theme' ); ?></h2>

			<?php if ( selph_has_helpers() ) : ?>
				<div data-reveal style="--d:.1s" class="mt-8">
					<?php echo do_shortcode( '[selph_spotlights limit="4"]' ); ?>
				</div>
			<?php else : ?>
				<ul data-reveal style="--d:.1s" class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
					<li class="rounded-2xl bg-white p-6 ring-1 ring-ink/10 transition duration-200 hover:-translate-y-1 hover:shadow-md">
						<p class="inline-block rounded-full bg-lime px-3 py-1 text-sm font-semibold"><?php esc_html_e( 'Member of the month', 'selph-theme' ); ?></p>
						<div class="mt-4 flex items-center gap-4">
							<span aria-hidden="true" class="grid h-14 w-14 shrink-0 place-items-center rounded-full bg-deep font-display text-xl font-bold text-white">HH</span>
							<h3 class="font-display text-xl font-bold leading-tight"><?php esc_html_e( 'Harper Hardware', 'selph-theme' ); ?></h3>
						</div>
						<p class="mt-3 text-[15px]"><?php esc_html_e( 'Four generations of neighbors have bought their first hammer here.', 'selph-theme' ); ?></p>
						<a class="link mt-3 inline-block" href="#directory"><?php esc_html_e( 'Read the story', 'selph-theme' ); ?></a>
					</li>
					<li class="rounded-2xl bg-white p-6 ring-1 ring-ink/10 transition duration-200 hover:-translate-y-1 hover:shadow-md">
						<p class="inline-block rounded-full bg-lime px-3 py-1 text-sm font-semibold"><?php esc_html_e( 'Ambassador of the month', 'selph-theme' ); ?></p>
						<div class="mt-4 flex items-center gap-4">
							<span aria-hidden="true" class="grid h-14 w-14 shrink-0 place-items-center rounded-full bg-deep font-display text-xl font-bold text-white">DO</span>
							<h3 class="font-display text-xl font-bold leading-tight"><?php esc_html_e( 'Daniel Ortiz', 'selph-theme' ); ?></h3>
						</div>
						<p class="mt-3 text-[15px]"><?php esc_html_e( 'Prairie Savings Bank. He has welcomed more than 20 new members this year.', 'selph-theme' ); ?></p>
						<a class="link mt-3 inline-block" href="#contact"><?php esc_html_e( 'Meet our ambassadors', 'selph-theme' ); ?></a>
					</li>
					<li class="rounded-2xl bg-white p-6 ring-1 ring-ink/10 transition duration-200 hover:-translate-y-1 hover:shadow-md">
						<h3 class="font-display text-xl font-bold"><?php esc_html_e( 'Latest news', 'selph-theme' ); ?></h3>
						<ul class="mt-2 divide-y divide-ink/10">
							<li class="py-2"><span class="block text-sm"><?php esc_html_e( 'Nov 10', 'selph-theme' ); ?></span><a class="link" href="#events"><?php esc_html_e( 'Ribbon cutting at Cedar and Sage Cafe', 'selph-theme' ); ?></a></li>
							<li class="py-2"><span class="block text-sm"><?php esc_html_e( 'Nov 4', 'selph-theme' ); ?></span><a class="link" href="#events"><?php esc_html_e( 'Holiday parade entries are now open', 'selph-theme' ); ?></a></li>
							<li class="py-2"><span class="block text-sm"><?php esc_html_e( 'Oct 29', 'selph-theme' ); ?></span><a class="link" href="#join"><?php esc_html_e( 'Chamber welcomes five new members', 'selph-theme' ); ?></a></li>
						</ul>
					</li>
					<li class="rounded-2xl bg-white p-6 ring-1 ring-ink/10 transition duration-200 hover:-translate-y-1 hover:shadow-md">
						<h3 class="font-display text-xl font-bold"><?php esc_html_e( 'Welcome new members', 'selph-theme' ); ?></h3>
						<ul class="mt-2 divide-y divide-ink/10 text-[15px]">
							<li class="py-2"><?php esc_html_e( 'Redbud Insurance Group', 'selph-theme' ); ?></li>
							<li class="py-2"><?php esc_html_e( 'Larkspur Fine Jewelry', 'selph-theme' ); ?></li>
							<li class="py-2"><?php esc_html_e( 'Hill Country Electric', 'selph-theme' ); ?></li>
							<li class="py-2"><?php esc_html_e( 'Kids First Tutoring', 'selph-theme' ); ?></li>
							<li class="py-2"><?php esc_html_e( 'Sunrise Medical Clinic', 'selph-theme' ); ?></li>
						</ul>
					</li>
				</ul>
			<?php endif; ?>
		</div>
	</section>

	<section id="guide" class="scroll-mt-nav py-16 lg:py-20">
		<div class="wrap">
			<div class="grid items-center gap-10 lg:grid-cols-[auto_1fr]">
				<div data-reveal class="mx-auto">
					<div aria-hidden="true" class="flex h-72 w-52 flex-col justify-between rounded-l-md rounded-r-2xl bg-deep p-5 text-white shadow-xl ring-1 ring-ink/20 transition-transform duration-300 hover:-rotate-2 hover:scale-105">
						<span class="font-display text-sm font-semibold"><?php esc_html_e( 'Selph Chamber', 'selph-theme' ); ?></span>
						<span class="font-display text-3xl font-extrabold leading-tight"><?php esc_html_e( '2027 Community Guide', 'selph-theme' ); ?></span>
						<span class="h-2 w-16 rounded bg-sky"></span>
					</div>
				</div>
				<div data-reveal style="--d:.1s">
					<h2 id="guide-title" class="text-3xl font-extrabold text-deep sm:text-4xl"><?php esc_html_e( 'The 2027 business and community guide', 'selph-theme' ); ?></h2>
					<p class="mt-4 max-w-[58ch] text-lg"><?php esc_html_e( 'Thinking about opening or moving a business here? The guide covers our local economy, member resources, and a profile of every town we serve.', 'selph-theme' ); ?></p>
					<a class="btn btn-primary mt-6" href="#economic-development"><?php esc_html_e( 'Explore the guide', 'selph-theme' ); ?></a>
				</div>
			</div>
			<h2 id="communities" data-reveal class="scroll-mt-nav mt-16 text-3xl font-extrabold text-deep sm:text-4xl"><?php esc_html_e( 'Communities we serve', 'selph-theme' ); ?></h2>
			<ul data-reveal style="--d:.1s" class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
				<?php foreach ( [ 'Selph Springs', 'Cedar Hollow', 'Larkspur', 'Oak Ridge', 'Prairie Creek', 'Sage Meadow' ] as $community ) : ?>
					<li>
						<a href="#economic-development" class="group flex h-full flex-col items-center gap-3 rounded-2xl border-2 border-ink/15 p-5 text-center font-semibold transition duration-200 hover:-translate-y-1 hover:border-deep hover:bg-mint/40">
							<span aria-hidden="true" class="grid h-14 w-14 place-items-center rounded-full bg-teal font-display text-xl font-bold transition-transform duration-300 group-hover:scale-110"><?php echo esc_html( strtoupper( substr( $community, 0, 1 ) ) ); ?></span>
							<?php echo esc_html( $community ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<section id="economic-development" class="scroll-mt-nav overflow-hidden bg-ink py-16 text-white lg:py-20" aria-labelledby="econ-title">
		<div class="wrap grid items-center gap-10 lg:grid-cols-[1.05fr_.95fr]">
			<div data-reveal>
				<p class="text-sm font-bold uppercase tracking-[.18em] text-teal"><?php esc_html_e( 'Business & community growth', 'selph-theme' ); ?></p>
				<h2 id="econ-title" class="mt-3 max-w-[18ch] text-3xl font-extrabold sm:text-4xl"><?php esc_html_e( 'A stronger region starts with informed decisions.', 'selph-theme' ); ?></h2>
				<p class="mt-5 max-w-[58ch] text-lg text-white/85"><?php esc_html_e( 'Explore local business resources, community profiles, workforce connections, and regional information for businesses considering a move or expansion.', 'selph-theme' ); ?></p>
				<div class="mt-7 flex flex-wrap gap-3">
					<a class="btn bg-sky text-ink hover:bg-white" href="#guide"><?php esc_html_e( 'Explore the community guide', 'selph-theme' ); ?></a>
					<a class="btn border-2 border-white/70 text-white hover:bg-white hover:text-ink" href="#contact"><?php esc_html_e( 'Talk with the chamber', 'selph-theme' ); ?></a>
				</div>
			</div>
			<div data-reveal style="--d:.12s" class="relative rounded-3xl bg-white/10 p-6 ring-1 ring-white/20 sm:p-8">
				<div class="absolute -right-10 -top-10 h-36 w-36 rounded-full bg-sky/20 blur-2xl" aria-hidden="true"></div>
				<h3 class="relative font-display text-2xl font-bold"><?php esc_html_e( 'Considering Selph?', 'selph-theme' ); ?></h3>
				<p class="relative mt-2 max-w-[44ch] text-white/80"><?php esc_html_e( 'A starting point for site selectors, employers, entrepreneurs, and families exploring the area.', 'selph-theme' ); ?></p>
				<ul class="relative mt-6 grid gap-3 sm:grid-cols-2">
					<li class="rounded-xl bg-white p-4 text-ink"><span class="block text-sm font-semibold text-deep">01</span><strong><?php esc_html_e( 'Community profiles', 'selph-theme' ); ?></strong><span class="mt-1 block text-sm"><?php esc_html_e( 'Get to know the towns we serve.', 'selph-theme' ); ?></span></li>
					<li class="rounded-xl bg-white p-4 text-ink"><span class="block text-sm font-semibold text-deep">02</span><strong><?php esc_html_e( 'Business connections', 'selph-theme' ); ?></strong><span class="mt-1 block text-sm"><?php esc_html_e( 'Meet local owners and service providers.', 'selph-theme' ); ?></span></li>
					<li class="rounded-xl bg-white p-4 text-ink"><span class="block text-sm font-semibold text-deep">03</span><strong><?php esc_html_e( 'Regional resources', 'selph-theme' ); ?></strong><span class="mt-1 block text-sm"><?php esc_html_e( 'Find useful local and economic information.', 'selph-theme' ); ?></span></li>
					<li class="rounded-xl bg-white p-4 text-ink"><span class="block text-sm font-semibold text-deep">04</span><strong><?php esc_html_e( 'Chamber support', 'selph-theme' ); ?></strong><span class="mt-1 block text-sm"><?php esc_html_e( 'Connect with a team member for next steps.', 'selph-theme' ); ?></span></li>
				</ul>
			</div>
		</div>
	</section>

	<section id="leadership" class="scroll-mt-nav bg-teal py-16 lg:py-20" aria-labelledby="lead-title">
		<div class="wrap grid items-center gap-8 lg:grid-cols-[1.4fr_1fr]">
			<div data-reveal>
				<h2 id="lead-title" class="text-3xl font-extrabold sm:text-4xl"><?php esc_html_e( 'Leadership Selph', 'selph-theme' ); ?></h2>
				<p class="mt-4 max-w-[56ch] text-lg"><?php esc_html_e( 'A nine-month program that prepares established leaders for their next step in serving the community. Classes meet one morning a month.', 'selph-theme' ); ?></p>
				<a class="btn btn-primary mt-6" href="#contact"><?php esc_html_e( 'Apply now', 'selph-theme' ); ?></a>
			</div>
			<div id="president" data-reveal style="--d:.12s" class="scroll-mt-nav rounded-2xl bg-white p-6 ring-1 ring-ink/10">
				<div class="flex items-center gap-4">
					<img src="https://images.pexels.com/photos/3760263/pexels-photo-3760263.jpeg?auto=compress&cs=tinysrgb&w=200" alt="<?php esc_attr_e( 'Portrait of Rosa Martinez, President and CEO', 'selph-theme' ); ?>" class="h-14 w-14 shrink-0 rounded-full object-cover" loading="lazy" width="56" height="56">
					<div>
						<h3 class="font-display text-xl font-bold"><?php esc_html_e( 'Rosa Martinez', 'selph-theme' ); ?></h3>
						<p class="text-sm"><?php esc_html_e( 'President and CEO', 'selph-theme' ); ?></p>
					</div>
				</div>
				<p class="mt-4 text-[15px]"><?php esc_html_e( 'Rosa has led the chamber for 20 years. Stop by, call, or set up a visit to talk about your business.', 'selph-theme' ); ?></p>
				<a class="btn btn-quiet mt-4" href="mailto:rosa@selphchamber.org?subject=Schedule%20a%20visit"><?php esc_html_e( 'Schedule a visit', 'selph-theme' ); ?></a>
			</div>
		</div>
	</section>

	<section id="sponsors" class="scroll-mt-nav border-y border-ink/10 py-16 lg:py-20" aria-labelledby="sp-title">
		<div class="wrap">
			<h2 id="sp-title" data-reveal class="text-3xl font-extrabold text-deep sm:text-4xl"><?php esc_html_e( 'Our partners', 'selph-theme' ); ?></h2>
			<p data-reveal style="--d:.08s" class="mt-3 max-w-[60ch] text-lg"><?php esc_html_e( 'Thank you to the businesses that make our events and programs possible.', 'selph-theme' ); ?></p>

			<?php if ( selph_has_helpers() ) : ?>

				<h3 class="mt-10 font-display text-xl font-bold"><?php esc_html_e( 'Chairman’s Circle', 'selph-theme' ); ?></h3>
				<div data-reveal class="mt-4">
					<?php echo do_shortcode( '[selph_sponsors tier="chairmans-circle" limit="8"]' ); ?>
				</div>

				<h3 class="mt-10 font-display text-xl font-bold"><?php esc_html_e( 'Event partners: Gold', 'selph-theme' ); ?></h3>
				<div data-reveal class="mt-4">
					<?php echo do_shortcode( '[selph_sponsors tier="gold" limit="8"]' ); ?>
				</div>

				<h3 class="mt-10 font-display text-xl font-bold"><?php esc_html_e( 'Silver', 'selph-theme' ); ?></h3>
				<div data-reveal class="mt-4">
					<?php echo do_shortcode( '[selph_sponsors tier="silver" limit="12"]' ); ?>
				</div>

				<h3 class="mt-10 font-display text-xl font-bold"><?php esc_html_e( 'Bronze', 'selph-theme' ); ?></h3>
				<div data-reveal class="mt-4">
					<?php echo do_shortcode( '[selph_sponsors tier="bronze" limit="16"]' ); ?>
				</div>

			<?php else : ?>

				<!-- Fallback static content when the helper plugin is not active -->
				<h3 class="mt-10 font-display text-xl font-bold"><?php esc_html_e( 'Chairman’s Circle', 'selph-theme' ); ?></h3>
				<ul data-reveal class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4">
					<?php foreach ( [ 'Harper Hardware' => 'Presenting partner', 'Prairie Savings Bank' => 'Chairman’s Circle', 'Lone Oak Dental' => 'Chairman’s Circle', 'Cedar and Sage Cafe' => 'Chairman’s Circle' ] as $partner => $tier ) : ?>
						<li>
							<a href="#join" class="grid h-24 place-items-center rounded-xl bg-mint/60 px-3 text-center transition duration-200 hover:-translate-y-1 hover:bg-mint hover:shadow-md">
								<span>
									<span class="block font-display text-lg font-bold"><?php echo esc_html( $partner ); ?></span>
									<span class="block text-sm"><?php echo esc_html( $tier ); ?></span>
								</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>

				<h3 class="mt-10 font-display text-xl font-bold"><?php esc_html_e( 'Event partners: Gold', 'selph-theme' ); ?></h3>
				<ul data-reveal class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4">
					<?php foreach ( [ 'Redbud Insurance Group', 'Hill Country Electric', 'First Prairie Credit Union', 'Sunrise Medical Clinic' ] as $partner ) : ?>
						<li><a href="#join" class="grid h-16 place-items-center rounded-xl border-2 border-ink/15 px-3 text-center font-semibold transition duration-200 hover:-translate-y-1 hover:border-deep hover:shadow-md"><?php echo esc_html( $partner ); ?></a></li>
					<?php endforeach; ?>
				</ul>

				<h3 class="mt-10 font-display text-xl font-bold"><?php esc_html_e( 'Silver', 'selph-theme' ); ?></h3>
				<ul data-reveal class="mt-4 flex flex-wrap gap-x-8 gap-y-2">
					<?php foreach ( [ 'Larkspur Fine Jewelry', 'Kids First Tutoring', 'Oak Ridge Realty', 'Stillwater Print Shop' ] as $partner ) : ?>
						<li><a class="link" href="#join"><?php echo esc_html( $partner ); ?></a></li>
					<?php endforeach; ?>
				</ul>

				<h3 class="mt-10 font-display text-xl font-bold"><?php esc_html_e( 'Bronze', 'selph-theme' ); ?></h3>
				<ul data-reveal class="mt-4 flex flex-wrap gap-x-8 gap-y-2 text-[15px]">
					<?php foreach ( [ 'Sage Meadow Landscaping', 'Cedar Hollow Auto', 'Selph Springs Pharmacy', 'Prairie Creek Title', 'Willow Lane Florist' ] as $partner ) : ?>
						<li><a class="link" href="#join"><?php echo esc_html( $partner ); ?></a></li>
					<?php endforeach; ?>
				</ul>

			<?php endif; ?>
		</div>
	</section>

	<section id="join" class="scroll-mt-nav relative overflow-hidden bg-deep pb-20 pt-16 text-white lg:pt-20" aria-labelledby="join-title">
		<div class="absolute inset-0 opacity-20">
			<img src="https://images.pexels.com/photos/3184338/pexels-photo-3184338.jpeg?auto=compress&cs=tinysrgb&w=1600" alt="" class="h-full w-full object-cover" loading="lazy" aria-hidden="true">
		</div>
		<div class="relative wrap grid items-center gap-8 lg:grid-cols-[1.3fr_1fr]">
			<div data-reveal>
				<h2 id="join-title" class="text-3xl font-extrabold sm:text-4xl"><?php esc_html_e( 'Ready to join your neighbors?', 'selph-theme' ); ?></h2>
				<p class="mt-4 max-w-[52ch] text-lg text-white/90"><?php esc_html_e( 'Applying takes about a minute. A member of our team will call you within two business days to welcome you.', 'selph-theme' ); ?></p>
			</div>
			<div data-reveal style="--d:.14s" class="flex flex-wrap gap-4 lg:justify-end">
				<a class="btn bg-white text-ink hover:bg-lime" href="mailto:info@selphchamber.org?subject=Membership%20application"><?php esc_html_e( 'Start your membership application', 'selph-theme' ); ?></a>
				<a class="btn border-2 border-white text-white hover:bg-white hover:text-ink" href="#contact"><?php esc_html_e( 'Talk with our team', 'selph-theme' ); ?></a>
			</div>
			<div class="lg:col-span-2" data-reveal style="--d:.22s">
				<div class="grid gap-3 rounded-2xl bg-white/10 p-5 ring-1 ring-white/20 sm:grid-cols-2 lg:grid-cols-4">
					<div>
						<p class="text-sm font-bold uppercase tracking-wide text-teal"><?php esc_html_e( 'Connect', 'selph-theme' ); ?></p>
						<p class="mt-1 font-semibold"><?php esc_html_e( 'Build your network', 'selph-theme' ); ?></p>
						<p class="mt-1 text-sm text-white/75"><?php esc_html_e( 'Member directory, introductions, and networking opportunities.', 'selph-theme' ); ?></p>
					</div>
					<div>
						<p class="text-sm font-bold uppercase tracking-wide text-teal"><?php esc_html_e( 'Promote', 'selph-theme' ); ?></p>
						<p class="mt-1 font-semibold"><?php esc_html_e( 'Increase visibility', 'selph-theme' ); ?></p>
						<p class="mt-1 text-sm text-white/75"><?php esc_html_e( 'Member spotlights, business listings, and event exposure.', 'selph-theme' ); ?></p>
					</div>
					<div>
						<p class="text-sm font-bold uppercase tracking-wide text-teal"><?php esc_html_e( 'Lead', 'selph-theme' ); ?></p>
						<p class="mt-1 font-semibold"><?php esc_html_e( 'Develop your skills', 'selph-theme' ); ?></p>
						<p class="mt-1 text-sm text-white/75"><?php esc_html_e( 'Leadership programs, training, and peer learning.', 'selph-theme' ); ?></p>
					</div>
					<div>
						<p class="text-sm font-bold uppercase tracking-wide text-teal"><?php esc_html_e( 'Advocate', 'selph-theme' ); ?></p>
						<p class="mt-1 font-semibold"><?php esc_html_e( 'Have a stronger voice', 'selph-theme' ); ?></p>
						<p class="mt-1 text-sm text-white/75"><?php esc_html_e( 'Connect with community leaders and local business initiatives.', 'selph-theme' ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();