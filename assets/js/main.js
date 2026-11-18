(function () {
	const header = document.getElementById('site-header');
	const updateHeader = function () {
		if (header) header.classList.toggle('is-scrolled', window.scrollY > 24);
	};
	updateHeader();
	window.addEventListener('scroll', updateHeader, { passive: true });

	const btn = document.getElementById('menu-btn');
	const nav = document.getElementById('site-nav');
	const desktop = window.matchMedia('(min-width: 1024px)');
	const items = Array.prototype.slice.call(document.querySelectorAll('[data-sub]'));
	const timers = new WeakMap();
	function setSub(item, open) {
		item.setAttribute('data-open', String(open));
		const toggle = item.querySelector('button');
		if (toggle) toggle.setAttribute('aria-expanded', String(open));
		if (!open) delete item.dataset.kb;
	}
	function closeAll(except) {
		items.forEach(function (item) { if (item !== except) setSub(item, false); });
	}
	function setMenu(open) {
		nav.setAttribute('data-open', String(open));
		btn.setAttribute('aria-expanded', String(open));
		if (!open) closeAll();
	}
	if (btn && nav) {
		btn.addEventListener('click', function () { setMenu(nav.getAttribute('data-open') !== 'true'); });
		items.forEach(function (item) {
			const toggle = item.querySelector('button');
			toggle.addEventListener('click', function (event) {
				let open = toggle.getAttribute('aria-expanded') !== 'true';
				if (desktop.matches && event.detail > 0) open = true;
				closeAll(item);
				setSub(item, open);
				if (open && event.detail === 0) item.dataset.kb = '1';
			});
			item.addEventListener('mouseenter', function () {
				if (!desktop.matches) return;
				clearTimeout(timers.get(item));
				closeAll(item);
				setSub(item, true);
			});
			item.addEventListener('mouseleave', function () {
				if (!desktop.matches) return;
				timers.set(item, setTimeout(function () { if (item.dataset.kb !== '1') setSub(item, false); }, 160));
			});
			item.addEventListener('focusout', function (event) {
				if (desktop.matches && !item.contains(event.relatedTarget)) setSub(item, false);
			});
		});
		nav.addEventListener('click', function (event) {
			if (event.target.closest('a')) {
				closeAll();
				if (!desktop.matches) setMenu(false);
			}
		});
		document.addEventListener('click', function (event) {
			if (!nav.contains(event.target) && !btn.contains(event.target)) closeAll();
		});
		document.addEventListener('keydown', function (event) {
			if (event.key !== 'Escape') return;
			const open = items.find(function (item) { return item.getAttribute('data-open') === 'true'; });
			if (open) {
				setSub(open, false);
				open.querySelector('button').focus();
			} else if (!desktop.matches && nav.getAttribute('data-open') === 'true') {
				setMenu(false);
				btn.focus();
			}
		});
		desktop.addEventListener('change', function () { setMenu(false); });
	}

	const revealItems = document.querySelectorAll('[data-reveal]');
	if (!('IntersectionObserver' in window)) {
		Array.prototype.forEach.call(revealItems, function (item) { item.classList.add('is-in'); });
	} else {
		const observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-in');
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
		Array.prototype.forEach.call(revealItems, function (item) { observer.observe(item); });
	}

	const alertBox = document.getElementById('alert');
	const alertClose = document.getElementById('alert-close');
	if (alertBox && alertClose) alertClose.addEventListener('click', function () { alertBox.remove(); });

	const quoteBox = document.getElementById('quotes');
	if (!quoteBox) return;
	const slides = Array.prototype.slice.call(quoteBox.querySelectorAll('[data-slide]'));
	const dots = Array.prototype.slice.call(document.querySelectorAll('[data-dot]'));
	let current = 0;
	function showQuote(index) {
		current = (index + slides.length) % slides.length;
		slides.forEach(function (slide, i) { slide.hidden = i !== current; });
		dots.forEach(function (dot, i) { dot.setAttribute('aria-current', i === current ? 'true' : 'false'); });
	}
	document.getElementById('q-prev').addEventListener('click', function () { showQuote(current - 1); });
	document.getElementById('q-next').addEventListener('click', function () { showQuote(current + 1); });
	dots.forEach(function (dot, i) { dot.addEventListener('click', function () { showQuote(i); }); });
	showQuote(0);
})();