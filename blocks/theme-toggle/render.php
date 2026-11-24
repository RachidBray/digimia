<?php
/**
 * Theme toggle block render.
 *
 * @package digimia
 */

declare(strict_types=1);

$digimia_wrapper_attributes = get_block_wrapper_attributes(
	array(
		'class' => 'digimia-theme-toggle-block',
	)
);
?>
<div <?php echo $digimia_wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<button
		type="button"
		class="digimia-theme-toggle"
		aria-pressed="false"
		aria-label="<?php echo esc_attr__( 'Toggle dark/light mode', 'digimia' ); ?>"
	>
		<svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
			<circle cx="12" cy="12" r="4"></circle>
			<path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"></path>
		</svg>
		<svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
			<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
		</svg>
	</button>
</div>
