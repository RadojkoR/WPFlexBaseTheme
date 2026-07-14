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
			},
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
			} ),
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
		);
	}

	registerPlugin( 'whs-frame-settings', {
		render: WhsFrameSettingsPanel,
		icon: 'admin-customizer',
	} );
}( window.wp ));
