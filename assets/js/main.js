/**
 * AYED Ghana front-end behaviour.
 *
 * - Sticky header state on scroll
 * - Mobile navigation toggle
 * - Scroll reveal animations
 * - Back to top button
 * - Secure AJAX contact form submission
 */
(function () {
	"use strict";

	var prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

	document.addEventListener("DOMContentLoaded", function () {
		initHeader();
		initMobileNav();
		initReveal();
		initBackToTop();
		initAjaxForms();
	});

	/* Sticky header shadow on scroll. */
	function initHeader() {
		var header = document.querySelector("[data-header]");
		if (!header) {
			return;
		}
		var onScroll = function () {
			header.classList.toggle("is-scrolled", window.scrollY > 40);
		};
		onScroll();
		window.addEventListener("scroll", onScroll, { passive: true });
	}

	/* Mobile navigation. */
	function initMobileNav() {
		var toggle = document.querySelector("[data-nav-toggle]");
		var panel = document.querySelector("[data-mobile-nav]");
		if (!toggle || !panel) {
			return;
		}
		toggle.addEventListener("click", function () {
			var open = toggle.getAttribute("aria-expanded") === "true";
			toggle.setAttribute("aria-expanded", String(!open));
			toggle.setAttribute("aria-label", open ? "Open menu" : "Close menu");
			panel.hidden = open;
		});
		/* Close when a link is tapped. */
		panel.addEventListener("click", function (e) {
			if (e.target.closest("a")) {
				toggle.setAttribute("aria-expanded", "false");
				panel.hidden = true;
			}
		});
	}

	/* Reveal on scroll with light stagger. */
	function initReveal() {
		var els = Array.prototype.slice.call(document.querySelectorAll(".reveal"));
		if (!els.length) {
			return;
		}
		if (prefersReduced || !("IntersectionObserver" in window)) {
			els.forEach(function (el) { el.classList.add("is-visible"); });
			return;
		}
		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) {
					return;
				}
				var el = entry.target;
				var siblings = Array.prototype.slice.call(el.parentElement.querySelectorAll(":scope > .reveal"));
				var delay = Math.max(0, siblings.indexOf(el)) * 90;
				window.setTimeout(function () { el.classList.add("is-visible"); }, delay);
				observer.unobserve(el);
			});
		}, { threshold: 0.12, rootMargin: "0px 0px -40px 0px" });
		els.forEach(function (el) { observer.observe(el); });
	}

	/* Back to top button. */
	function initBackToTop() {
		var btn = document.querySelector("[data-back-to-top]");
		if (!btn) {
			return;
		}
		var onScroll = function () {
			btn.classList.toggle("is-visible", window.scrollY > 600);
		};
		onScroll();
		window.addEventListener("scroll", onScroll, { passive: true });
		btn.addEventListener("click", function () {
			window.scrollTo({ top: 0, behavior: prefersReduced ? "auto" : "smooth" });
		});
	}

	/* Secure AJAX forms (contact, application). Each form carries its own hidden
	   action and nonce inputs, so this handler is generic. */
	function initAjaxForms() {
		if (typeof window.ayedData === "undefined") {
			return;
		}
		var forms = document.querySelectorAll("[data-ajax-form]");
		Array.prototype.forEach.call(forms, function (form) {
			var status = form.querySelector(".form-status");
			var submit = form.querySelector(".form-submit");
			var defaultLabel = submit ? submit.textContent : "";

			form.addEventListener("submit", function (e) {
				e.preventDefault();

				if (!form.checkValidity()) {
					form.reportValidity();
					return;
				}

				setStatus(status, "", "");
				if (submit) {
					submit.disabled = true;
					submit.textContent = window.ayedData.sending;
				}

				fetch(window.ayedData.ajaxUrl, {
					method: "POST",
					credentials: "same-origin",
					body: new FormData(form)
				})
					.then(function (res) { return res.json().then(function (json) { return { ok: res.ok, json: json }; }); })
					.then(function (result) {
						var message = result.json && result.json.data && result.json.data.message;
						if (result.json && result.json.success) {
							setStatus(status, message || window.ayedData.sent, "is-success");
							form.reset();
						} else {
							setStatus(status, message || window.ayedData.error, "is-error");
						}
					})
					.catch(function () {
						setStatus(status, window.ayedData.error, "is-error");
					})
					.finally(function () {
						if (submit) {
							submit.disabled = false;
							submit.textContent = defaultLabel;
						}
					});
			});
		});
	}

	function setStatus(el, text, cls) {
		if (!el) {
			return;
		}
		el.textContent = text;
		el.className = "form-status" + (cls ? " " + cls : "");
	}
})();
