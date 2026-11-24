/**
 * Digimia Theme Toggle
 *
 * Handles dark/light mode switching with localStorage persistence
 * and prefers-color-scheme detection on first visit.
 *
 * @package digimia
 */
(function () {
	'use strict';

	const STORAGE_KEY = 'digimia-theme';
	const DARK = 'dark';
	const LIGHT = 'light';

	/**
	 * Get the current theme preference.
	 * Priority: localStorage > prefers-color-scheme: dark > light (default).
	 */
	function getPreference() {
		const stored = localStorage.getItem(STORAGE_KEY);
		if (stored === DARK || stored === LIGHT) {
			return stored;
		}
		if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
			return DARK;
		}
		return LIGHT;
	}

	/**
	 * Apply the theme to the document.
	 */
	function applyTheme(theme) {
		document.documentElement.setAttribute('data-theme', theme);
		localStorage.setItem(STORAGE_KEY, theme);
		updateToggleState(theme);

		// Dispatch custom event for extensibility
		document.dispatchEvent(new CustomEvent('digimia:themechange', {
			detail: { theme }
		}));
	}

	/**
	 * Toggle between dark and light.
	 */
	function toggle() {
		const current = document.documentElement.getAttribute('data-theme') || LIGHT;
		applyTheme(current === DARK ? LIGHT : DARK);
	}

	/**
	 * Sync button state for accessibility.
	 */
	function updateToggleState(theme) {
		const buttons = document.querySelectorAll('.digimia-theme-toggle');
		const isDark = theme === DARK;
		buttons.forEach(function (btn) {
			btn.setAttribute('aria-pressed', isDark ? 'true' : 'false');
		});
	}

	/**
	 * Initialize toggle buttons.
	 */
	function initToggleButtons() {
		const buttons = document.querySelectorAll('.digimia-theme-toggle');
		buttons.forEach(function (btn) {
			btn.addEventListener('click', function (e) {
				e.preventDefault();
				toggle();
			});
		});

		updateToggleState(document.documentElement.getAttribute('data-theme') || LIGHT);
	}

	/**
	 * Listen for system theme changes.
	 */
	function watchSystemTheme() {
		if (!window.matchMedia) {
			return;
		}

		window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
			// Only respond if user hasn't set a manual preference
			if (!localStorage.getItem(STORAGE_KEY)) {
				applyTheme(e.matches ? DARK : LIGHT);
			}
		});
	}

	// Apply theme immediately (backup for inline script)
	applyTheme(getPreference());

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initToggleButtons();
			watchSystemTheme();
		});
	} else {
		initToggleButtons();
		watchSystemTheme();
	}
})();
