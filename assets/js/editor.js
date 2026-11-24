(function (wp) {
	'use strict';

	if (!wp || !wp.blocks || !wp.element || !wp.data || !(wp.blockEditor || wp.editor) || !wp.components) {
		return;
	}

	const { registerBlockType } = wp.blocks;
	const { __ } = wp.i18n || { __: (text) => text };
	const { createElement: el, Fragment } = wp.element;
	const blockEditor = wp.blockEditor || wp.editor;
	const { useSelect, useDispatch } = wp.data;
	const { BlockControls, useBlockProps } = blockEditor;
	const { ToolbarGroup, ToolbarButton } = wp.components;

	const renderButtonIcon = (className, path, extraChildren = null) =>
		el(
			'svg',
			{
				className,
				xmlns: 'http://www.w3.org/2000/svg',
				viewBox: '0 0 24 24',
				'aria-hidden': 'true',
				focusable: 'false'
			},
			extraChildren,
			el('path', { d: path })
		);

	const ThemeToggleEdit = ({ clientId }) => {
		const { rootClientId, blockIndex, blockOrder } = useSelect(
			(select) => {
				const editorSelect = select('core/block-editor');
				const nextRootClientId = editorSelect.getBlockRootClientId(clientId);

				return {
					rootClientId: nextRootClientId,
					blockIndex: editorSelect.getBlockIndex(clientId, nextRootClientId),
					blockOrder: editorSelect.getBlockOrder(nextRootClientId)
				};
			},
			[clientId]
		);
		const { moveBlocksUp, moveBlocksDown } = useDispatch('core/block-editor');

		const canMoveUp = blockIndex > 0;
		const canMoveDown = Array.isArray(blockOrder) ? blockIndex < blockOrder.length - 1 : false;

		const blockProps = useBlockProps({
			className: 'digimia-theme-toggle-block'
		});

		// Custom mover controls so the block can always be repositioned in template parts.
		const moverControls = el(
			BlockControls,
			null,
			el(
				ToolbarGroup,
				null,
				el(ToolbarButton, {
					icon: 'arrow-up-alt2',
					label: __('Move up', 'digimia'),
					onClick: () => moveBlocksUp([clientId], rootClientId),
					disabled: !canMoveUp
				}),
				el(ToolbarButton, {
					icon: 'arrow-down-alt2',
					label: __('Move down', 'digimia'),
					onClick: () => moveBlocksDown([clientId], rootClientId),
					disabled: !canMoveDown
				})
			)
		);

		return el(
			Fragment,
			null,
			moverControls,
			el(
				'div',
				blockProps,
				el(
					'button',
					{
						type: 'button',
						className: 'digimia-theme-toggle',
						'aria-pressed': 'false',
						'aria-label': __('Toggle dark/light mode', 'digimia')
					},
					renderButtonIcon(
						'icon-sun',
						'M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41',
						el('circle', { cx: '12', cy: '12', r: '4' })
					),
					renderButtonIcon('icon-moon', 'M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z')
				)
			)
		);
	};

	registerBlockType('digimia/theme-toggle', {
		apiVersion: 3,
		title: __('Theme Toggle', 'digimia'),
		category: 'design',
		icon: 'lightbulb',
		description: __('Dark/light mode toggle button.', 'digimia'),
		edit: ThemeToggleEdit,
		save: function () {
			return null;
		}
	});
})(window.wp);
