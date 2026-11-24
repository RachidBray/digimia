/**
 * Button Icon Extension — Editor UI.
 *
 * Extends core/button with a visual icon picker in the Inspector sidebar
 * and a live CSS-based preview in the editor canvas.
 *
 * Architecture:
 * - blocks.registerBlockType  → adds custom attributes
 * - editor.BlockEdit          → InspectorControls (sidebar icon picker)
 * - editor.BlockListBlock     → wrapperProps with CSS custom properties
 *
 * The editor preview uses CSS mask-image on a ::before pseudo-element.
 * This works across the WP 6.6+ iframe-based editor because it's pure
 * React + CSS — no DOM manipulation, no document.getElementById.
 *
 * @package digimia
 */

import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	Tooltip,
} from '@wordpress/components';
import { Fragment } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

/**
 * Get the icon registry from the localized PHP data.
 */
const getIcons = () => window.digimiaButtonIcons?.icons || [];

/**
 * Convert an SVG string into a CSS url() data URI for mask-image.
 * Replaces currentColor with black (mask only cares about alpha/shape).
 */
const svgToMaskUri = ( svg ) => {
	const cleaned = svg.replace( /currentColor/g, 'black' );
	return 'url("data:image/svg+xml,' + encodeURIComponent( cleaned ) + '")';
};

/**
 * Whether an icon points left or right (an arrow or caret), so it is mirrored
 * when the page reads right to left. Same test as is_directional_icon() in
 * inc/icons.php, which marks the icons on the front end.
 */
const isDirectional = ( slug = '' ) => /(^|[/-])(left|right)(-|$)/.test( slug );

/**
 * 1. Register custom attributes on core/button.
 */
addFilter(
	'blocks.registerBlockType',
	'digimia/button-icon-attributes',
	( settings, name ) => {
		if ( name !== 'core/button' ) {
			return settings;
		}

		return {
			...settings,
			attributes: {
				...settings.attributes,
				digimiaIcon: {
					type: 'string',
					default: '',
				},
				digimiaIconPosition: {
					type: 'string',
					default: 'left',
				},
			},
		};
	}
);

/**
 * 2. Add InspectorControls — icon picker and position. The icon size follows
 * the button's font size (see _core-button.scss).
 */
const withIconControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( props.name !== 'core/button' ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props;
		const { digimiaIcon, digimiaIconPosition } = attributes;
		const icons = getIcons();

		return (
			<Fragment>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody
						title={ __( 'Button Icon', 'digimia' ) }
						initialOpen={ !! digimiaIcon }
						className="digimia-button-icon-panel"
					>
						<div className="digimia-icon-picker">
							<div className="digimia-icon-picker__grid">
								{ /* None option */ }
								<Tooltip text={ __( 'No icon', 'digimia' ) }>
									<button
										type="button"
										className={ `digimia-icon-picker__item ${
											! digimiaIcon ? 'is-active' : ''
										}` }
										onClick={ () =>
											setAttributes( { digimiaIcon: '' } )
										}
										aria-label={ __( 'Remove icon', 'digimia' ) }
									>
										<span className="digimia-icon-picker__none">✕</span>
									</button>
								</Tooltip>

								{ icons.map( ( icon ) => (
									<Tooltip
										key={ icon.slug }
										text={ icon.label }
									>
										<button
											type="button"
											className={ `digimia-icon-picker__item ${
												digimiaIcon === icon.slug
													? 'is-active'
													: ''
											}` }
											onClick={ () =>
												setAttributes( {
													digimiaIcon: icon.slug,
												} )
											}
											aria-label={ icon.label }
											dangerouslySetInnerHTML={ {
												__html: icon.svg,
											} }
										/>
									</Tooltip>
								) ) }
							</div>
						</div>

						{ digimiaIcon && (
							<Fragment>
								<SelectControl
									label={ __( 'Icon Position', 'digimia' ) }
									help={ __( 'The icon scales with the button text. Change the font size to resize both.', 'digimia' ) }
									value={ digimiaIconPosition }
									options={ [
										{
											label: __( 'Left', 'digimia' ),
											value: 'left',
										},
										{
											label: __( 'Right', 'digimia' ),
											value: 'right',
										},
										{
											label: __( 'Icon Only', 'digimia' ),
											value: 'only',
										},
									] }
									onChange={ ( value ) =>
										setAttributes( {
											digimiaIconPosition: value,
										} )
									}
								/>
							</Fragment>
						) }
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'withIconControls' );

addFilter(
	'editor.BlockEdit',
	'digimia/button-icon-controls',
	withIconControls
);

/**
 * 3. Live editor preview via CSS custom properties + mask-image.
 *
 * Sets --digimia-icon-svg on the block wrapper,
 * which the editor SCSS uses on ::before to render the icon.
 * Works inside the WP 6.6+ iframe because it's pure React + CSS.
 */
const withIconPreview = createHigherOrderComponent( ( BlockListBlock ) => {
	return ( props ) => {
		if ( props.name !== 'core/button' ) {
			return <BlockListBlock { ...props } />;
		}

		const { digimiaIcon, digimiaIconPosition } = props.attributes;

		// Always set --digimia-icon-display so the ::before is explicitly
		// hidden (none) or shown (inline-block). This is bulletproof even
		// if WP caches stale classes on the wrapper element.
		if ( ! digimiaIcon ) {
			const wrapperProps = {
				...( props.wrapperProps || {} ),
				style: {
					...( props.wrapperProps?.style || {} ),
					'--digimia-icon-display': 'none',
					'--digimia-icon-svg': undefined,
				},
			};

			return (
				<BlockListBlock
					{ ...props }
					wrapperProps={ wrapperProps }
				/>
			);
		}

		const icons = getIcons();
		const icon = icons.find( ( i ) => i.slug === digimiaIcon );

		if ( ! icon ) {
			return <BlockListBlock { ...props } />;
		}

		const position = digimiaIconPosition || 'left';
		const iconOnly = position === 'only';

		const wrapperProps = {
			...( props.wrapperProps || {} ),
			style: {
				...( props.wrapperProps?.style || {} ),
				'--digimia-icon-display': 'inline-block',
				'--digimia-icon-svg': svgToMaskUri( icon.svg ),
			},
		};

		const classes = [
			props.className || '',
			'has-digimia-icon',
			`icon-pos-${ position }`,
			iconOnly ? 'is-icon-only' : '',
			isDirectional( digimiaIcon ) ? 'is-directional' : '',
		].filter( Boolean ).join( ' ' );

		return (
			<BlockListBlock
				{ ...props }
				className={ classes }
				wrapperProps={ wrapperProps }
			/>
		);
	};
}, 'withIconPreview' );

addFilter(
	'editor.BlockListBlock',
	'digimia/button-icon-preview',
	withIconPreview
);

/**
 * 4. Mark Icon blocks that show a directional icon, as the front end does, so
 * the editor mirrors them right to left too.
 */
const withDirectionalIcon = createHigherOrderComponent( ( BlockListBlock ) => {
	return ( props ) => {
		if ( props.name !== 'core/icon' || ! isDirectional( props.attributes?.icon ) ) {
			return <BlockListBlock { ...props } />;
		}

		return (
			<BlockListBlock
				{ ...props }
				className={ [ props.className, 'is-directional' ].filter( Boolean ).join( ' ' ) }
			/>
		);
	};
}, 'withDirectionalIcon' );

addFilter(
	'editor.BlockListBlock',
	'digimia/directional-icon',
	withDirectionalIcon
);
