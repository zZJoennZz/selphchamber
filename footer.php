<?php
/**
 * The footer for our theme.
 *
 * @package Selph_Theme
 */
?>

<footer id="contact" class="scroll-mt-nav bg-ink text-white">
	<div class="wrap grid gap-10 py-12 md:grid-cols-2 lg:grid-cols-4">
		<div>
			<h2 class="font-display text-xl font-extrabold"><?php esc_html_e( 'Selph Chamber of Commerce', 'selph-theme' ); ?></h2>
			<address class="mt-3 not-italic">
				<?php esc_html_e( '100 Main Street', 'selph-theme' ); ?><br>
				<?php esc_html_e( 'Anytown, Texas 75000', 'selph-theme' ); ?><br>
				<a class="inline-block py-1 underline underline-offset-4" href="tel:+15555550100">(555) 555-0100</a><br>
				<a class="inline-block py-1 underline underline-offset-4" href="mailto:info@selphchamber.org">info@selphchamber.org</a>
			</address>
			<p class="mt-3 text-sm">
				<?php esc_html_e( 'Monday to Friday', 'selph-theme' ); ?><br>
				<?php esc_html_e( '8:30 a.m. to 5:00 p.m.', 'selph-theme' ); ?>
			</p>
		</div>
		<nav aria-label="<?php esc_attr_e( 'Get involved', 'selph-theme' ); ?>">
			<h2 class="font-display text-lg font-bold"><?php esc_html_e( 'Get involved', 'selph-theme' ); ?></h2>
			<ul class="mt-3">
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#join"><?php esc_html_e( 'Become an ambassador', 'selph-theme' ); ?></a></li>
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#join"><?php esc_html_e( 'Program guidelines', 'selph-theme' ); ?></a></li>
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#events"><?php esc_html_e( 'Festival volunteer sign up', 'selph-theme' ); ?></a></li>
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#leadership"><?php esc_html_e( 'Leadership Selph', 'selph-theme' ); ?></a></li>
			</ul>
		</nav>
		<nav aria-label="<?php esc_attr_e( 'Quick links', 'selph-theme' ); ?>">
			<h2 class="font-display text-lg font-bold"><?php esc_html_e( 'Quick links', 'selph-theme' ); ?></h2>
			<ul class="mt-3">
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#join"><?php esc_html_e( 'Member login', 'selph-theme' ); ?></a></li>
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#events"><?php esc_html_e( 'Event calendar', 'selph-theme' ); ?></a></li>
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#directory"><?php esc_html_e( 'Member directory', 'selph-theme' ); ?></a></li>
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#news"><?php esc_html_e( 'Hot deals', 'selph-theme' ); ?></a></li>
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#join"><?php esc_html_e( 'Job board', 'selph-theme' ); ?></a></li>
			</ul>
		</nav>
		<div>
			<h2 class="font-display text-lg font-bold"><?php esc_html_e( 'Stay connected', 'selph-theme' ); ?></h2>
			<ul class="mt-3 flex gap-3">
				<li><a aria-label="Facebook" href="#contact" class="grid h-11 w-11 place-items-center rounded-full border-2 border-white/60 transition-colors hover:bg-white hover:text-ink"><svg aria-hidden="true" viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor"><path d="M14 8h2V5h-2a3 3 0 0 0-3 3v2H9v3h2v6h3v-6h2l1-3h-3V8z"/></svg></a></li>
				<li><a aria-label="LinkedIn" href="#contact" class="grid h-11 w-11 place-items-center rounded-full border-2 border-white/60 transition-colors hover:bg-white hover:text-ink"><svg aria-hidden="true" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 10v8M6 6.5v.01M10 18v-5a3 3 0 0 1 6 0v5M10 10v8"/></svg></a></li>
				<li><a aria-label="Instagram" href="#contact" class="grid h-11 w-11 place-items-center rounded-full border-2 border-white/60 transition-colors hover:bg-white hover:text-ink"><svg aria-hidden="true" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="5"/><circle cx="12" cy="12" r="3.5"/><circle cx="17" cy="7" r=".6"/></svg></a></li>
			</ul>
		</div>
	</div>
	<div class="border-t border-white/20">
		<div class="wrap flex flex-wrap items-center justify-between gap-x-6 gap-y-1 py-4 text-sm">
			<p><?php printf( esc_html__( 'Copyright %s Selph Chamber of Commerce. All rights reserved.', 'selph-theme' ), esc_html( gmdate( 'Y' ) ) ); ?></p>
			<ul class="flex flex-wrap gap-x-5">
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#contact"><?php esc_html_e( 'Accessibility statement', 'selph-theme' ); ?></a></li>
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#contact"><?php esc_html_e( 'Report a website problem', 'selph-theme' ); ?></a></li>
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#contact"><?php esc_html_e( 'Privacy policy', 'selph-theme' ); ?></a></li>
				<li><a class="inline-block py-1 underline underline-offset-4 transition-colors hover:text-lime" href="#contact"><?php esc_html_e( 'Terms and conditions', 'selph-theme' ); ?></a></li>
			</ul>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>