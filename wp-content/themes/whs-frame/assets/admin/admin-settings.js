/* FlexBase Admin Settings — admin-settings.js */
/* global wp, whsFrameAdmin */
( function () {
	'use strict';

	const {
		createElement: h,
		useState,
		useEffect,
		useCallback,
		Fragment,
	} = wp.element;

	const apiFetch = wp.apiFetch;

	const {
		nonce,
		restUrl,
		fontLabels,
		mediaPreviews,
	} = window.whsFrameAdmin || {};

	apiFetch.use( apiFetch.createNonceMiddleware( nonce ) );

	// ─── Constants ───────────────────────────────────────────────────────────────

	const TABS = [
		{ id: 'themes',      label: 'Themes'      },
		{ id: 'general',     label: 'General'     },
		{ id: 'header',      label: 'Header'      },
		{ id: 'topbar',      label: 'Top Bar'     },
		{ id: 'buttons',     label: 'Buttons'     },
		{ id: 'mobile',      label: 'Mobile'      },
		{ id: 'footer',      label: 'Footer'      },
		{ id: 'social',      label: 'Social'      },
	];

	const STICKY_OPTIONS = {
		none:      'Not Sticky',
		always:    'Always Sticky',
		scroll_up: 'Sticky on Scroll Up Only',
	};

	const COL_TYPE_OPTIONS = {
		none:         'None',
		email:        'Email',
		phone:        'Phone',
		email_phone:  'Email + Phone',
		social_icons: 'Social Icons',
		custom_text:  'Custom Text',
	};

	const PRESETS = {
		light: {
			label: 'Light',
			description: 'Clean, bright theme with purple accent',
			colors: {
				color_primary:    '#7c3aed',
				color_secondary:  '#3b82f6',
				color_background: '#f8f8ff',
				color_text:       '#1e1e2e',
				header_bg_color:   '#ffffff',
				header_text_color: '#1e1e2e',
				header_nav_hover:  '#7c3aed',
				header_nav_active: '#3b82f6',
				topbar_bg_color:   '#7c3aed',
				topbar_text_color: '#ffffff',
				topbar_link_color: '#e0d7ff',
				footer_bg_color:   '#f0f0f8',
				footer_text_color: '#1e1e2e',
				footer_heading_color: '#1e1e2e',
				footer_link_color: '#7c3aed',
				footer_contact_address_link_color: '#374151',
				footer_contact_address_icon_color: '#374151',
				footer_contact_address_hover_color: '#7c3aed',
				footer_contact_email_icon_color:   '#374151',
				footer_contact_email_hover_color: '#7c3aed',
				footer_contact_phone_icon_color:   '#374151',
				footer_contact_phone_hover_color: '#7c3aed',
				footer_copyright_text_color:       '#6b7280',
				footer_powered_by_color:           '#6b7280',
				footer_social_icon_color:          '#374151',
				footer_social_hover_color:         '#7c3aed',
				footer_social_icon_border_color:   '#d1d5db',
				footer_social_icon_border_hover_color: '#7c3aed',
				mobile_menu_bg_color:              '#ffffff',
				mobile_menu_text_color:            '#1e1e2e',
				mobile_menu_link_hover:            '#7c3aed',
				mobile_menu_active_bg:             '#f5f3ff',
				mobile_menu_active_text:           '#7c3aed',
				mobile_close_bg_color:             '#ffffff',
				mobile_close_icon_color:           '#1e1e2e',
				mobile_close_border_color:         '#e5e7eb',
				mobile_close_border_width:         1,
				mobile_close_border_radius:        8,
				nav_login_button_border_color: '#7c3aed',
				nav_login_button_text_color: '#7c3aed',
				nav_login_button_hover_bg_color: '#7c3aed',
				nav_login_button_hover_border_color: '#7c3aed',
				nav_signup_button_bg_color: '#7c3aed',
				nav_signup_button_hover_bg_color: '#7c3aed',
				nav_signup_button_border_color: '#7c3aed',
				nav_signup_button_hover_text_color: '#ffffff',
				nav_signup_button_hover_border_color: '#7c3aed',
				nav_login_button_hover_text_color: '#ffffff',
				nav_login_button_bg_transparent: true,
				nav_login_button_hover_bg_transparent: false,
				nav_signup_button_bg_transparent: false,
				nav_signup_button_hover_bg_transparent: false,
			},
		},
		dark: {
			label: 'Dark',
			description: 'Deep dark theme with purple and blue accents',
			colors: {
				color_primary:    '#7c3aed',
				color_secondary:  '#3b82f6',
				color_background: '#0f0f1a',
				color_text:       '#e2e8f0',
				header_bg_color:   '#1a1a2e',
				header_text_color: '#e2e8f0',
				header_nav_hover:  '#a78bfa',
				header_nav_active: '#60a5fa',
				topbar_bg_color:   '#0a0a14',
				topbar_text_color: '#e2e8f0',
				topbar_link_color: '#a78bfa',
				footer_bg_color:   '#0a0a14',
				footer_text_color: '#e2e8f0',
				footer_heading_color: '#e2e8f0',
				footer_link_color: '#a78bfa',
				footer_contact_address_link_color: '#cbd5e1',
				footer_contact_address_icon_color: '#cbd5e1',
				footer_contact_address_hover_color: '#a78bfa',
				footer_contact_email_icon_color:   '#cbd5e1',
				footer_contact_email_hover_color: '#a78bfa',
				footer_contact_phone_icon_color:   '#cbd5e1',
				footer_contact_phone_hover_color: '#a78bfa',
				footer_copyright_text_color:       '#9ca3af',
				footer_powered_by_color:           '#9ca3af',
				footer_social_icon_color:          '#cbd5e1',
				footer_social_hover_color:         '#a78bfa',
				footer_social_icon_border_color:   '#3d3d6b',
				footer_social_icon_border_hover_color: '#a78bfa',
				mobile_menu_bg_color:              '#1a1a2e',
				mobile_menu_text_color:            '#e2e8f0',
				mobile_menu_link_hover:            '#a78bfa',
				mobile_menu_active_bg:             '#2d2b55',
				mobile_menu_active_text:           '#a78bfa',
				mobile_close_bg_color:             '#1a1a2e',
				mobile_close_icon_color:           '#e2e8f0',
				mobile_close_border_color:         '#3d3d6b',
				mobile_close_border_width:         1,
				mobile_close_border_radius:        8,
				nav_login_button_border_color: '#7c3aed',
				nav_login_button_text_color: '#7c3aed',
				nav_login_button_hover_bg_color: '#7c3aed',
				nav_login_button_hover_border_color: '#7c3aed',
				nav_signup_button_bg_color: '#7c3aed',
				nav_signup_button_hover_bg_color: '#7c3aed',
				nav_signup_button_border_color: '#7c3aed',
				nav_signup_button_hover_text_color: '#ffffff',
				nav_signup_button_hover_border_color: '#7c3aed',
				nav_login_button_hover_text_color: '#ffffff',
				nav_login_button_bg_transparent: true,
				nav_login_button_hover_bg_transparent: false,
				nav_signup_button_bg_transparent: false,
				nav_signup_button_hover_bg_transparent: false,
			},
		},
		ocean: {
			label: 'Ocean',
			description: 'Refreshing teal theme with coastal vibes',
			colors: {
				color_primary:    '#0d9488',
				color_secondary:  '#0ea5e9',
				color_background: '#f0fdfa',
				color_text:       '#134e4a',
				header_bg_color:   '#f0fdfa',
				header_text_color: '#134e4a',
				header_nav_hover:  '#0d9488',
				header_nav_active: '#0ea5e9',
				topbar_bg_color:   '#0d9488',
				topbar_text_color: '#ffffff',
				topbar_link_color: '#ccfbf1',
				footer_bg_color:   '#f0fdfa',
				footer_text_color: '#134e4a',
				footer_heading_color: '#134e4a',
				footer_link_color: '#0d9488',
				footer_contact_address_link_color: '#134e4a',
				footer_contact_address_icon_color: '#134e4a',
				footer_contact_address_hover_color: '#0d9488',
				footer_contact_email_icon_color:   '#134e4a',
				footer_contact_email_hover_color: '#0d9488',
				footer_contact_phone_icon_color:   '#134e4a',
				footer_contact_phone_hover_color: '#0d9488',
				footer_copyright_text_color:       '#6b7280',
				footer_powered_by_color:           '#6b7280',
				footer_social_icon_color:          '#374151',
				footer_social_hover_color:         '#0d9488',
				footer_social_icon_border_color:   '#d1d5db',
				footer_social_icon_border_hover_color: '#0d9488',
				mobile_menu_bg_color:              '#ffffff',
				mobile_menu_text_color:            '#134e4a',
				mobile_menu_link_hover:            '#0d9488',
				mobile_menu_active_bg:             '#f0fdfa',
				mobile_menu_active_text:           '#0d9488',
				mobile_close_bg_color:             '#ffffff',
				mobile_close_icon_color:           '#134e4a',
				mobile_close_border_color:         '#d1d5db',
				mobile_close_border_width:         1,
				mobile_close_border_radius:        8,
				nav_login_button_border_color: '#0d9488',
				nav_login_button_text_color: '#0d9488',
				nav_login_button_hover_bg_color: '#0d9488',
				nav_login_button_hover_text_color: '#ffffff',
				nav_signup_button_bg_color: '#0d9488',
				nav_signup_button_hover_bg_color: '#0f766e',
				nav_signup_button_border_color: '#0d9488',
				nav_signup_button_hover_text_color: '#ffffff',
				nav_signup_button_hover_border_color: '#0f766e',
				nav_login_button_hover_border_color: '#0d9488',
				nav_login_button_bg_transparent: true,
				nav_login_button_hover_bg_transparent: false,
				nav_signup_button_bg_transparent: false,
				nav_signup_button_hover_bg_transparent: false,
			},
		},
	};

	const NETWORKS = [ 'facebook', 'instagram', 'twitter', 'linkedin', 'youtube', 'tiktok' ];

	const NETWORK_LABELS = {
		facebook:  'Facebook',
		instagram: 'Instagram',
		twitter:   'Twitter / X',
		linkedin:  'LinkedIn',
		youtube:   'YouTube',
		tiktok:    'TikTok',
	};

	const FA_DEFAULTS = {
		facebook:  'fa-brands fa-facebook-f',
		instagram: 'fa-brands fa-instagram',
		twitter:   'fa-brands fa-x-twitter',
		linkedin:  'fa-brands fa-linkedin-in',
		youtube:   'fa-brands fa-youtube',
		tiktok:    'fa-brands fa-tiktok',
	};

	const COLS = [ 'left', 'center', 'right' ];
	const COL_LABELS = { left: 'Left Column', center: 'Center Column', right: 'Right Column' };

	// ─── Field Components ─────────────────────────────────────────────────────────

	function Field( { label, description, children } ) {
		return h( 'div', { className: 'fb-field' },
			h( 'label', { className: 'fb-field__label' }, label ),
			description && h( 'p', { className: 'fb-field__desc' }, description ),
			children
		);
	}

	function ColorField( { label, value, onChange, description } ) {
		const hex = value || '#000000';
		return h( Field, { label, description },
			h( 'div', { className: 'fb-color-wrap' },
				h( 'input', {
					type: 'color',
					value: hex,
					onChange: e => onChange( e.target.value ),
					className: 'fb-color-swatch',
				} ),
				h( 'input', {
					type: 'text',
					value: value || '',
					onChange: e => onChange( e.target.value ),
					className: 'fb-input fb-input--hex',
					placeholder: '#000000',
					spellCheck: false,
				} )
			)
		);
	}

	function TextField( { label, value, onChange, type = 'text', placeholder = '', description } ) {
		return h( Field, { label, description },
			h( 'input', {
				type,
				value: value || '',
				onChange: e => onChange( e.target.value ),
				placeholder,
				className: 'fb-input',
			} )
		);
	}

	function TextareaField( { label, value, onChange, placeholder = '', description, rows = 3 } ) {
		return h( Field, { label, description },
			h( 'textarea', {
				value: value || '',
				onChange: e => onChange( e.target.value ),
				placeholder,
				rows,
				className: 'fb-textarea',
			} )
		);
	}

	function ToggleField( { label, value, onChange, description } ) {
		return h( Field, { label, description },
			h( 'input', {
				type: 'checkbox',
				checked: !! value,
				onChange: e => onChange( e.target.checked ),
				className: 'fb-toggle',
			} )
		);
	}

	function SelectField( { label, value, onChange, options, description } ) {
		// Accept either a { value: label } object or an ordered array of
		// { value, label } pairs (objects reorder numeric keys in JS).
		const entries = Array.isArray( options )
			? options.map( o => [ o.value, o.label ] )
			: Object.entries( options );
		return h( Field, { label, description },
			h( 'select', {
				value: value || '',
				onChange: e => onChange( e.target.value ),
				className: 'fb-select',
			},
				entries.map( ( [ k, v ] ) =>
					h( 'option', { key: k, value: k }, v )
				)
			)
		);
	}

	function SectionHeading( { children } ) {
		return h( 'h3', { className: 'fb-section-heading' }, children );
	}

	function Grid( { cols = 2, children } ) {
		return h( 'div', { className: `fb-grid fb-grid--${ cols }` }, children );
	}

	function CompactColorField( { label, value, onChange } ) {
		const hex = value || '#000000';
		return h( 'div', { className: 'fb-field fb-field--compact' },
			h( 'label', { className: 'fb-field__label fb-field__label--compact' }, label ),
			h( 'div', { className: 'fb-color-wrap fb-color-wrap--compact' },
				h( 'input', {
					type: 'color',
					value: hex,
					onChange: e => onChange( e.target.value ),
					className: 'fb-color-swatch',
				} ),
				h( 'input', {
					type: 'text',
					value: value || '',
					onChange: e => onChange( e.target.value ),
					className: 'fb-input fb-input--hex fb-input--xs',
					placeholder: '#000000',
					spellCheck: false,
				} )
			)
		);
	}

	function CompactToggleField( { label, value, onChange } ) {
		return h( 'div', { className: 'fb-field fb-field--compact' },
			h( 'label', { className: 'fb-field__label fb-field__label--compact' }, label ),
			h( 'input', {
				type: 'checkbox',
				checked: !! value,
				onChange: e => onChange( e.target.checked ),
				className: 'fb-toggle',
			} )
		);
	}

	function CompactNumberField( { label, value, onChange, min = 0, max = 100, step = 1 } ) {
		return h( 'div', { className: 'fb-field fb-field--compact' },
			h( 'label', { className: 'fb-field__label fb-field__label--compact' }, label ),
			h( 'input', {
				type: 'number',
				value: value || '',
				onChange: e => onChange( e.target.value ),
				min,
				max,
				step,
				className: 'fb-input fb-input--number fb-input--xs',
				placeholder: '0',
			} )
		);
	}

	function CompactTextField( { label, value, onChange, placeholder = '' } ) {
		return h( 'div', { className: 'fb-field fb-field--compact' },
			h( 'label', { className: 'fb-field__label fb-field__label--compact' }, label ),
			h( 'input', {
				type: 'text',
				value: value || '',
				onChange: e => onChange( e.target.value ),
				placeholder,
				className: 'fb-input fb-input--xs',
			} )
		);
	}

	// Live cache of attachment preview URLs — seeded from PHP on page load,
	// updated when the user picks a new image (survives tab switches).
	const mediaPreviewCache = Object.assign( {}, mediaPreviews );

	function MediaField( { label, value, onChange, previewKey, description } ) {
		const [ preview, setPreview ] = useState( mediaPreviewCache[ previewKey ] || '' );

		const openMedia = () => {
			if ( ! window.wp || ! window.wp.media ) {
				return;
			}
			const frame = window.wp.media( {
				title: 'Select Image',
				library: { type: 'image' },
				multiple: false,
			} );
			frame.on( 'select', () => {
				const att = frame.state().get( 'selection' ).first().toJSON();
				const url = ( att.sizes && att.sizes.medium && att.sizes.medium.url ) || att.url || '';
				mediaPreviewCache[ previewKey ] = url;
				setPreview( url );
				onChange( att.id );
			} );
			frame.open();
		};

		const removeImage = () => {
			mediaPreviewCache[ previewKey ] = '';
			setPreview( '' );
			onChange( 0 );
		};

		return h( Field, { label, description },
			h( 'div', { className: 'fb-media' },
				!! value && preview && h( 'img', { src: preview, alt: '', className: 'fb-media__preview' } ),
				h( 'div', { className: 'fb-media__actions' },
					h( 'button', { type: 'button', className: 'fb-btn', onClick: openMedia },
						value ? 'Change Image' : 'Select Image'
					),
					!! value && h( 'button', { type: 'button', className: 'fb-btn fb-btn--danger', onClick: removeImage }, 'Remove' )
				)
			)
		);
	}

	// ─── Tab: Themes ─────────────────────────────────────────────────────────────

	// Returns the id of the preset whose every value matches the current
	// settings, or null when colors have been customized away from all presets.
	function detectActivePreset( settings ) {
		if ( ! settings ) {
			return null;
		}
		const ids = Object.keys( PRESETS );
		for ( let i = 0; i < ids.length; i++ ) {
			const colors  = PRESETS[ ids[ i ] ].colors;
			const matches = Object.keys( colors ).every( function ( k ) {
				const presetValue  = colors[ k ];
				const currentValue = settings[ k ];
				if ( typeof presetValue === 'string' && typeof currentValue === 'string' ) {
					return presetValue.toLowerCase() === currentValue.toLowerCase();
				}
				return presetValue === currentValue || String( presetValue ) === String( currentValue );
			} );
			if ( matches ) {
				return ids[ i ];
			}
		}
		return null;
	}

	function ThemesTab( { onApply, settings } ) {
		// Derived from current settings — marks the matching preset card even
		// after a page reload, and clears when any color is customized.
		const selected = detectActivePreset( settings );

		const handleSelect = ( id ) => {
			const colors = PRESETS[ id ].colors;

			// Validate: log any key that doesn't exist in the loaded settings object
			if ( settings && Object.keys( settings ).length ) {
				const mismatched = Object.keys( colors ).filter(
					function ( k ) { return ! Object.prototype.hasOwnProperty.call( settings, k ); }
				);
				if ( mismatched.length ) {
					// eslint-disable-next-line no-console
					console.warn( '[FlexBase Themes] Preset "' + id + '" — keys not in settings:', mismatched );
				}
			}

			onApply( colors );
		};

		return h( Fragment, null,
			h( 'p', { className: 'fb-themes-hint' },
				'Click a theme to instantly apply all colors. Then click Save Changes.'
			),
			h( 'div', { style: {
				display: 'flex',
				flexDirection: 'row',
				gap: '24px',
				flexWrap: 'wrap',
			} },
				Object.entries( PRESETS ).map( function ( entry ) {
					var id     = entry[ 0 ];
					var preset = entry[ 1 ];
					var c      = preset.colors;
					var active = selected === id;
					var primaryColor = c.color_primary || '#7c3aed';
					var shadowColor  = 'rgba(' + parseInt( primaryColor.slice(1,3), 16 ) + ',' + parseInt( primaryColor.slice(3,5), 16 ) + ',' + parseInt( primaryColor.slice(5,7), 16 ) + ',0.15)';
					return h( 'div', {
						key: id,
						style: {
							position: 'relative',
							width: '280px',
							backgroundColor: '#ffffff',
							border: active ? '2px solid ' + primaryColor : '1px solid #e5e7eb',
							borderRadius: '12px',
							padding: '16px',
							cursor: 'pointer',
							boxShadow: active ? '0 0 0 3px ' + shadowColor : '0 2px 8px rgba(0,0,0,0.08)',
						},
						onClick: function () { handleSelect( id ); },
					},
						// Checkmark badge on the currently active preset
						active && h( 'div', { className: 'fb-theme-card__badge' }, '✓' ),

						// ── Mockup div ──────────────────────────────────────────
						h( 'div', { style: {
							height: '140px',
							borderRadius: '8px',
							overflow: 'hidden',
							display: 'flex',
							flexDirection: 'column',
						} },
							// Topbar strip
							h( 'div', { style: {
								height: '20px',
								backgroundColor: c.topbar_bg_color,
							} } ),

							// Header bar
							h( 'div', { style: {
								height: '36px',
								backgroundColor: c.header_bg_color,
								display: 'flex',
								alignItems: 'center',
								padding: '0 12px',
								gap: '8px',
							} },
								// Colored dot (primary)
								h( 'div', { style: {
									width: '12px',
									height: '12px',
									borderRadius: '50%',
									backgroundColor: c.color_primary,
									flexShrink: 0,
								} } ),

								// 3 fake nav lines
								h( 'div', { style: {
									width: '30px',
									height: '6px',
									borderRadius: '3px',
									backgroundColor: '#e5e7eb',
									flexShrink: 0,
								} } ),
								h( 'div', { style: {
									width: '30px',
									height: '6px',
									borderRadius: '3px',
									backgroundColor: '#e5e7eb',
									flexShrink: 0,
								} } ),
								h( 'div', { style: {
									width: '30px',
									height: '6px',
									borderRadius: '3px',
									backgroundColor: '#e5e7eb',
									flexShrink: 0,
								} } )
							),

							// Content area
							h( 'div', { style: {
								flex: '1',
								backgroundColor: c.color_background,
								display: 'flex',
								flexDirection: 'column',
							} },
								// 3 fake text lines
								h( 'div', { style: {
									height: '6px',
									borderRadius: '3px',
									backgroundColor: '#e5e7eb',
									margin: '8px 12px',
								} } ),
								h( 'div', { style: {
									height: '6px',
									borderRadius: '3px',
									backgroundColor: '#e5e7eb',
									margin: '8px 12px',
								} } ),
								h( 'div', { style: {
									height: '6px',
									borderRadius: '3px',
									backgroundColor: '#e5e7eb',
									margin: '8px 12px',
									width: '60%',
								} } )
							),

							// Footer bar
							h( 'div', { style: {
								height: '28px',
								backgroundColor: c.footer_bg_color,
							} } )
						),

						// ── Card info ────────────────────────────────────────
						h( 'div', { style: { marginTop: '12px' } },
							h( 'div', { style: {
								fontWeight: '600',
								fontSize: '15px',
							} }, preset.label ),
							h( 'div', { style: {
								fontSize: '13px',
								color: '#6b7280',
								marginTop: '4px',
							} }, preset.description )
						)
					);
				} )
			)
		);
	}

	// ─── Tab: General ─────────────────────────────────────────────────────────────

	function GeneralTab( { s, set } ) {
		const fonts = Object.fromEntries(
			Object.entries( fontLabels || {} ).map( ( [ k, v ] ) => [ k, v ] )
		);

		return h( Fragment, null,
			h( SectionHeading, null, 'Brand Colors' ),
			h( Grid, { cols: 2 },
				h( ColorField, { label: 'Primary Color',    value: s.color_primary,    onChange: v => set( 'color_primary', v ) } ),
				h( ColorField, { label: 'Secondary Color',  value: s.color_secondary,  onChange: v => set( 'color_secondary', v ) } ),
				h( ColorField, { label: 'Background Color', value: s.color_background, onChange: v => set( 'color_background', v ) } ),
				h( ColorField, { label: 'Text Color',       value: s.color_text,       onChange: v => set( 'color_text', v ) } )
			),

			h( SectionHeading, null, 'Typography' ),
			h( Grid, { cols: 2 },
				h( SelectField, { label: 'Base Font',    value: s.font_base,    onChange: v => set( 'font_base', v ),    options: fonts, description: 'Body text and UI elements' } ),
				h( SelectField, { label: 'Heading Font', value: s.font_heading, onChange: v => set( 'font_heading', v ), options: fonts, description: 'H1–H6 headings' } )
			),

			h( SectionHeading, null, 'Layout' ),
			h( 'div', { className: 'fb-field' },
				h( 'label', { className: 'fb-field__label' }, 'Container Max-Width (px)' ),
				h( 'p', { className: 'fb-field__desc' }, 'Default: 1200. Range: 600–2560.' ),
				h( 'input', {
					type: 'number',
					value: s.container_width || 1200,
					min: 600, max: 2560, step: 10,
					onChange: e => set( 'container_width', parseInt( e.target.value, 10 ) || 1200 ),
					className: 'fb-input fb-input--number',
				} )
			)
		);
	}

	// ─── Tab: Header ─────────────────────────────────────────────────────────────

	function HeaderTab( { s, set } ) {
		return h( Fragment, null,
			h( SectionHeading, null, 'Logo' ),
			h( Grid, { cols: 2 },
				h( MediaField, {
					label: 'Header Logo',
					value: s.custom_logo,
					onChange: v => set( 'custom_logo', v ),
					previewKey: 'custom_logo',
					description: 'Recommended size: 250 × 80 px. Shared with Customizer → Site Identity.',
				} ),
				h( ToggleField, {
					label: 'Show Logo in Mobile Menu',
					value: s.mobile_menu_logo,
					onChange: v => set( 'mobile_menu_logo', v ),
					description: 'Displays the site logo at the top of the mobile menu panel',
				} )
			),

			h( SectionHeading, null, 'Header & Nav Colors' ),
			h( Grid, { cols: 4 },
				h( CompactColorField, { label: 'Background Color', value: s.header_bg_color,   onChange: v => set( 'header_bg_color', v ) } ),
				h( CompactColorField, { label: 'Nav Text',  value: s.header_text_color, onChange: v => set( 'header_text_color', v ) } ),
				h( CompactColorField, { label: 'Nav Hover', value: s.header_nav_hover,  onChange: v => set( 'header_nav_hover', v ) } ),
				h( CompactColorField, { label: 'Nav Active', value: s.header_nav_active, onChange: v => set( 'header_nav_active', v ) } )
			),

			h( SectionHeading, null, 'Nav Typography' ),
			h( Grid, { cols: 2 },
				h( SelectField, {
					label: 'Text Transform',
					value: s.header_nav_text_transform || 'none',
					onChange: v => set( 'header_nav_text_transform', v ),
					options: {
						'none': 'Default',
						'uppercase': 'Uppercase',
						'lowercase': 'Lowercase',
						'capitalize': 'Capitalize',
					}
				} ),
				h( Field, { label: 'Font Weight' },
					h( 'input', {
						type: 'number',
						value: s.header_nav_font_weight || 400,
						min: 100, max: 900, step: 100,
						onChange: e => set( 'header_nav_font_weight', parseInt( e.target.value, 10 ) || 400 ),
						className: 'fb-input fb-input--number',
					} )
				)
			),

			h( SectionHeading, null, 'Behavior' ),
			h( Grid, { cols: 2 },
				h( SelectField, {
					label: 'Sticky Mode',
					value: s.header_sticky,
					onChange: v => set( 'header_sticky', v ),
					options: STICKY_OPTIONS,
				} ),
				h( ToggleField, {
					label: 'Transparent Header',
					value: s.header_transparent,
					onChange: v => set( 'header_transparent', v ),
					description: 'Transparent at page top, solid on scroll',
				} )
			),

			s.header_transparent && h( Fragment, null,
				h( SectionHeading, null, 'Transparent Header Colors' ),
				h( 'p', { className: 'fb-field__desc' }, 'Applied while the header is transparent (before scroll).' ),
				h( Grid, { cols: 3 },
					h( ColorField, { label: 'Nav Text',  value: s.header_transparent_text,  onChange: v => set( 'header_transparent_text', v ) } ),
					h( ColorField, { label: 'Nav Hover', value: s.header_transparent_hover, onChange: v => set( 'header_transparent_hover', v ) } ),
					h( ColorField, { label: 'Nav Active', value: s.header_transparent_active, onChange: v => set( 'header_transparent_active', v ) } )
				)
			)
		);
	}

	// ─── Tab: Top Bar ─────────────────────────────────────────────────────────────

	function TopBarTab( { s, set } ) {
		return h( Fragment, null,
			h( SectionHeading, null, 'Structure' ),
			h( Grid, { cols: 3 },
				h( ToggleField, { label: 'Enable Top Bar', value: s.topbar_enable, onChange: v => set( 'topbar_enable', v ) } ),
				h( ToggleField, { label: 'Hide on Mobile', value: s.topbar_hide_mobile, onChange: v => set( 'topbar_hide_mobile', v ) } ),
				h( ToggleField, { label: 'Dismissible', value: s.topbar_dismissible, onChange: v => set( 'topbar_dismissible', v ), description: 'Show a close button. Dismissed state saved in localStorage.' } )
			),
			h( Grid, { cols: 3 },
				COLS.map( col =>
					h( SelectField, {
						key: col,
						label: COL_LABELS[ col ] + ' Content',
						value: s[ `topbar_${ col }_type` ],
						onChange: v => set( `topbar_${ col }_type`, v ),
						options: COL_TYPE_OPTIONS,
					} )
				)
			),

			h( SectionHeading, null, 'Colors' ),
			h( Grid, { cols: 3 },
				h( ColorField, { label: 'Background',      value: s.topbar_bg_color,   onChange: v => set( 'topbar_bg_color', v ) } ),
				h( ColorField, { label: 'Text Color',      value: s.topbar_text_color, onChange: v => set( 'topbar_text_color', v ) } ),
				h( ColorField, { label: 'Link / Icon',     value: s.topbar_link_color, onChange: v => set( 'topbar_link_color', v ) } )
			),

			...COLS.map( col =>
				h( Fragment, { key: col },
					h( SectionHeading, null, COL_LABELS[ col ] ),
					h( Grid, { cols: 3 },
						h( TextField, { label: 'Email',       value: s[ `topbar_${ col }_email` ], onChange: v => set( `topbar_${ col }_email`, v ), type: 'email', placeholder: 'info@example.com' } ),
						h( TextField, { label: 'Phone',       value: s[ `topbar_${ col }_phone` ], onChange: v => set( `topbar_${ col }_phone`, v ), placeholder: '+1 234 567 8900' } ),
						h( TextField, { label: 'Custom Text', value: s[ `topbar_${ col }_text` ],  onChange: v => set( `topbar_${ col }_text`, v ),  placeholder: 'Any text or HTML' } )
					)
				)
			)
		);
	}

	// ─── Tab: Buttons ────────────────────────────────────────────────────────────

	function ButtonsTab( { s, set } ) {
		return h( Fragment, null,
			h( SectionHeading, null, 'General' ),
			h( Grid, { cols: 1 },
				h( SelectField, { label: 'Button Style', value: s.nav_button_style, onChange: v => set( 'nav_button_style', v ), options: { 'link': 'Link', 'button': 'Button' }, description: 'Display Login and Signup as plain links or styled buttons' } )
			),

			h( SectionHeading, null, 'Login Button' ),
			h( Grid, { cols: 1 },
				h( ToggleField, { label: 'Enable Login',  value: s.nav_login_enable, onChange: v => set( 'nav_login_enable', v ), description: 'Show login link/button in header navigation' } )
			),
			s.nav_login_enable && h( Fragment, null,
				h( Grid, { cols: 2 },
					h( TextField, { label: 'Login Label', value: s.nav_login_label, onChange: v => set( 'nav_login_label', v ), placeholder: 'Login' } ),
					h( TextField, { label: 'Login URL', value: s.nav_login_url, onChange: v => set( 'nav_login_url', v ), type: 'url', placeholder: 'https://example.com/login' } )
				),
				h( Grid, { cols: 1 },
					h( TextField, { label: 'Logout URL', value: s.nav_logout_url, onChange: v => set( 'nav_logout_url', v ), type: 'url', placeholder: 'https://example.com/logout', description: 'URL to redirect to after logout' } )
				),
				h( SectionHeading, null, 'Login Button Styling' ),
				h( Grid, { cols: 3 },
					h( CompactColorField, { label: 'Background Color', value: s.nav_login_button_bg_color, onChange: v => set( 'nav_login_button_bg_color', v ) } ),
					h( CompactToggleField, { label: 'Transparent', value: s.nav_login_button_bg_transparent, onChange: v => set( 'nav_login_button_bg_transparent', v ) } ),
					h( CompactColorField, { label: 'Text Color', value: s.nav_login_button_text_color, onChange: v => set( 'nav_login_button_text_color', v ) } )
				),
				h( Grid, { cols: 3 },
					h( CompactColorField, { label: 'Border Color', value: s.nav_login_button_border_color, onChange: v => set( 'nav_login_button_border_color', v ) } ),
					h( CompactNumberField, { label: 'Border Width', value: s.nav_login_button_border_width, onChange: v => set( 'nav_login_button_border_width', parseInt( v, 10 ) || 0 ), min: 0, max: 10 } ),
					h( CompactNumberField, { label: 'Border Radius', value: s.nav_login_button_border_radius, onChange: v => set( 'nav_login_button_border_radius', parseInt( v, 10 ) || 6 ), min: 0, max: 50 } )
				),
				h( Grid, { cols: 3 },
					h( CompactColorField, { label: 'Hover Background', value: s.nav_login_button_hover_bg_color, onChange: v => set( 'nav_login_button_hover_bg_color', v ) } ),
					h( CompactColorField, { label: 'Hover Text', value: s.nav_login_button_hover_text_color, onChange: v => set( 'nav_login_button_hover_text_color', v ) } ),
					h( CompactColorField, { label: 'Hover Border', value: s.nav_login_button_hover_border_color, onChange: v => set( 'nav_login_button_hover_border_color', v ) } )
				),
				h( Grid, { cols: 3 },
					h( CompactTextField, { label: 'Width', value: s.nav_login_button_width, onChange: v => set( 'nav_login_button_width', v ), placeholder: 'auto' } ),
					h( CompactTextField, { label: 'Height', value: s.nav_login_button_height, onChange: v => set( 'nav_login_button_height', v ), placeholder: 'auto' } ),
					h( CompactTextField, { label: 'Padding', value: s.nav_login_button_padding, onChange: v => set( 'nav_login_button_padding', v ), placeholder: '0.5rem 1rem' } )
				)
			),

			h( SectionHeading, null, 'Signup Button' ),
			h( Grid, { cols: 1 },
				h( ToggleField, { label: 'Enable Signup', value: s.nav_signup_enable, onChange: v => set( 'nav_signup_enable', v ), description: 'Show signup link/button in header navigation' } )
			),
			s.nav_signup_enable && h( Fragment, null,
				h( Grid, { cols: 2 },
					h( TextField, { label: 'Signup Label', value: s.nav_signup_label, onChange: v => set( 'nav_signup_label', v ), placeholder: 'Sign Up' } ),
					h( TextField, { label: 'Signup URL', value: s.nav_signup_url, onChange: v => set( 'nav_signup_url', v ), type: 'url', placeholder: 'https://example.com/signup' } )
				),
				h( SectionHeading, null, 'Signup Button Styling' ),
				h( Grid, { cols: 3 },
					h( CompactColorField, { label: 'Background Color', value: s.nav_signup_button_bg_color, onChange: v => set( 'nav_signup_button_bg_color', v ) } ),
					h( CompactToggleField, { label: 'Transparent', value: s.nav_signup_button_bg_transparent, onChange: v => set( 'nav_signup_button_bg_transparent', v ) } ),
					h( CompactColorField, { label: 'Text Color', value: s.nav_signup_button_text_color, onChange: v => set( 'nav_signup_button_text_color', v ) } )
				),
				h( Grid, { cols: 3 },
					h( CompactColorField, { label: 'Border Color', value: s.nav_signup_button_border_color, onChange: v => set( 'nav_signup_button_border_color', v ) } ),
					h( CompactNumberField, { label: 'Border Width', value: s.nav_signup_button_border_width, onChange: v => set( 'nav_signup_button_border_width', parseInt( v, 10 ) || 0 ), min: 0, max: 10 } ),
					h( CompactNumberField, { label: 'Border Radius', value: s.nav_signup_button_border_radius, onChange: v => set( 'nav_signup_button_border_radius', parseInt( v, 10 ) || 6 ), min: 0, max: 50 } )
				),
				h( Grid, { cols: 3 },
					h( CompactColorField, { label: 'Hover Background', value: s.nav_signup_button_hover_bg_color, onChange: v => set( 'nav_signup_button_hover_bg_color', v ) } ),
					h( CompactColorField, { label: 'Hover Text', value: s.nav_signup_button_hover_text_color, onChange: v => set( 'nav_signup_button_hover_text_color', v ) } ),
					h( CompactColorField, { label: 'Hover Border', value: s.nav_signup_button_hover_border_color, onChange: v => set( 'nav_signup_button_hover_border_color', v ) } )
				),
				h( Grid, { cols: 3 },
					h( CompactTextField, { label: 'Width', value: s.nav_signup_button_width, onChange: v => set( 'nav_signup_button_width', v ), placeholder: 'auto' } ),
					h( CompactTextField, { label: 'Height', value: s.nav_signup_button_height, onChange: v => set( 'nav_signup_button_height', v ), placeholder: 'auto' } ),
					h( CompactTextField, { label: 'Padding', value: s.nav_signup_button_padding, onChange: v => set( 'nav_signup_button_padding', v ), placeholder: '0.5rem 1rem' } )
				)
			),

			h( SectionHeading, null, 'Language Switcher' ),
			h( Grid, { cols: 1 },
				h( ToggleField, { label: 'Enable Language Switcher', value: s.nav_language_switcher_enable, onChange: v => set( 'nav_language_switcher_enable', v ), description: 'Show language selector in header navigation' } )
			),
			s.nav_language_switcher_enable && h( Grid, { cols: 1 },
				h( ToggleField, { label: 'Show Flags', value: s.nav_language_switcher_flags, onChange: v => set( 'nav_language_switcher_flags', v ), description: 'Display flag icons for each language' } )
			),
			s.nav_language_switcher_enable && h( Grid, { cols: 1 },
				h( ToggleField, { label: 'Show Language Name', value: s.nav_language_switcher_name, onChange: v => set( 'nav_language_switcher_name', v ), description: 'Display full language name (e.g., "English")' } )
			),
			s.nav_language_switcher_enable && h( Grid, { cols: 1 },
				h( ToggleField, { label: 'Show Language Code', value: s.nav_language_switcher_code, onChange: v => set( 'nav_language_switcher_code', v ), description: 'Display language code (e.g., "EN")' } )
			)
		);
	}

	// ─── Tab: Mobile ─────────────────────────────────────────────────────────────

	function MobileTab( { s, set } ) {
		return h( Fragment, null,
			h( SectionHeading, null, 'Mobile Menu Colors' ),
			h( Grid, { cols: 3 },
				h( ColorField, { label: 'Background Color',  value: s.mobile_menu_bg_color,   onChange: v => set( 'mobile_menu_bg_color', v ) } ),
				h( ColorField, { label: 'Text Color',        value: s.mobile_menu_text_color, onChange: v => set( 'mobile_menu_text_color', v ) } ),
				h( ColorField, { label: 'Link Hover Color',  value: s.mobile_menu_link_hover, onChange: v => set( 'mobile_menu_link_hover', v ) } )
			),
			h( Grid, { cols: 3 },
				h( ColorField, { label: 'Active Link Background', value: s.mobile_menu_active_bg,   onChange: v => set( 'mobile_menu_active_bg', v ) } ),
				h( ColorField, { label: 'Active Link Text',       value: s.mobile_menu_active_text, onChange: v => set( 'mobile_menu_active_text', v ) } ),
				h( 'div', { className: 'fb-field' }, '' )
			),

			h( SectionHeading, null, 'Close Button Styling' ),
			h( Grid, { cols: 3 },
				h( CompactColorField, { label: 'Background', value: s.mobile_close_bg_color, onChange: v => set( 'mobile_close_bg_color', v ) } ),
				h( CompactColorField, { label: 'Icon Color', value: s.mobile_close_icon_color, onChange: v => set( 'mobile_close_icon_color', v ) } ),
				h( CompactColorField, { label: 'Border Color', value: s.mobile_close_border_color, onChange: v => set( 'mobile_close_border_color', v ) } )
			),
			h( Grid, { cols: 3 },
				h( CompactNumberField, { label: 'Border Width', value: s.mobile_close_border_width, onChange: v => set( 'mobile_close_border_width', parseInt( v, 10 ) || 0 ), min: 0, max: 10 } ),
				h( CompactNumberField, { label: 'Border Radius', value: s.mobile_close_border_radius, onChange: v => set( 'mobile_close_border_radius', parseInt( v, 10 ) || 8 ), min: 0, max: 50 } ),
				h( 'div', { className: 'fb-field fb-field--compact' }, '' )
			)
		);
	}

	// ─── Tab: Footer ─────────────────────────────────────────────────────────────

	function FooterTab( { s, set } ) {
		return h( Fragment, null,
			// ─── SECTION 0: Logo ────────────────────────────────────────────────────
			h( SectionHeading, null, 'Logo' ),
			h( Grid, { cols: 1 },
				h( MediaField, {
					label: 'Footer Logo',
					value: s.footer_logo,
					onChange: v => set( 'footer_logo', v ),
					previewKey: 'footer_logo',
					description: 'Separate logo for the footer. Falls back to the header logo.',
				} )
			),

			// ─── SECTION 1: Colors ──────────────────────────────────────────────────
			h( SectionHeading, null, 'Colors' ),
			h( Grid, { cols: 3 },
				h( ColorField, { label: 'Background', value: s.footer_bg_color, onChange: v => set( 'footer_bg_color', v ) } ),
				h( ColorField, { label: 'Text Color', value: s.footer_text_color, onChange: v => set( 'footer_text_color', v ) } ),
				h( ColorField, { label: 'Heading Color', value: s.footer_heading_color, onChange: v => set( 'footer_heading_color', v ) } )
			),
			h( Grid, { cols: 3 },
				h( CompactColorField, { label: 'Copyright Text', value: s.footer_copyright_text_color, onChange: v => set( 'footer_copyright_text_color', v ) } ),
				h( CompactColorField, { label: 'Powered By Color', value: s.footer_powered_by_color, onChange: v => set( 'footer_powered_by_color', v ) } ),
				h( 'div', { className: 'fb-field fb-field--compact' }, '' )
			),

			// ─── SECTION 2: Address ─────────────────────────────────────────────────
			h( SectionHeading, null, 'Address' ),
			h( TextareaField, { label: 'Address Text', value: s.footer_address, onChange: v => set( 'footer_address', v ), placeholder: '123 Main St\nCity, State 12345', rows: 3 } ),
			h( Grid, { cols: 2 },
				h( TextField, { label: 'Map URL', value: s.footer_contact_address_map_url, onChange: v => set( 'footer_contact_address_map_url', v ), type: 'url', placeholder: 'https://maps.google.com/...' } ),
				h( TextField, { label: 'Icon Class (FA)', value: s.footer_contact_address_icon, onChange: v => set( 'footer_contact_address_icon', v ), placeholder: 'fa-solid fa-location-dot' } )
			),
			h( Grid, { cols: 3 },
				h( CompactColorField, { label: 'Icon Color', value: s.footer_contact_address_icon_color, onChange: v => set( 'footer_contact_address_icon_color', v ) } ),
				h( CompactColorField, { label: 'Link Color', value: s.footer_contact_address_link_color, onChange: v => set( 'footer_contact_address_link_color', v ) } ),
				h( CompactColorField, { label: 'Hover Color', value: s.footer_contact_address_hover_color, onChange: v => set( 'footer_contact_address_hover_color', v ) } )
			),

			// ─── SECTION 3: Contact ─────────────────────────────────────────────────
			h( SectionHeading, null, 'Contact' ),
			h( Grid, { cols: 2 },
				h( TextField, { label: 'Email 1', value: s.footer_contact_email_1, onChange: v => set( 'footer_contact_email_1', v ), type: 'email', placeholder: 'email1@example.com' } ),
				h( TextField, { label: 'Email 2', value: s.footer_contact_email_2, onChange: v => set( 'footer_contact_email_2', v ), type: 'email', placeholder: 'email2@example.com' } )
			),
			h( Grid, { cols: 2 },
				h( CompactColorField, { label: 'Email Icon Color', value: s.footer_contact_email_icon_color, onChange: v => set( 'footer_contact_email_icon_color', v ) } ),
				h( CompactColorField, { label: 'Email Hover Color', value: s.footer_contact_email_hover_color, onChange: v => set( 'footer_contact_email_hover_color', v ) } )
			),
			h( Grid, { cols: 2 },
				h( TextField, { label: 'Phone 1', value: s.footer_contact_phone_1, onChange: v => set( 'footer_contact_phone_1', v ), placeholder: '+1 234 567 8900' } ),
				h( TextField, { label: 'Phone 2', value: s.footer_contact_phone_2, onChange: v => set( 'footer_contact_phone_2', v ), placeholder: '+1 234 567 8901' } )
			),
			h( Grid, { cols: 2 },
				h( CompactColorField, { label: 'Phone Icon Color', value: s.footer_contact_phone_icon_color, onChange: v => set( 'footer_contact_phone_icon_color', v ) } ),
				h( CompactColorField, { label: 'Phone Hover Color', value: s.footer_contact_phone_hover_color, onChange: v => set( 'footer_contact_phone_hover_color', v ) } )
			),

			// ─── SECTION 4: Social Icons ────────────────────────────────────────────
			h( SectionHeading, null, 'Social Icons' ),
			h( Grid, { cols: 2 },
				h( CompactColorField, { label: 'Icon Color', value: s.footer_social_icon_color, onChange: v => set( 'footer_social_icon_color', v ) } ),
				h( CompactColorField, { label: 'Icon Hover', value: s.footer_social_hover_color, onChange: v => set( 'footer_social_hover_color', v ) } )
			),
			h( Grid, { cols: 2 },
				h( CompactColorField, { label: 'Background Color', value: s.footer_social_icon_bg_color, onChange: v => set( 'footer_social_icon_bg_color', v ) } ),
				h( CompactColorField, { label: 'Background Hover', value: s.footer_social_icon_bg_hover_color, onChange: v => set( 'footer_social_icon_bg_hover_color', v ) } )
			),
			h( Grid, { cols: 2 },
				h( CompactColorField, { label: 'Border Color', value: s.footer_social_icon_border_color, onChange: v => set( 'footer_social_icon_border_color', v ) } ),
				h( CompactColorField, { label: 'Border Hover', value: s.footer_social_icon_border_hover_color, onChange: v => set( 'footer_social_icon_border_hover_color', v ) } )
			),
			h( Grid, { cols: 2 },
				h( CompactNumberField, { label: 'Border Width', value: s.footer_social_icon_border_width, onChange: v => set( 'footer_social_icon_border_width', parseInt( v, 10 ) || 0 ), min: 0, max: 10 } ),
				h( CompactNumberField, { label: 'Border Radius', value: s.footer_social_icon_border_radius, onChange: v => set( 'footer_social_icon_border_radius', parseInt( v, 10 ) || 8 ), min: 0, max: 50 } )
			),

			// ─── SECTION 5: Navigation ──────────────────────────────────────────────
			h( SectionHeading, null, 'Navigation' ),
			h( Grid, { cols: 2 },
				h( CompactColorField, { label: 'Nav Link Color', value: s.footer_link_color, onChange: v => set( 'footer_link_color', v ) } ),
				h( CompactColorField, { label: 'Nav Link Hover', value: s.footer_link_hover_color, onChange: v => set( 'footer_link_hover_color', v ) } )
			),

			// ─── SECTION 6: Copyright & Powered By ───────────────────────────────────
			h( SectionHeading, null, 'Copyright & Powered By' ),
			h( TextareaField, {
				label: 'Copyright Text',
				value: s.footer_copyright,
				onChange: v => set( 'footer_copyright', v ),
				placeholder: 'Leave empty for default "© Year Site Name"',
				rows: 2,
			} ),
			h( Grid, { cols: 2 },
				h( TextField, { label: 'Powered By Text', value: s.footer_powered_by_text, onChange: v => set( 'footer_powered_by_text', v ), placeholder: 'Powered by MyCompany' } ),
				h( TextField, { label: 'Powered By URL', value: s.footer_powered_by_url, onChange: v => set( 'footer_powered_by_url', v ), type: 'url', placeholder: 'https://example.com' } )
			),
			h( Grid, { cols: 2 },
				h( CompactColorField, { label: 'Powered By Color', value: s.footer_powered_by_color, onChange: v => set( 'footer_powered_by_color', v ) } ),
				h( 'div', { className: 'fb-field fb-field--compact' }, '' )
			)
		);
	}

	// ─── Tab: Social ─────────────────────────────────────────────────────────────

	function SocialTab( { s, set } ) {
		return h( Fragment, null,
			h( SectionHeading, null, 'Social Networks' ),
			h( 'p', { className: 'fb-field__desc fb-social-intro' },
				'Topbar and footer can have independent URLs. Icon FA class is shared.'
			),
			h( 'div', { className: 'fb-social-grid' },
				h( 'div', { className: 'fb-social-grid__head' },
					h( 'div', null ),
					h( 'div', null, 'Top Bar URL' ),
					h( 'div', null, 'Footer URL' ),
					h( 'div', null, 'Icon Class (FA)' )
				),
				NETWORKS.map( net =>
					h( 'div', { key: net, className: 'fb-social-grid__row' },
						h( 'div', { className: 'fb-social-grid__net' },
							h( 'i', { className: s[ `social_${ net }_icon` ] || FA_DEFAULTS[ net ], 'aria-hidden': 'true' } ),
							h( 'span', null, NETWORK_LABELS[ net ] )
						),
						h( 'div', null,
							h( 'input', {
								type: 'url',
								value: s[ `topbar_social_${ net }` ] || '',
								onChange: e => set( `topbar_social_${ net }`, e.target.value ),
								placeholder: 'https://',
								className: 'fb-input fb-input--sm',
							} )
						),
						h( 'div', null,
							h( 'input', {
								type: 'url',
								value: s[ `footer_social_${ net }` ] || '',
								onChange: e => set( `footer_social_${ net }`, e.target.value ),
								placeholder: 'https://',
								className: 'fb-input fb-input--sm',
							} )
						),
						h( 'div', null,
							h( 'input', {
								type: 'text',
								value: s[ `social_${ net }_icon` ] || '',
								onChange: e => set( `social_${ net }_icon`, e.target.value ),
								placeholder: FA_DEFAULTS[ net ],
								className: 'fb-input fb-input--sm fb-input--mono',
								spellCheck: false,
							} )
						)
					)
				)
			)
		);
	}

	// ─── Main App ─────────────────────────────────────────────────────────────────

	function App() {
		const [ tab,     setTab     ] = useState( 'general' );
		const [ settings, setAllSettings ] = useState( {} );
		const [ status,  setStatus  ] = useState( 'idle' ); // idle | loading | saving | saved | error
		const [ loaded,  setLoaded  ] = useState( false );

		useEffect( () => {
			setStatus( 'loading' );
			apiFetch( { url: restUrl } )
				.then( data => {
					setAllSettings( data );
					setLoaded( true );
					setStatus( 'idle' );
				} )
				.catch( () => {
					setLoaded( true );
					setStatus( 'idle' );
				} );
		}, [] );

		const set = useCallback( ( key, value ) => {
			setAllSettings( prev => ( { ...prev, [ key ]: value } ) );
		}, [] );

		const setMany = useCallback( ( updates ) => {
			setAllSettings( prev => ( { ...prev, ...updates } ) );
		}, [] );

		const save = useCallback( () => {
			setStatus( 'saving' );
			apiFetch( { url: restUrl, method: 'POST', data: settings } )
				.then( saved => {
					setAllSettings( saved );
					setStatus( 'saved' );
					setTimeout( () => setStatus( 'idle' ), 2500 );
				} )
				.catch( () => {
					setStatus( 'error' );
					setTimeout( () => setStatus( 'idle' ), 3000 );
				} );
		}, [ settings ] );

		const saving = status === 'saving';

		if ( ! loaded ) {
			return h( 'div', { className: 'fb-loading' },
				h( 'span', { className: 'fb-spinner' } ),
				'Loading settings…'
			);
		}

		const tabPanels = {
			themes:     h( ThemesTab,     { onApply: setMany, settings: settings } ),
			general:    h( GeneralTab,    { s: settings, set } ),
			header:     h( HeaderTab,     { s: settings, set } ),
			topbar:     h( TopBarTab,     { s: settings, set } ),
			buttons:    h( ButtonsTab,    { s: settings, set } ),
			mobile:     h( MobileTab,     { s: settings, set } ),
			footer:     h( FooterTab,     { s: settings, set } ),
			social:     h( SocialTab,     { s: settings, set } ),
		};

		return h( 'div', { className: 'fb-wrap' },

			// ── Header ────────────────────────────────────────────────────────────
			h( 'div', { className: 'fb-header' },
				h( 'div', { className: 'fb-header__title' },
					h( 'span', { className: 'dashicons dashicons-layout fb-header__icon' } ),
					'FlexBase Settings'
				),
				h( 'div', { className: 'fb-header__actions' },
					status === 'saved' && h( 'span', { className: 'fb-status fb-status--ok'  }, '✓ Saved' ),
					status === 'error' && h( 'span', { className: 'fb-status fb-status--err' }, '✕ Error' ),
					h( 'button', {
						className: 'fb-btn-save' + ( saving ? ' fb-btn-save--busy' : '' ),
						onClick: save,
						disabled: saving,
					},
						saving
							? h( Fragment, null, h( 'span', { className: 'fb-spinner fb-spinner--sm' } ), ' Saving…' )
							: 'Save Changes'
					)
				)
			),

			// ── Tabs ──────────────────────────────────────────────────────────────
			h( 'div', { className: 'fb-tabs' },
				TABS.map( t =>
					h( 'button', {
						key: t.id,
						className: 'fb-tab' + ( tab === t.id ? ' fb-tab--active' : '' ),
						onClick: () => setTab( t.id ),
					}, t.label )
				)
			),

			// ── Body ──────────────────────────────────────────────────────────────
			h( 'div', { className: 'fb-body' },
				tabPanels[ tab ]
			)
		);
	}

	// ─── Mount ────────────────────────────────────────────────────────────────────

	const root = document.getElementById( 'flexbase-settings-root' );
	if ( root ) {
		if ( typeof wp.element.createRoot === 'function' ) {
			wp.element.createRoot( root ).render( h( App ) );
		} else {
			wp.element.render( h( App ), root );
		}
	}
} )();
