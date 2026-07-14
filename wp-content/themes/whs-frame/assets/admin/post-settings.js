/* WHS Frame — post-settings.js */
/* Per-post "WHS Frame Settings" panel in the block editor sidebar. */
( function ( wp ) {
	'use strict';

	if ( ! wp || ! wp.plugins || ! wp.data || ! wp.element || ! wp.components ) {
		return;
	}

	var registerPlugin = wp.plugins.registerPlugin;
	var PluginDocumentSettingPanel =
		( wp.editor && wp.editor.PluginDocumentSettingPanel ) ||
		( wp.editPost && wp.editPost.PluginDocumentSettingPanel );

	if ( ! PluginDocumentSettingPanel ) {
		return;
	}

	var useSelect        = wp.data.useSelect;
	var useDispatch       = wp.data.useDispatch;
	var CheckboxControl  = wp.components.CheckboxControl;
	var SelectControl    = wp.components.SelectControl;
	var RangeControl     = wp.components.RangeControl;
	var h                = wp.element.createElement;
	var __                = wp.i18n.__;

	function WhsFrameSettingsPanel() {
		var meta = useSelect( function ( select ) {
			return select( 'core/editor' ).getEditedPostAttribute( 'meta' ) || {};
		}, [] );
		var editPost = useDispatch( 'core/editor' ).editPost;

		function setMeta( key, value ) {
			var next = Object.assign( {}, meta );
			next[ key ] = value;
			editPost( { meta: next } );
		}

		return h( PluginDocumentSettingPanel,
			{
				name: 'whs-frame-settings',
				title: __( 'WHS Frame Settings', 'whs-frame' ),
				className: 'whs-frame-doc-panel',
			},
			h( 'div', { className: 'whs-frame-doc-panel__group' },
				h( SelectControl, {
					label: __( 'Content Layout', 'whs-frame' ),
					value: meta._whs_frame_content_layout || '',
					options: [
						{ label: __( 'Customizer Setting', 'whs-frame' ), value: '' },
						{ label: __( 'Boxed', 'whs-frame' ), value: 'boxed' },
						{ label: __( 'Content Boxed', 'whs-frame' ), value: 'content-boxed' },
						{ label: __( 'Full Width/Contained', 'whs-frame' ), value: 'full-width-contained' },
						{ label: __( 'Full Width/Stretched', 'whs-frame' ), value: 'full-width-stretched' },
						{ label: __( 'Custom Width', 'whs-frame' ), value: 'custom' },
					],
					onChange: function ( v ) { setMeta( '_whs_frame_content_layout', v ); },
				} ),
				'custom' === meta._whs_frame_content_layout && h( RangeControl, {
					label: __( 'Custom Width (%)', 'whs-frame' ),
					value: meta._whs_frame_content_custom_width || 80,
					onChange: function ( v ) { setMeta( '_whs_frame_content_custom_width', v ); },
					min: 20,
					max: 100,
					help: __( 'Content is always centered at this width.', 'whs-frame' ),
				} )
			),
			h( 'p', { className: 'whs-frame-doc-panel__heading' }, __( 'Disable Sections', 'whs-frame' ) ),
			h( 'div', { className: 'whs-frame-doc-panel__group' },
				h( CheckboxControl, {
					label: __( 'Disable Title', 'whs-frame' ),
					checked: !! meta._whs_frame_disable_title,
					onChange: function ( v ) { setMeta( '_whs_frame_disable_title', v ); },
				} ),
				h( CheckboxControl, {
					label: __( 'Disable Featured Image', 'whs-frame' ),
					checked: !! meta._whs_frame_disable_featured_image,
					onChange: function ( v ) { setMeta( '_whs_frame_disable_featured_image', v ); },
				} ),
				h( CheckboxControl, {
					label: __( 'Disable Header', 'whs-frame' ),
					checked: !! meta._whs_frame_disable_header,
					onChange: function ( v ) { setMeta( '_whs_frame_disable_header', v ); },
				} ),
				h( CheckboxControl, {
					label: __( 'Disable Footer', 'whs-frame' ),
					checked: !! meta._whs_frame_disable_footer,
					onChange: function ( v ) { setMeta( '_whs_frame_disable_footer', v ); },
				} )
			),
			h( 'div', { className: 'whs-frame-doc-panel__group whs-frame-doc-panel__group--last' },
				h( SelectControl, {
					label: __( 'Transparent Header', 'whs-frame' ),
					value: meta._whs_frame_transparent_header || '',
					options: [
						{ label: __( 'Customizer Setting', 'whs-frame' ), value: '' },
						{ label: __( 'Enable', 'whs-frame' ), value: 'enable' },
						{ label: __( 'Disable', 'whs-frame' ), value: 'disable' },
					],
					onChange: function ( v ) { setMeta( '_whs_frame_transparent_header', v ); },
				} )
			)
		);
	}

	registerPlugin( 'whs-frame-settings', {
		render: WhsFrameSettingsPanel,
		icon: 'admin-customizer',
	} );
}( window.wp ));
