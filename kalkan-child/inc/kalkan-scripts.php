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

	/* ── App Store CTA measurement (works with an existing GA4 gtag setup) ── */
	document.querySelectorAll('a[href*="apple.co/"], a[href*="apps.apple.com/"]').forEach(function (link) {
		link.addEventListener('click', function () {
			if (typeof window.gtag !== 'function') {
				return;
			}

			window.gtag('event', 'app_store_click', {
				link_url: this.href,
				link_text: (this.getAttribute('aria-label') || this.textContent || 'App Store').trim(),
				page_path: window.location.pathname
			});
		});
	});

	/* ── WebMCP: read-only product context for supporting browser agents ── */
	if (document.modelContext && typeof document.modelContext.registerTool === 'function') {
		var webMcpController = new AbortController();

		document.modelContext.registerTool({
			name: 'get_kalkan_product_summary',
			description: 'Return a concise, factual summary of Kalkan and its documented privacy and platform limitations.',
			inputSchema: { type: 'object', properties: {}, additionalProperties: false },
			annotations: { readOnlyHint: true },
			execute: async function () {
				return { content: [{
					type: 'text',
					text: document.documentElement.lang === 'en-US'
						? 'Kalkan is an iOS spam-call blocker and caller-ID app. It uses preloaded on-device Call Directory data, does not upload contacts or call history, and cannot guarantee detection of every new number or authenticate callers against spoofing.'
						: 'Kalkan, iOS için spam arama engelleme ve arayan kimliği uygulamasıdır. Cihaza önceden yüklenmiş Call Directory verilerini kullanır; rehberi veya arama geçmişini yüklemez. Her yeni numarayı tespit etmeyi veya arayanı sahteciliğe karşı doğrulamayı garanti etmez.'
				}] };
			}
		}, { signal: webMcpController.signal });

		document.modelContext.registerTool({
			name: 'list_kalkan_page_sections',
			description: 'List the visible titled sections on the current Kalkan page so an agent can navigate the public documentation accurately.',
			inputSchema: { type: 'object', properties: {}, additionalProperties: false },
			annotations: { readOnlyHint: true },
			execute: async function () {
				var sections = Array.from(document.querySelectorAll('main section[id], main h1[id], main h2[id]')).map(function (el) {
					var heading = el.matches('h1,h2') ? el : el.querySelector('h1,h2');
					return heading ? { id: el.id || heading.id, title: heading.textContent.trim() } : null;
				}).filter(Boolean);
				return { content: [{ type: 'text', text: JSON.stringify(sections) }] };
			}
		}, { signal: webMcpController.signal });
	}
}());
</script>
