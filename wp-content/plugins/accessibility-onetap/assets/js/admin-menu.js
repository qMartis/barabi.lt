/* eslint no-undef: "off", no-alert: "off" */
( function( $ ) {
	// Event handler for click on label within icon settings group
	$( '.settings-group.icons .boxes .box label' ).on( 'click', function() {
		// Get the image URL from the img element inside the clicked label
		const getIcon = $( this ).children().attr( 'src' );

		// Update the image in size settings group with the selected image
		$( '.settings-group.size .boxes .box label img' ).attr( 'src', getIcon );

		// Update the image in border settings group with the selected image
		$( '.settings-group.border .boxes .box label img' ).attr( 'src', getIcon );
		$( '.sidebar-preview .preview-viewport button img' ).attr( 'src', getIcon );
	} );

	$( '.settings-group.size .boxes .box label' ).on( 'click', function() {
		if ( 'design-size1' === $( this ).find( 'input' ).val() ) {
			$( '.sidebar-preview .preview-viewport button img' ).css( {
				padding: '10px',
				width: '50px',
				height: '50px',
			} );
		} else if ( 'design-size2' === $( this ).find( 'input' ).val() ) {
			$( '.sidebar-preview .preview-viewport button img' ).css( {
				padding: '15px',
				width: '65px',
				height: '65px',
			} );
		} else if ( 'design-size3' === $( this ).find( 'input' ).val() ) {
			$( '.sidebar-preview .preview-viewport button img' ).css( {
				padding: '17.5px',
				width: '80px',
				height: '80px',
			} );
		} else {
			$( '.sidebar-preview .preview-viewport button img' ).css( {
				padding: '15px',
				width: '65px',
				height: '65px',
			} );
		}
	} );

	$( '.settings-group.border .boxes .box label' ).on( 'click', function() {
		const OutlineColor = $( '.settings-group.color .box1' ).attr( 'style' );

		// Extract color value from CSS custom property
		const colorMatch = OutlineColor ? OutlineColor.match( /--outline-color:\s*(#[0-9a-fA-F]{6}|#[0-9a-fA-F]{3})/ ) : null;
		const colorValue = colorMatch ? colorMatch[ 1 ] : null;

		if ( 'design-border1' === $( this ).find( 'input' ).val() ) {
			$( '.sidebar-preview .preview-viewport button img' ).css( {
				border: 'solid 2px #fff',
				'box-shadow': '0 0 0 4px ' + colorValue,
			} );
		} else if ( 'design-border2' === $( this ).find( 'input' ).val() ) {
			$( '.sidebar-preview .preview-viewport button img' ).css( {
				border: 'none',
				'box-shadow': 'none',
			} );
		} else {
			$( '.sidebar-preview .preview-viewport button img' ).css( {
				border: 'none',
				'box-shadow': 'none',
			} );
		}
	} );

	// Predefined color options
	$( '.settings-group.color .box3 ul li' ).on( 'click', function() {
		const selectedColor = $( this ).data( 'color' );
		$( '.sidebar-preview .preview-viewport button img' ).css( {
			'background-color': selectedColor,
		} );

		$( '.setting-control.radio-image .boxes .box label img' ).css( {
			'background-color': selectedColor,
		} );

		if ( 'design-border1' === $( '.settings-group.border .boxes .box label input' ).val() ) {
			$( '.sidebar-preview .preview-viewport button img' ).css( {
				border: 'solid 2px #fff',
				'box-shadow': '0 0 0 4px ' + selectedColor,
			} );

			$( '.settings-group.border .setting-control.radio-image .boxes .box1 label img' ).css( {
				border: 'solid 2px #fff',
				'box-shadow': '0 0 0 4px ' + selectedColor,
			} );
		} else if ( 'design-border2' === $( '.settings-group.border .boxes .box label input' ).val() ) {
			$( '.sidebar-preview .preview-viewport button img' ).css( {
				border: 'none',
				'box-shadow': 'none',
			} );
		}

		$( '.settings-group.color .color-result' ).text( selectedColor );
		$( '.settings-group.color .wp-color-picker' ).val( selectedColor ).trigger( 'change' );
	} );

	/**
	 * Widget position functionality - refactored for efficiency
	 * Handles position changes for all device types (desktop, tablet, mobile)
	 */

	// Position styles configuration object
	const positionStyles = {
		'top-right': {
			bottom: '83%',
			'margin-top': '40px',
			right: '0',
			'margin-right': '40px',
		},
		'top-left': {
			bottom: '83%',
			'margin-top': '40px',
			left: '0',
			'margin-left': '40px',
		},
		'middle-right': {
			right: '0',
			'margin-right': '40px',
			bottom: '50%',
			'margin-bottom': '40px',
		},
		'middle-left': {
			left: '0',
			'margin-left': '40px',
			bottom: '50%',
			'margin-bottom': '40px',
		},
		'bottom-right': {
			right: '0',
			'margin-right': '40px',
			bottom: '0',
			'margin-bottom': '40px',
		},
		'bottom-left': {
			left: '0',
			'margin-left': '40px',
			bottom: '0',
			'margin-bottom': '40px',
		},
	};

	// Reset styles object
	const resetStyles = {
		top: '',
		right: '',
		bottom: '',
		left: '',
		'margin-top': '',
		'margin-right': '',
		'margin-bottom': '',
		'margin-left': '',
	};

	/**
	 * Update widget position for specific device
	 * @param {string} selectedPosition - The selected position value
	 * @param {string} deviceType       - The device type (desktop, tablet, mobile)
	 */
	function updateWidgetPosition( selectedPosition, deviceType ) {
		const $previewButton = $( `.sidebar-preview .viewport-${ deviceType } button` );

		// Reset all position styles first
		$previewButton.css( resetStyles );

		// Apply position styles based on selection
		if ( positionStyles[ selectedPosition ] ) {
			$previewButton.css( positionStyles[ selectedPosition ] );
		}
	}

	// Event listeners for all device types
	$( '.settings-group.widge-position.desktop select' ).on( 'change', function() {
		const selectedPosition = $( this ).val();
		updateWidgetPosition( selectedPosition, 'desktop' );

		// Trigger position adjustments when widget position changes
		const topBottomValue = $( '.settings-group.position-top-bottom.desktop input' ).val();
		const leftRightValue = $( '.settings-group.position-left-right.desktop input' ).val();

		if ( topBottomValue ) {
			updatePosition( 'desktop', 'top-bottom', topBottomValue );
		}
		if ( leftRightValue ) {
			updatePosition( 'desktop', 'left-right', leftRightValue );
		}
	} );

	$( '.settings-group.widge-position-tablet.tablet select' ).on( 'change', function() {
		const selectedPosition = $( this ).val();
		updateWidgetPosition( selectedPosition, 'tablet' );

		// Trigger position adjustments when widget position changes
		const topBottomValue = $( '.settings-group.position-top-bottom-tablet.tablet input' ).val();
		const leftRightValue = $( '.settings-group.position-left-right-tablet.tablet input' ).val();

		if ( topBottomValue ) {
			updatePosition( 'tablet', 'top-bottom', topBottomValue );
		}
		if ( leftRightValue ) {
			updatePosition( 'tablet', 'left-right', leftRightValue );
		}
	} );

	$( '.settings-group.widge-position-mobile.mobile select' ).on( 'change', function() {
		const selectedPosition = $( this ).val();
		updateWidgetPosition( selectedPosition, 'mobile' );

		// Trigger position adjustments when widget position changes
		const topBottomValue = $( '.settings-group.position-top-bottom-mobile.mobile input' ).val();
		const leftRightValue = $( '.settings-group.position-left-right-mobile.mobile input' ).val();

		if ( topBottomValue ) {
			updatePosition( 'mobile', 'top-bottom', topBottomValue );
		}
		if ( leftRightValue ) {
			updatePosition( 'mobile', 'left-right', leftRightValue );
		}
	} );

	/**
	 * Position adjustment functionality - refactored for efficiency
	 * Handles top-bottom and left-right positioning for all device types
	 */

	/**
	 * Update position based on input value and widget position
	 * @param {string} deviceType - The device type (desktop, tablet, mobile)
	 * @param {string} direction  - The direction (top-bottom or left-right)
	 * @param {number} value      - The input value
	 */
	function updatePosition( deviceType, direction, value ) {
		// Get the correct selector for widget position based on device type
		let widgetPositionSelector;
		if ( deviceType === 'desktop' ) {
			widgetPositionSelector = `.settings-group.widge-position.${ deviceType } select`;
		} else if ( deviceType === 'tablet' ) {
			widgetPositionSelector = `.settings-group.widge-position-tablet.${ deviceType } select`;
		} else if ( deviceType === 'mobile' ) {
			widgetPositionSelector = `.settings-group.widge-position-mobile.${ deviceType } select`;
		}

		const selectedPosition = $( widgetPositionSelector ).val();

		// Device-specific configuration with separate multipliers for each direction
		const deviceConfig = {
			desktop: {
				leftRight: {
					baseValue: 20,
					multiplier: 0.8,
				},
				topBottom: {
					baseValue: 40,
					multiplier: 1.1,
				},
			},
			tablet: {
				leftRight: {
					baseValue: 230,
					multiplier: 1,
				},
				topBottom: {
					baseValue: 20,
					multiplier: 1.1,
				},
			},
			mobile: {
				leftRight: {
					baseValue: 325,
					multiplier: 1.1,
				},
				topBottom: {
					baseValue: 15,
					multiplier: 1,
				},
			},
		};

		// Get configuration for current device
		const config = deviceConfig[ deviceType ];
		if ( ! config ) {
			console.warn( `No configuration found for device type: ${ deviceType }` );
			return;
		}

		// Calculate values based on direction
		let calculatedValue;
		if ( direction === 'left-right' ) {
			calculatedValue = ( config.leftRight.baseValue + ( parseInt( value ) * config.leftRight.multiplier ) ) + 'px';
		} else if ( direction === 'top-bottom' ) {
			calculatedValue = ( config.topBottom.baseValue + ( parseInt( value ) * config.topBottom.multiplier ) ) + 'px';
		} else {
			console.warn( `Invalid direction: ${ direction }` );
			return;
		}

		const $previewButton = $( `.sidebar-preview .viewport-${ deviceType } button` );

		if ( direction === 'top-bottom' ) {
			// Handle top-bottom positioning (half values)
			if ( selectedPosition && selectedPosition.includes( 'top' ) ) {
				$previewButton.css( {
					'margin-top': calculatedValue,
					top: 0,
				} );
			} else {
				$previewButton.css( 'margin-bottom', calculatedValue );
			}
		} else if ( direction === 'left-right' ) {
			// Handle left-right positioning (full values)
			if ( selectedPosition && selectedPosition.includes( 'left' ) ) {
				$previewButton.css( {
					'margin-left': calculatedValue,
					left: 0,
				} );
			} else {
				$previewButton.css( 'margin-right', calculatedValue );
			}
		}
	}

	/**
	 * Toggle button visibility for specific device
	 * @param {string}  deviceType - The device type (desktop, tablet, mobile)
	 * @param {boolean} isChecked  - Whether the checkbox is checked
	 */
	function toggleButtonVisibility( deviceType, isChecked ) {
		const $previewButton = $( `.sidebar-preview .viewport-${ deviceType } button` );
		$previewButton.css( 'display', isChecked ? 'none' : 'block' );
	}

	// Event listeners for position adjustments
	$( '.settings-group.position-top-bottom.desktop input' ).on( 'change', function() {
		updatePosition( 'desktop', 'top-bottom', $( this ).val() );
	} );

	$( '.settings-group.position-top-bottom-tablet.tablet input' ).on( 'change', function() {
		updatePosition( 'tablet', 'top-bottom', $( this ).val() );
	} );

	$( '.settings-group.position-top-bottom-mobile.mobile input' ).on( 'change', function() {
		updatePosition( 'mobile', 'top-bottom', $( this ).val() );
	} );

	$( '.settings-group.position-left-right.desktop input' ).on( 'change', function() {
		updatePosition( 'desktop', 'left-right', $( this ).val() );
	} );

	$( '.settings-group.position-left-right-tablet.tablet input' ).on( 'change', function() {
		updatePosition( 'tablet', 'left-right', $( this ).val() );
	} );

	$( '.settings-group.position-left-right-mobile.mobile input' ).on( 'change', function() {
		updatePosition( 'mobile', 'left-right', $( this ).val() );
	} );

	// Event listeners for toggle visibility
	$( '.settings-group.toggle-device-position-desktop input' ).on( 'change', function() {
		toggleButtonVisibility( 'desktop', $( this ).is( ':checked' ) );
	} );

	$( '.settings-group.toggle-device-position-tablet.tablet input' ).on( 'change', function() {
		toggleButtonVisibility( 'tablet', $( this ).is( ':checked' ) );
	} );

	$( '.settings-group.toggle-device-position-mobile.mobile input' ).on( 'change', function() {
		toggleButtonVisibility( 'mobile', $( this ).is( ':checked' ) );
	} );

	/**
	 * Handle company website input focus/blur events
	 * Adds/removes focus class to protocol element for visual feedback
	 */
	function initCompanyWebsiteInput() {
		const $input = $( '#company_website' );
		const $protocol = $( '.protocol' );

		$input.on( 'focus', function() {
			$protocol.addClass( 'focus' );
		} );

		$input.on( 'blur', function() {
			$protocol.removeClass( 'focus' );
		} );
	}

	// Initialize company website input functionality
	initCompanyWebsiteInput();

	/**
	 * Initialize positions and visibility on page load
	 * Apply current settings when the page is loaded
	 */
	$( document ).ready( function() {
		const outlineColor = $( '.settings-group.color .box1' ).attr( 'style' );
		const colorMatch = outlineColor ? outlineColor.match( /--outline-color:\s*(#[0-9a-fA-F]{6}|#[0-9a-fA-F]{3})/ ) : null;
		const colorValue = colorMatch ? colorMatch[ 1 ] : null;

		// Get URL parameter and show corresponding element
		const urlParams = new URLSearchParams( window.location.search );
		const pageParam = urlParams.get( 'page' );

		if ( pageParam ) {
			// Convert hyphens to underscores for CSS ID selector compatibility
			let elementId = pageParam.replace( /-/g, '_' );

			// If contains "accessibility_onetap", remove only the "accessibility_" part
			if ( elementId.includes( 'accessibility_onetap' ) ) {
				elementId = elementId.replace( 'accessibility_', '' );
			}

			// Show the element with the converted ID
			$( `#${ elementId }` ).fadeIn( 400 );
			if ( 'apop_settings' === elementId || 'onetap_settings' === elementId ) {
				$( '.sidebar-preview' ).fadeIn( 400 );
			}

			if ( 'apop_accessibility_status' === elementId || 'accessibility-onetap-accessibility-status' === elementId ) {
				$( '#apop-accessibility-status' ).fadeIn( 400 );
			}
		}

		// Initialize widget positions for all devices
		[ 'desktop', 'tablet', 'mobile' ].forEach( function( deviceType ) {
			// Get the correct selector for widget position based on device type
			let widgetPositionSelector;
			if ( deviceType === 'desktop' ) {
				widgetPositionSelector = `.settings-group.widge-position.${ deviceType } select`;
			} else if ( deviceType === 'tablet' ) {
				widgetPositionSelector = `.settings-group.widge-position-tablet.${ deviceType } select`;
			} else if ( deviceType === 'mobile' ) {
				widgetPositionSelector = `.settings-group.widge-position-mobile.${ deviceType } select`;
			}

			const selectedPosition = $( widgetPositionSelector ).val();
			if ( selectedPosition ) {
				updateWidgetPosition( selectedPosition, deviceType );
			}

			// Initialize position adjustments
			let topBottomValue, leftRightValue;

			if ( deviceType === 'desktop' ) {
				topBottomValue = $( `.settings-group.position-top-bottom.${ deviceType } input` ).val();
				leftRightValue = $( `.settings-group.position-left-right.${ deviceType } input` ).val();
			} else if ( deviceType === 'tablet' ) {
				topBottomValue = $( `.settings-group.position-top-bottom-tablet.tablet input` ).val();
				leftRightValue = $( `.settings-group.position-left-right-tablet.tablet input` ).val();
			} else if ( deviceType === 'mobile' ) {
				topBottomValue = $( `.settings-group.position-top-bottom-mobile.mobile input` ).val();
				leftRightValue = $( `.settings-group.position-left-right-mobile.mobile input` ).val();
			}

			if ( topBottomValue ) {
				updatePosition( deviceType, 'top-bottom', topBottomValue );
			}
			if ( leftRightValue ) {
				updatePosition( deviceType, 'left-right', leftRightValue );
			}

			// Initialize toggle visibility
			const isChecked = $( `.settings-group.toggle-device-position-${ deviceType } input` ).is( ':checked' );
			toggleButtonVisibility( deviceType, isChecked );
		} );

		// Initialize size settings
		const selectedSize = $( '.settings-group.size .boxes .box input[type="radio"]:checked' ).val();
		if ( selectedSize ) {
			if ( 'design-size1' === selectedSize ) {
				$( '.sidebar-preview .preview-viewport button img' ).css( {
					padding: '10px',
					width: '50px',
					height: '50px',
				} );
			} else if ( 'design-size2' === selectedSize ) {
				$( '.sidebar-preview .preview-viewport button img' ).css( {
					padding: '15px',
					width: '65px',
					height: '65px',
				} );
			} else if ( 'design-size3' === selectedSize ) {
				$( '.sidebar-preview .preview-viewport button img' ).css( {
					padding: '17.5px',
					width: '80px',
					height: '80px',
				} );
			} else {
				$( '.sidebar-preview .preview-viewport button img' ).css( {
					padding: '15px',
					width: '65px',
					height: '65px',
				} );
			}
		}

		// Initialize color settings
		if ( colorValue ) {
			$( '.sidebar-preview .preview-frame .preview-container .preview-viewport button img' ).css( {
				'background-color': colorValue,
			} );

			$( '.setting-control.radio-image .boxes .box label img' ).css( {
				'background-color': colorValue,
			} );

			$( '.settings-group.border .boxes .box1 img' ).css( {
				'box-shadow': '0 0 0 4px ' + colorValue,
			} );
		}

		// Initialize border settings
		const selectedBorder = $( '.settings-group.border .boxes .box input[type="radio"]:checked' ).val();
		if ( selectedBorder ) {
			if ( 'design-border1' === selectedBorder ) {
				$( '.sidebar-preview .preview-viewport button img' ).css( {
					border: 'solid 2px #fff',
					'box-shadow': '0 0 0 4px ' + colorValue,
					'background-color': colorValue,
				} );
			} else if ( 'design-border2' === selectedBorder ) {
				$( '.sidebar-preview .preview-viewport button img' ).css( {
					border: 'none',
					'box-shadow': 'none',
				} );
			} else {
				$( '.sidebar-preview .preview-viewport button img' ).css( {
					border: 'none',
					'box-shadow': 'none',
				} );
			}
		}
	} );

	// Get the src attribute from the currently selected/checked icon
	const checkedIcon = $( '.settings-group.icons .boxes .box input[type="radio"]:checked' ).closest( 'label' ).find( 'img' ).attr( 'src' );

	// If a checked icon is found, update the size and border settings with the same icon
	if ( checkedIcon ) {
		// Update the image in size settings group to match the selected icon
		$( '.settings-group.size .boxes .box label img' ).attr( 'src', checkedIcon );
		// Update the image in border settings group to match the selected icon
		$( '.settings-group.border .boxes .box label img' ).attr( 'src', checkedIcon );
	}

	// Device configuration for settings visibility
	const deviceConfig = [
		{
			device: 'desktop',
			checkbox: $( 'input[name="onetap_settings[toggle-device-position-desktop]"]' ),
			elements: [
				$( '.settings-group.widge-position.desktop' ),
				$( '.settings-group.position-top-bottom.desktop' ),
				$( '.settings-group.position-left-right.desktop' ),
			],
		},
		{
			device: 'tablet',
			checkbox: $( 'input[name="onetap_settings[toggle-device-position-tablet]"]' ),
			elements: [
				$( '.settings-group.widge-position-tablet.tablet' ),
				$( '.settings-group.position-top-bottom-tablet.tablet' ),
				$( '.settings-group.position-left-right-tablet.tablet' ),
			],
		},
		{
			device: 'mobile',
			checkbox: $( 'input[name="onetap_settings[toggle-device-position-mobile]"]' ),
			elements: [
				$( '.settings-group.widge-position-mobile.mobile' ),
				$( '.settings-group.position-top-bottom-mobile.mobile' ),
				$( '.settings-group.position-left-right-mobile.mobile' ),
			],
		},
	];

	// Generic function to toggle device settings visibility
	function toggleDeviceSettings( config ) {
		const isChecked = config.checkbox.is( ':checked' );
		const action = isChecked ? 'addClass' : 'removeClass';

		// Toggle visibility for all elements in this device config
		// If checkbox is checked, hide elements (add 'hide' class)
		// If checkbox is unchecked, show elements (remove 'hide' class)
		config.elements.forEach( ( element ) => {
			element[ action ]( 'hide' );
		} );
	}

	// Initialize settings visibility on page load
	deviceConfig.forEach( ( config ) => {
		toggleDeviceSettings( config );

		// Add event listener for checkbox changes
		config.checkbox.on( 'change', function() {
			toggleDeviceSettings( config );
		} );
	} );

	/**
	 * Positions the badge based on the width of the selected text in the dropdown
	 */
	function positionBadge() {
		// Get the select element and the selected text
		const $select = $( 'select[name="onetap_settings[language]"]' );
		const selectedText = $select.find( 'option:selected' ).text();

		// Create a dummy element to measure the width of the selected text
		const $temp = $( '<span>' ).text( selectedText ).css( {
			position: 'absolute',
			visibility: 'hidden',
			'white-space': 'nowrap',
			'font-family': $select.css( 'font-family' ),
			'font-size': $select.css( 'font-size' ),
			'font-weight': $select.css( 'font-weight' ),
		} ).appendTo( 'body' );

		// Get the measured text width
		const textWidth = $temp.width();
		// Remove the dummy element from DOM
		$temp.remove();

		// Apply styles to .badge with the correct position
		$select.closest( '.settings-group.language .box1' ).find( '.badge' ).css( {
			left: textWidth + 23 + 'px', // 23px is additional offset
			display: 'inline-block',
		} );
	}

	// Call when page loads for initial position
	positionBadge();

	// Call when select changes to update badge position
	$( 'select[name="onetap_settings[language]"]' ).on( 'change', function() {
		positionBadge();
	} );

	// Call the function to apply the active language labels
	getActiveLanguage();
	function getActiveLanguage() {
		// Check if the global object 'adminLocalize' and required properties exist
		if (
			typeof adminLocalize !== 'undefined' &&
			typeof adminLocalize.activeLanguage === 'string' &&
			adminLocalize.activeLanguage.trim() !== '' &&
			typeof adminLocalize.localizedLabels === 'object' &&
			adminLocalize.localizedLabels.hasOwnProperty( adminLocalize.activeLanguage )
		) {
			// Get the currently active language
			const activeLanguage = adminLocalize.activeLanguage;

			// Get the localized labels for the active language
			const labels = adminLocalize.localizedLabels[ activeLanguage ];

			// Loop through each label key
			for ( const key in labels ) {
				if ( labels.hasOwnProperty( key ) ) {
					// Find the input element with the corresponding class and set its value
					$( '.admin_page_apop-module-labels input.' + key ).attr( 'value', labels[ key ] );
				}
			}
		}
	}

	// Get the currently active language from the localized admin data
	const activeLanguage = adminLocalize.activeLanguage;
	if ( activeLanguage ) {
		// Get the display name (text) of the active language
		const languageName = $( `.current-language li[data-language="${ activeLanguage }"]` ).text();

		// Get the image source URL for the active language icon
		const languageImageSrc = $( `.current-language li[data-language="${ activeLanguage }"] img` ).attr( 'src' );

		// If both the language name and image source exist, update the UI accordingly
		if ( languageName && languageImageSrc ) {
			$( 'a.current-language .text strong' ).text( languageName );
			$( 'a.current-language .image img.active' ).attr( 'src', languageImageSrc );
			$( 'a.current-language' ).show();
		}
	}

	/**
	 * Copy content from a TinyMCE editor or textarea and give visual feedback.
	 *
	 * @param {string} editorId - The ID of the TinyMCE editor or textarea.
	 * @param {jQuery} $button  - The jQuery object for the copy button.
	 */
	$( '.copy' ).on( 'click', function() {
		const editorId = 'editor_generator';
		let content = '';

		// Try to get content from TinyMCE editor if available
		if ( typeof tinymce !== 'undefined' && tinymce.get( editorId ) ) {
			content = tinymce.get( editorId ).getContent();
		} else {
			// Fallback to plain textarea value if TinyMCE is not available
			content = $( '#' + editorId ).val();
		}

		const $button = $( this ); // The copy button element
		const $textElement = $button.find( '.copy-text' ); // The span that holds the button text
		const originalText = $button.data( 'default-text' ) || 'Copy'; // Default button text
		const copiedText = $button.data( 'copied-text' ) || 'Copied!'; // Text shown after copying

		// Copy the editor content to clipboard
		navigator.clipboard.writeText( content ).then( () => {
			// Update the button UI to show 'Copied!' and apply visual feedback
			$textElement.text( copiedText );
			$button.addClass( 'copied' );

			// Reset the button UI after 2 seconds
			setTimeout( () => {
				$textElement.text( originalText );
				$button.removeClass( 'copied' );
			}, 2000 );
		} );
	} );

	/**
	 * Initialize form validation and interactivity for the Accessibility Statement form.
	 *
	 * This function:
	 * - Caches relevant form elements.
	 * - Validates input fields and checkbox in real-time.
	 * - Enables or disables the submit button based on validation.
	 * - Prevents form submission if validation fails.
	 *
	 * Assumes the DOM is already loaded before this function is called.
	 */
	function handleAccessibilityStatusForm() {
		// Cache selectors to avoid querying the DOM repeatedly
		const $selectLanguage = $( 'select[name="onetap_select_language"]' );
		const $companyName = $( 'input[name="onetap_company_name"]' );
		const $companyWebsite = $( 'input[name="onetap_company_website"]' );
		const $businessEmail = $( 'input[name="onetap_business_email"]' );
		const $confirmationCheckbox = $( 'input[name="onetap_confirmation_checkbox"]' );
		const $submitButton = $( 'button.save-changes.generate-accessibility-statement' );

		// Function to check if all form fields are valid
		function checkFormFields() {
			const selectLanguage = ( $selectLanguage.val() || '' ).trim();
			const companyName = ( $companyName.val() || '' ).trim();
			const companyWebsite = ( $companyWebsite.val() || '' ).trim();
			const businessEmail = ( $businessEmail.val() || '' ).trim();
			const confirm = $confirmationCheckbox.is( ':checked' );

			// Enable or disable the submit button based on input validation
			if ( selectLanguage && companyName && companyWebsite && businessEmail && confirm ) {
				$submitButton.addClass( 'active' );
			} else {
				$submitButton.removeClass( 'active' );
			}
		}

		// Attach event listeners for inputs and checkbox
		$selectLanguage.on( 'input', checkFormFields );
		$companyName.on( 'input', checkFormFields );
		$companyWebsite.on( 'input', checkFormFields );
		$businessEmail.on( 'input', checkFormFields );
		$confirmationCheckbox.on( 'change', checkFormFields );

		// Initial check on page load
		checkFormFields();

		// Prevent form submission if fields are not valid
		$submitButton.on( 'click', function( e ) {
			const selectLanguage = ( $selectLanguage.val() || '' ).trim();
			const companyName = ( $companyName.val() || '' ).trim();
			const companyWebsite = ( $companyWebsite.val() || '' ).trim();
			const businessEmail = ( $businessEmail.val() || '' ).trim();
			const confirm = $confirmationCheckbox.is( ':checked' );

			// Validate that all required fields are filled before proceeding
			if ( ! selectLanguage || ! companyName || ! companyWebsite || ! businessEmail || ! confirm ) {
				e.preventDefault();
				// Show warning using SweetAlert
				swal( {
					title: 'Warning!',
					text: 'Please complete all fields.',
					icon: 'info',
					showCloseButton: true,
				} );
				return;
			}

			// Find the status message element that matches the selected language
			const $matchingStatusMessage = $( '.status-message-accessibility[data-content-lang="' + selectLanguage + '"]' );

			// Generate current date in localized format: [MonthName Day, Year]
			const now = new Date();
			const options = { year: 'numeric', month: 'long', day: 'numeric' };
			const locale = selectLanguage || 'en'; // fallback to 'en' if not selected
			const formattedDate = `${ now.toLocaleDateString( locale, options ) }`;

			// Get the HTML content of the matching status message
			let htmlContent = $matchingStatusMessage.html(); // Use html() to preserve HTML formatting

			// Replace placeholders in the HTML with actual values
			htmlContent = htmlContent.replace( /\[Company Name\]/g, companyName )
				.replace( /\[Company Website\]/g, companyWebsite )
				.replace( /\[Company E-Mail\]/g, businessEmail )
				.replace( /\[March 9, 2025\]/g, formattedDate );

			// Set the final content into the TinyMCE editor if it's initialized
			const editor = tinymce.get( 'editor_generator' );
			if ( editor ) {
				editor.setContent( htmlContent );
			}

			e.preventDefault();
		} );
	}
	handleAccessibilityStatusForm();

	/**
	 * Handle edit button functionality for ALT TEXT  editing
	 */
	$( '.box-image-alt .button.edit-btn' ).on( 'click', function() {
		const $button = $( this );
		const $row = $button.closest( '.row' );
		const $altTextCol = $row.find( '.col.alt-text' );
		const $textSpan = $altTextCol.find( '.text' );
		const imageId = $button.data( 'image-id' );

		// Get current text content
		const currentText = $textSpan.text();

		// Hide the edit button
		$button.addClass( 'hide' );

		// Show the save button
		$button.siblings( '.save-btn' ).removeClass( 'hide' );

		// Replace text span with textarea
		$textSpan.replaceWith( '<textarea data-image-id="' + imageId + '">' + currentText + '</textarea>' );
	} );

	/**
	 * Handle save button functionality for ALT TEXT saving
	 */
	$( document ).on( 'click', '.box-image-alt .button.save-btn', function() {
		const $button = $( this );
		const $row = $button.closest( '.row' );
		const $altTextCol = $row.find( '.col.alt-text' );
		const $textarea = $altTextCol.find( 'textarea' );
		const imageId = $button.data( 'image-id' );

		// Get textarea value
		const newText = $textarea.val();

		// Send AJAX request to save alt text
		$.ajax( {
			url: adminLocalize.ajaxUrl,
			method: 'POST',
			data: {
				nonce: adminLocalize.ajaxNonce,
				action: 'onetap_save_alt_text',
				image_id: imageId,
				alt_text: newText,
			},
			success( response ) {
				if ( response.success ) {
					// Hide the save button
					$button.addClass( 'hide' );

					// Show the edit button
					$button.siblings( '.edit-btn' ).removeClass( 'hide' );

					// Replace textarea with text span
					$textarea.replaceWith( '<span class="text">' + newText + '</span>' );

					// Show success message
					if ( typeof swal !== 'undefined' ) {
						swal( {
							title: 'Success!',
							text: 'Alt text saved successfully',
							icon: 'success',
							timer: 2000,
							showConfirmButton: false,
						} );
					}
				} else if ( typeof swal !== 'undefined' ) {
					// Show error message
					swal( {
						title: 'Error!',
						text: response.error || 'Failed to save alt text',
						icon: 'error',
					} );
				}
			},
			error( xhr, textStatus, errorThrown ) {
				console.error( 'Error saving alt text:', errorThrown );

				// Show error message
				if ( typeof swal !== 'undefined' ) {
					swal( {
						title: 'Error!',
						text: 'Failed to save alt text. Please try again.',
						icon: 'error',
					} );
				}
			},
		} );
	} );

	/**
	 * Prevent navigation when disabled pagination buttons are clicked
	 * Handles both previous and next buttons that are disabled
	 */
	$( document ).on( 'click', '.button.disable.prev-btn, .button.disable.next-btn', function( e ) {
		// Prevent the default link behavior (redirection)
		e.preventDefault();

		// Return false to ensure no further action
		return false;
	} );

	/**
	 * Append current language box into module labels control
	 * Clones .box-current-language (with descendants) and appends to .setting-control.module-labels
	 * Ensures the appended box displays as block and avoids duplicate insertion
	 */
	function appendCurrentLanguageBoxToModuleLabels() {
		const $sourceBox = $( '.box-current-language' );
		const $targetControl = $( '.settings-group.accessibility-information .setting-control.module-labels .setting-title' );

		if ( $sourceBox.length && $targetControl.length ) {
			// Avoid duplicate insertion if already appended
			if ( $targetControl.find( '.box-current-language' ).length === 0 ) {
				const $cloned = $sourceBox.first().clone( true, true );
				$cloned.css( 'display', 'block' );
				$targetControl.append( $cloned );
			} else {
				$targetControl.find( '.box-current-language' ).css( 'display', 'block' );
			}
		}
	}

	// Call the function when document is ready
	$( document ).ready( function() {
		appendCurrentLanguageBoxToModuleLabels();
	} );
}( jQuery ) );
