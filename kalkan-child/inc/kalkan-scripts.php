<script>
(function () {
	'use strict';

	/* ── Mobile menu toggle ── */
	var toggle = document.getElementById('kk-menu-toggle');
	var drawer = document.getElementById('kk-mobile-nav');

	if (toggle && drawer) {
		toggle.addEventListener('click', function () {
			var open = drawer.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});

		drawer.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function () {
				drawer.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
			});
		});
	}

	/* ── Scroll animations ── */
	if ('IntersectionObserver' in window) {
		var animObserver = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('kk-visible');
					animObserver.unobserve(entry.target);
				}
			});
		}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

		document.querySelectorAll('.kk-animate').forEach(function (el) {
			animObserver.observe(el);
		});
	} else {
		document.querySelectorAll('.kk-animate').forEach(function (el) {
			el.classList.add('kk-visible');
		});
	}

	/* ── FAQ accordion toggle ── */
	document.querySelectorAll('.kk-faq-question').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var item = this.closest('.kk-faq-item');
			var answer = item.querySelector('.kk-faq-answer');
			var toggleEl = this.querySelector('.kk-faq-toggle');
			var isOpen = item.classList.contains('active');

			document.querySelectorAll('.kk-faq-item.active').forEach(function (other) {
				if (other !== item) {
					other.classList.remove('active');
					other.querySelector('.kk-faq-answer').style.maxHeight = null;
					other.querySelector('.kk-faq-toggle').textContent = '+';
				}
			});

			if (isOpen) {
				item.classList.remove('active');
				answer.style.maxHeight = null;
				toggleEl.textContent = '+';
			} else {
				item.classList.add('active');
				answer.style.maxHeight = answer.scrollHeight + 'px';
				toggleEl.textContent = '\u2212';
			}
		});
	});

	/* ── Smooth scroll for anchor links ── */
	document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
		anchor.addEventListener('click', function (e) {
			var id = this.getAttribute('href').slice(1);
			var target = document.getElementById(id);
			if (target) {
				e.preventDefault();
				target.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}
		});
	});
}());
</script>
