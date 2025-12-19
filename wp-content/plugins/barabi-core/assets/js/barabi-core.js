(function ( $ ) {
	'use strict';

	// This case is important when theme is not active
	if ( typeof qodef !== 'object' ) {
		window.qodef = {};
	}

	window.qodefCore                = {};
	qodefCore.shortcodes            = {};
	qodefCore.listShortcodesScripts = {
		qodefSwiper: qodef.qodefSwiper,
		qodefPagination: qodef.qodefPagination,
		qodefFilter: qodef.qodefFilter,
		qodefMasonryLayout: qodef.qodefMasonryLayout,
		qodefJustifiedGallery: qodef.qodefJustifiedGallery,
		qodefCustomCursor: qodefCore.qodefCustomCursor,
	};

	qodefCore.body         = $( 'body' );
	qodefCore.html         = $( 'html' );
	qodefCore.windowWidth  = $( window ).width();
	qodefCore.windowHeight = $( window ).height();
	qodefCore.scroll       = 0;

	$( document ).ready(
		function () {
			qodefCore.scroll = $( window ).scrollTop();
			qodefInlinePageStyle.init();
		}
	);

	$( window ).resize(
		function () {
			qodefCore.windowWidth  = $( window ).width();
			qodefCore.windowHeight = $( window ).height();
		}
	);

	$( window ).scroll(
		function () {
			qodefCore.scroll = $( window ).scrollTop();
		}
	);

	$( window ).load(
		function () {
			qodefParallaxItem.init();
		}
	);

	/**
	 * Check element to be in the viewport
	 */
	var qodefIsInViewport = {
		check: function ( $element, callback, onlyOnce ) {
			if ( $element.length ) {
				var offset = typeof $element.data( 'viewport-offset' ) !== 'undefined' ? $element.data( 'viewport-offset' ) : 0.15; // When item is 15% in the viewport

				var observer = new IntersectionObserver(
					function ( entries ) {
						// isIntersecting is true when element and viewport are overlapping
						// isIntersecting is false when element and viewport don't overlap
						if ( entries[0].isIntersecting === true ) {
							callback.call( $element );

							// Stop watching the element when it's initialize
							if ( onlyOnce !== false ) {
								observer.disconnect();
							}
						}
					},
					{ threshold: [offset] }
				);

				observer.observe( $element[0] );
			}
		},
	};

	qodefCore.qodefIsInViewport = qodefIsInViewport;

	var qodefScroll = {
		disable: function () {
			if ( window.addEventListener ) {
				window.addEventListener(
					'wheel',
					qodefScroll.preventDefaultValue,
					{ passive: false }
				);
			}

			// window.onmousewheel = document.onmousewheel = qodefScroll.preventDefaultValue;
			document.onkeydown = qodefScroll.keyDown;
		},
		enable: function () {
			if ( window.removeEventListener ) {
				window.removeEventListener(
					'wheel',
					qodefScroll.preventDefaultValue,
					{ passive: false }
				);
			}
			window.onmousewheel = document.onmousewheel = document.onkeydown = null;
		},
		preventDefaultValue: function ( e ) {
			e = e || window.event;
			if ( e.preventDefault ) {
				e.preventDefault();
			}
			e.returnValue = false;
		},
		keyDown: function ( e ) {
			var keys = [37, 38, 39, 40];
			for ( var i = keys.length; i--; ) {
				if ( e.keyCode === keys[i] ) {
					qodefScroll.preventDefaultValue( e );
					return;
				}
			}
		}
	};

	qodefCore.qodefScroll = qodefScroll;

	var qodefPerfectScrollbar = {
		init: function ( $holder ) {
			if ( $holder.length ) {
				qodefPerfectScrollbar.qodefInitScroll( $holder );
			}
		},
		qodefInitScroll: function ( $holder ) {
			var $defaultParams = {
				wheelSpeed: 0.6,
				suppressScrollX: true
			};

			var $ps = new PerfectScrollbar(
				$holder[0],
				$defaultParams
			);

			$( window ).resize(
				function () {
					$ps.update();
				}
			);
		}
	};

	qodefCore.qodefPerfectScrollbar = qodefPerfectScrollbar;

	var qodefInlinePageStyle = {
		init: function () {
			this.holder = $( '#barabi-core-page-inline-style' );

			if ( this.holder.length ) {
				var style = this.holder.data( 'style' );

				if ( style.length ) {
					$( 'head' ).append( '<style type="text/css">' + style + '</style>' );
				}
			}
		}
	};

	/**
	 * Init parallax item
	 */
	var qodefParallaxItem = {
		init: function () {
			var $items = $( '.qodef-parallax-item' );

			if ( $items.length ) {
				$items.each(
					function () {
						var $currentItem = $( this ),
							$y           = Math.floor( Math.random() * (-100 - (-25)) + (-25) );

						if ( $currentItem.hasClass( 'qodef-grid-item' ) ) {
							$currentItem.children( '.qodef-e-inner' ).attr(
								'data-parallax',
								'{"y": ' + $y + ', "smoothness": ' + '30' + '}'
							);
						} else {
							$currentItem.attr(
								'data-parallax',
								'{"y": ' + $y + ', "smoothness": ' + '30' + '}'
							);
						}
					}
				);
			}

			qodefParallaxItem.initParallax();
		},
		initParallax: function () {
			var parallaxInstances = $( '[data-parallax]' );

			if ( parallaxInstances.length && ! qodefCore.html.hasClass( 'touchevents' ) && typeof ParallaxScroll === 'object' ) {
				ParallaxScroll.init(); //initialization removed from plugin js file to have it run only on non-touch devices
			}
		},
	};

	qodefCore.qodefParallaxItem = qodefParallaxItem;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefBackToTop.init();
		}
	);

	var qodefBackToTop = {
		init: function () {
			this.holder = $( '#qodef-back-to-top' );

			if ( this.holder.length ) {
				// Scroll To Top
				this.holder.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefBackToTop.animateScrollToTop();
					}
				);

				qodefBackToTop.showHideBackToTop();
			}
		},
		animateScrollToTop: function () {
			var startPos = qodef.scroll,
				newPos   = qodef.scroll,
				step     = .9,
				animationFrameId;

			var startAnimation = function () {
				if ( newPos === 0 ) {
					return;
				}

				newPos < 0.0001 ? newPos = 0 : null;

				var ease = qodefBackToTop.easingFunction( (startPos - newPos) / startPos );
				$( 'html, body' ).scrollTop( startPos - (startPos - newPos) * ease );
				newPos = newPos * step;

				animationFrameId = requestAnimationFrame( startAnimation );
			};

			startAnimation();

			$( window ).one(
				'wheel touchstart',
				function () {
					cancelAnimationFrame( animationFrameId );
				}
			);
		},
		easingFunction: function ( n ) {
			return 0 == n ? 0 : Math.pow( 1024, n - 1 );
		},
		showHideBackToTop: function () {
			$( window ).scroll(
				function () {
					var $thisItem = $( this ),
						b         = $thisItem.scrollTop(),
						c         = $thisItem.height(),
						d;

					if ( b > 0 ) {
						d = b + c / 2;
					} else {
						d = 1;
					}

					if ( d < 1e3 ) {
						qodefBackToTop.addClass( 'off' );
					} else {
						qodefBackToTop.addClass( 'on' );
					}
				}
			);
		},
		addClass: function ( a ) {
			this.holder.removeClass( 'qodef--off qodef--on' );

			if ( a === 'on' ) {
				this.holder.addClass( 'qodef--on' );
			} else {
				this.holder.addClass( 'qodef--off' );
			}
		}
	};

})( jQuery );

(function ($) {
	"use strict";

	$( window ).on(
		'load',
		function () {
			qodefBackgroundText.init();
		}
	);

	$( window ).resize(
		function () {
			qodefBackgroundText.init();
		}
	);

	var qodefBackgroundText = {
		init                    : function () {
			var $holder = $( '.qodef-background-text' );

			if ($holder.length) {
				$holder.each(
					function () {
						qodefBackgroundText.responsiveOutputHandler( $( this ) );
					}
				);
			}
		},
		responsiveOutputHandler : function ($holder) {
			var breakpoints = {
				3840: 1441,
				1440: 1367,
				1366: 1025,
				1024: 1
			};

			$.each(
				breakpoints,
				function (max, min) {
					if (qodef.windowWidth <= max && qodef.windowWidth >= min) {
						qodefBackgroundText.generateResponsiveOutput( $holder, max );
					}
				}
			);
		},
		generateResponsiveOutput: function ($holder, width) {
			var $textHolder = $holder.find( '.qodef-m-background-text' );

			if ($textHolder.length) {
				$textHolder.css(
					{
						'font-size': $textHolder.data( 'size-' + width ) + 'px',
						'top'      : $textHolder.data( 'vertical-offset-' + width ) + 'px',
					}
				);
			}
		},
	};

	window.qodefBackgroundText = qodefBackgroundText;
})( jQuery );

(function ($) {
	'use strict';

	$(document).ready(function () {
		qodefCustomCursor.init();
	});

	// $(window).on(
	// 	'elementor/frontend/init',
	// 	function () {
	// 		qodefCustomCursor.init();
	// 	}
	// );

	var qodefCustomCursor = {
		cursorApended: false,
		init         : function () {
			const $dragSelectors = $('.qodef--drag-cursor');

			if ($dragSelectors.length) {
				const customCursor = qodefGlobal.vars.dragCursor;

				if (false === qodefCustomCursor.cursorApended) {
					qodefCore.html.append('<div class="qodef-m-custom-cursor qodef-m"><div class="qodef-m-custom-cursor-inner">' + customCursor + '</div></div>');
					qodefCustomCursor.cursorApended = true;
				}
				const $cursorHolder = $('.qodef-m-custom-cursor');

				if (!qodefCore.html.hasClass('touchevents')) {
					function handleMoveCursor(event) {
						$cursorHolder.css(
							{
								top : event.clientY - 60, // half of svg height
								left: event.clientX - 60, // half of svg width
							}
						);
					}

					document.addEventListener('pointermove', handleMoveCursor);

					// reset cursor selectors
					const resetCursorSelectors =
							'.qodef--drag-cursor .swiper-button-prev,' +
							'.qodef--drag-cursor .swiper-button-next,' +
							'.qodef--drag-cursor .swiper-pagination,' +
							'.qodef--drag-cursor .qodef-e-post-link,' + // port/blog/product list link overlay
							'.qodef--drag-cursor .qodef-e-hotspot',
						$resetCursorSelectors = $(resetCursorSelectors);

					$resetCursorSelectors.css(
						{
							cursor: 'pointer',
						}
					);

					$(document).on(
						'mouseenter',
						resetCursorSelectors,
						function () {
							$cursorHolder.addClass('qodef--hide');
						}
					).on(
						'mouseleave',
						resetCursorSelectors,
						function () {
							$cursorHolder.removeClass('qodef--hide');
						}
					);

					// drag cursor selectors
					const dragSelectors = '.qodef--drag-cursor';

					$(document).on(
						'mouseenter',
						dragSelectors,
						function () {
							$cursorHolder.addClass('qodef--show');
						}
					).on(
						'mouseleave',
						dragSelectors,
						function () {
							$cursorHolder.removeClass('qodef--show');
						}
					);
				}
			}
		},
	};

	qodefCore.qodefCustomCursor = qodefCustomCursor;

})(jQuery);

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefUncoverFooter.init();
		}
	);

	var qodefUncoverFooter = {
		holder: '',
		init: function () {
			this.holder = $( '#qodef-page-footer.qodef--uncover' );

			if ( this.holder.length && ! qodefCore.html.hasClass( 'touchevents' ) ) {
				qodefUncoverFooter.addClass();
				qodefUncoverFooter.setHeight( this.holder );

				$( window ).resize(
					function () {
						qodefUncoverFooter.setHeight( qodefUncoverFooter.holder );
					}
				);
			}
		},
		setHeight: function ( $holder ) {
			$holder.css( 'height', 'auto' );

			var footerHeight = $holder.outerHeight();

			if ( footerHeight > 0 ) {
				$( '#qodef-page-outer' ).css(
					{
						'margin-bottom': footerHeight,
						'background-color': qodefCore.body.css( 'backgroundColor' )
					}
				);

				$holder.css( 'height', footerHeight );
			}
		},
		addClass: function () {
			qodefCore.body.addClass( 'qodef-page-footer--uncover' );
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefFullscreenMenu.init();
		}
	);

	$( window ).on(
		'resize',
		function () {
			qodefFullscreenMenu.handleHeaderWidth( 'resize' );
		}
	);

	var qodefFullscreenMenu = {
		init: function () {
			var $fullscreenMenuOpener = $( 'a.qodef-fullscreen-menu-opener' ),
				$menuItems            = $( '#qodef-fullscreen-area nav ul li a' );

			if ( $fullscreenMenuOpener.length ) {
				// prevent header changing width when fullscreen menu is open
				qodefFullscreenMenu.handleHeaderWidth( 'init' );

				// open popup menu
				$fullscreenMenuOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						var $thisOpener = $( this );

						if ( ! qodefCore.body.hasClass( 'qodef-fullscreen-menu--opened' ) ) {
							qodefFullscreenMenu.openFullscreen( $thisOpener );

							$( document ).keyup(
								function ( e ) {
									if ( e.keyCode === 27 ) {
										qodefFullscreenMenu.closeFullscreen( $thisOpener );
									}
								}
							);
						} else {
							qodefFullscreenMenu.closeFullscreen( $thisOpener );
						}
					}
				);

				// open dropdowns
				$menuItems.on(
					'tap click',
					function ( e ) {
						var $thisItem = $( this );

						if ( $thisItem.parent().hasClass( 'menu-item-has-children' ) ) {
							e.preventDefault();
							qodefFullscreenMenu.clickItemWithChild( $thisItem );
						} else if ( $thisItem.attr( 'href' ) !== 'http://#' && $thisItem.attr( 'href' ) !== '#' ) {
							qodefFullscreenMenu.closeFullscreen( $fullscreenMenuOpener );
						}
					}
				);
			}
		},
		openFullscreen: function ( $opener ) {
			$opener.addClass( 'qodef--opened' );
			qodefCore.body.removeClass( 'qodef-fullscreen-menu-animate--out' ).addClass( 'qodef-fullscreen-menu--opened qodef-fullscreen-menu-animate--in' );
			qodefCore.qodefScroll.disable();
		},
		closeFullscreen: function ( $opener ) {
			$opener.removeClass( 'qodef--opened' );
			qodefCore.body.removeClass( 'qodef-fullscreen-menu--opened qodef-fullscreen-menu-animate--in' ).addClass( 'qodef-fullscreen-menu-animate--out' );
			qodefCore.qodefScroll.enable();
			$( 'nav.qodef-fullscreen-menu ul.sub_menu' ).slideUp( 200 );
		},
		clickItemWithChild: function ( thisItem ) {
			var $thisItemParent  = thisItem.parent(),
				$thisItemSubMenu = $thisItemParent.find( '.sub-menu' ).first();

			if ( $thisItemSubMenu.is( ':visible' ) ) {
				$thisItemSubMenu.slideUp( 300 );
				$thisItemParent.removeClass( 'qodef--opened' );
			} else {
				$thisItemSubMenu.slideDown( 300 );
				$thisItemParent.addClass( 'qodef--opened' ).siblings().find( '.sub-menu' ).slideUp( 400 );
			}
		},
		handleHeaderWidth: function ( state ) {
			var $header               = $( '#qodef-page-header' );
			var $fullscreenMenuOpener = $( 'a.qodef-fullscreen-menu-opener' );

			if ( $header.length && $fullscreenMenuOpener.length ) {
				// if desktop device
				if ( qodefCore.windowWidth > 1024 ) {
					// if page height is greater than window height, scroll bar is visible
					if ( qodefCore.body.height() > qodefCore.windowHeight ) {
						// on resize reset previously set inline width
						if ( 'resize' === state ) {
							$header.css( { 'width': '' } );
						}
						$header.width( $header.width() );
					}
				} else {
					// reset previously set inline width
					$header.css( { 'width': '' } );
				}
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefHeaderScrollAppearance.init();
		}
	);

	var qodefHeaderScrollAppearance = {
		appearanceType: function () {
			return qodefCore.body.attr( 'class' ).indexOf( 'qodef-header-appearance--' ) !== -1 ? qodefCore.body.attr( 'class' ).match( /qodef-header-appearance--([\w]+)/ )[1] : '';
		},
		init: function () {
			var appearanceType = this.appearanceType();

			if ( appearanceType !== '' && appearanceType !== 'none' ) {
				qodefCore[appearanceType + 'HeaderAppearance']();
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
	    function () {
            qodefMobileHeaderAppearance.init();
        }
	);

	/*
	 **	Init mobile header functionality
	 */
	var qodefMobileHeaderAppearance = {
		init: function () {
			if ( qodefCore.body.hasClass( 'qodef-mobile-header-appearance--sticky' ) ) {

				var docYScroll1   = qodefCore.scroll,
					displayAmount = qodefGlobal.vars.mobileHeaderHeight + qodefGlobal.vars.adminBarHeight,
					$pageOuter    = $( '#qodef-page-outer' );

				qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );

				$( window ).scroll(
				    function () {
                        qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );
                        docYScroll1 = qodefCore.scroll;
                    }
				);

				$( window ).resize(
				    function () {
                        $pageOuter.css( 'padding-top', 0 );
                        qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );
                    }
				);
			}
		},
		showHideMobileHeader: function ( docYScroll1, displayAmount, $pageOuter ) {
			if ( qodefCore.windowWidth <= 1024 ) {
				if ( qodefCore.scroll > displayAmount * 2 ) {
					//set header to be fixed
					qodefCore.body.addClass( 'qodef-mobile-header--sticky' );

					//add transition to it
					setTimeout(
						function () {
							qodefCore.body.addClass( 'qodef-mobile-header--sticky-animation' );
						},
						300
					); //300 is duration of sticky header animation

					//add padding to content so there is no 'jumping'
					$pageOuter.css( 'padding-top', qodefGlobal.vars.mobileHeaderHeight );
				} else {
					//unset fixed header
					qodefCore.body.removeClass( 'qodef-mobile-header--sticky' );

					//remove transition
					setTimeout(
						function () {
							qodefCore.body.removeClass( 'qodef-mobile-header--sticky-animation' );
						},
						300
					); //300 is duration of sticky header animation

					//remove padding from content since header is not fixed anymore
					$pageOuter.css( 'padding-top', 0 );
				}

				if ( (qodefCore.scroll > docYScroll1 && qodefCore.scroll > displayAmount) || (qodefCore.scroll < displayAmount * 3) ) {
					//show sticky header
					qodefCore.body.removeClass( 'qodef-mobile-header--sticky-display' );
				} else {
					//hide sticky header
					qodefCore.body.addClass( 'qodef-mobile-header--sticky-display' );
				}
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefNavMenu.init();
		}
	);

	var qodefNavMenu = {
		init: function () {
			qodefNavMenu.dropdownBehavior();
			qodefNavMenu.wideDropdownPosition();
			qodefNavMenu.dropdownPosition();
		},
		dropdownBehavior: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li' );

			$menuItems.each(
				function () {
					var $thisItem = $( this );

					if ( $thisItem.find( '.qodef-drop-down-second' ).length ) {
						qodef.qodefWaitForImages.check(
							$thisItem,
							function () {
								var $dropdownHolder      = $thisItem.find( '.qodef-drop-down-second' ),
									$dropdownMenuItem    = $dropdownHolder.find( '.qodef-drop-down-second-inner ul' ),
									dropDownHolderHeight = $dropdownMenuItem.outerHeight();

								if ( navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) ) {
									$thisItem.on(
										'touchstart mouseenter',
										function () {
											$dropdownHolder.css(
												{
													'height': dropDownHolderHeight,
													'overflow': 'visible',
													'visibility': 'visible',
													'opacity': '1',
												}
											);
										}
									).on(
										'mouseleave',
										function () {
											$dropdownHolder.css(
												{
													'height': '0px',
													'overflow': 'hidden',
													'visibility': 'hidden',
													'opacity': '0',
												}
											);
										}
									);
								} else {
									if ( qodefCore.body.hasClass( 'qodef-drop-down-second--animate-height' ) ) {
										var animateConfig = {
											interval: 0,
											over: function () {
												setTimeout(
													function () {
														$dropdownHolder.addClass( 'qodef-drop-down--start' ).css(
															{
																'visibility': 'visible',
																'height': '0',
																'opacity': '1',
															}
														);
														$dropdownHolder.stop().animate(
															{
																'height': dropDownHolderHeight,
															},
															400,
															'linear',
															function () {
																$dropdownHolder.css( 'overflow', 'visible' );
															}
														);
													},
													100
												);
											},
											timeout: 100,
											out: function () {
												$dropdownHolder.stop().animate(
													{
														'height': '0',
														'opacity': 0,
													},
													100,
													function () {
														$dropdownHolder.css(
															{
																'overflow': 'hidden',
																'visibility': 'hidden',
															}
														);
													}
												);

												$dropdownHolder.removeClass( 'qodef-drop-down--start' );
											}
										};

										$thisItem.hoverIntent( animateConfig );
									} else {
										var config = {
											interval: 0,
											over: function () {
												setTimeout(
													function () {
														$dropdownHolder.addClass( 'qodef-drop-down--start' ).stop().css( { 'height': dropDownHolderHeight } );
													},
													150
												);
											},
											timeout: 150,
											out: function () {
												$dropdownHolder.stop().css( { 'height': '0' } ).removeClass( 'qodef-drop-down--start' );
											}
										};

										$thisItem.hoverIntent( config );
									}
								}
							}
						);
					}
				}
			);
		},
		wideDropdownPosition: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li.qodef-menu-item--wide' );

			if ( $menuItems.length ) {
				$menuItems.each(
					function () {
						var $menuItem        = $( this );
						var $menuItemSubMenu = $menuItem.find( '.qodef-drop-down-second' );

						if ( $menuItemSubMenu.length ) {
							$menuItemSubMenu.css( 'left', 0 );

							var leftPosition = $menuItemSubMenu.offset().left;

							if ( qodefCore.body.hasClass( 'qodef--boxed' ) ) {
								//boxed layout case
								var boxedWidth = $( '.qodef--boxed #qodef-page-wrapper' ).outerWidth();
								leftPosition   = leftPosition - (qodefCore.windowWidth - boxedWidth) / 2;
								$menuItemSubMenu.css( { 'left': -leftPosition, 'width': boxedWidth } );

							} else if ( qodefCore.body.hasClass( 'qodef-drop-down-second--full-width' ) ) {
								//wide dropdown full width case
								$menuItemSubMenu.css( { 'left': -leftPosition, 'width': qodefCore.windowWidth } );
							} else {
								//wide dropdown in grid case
								$menuItemSubMenu.css( { 'left': -leftPosition + (qodefCore.windowWidth - $menuItemSubMenu.width()) / 2 } );
							}
						}
					}
				);
			}
		},
		dropdownPosition: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li.qodef-menu-item--narrow.menu-item-has-children' );

			if ( $menuItems.length ) {
				$menuItems.each(
					function () {
						var $thisItem         = $( this ),
							menuItemPosition  = $thisItem.offset().left,
							$dropdownHolder   = $thisItem.find( '.qodef-drop-down-second' ),
							$dropdownMenuItem = $dropdownHolder.find( '.qodef-drop-down-second-inner ul' ),
							dropdownMenuWidth = $dropdownMenuItem.outerWidth(),
							menuItemFromLeft  = $( window ).width() - menuItemPosition;

						if ( qodef.body.hasClass( 'qodef--boxed' ) ) {
							//boxed layout case
							var boxedWidth   = $( '.qodef--boxed #qodef-page-wrapper' ).outerWidth();
							menuItemFromLeft = boxedWidth - menuItemPosition;
						}

						var dropDownMenuFromLeft;

						if ( $thisItem.find( 'li.menu-item-has-children' ).length > 0 ) {
							dropDownMenuFromLeft = menuItemFromLeft - dropdownMenuWidth;
						}

						$dropdownHolder.removeClass( 'qodef-drop-down--right' );
						$dropdownMenuItem.removeClass( 'qodef-drop-down--right' );
						if ( menuItemFromLeft < dropdownMenuWidth || dropDownMenuFromLeft < dropdownMenuWidth ) {
							$dropdownHolder.addClass( 'qodef-drop-down--right' );
							$dropdownMenuItem.addClass( 'qodef-drop-down--right' );
						}
					}
				);
			}

			qodefNavMenu.setMenuDirection();

			$( window ).scroll(
				function () {
					qodefNavMenu.setMenuDirection();
				}
			);
		},
		setMenuDirection: function () {
			var header  = $( '#qodef-page-header' ),
				subMenu = $( '#qodef-page-header .qodef-drop-down-second' );

			if ( subMenu.length && qodef.body.hasClass( 'qodef-above-header-area--enabled' ) ) {
				if (qodefCore.body.offset().top - qodefCore.body.outerHeight() > qodefCore.scroll || qodefCore.scroll > 300) {
					header.removeClass( 'qodef-show-upwards' );
					subMenu.removeClass( 'qodef-sub-upwards' );
				} else {
					header.addClass( 'qodef-show-upwards' );
					subMenu.addClass( 'qodef-sub-upwards' );
				}
			}
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefParallaxBackground.init();
		}
	);

	/**
	 * Init global parallax background functionality
	 */
	var qodefParallaxBackground = {
		init: function ( settings ) {
			this.$sections = $( '.qodef-parallax' );

			// Allow overriding the default config
			$.extend( this.$sections, settings );

			var isSupported = ! qodefCore.html.hasClass( 'touchevents' ) && ! qodefCore.body.hasClass( 'qodef-browser--edge' ) && ! qodefCore.body.hasClass( 'qodef-browser--ms-explorer' );

			if ( this.$sections.length && isSupported ) {
				this.$sections.each(
					function () {
						qodefParallaxBackground.ready( $( this ) );
					}
				);
			}
		},
		ready: function ( $section ) {
			$section.$imgHolder  = $section.find( '.qodef-parallax-img-holder' );
			$section.$imgWrapper = $section.find( '.qodef-parallax-img-wrapper' );
			$section.$img        = $section.find( 'img.qodef-parallax-img' );

			var h           = $section.height(),
				imgWrapperH = $section.$imgWrapper.height();

			$section.movement = 100 * (imgWrapperH - h) / h / 2; //percentage (divided by 2 due to absolute img centering in CSS)

			$section.buffer       = window.scrollY;
			$section.scrollBuffer = null;


			//calc and init loop
			requestAnimationFrame(
				function () {
					$section.$imgHolder.animate( { opacity: 1 }, 100 );
					qodefParallaxBackground.calc( $section );
					qodefParallaxBackground.loop( $section );
				}
			);

			//recalc
			$( window ).on(
				'resize',
				function () {
					qodefParallaxBackground.calc( $section );
				}
			);
		},
		calc: function ( $section ) {
			var wH = $section.$imgWrapper.height(),
				wW = $section.$imgWrapper.width();

			if ( $section.$img.width() < wW ) {
				$section.$img.css(
					{
						'width': '100%',
						'height': 'auto',
					}
				);
			}

			if ( $section.$img.height() < wH ) {
				$section.$img.css(
					{
						'height': '100%',
						'width': 'auto',
						'max-width': 'unset',
					}
				);
			}
		},
		loop: function ( $section ) {
			if ( $section.scrollBuffer === Math.round( window.scrollY ) ) {
				requestAnimationFrame(
					function () {
						qodefParallaxBackground.loop( $section );
					}
				); //repeat loop

				return false; //same scroll value, do nothing
			} else {
				$section.scrollBuffer = Math.round( window.scrollY );
			}

			var wH   = window.outerHeight,
				sTop = $section.offset().top,
				sH   = $section.height();

			if ( $section.scrollBuffer + wH * 1.2 > sTop && $section.scrollBuffer < sTop + sH ) {
				var delta = (Math.abs( $section.scrollBuffer + wH - sTop ) / (wH + sH)).toFixed( 4 ), //coeff between 0 and 1 based on scroll amount
					yVal  = (delta * $section.movement).toFixed( 4 );

				if ( $section.buffer !== delta ) {
					$section.$imgWrapper.css( 'transform', 'translate3d(0,' + yVal + '%, 0)' );
				}

				$section.buffer = delta;
			}

			requestAnimationFrame(
				function () {
					qodefParallaxBackground.loop( $section );
				}
			); //repeat loop
		}
	};

	qodefCore.qodefParallaxBackground = qodefParallaxBackground;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefReview.init();
		}
	);

	var qodefReview = {
		init: function () {
			var ratingHolder = $( '#qodef-page-comments-form .qodef-rating-inner' );

			var addActive = function ( stars, ratingValue ) {
				for ( var i = 0; i < stars.length; i++ ) {
					var star = stars[i];

					if ( i < ratingValue ) {
						$( star ).addClass( 'active' );
					} else {
						$( star ).removeClass( 'active' );
					}
				}
			};

			ratingHolder.each(
				function () {
					var thisHolder  = $( this ),
						ratingInput = thisHolder.find( '.qodef-rating' ),
						ratingValue = ratingInput.val(),
						stars       = thisHolder.find( '.qodef-star-rating' );

					addActive( stars, ratingValue );

					stars.on(
						'click',
						function () {
							ratingInput.val( $( this ).data( 'value' ) ).trigger( 'change' );
						}
					);

					ratingInput.change(
						function () {
							ratingValue = ratingInput.val();

							addActive( stars, ratingValue );
						}
					);
				}
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideArea.init();
		}
	);

	var qodefSideArea = {
		init: function () {
			var $sideAreaOpener = $( 'a.qodef-side-area-opener' ),
				$sideAreaClose  = $( '#qodef-side-area-close' ),
				$sideArea       = $( '#qodef-side-area' );

			qodefSideArea.openerHoverColor( $sideAreaOpener );

			// Open Side Area
			$sideAreaOpener.on(
				'click',
				function ( e ) {
					e.preventDefault();

					if ( ! qodefCore.body.hasClass( 'qodef-side-area--opened' ) ) {
						qodefSideArea.openSideArea();

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefSideArea.closeSideArea();
								}
							}
						);
					} else {
						qodefSideArea.closeSideArea();
					}
				}
			);

			$sideAreaClose.on(
				'click',
				function ( e ) {
					e.preventDefault();
					qodefSideArea.closeSideArea();
				}
			);

			if ( $sideArea.length && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $sideArea );
			}
		},
		openSideArea: function () {
			var $wrapper      = $( '#qodef-page-wrapper' );
			var currentScroll = $( window ).scrollTop();

			$( '.qodef-side-area-cover' ).remove();
			$wrapper.prepend( '<div class="qodef-side-area-cover"/>' );
			qodefCore.body.removeClass( 'qodef-side-area-animate--out' ).addClass( 'qodef-side-area--opened qodef-side-area-animate--in' );

			$( '.qodef-side-area-cover' ).on(
				'click',
				function ( e ) {
					e.preventDefault();
					qodefSideArea.closeSideArea();
				}
			);

			$( window ).scroll(
				function () {
					if ( Math.abs( qodefCore.scroll - currentScroll ) > 400 ) {
						qodefSideArea.closeSideArea();
					}
				}
			);
		},
		closeSideArea: function () {
			qodefCore.body.removeClass( 'qodef-side-area--opened qodef-side-area-animate--in' ).addClass( 'qodef-side-area-animate--out' );
		},
		openerHoverColor: function ( $opener ) {
			if ( typeof $opener.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $opener.data( 'hover-color' );
				var originalColor = $opener.css( 'color' );

				$opener.on(
					'mouseenter',
					function () {
						$opener.css( 'color', hoverColor );
					}
				).on(
					'mouseleave',
					function () {
						$opener.css( 'color', originalColor );
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function() {
			qodefSpinner.init();
		}
	);

	$( window ).on(
		'load',
		function () {
			qodefSpinner.windowLoaded = true;

			if (document.visibilityState === 'visible') {
				qodefSpinner.fadeOutLoader();
			} else {
				document.addEventListener("visibilitychange", function() {
					if (document.visibilityState === 'visible') {
						qodefSpinner.fadeOutLoader();
					}
				});
			}
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				qodefSpinner.init( isEditMode );
			}
		}
	);

	var qodefSpinner = {
		holder: '',
		windowLoaded: false,
		init: function ( isEditMode ) {
			this.holder = $( '#qodef-page-spinner:not(.qodef--custom-spinner):not(.qodef-layout--textual)' );

			if ( this.holder.length ) {
				qodefSpinner.animateSpinner( isEditMode );
				qodefSpinner.fadeOutAnimation();
			}
		},
		animateSpinner: function ( isEditMode ) {

			if ( isEditMode ) {
				qodefSpinner.fadeOutLoader();
			}
		},
		fadeOutLoader: function ( speed, delay, easing ) {
			var $holder = qodefSpinner.holder.length ? qodefSpinner.holder : $( '#qodef-page-spinner:not(.qodef--custom-spinner):not(.qodef-layout--textual)' );

			speed  = speed ? speed : 600;
			delay  = delay ? delay : 0;
			easing = easing ? easing : 'swing';

			$holder.delay( delay ).fadeOut( speed, easing );

			$( window ).on(
				'bind',
				'pageshow',
				function ( event ) {
					if ( event.originalEvent.persisted ) {
						$holder.fadeOut( speed, easing );
					}
				}
			);
		},
		fadeOutAnimation: function () {

			// Check for fade out animation
			if ( qodefCore.body.hasClass( 'qodef-spinner--fade-out' ) ) {
				var $pageHolder = $( '#qodef-page-wrapper' ),
					$linkItems  = $( 'a' );

				// If back button is pressed, then show content to avoid state where content is on display:none
				window.addEventListener(
					'pageshow',
					function ( event ) {
						var historyPath = event.persisted || (typeof window.performance !== 'undefined' && window.performance.navigation.type === 2);
						if ( historyPath && ! $pageHolder.is( ':visible' ) ) {
							$pageHolder.show();
						}
					}
				);

				$linkItems.on(
					'click',
					function ( e ) {
						var $clickedLink = $( this );

						if (
							e.which === 1 && // check if the left mouse button has been pressed
							$clickedLink.attr( 'href' ).indexOf( window.location.host ) >= 0 && // check if the link is to the same domain
							! $clickedLink.hasClass( 'remove' ) && // check is WooCommerce remove link
							$clickedLink.parent( '.product-remove' ).length <= 0 && // check is WooCommerce remove link
							$clickedLink.parents( '.woocommerce-product-gallery__image' ).length <= 0 && // check is product gallery link
							typeof $clickedLink.data( 'rel' ) === 'undefined' && // check pretty photo link
							typeof $clickedLink.attr( 'rel' ) === 'undefined' && // check VC pretty photo link
							! $clickedLink.hasClass( 'lightbox-active' ) && // check is lightbox plugin active
							(typeof $clickedLink.attr( 'target' ) === 'undefined' || $clickedLink.attr( 'target' ) === '_self') && // check if the link opens in the same window
							$clickedLink.attr( 'href' ).split( '#' )[0] !== window.location.href.split( '#' )[0] // check if it is an anchor aiming for a different page
						) {
							e.preventDefault();

							$pageHolder.fadeOut(
								600,
								'easeOutSine',
								function () {
									window.location = $clickedLink.attr( 'href' );
								}
							);
						}
					}
				);
			}
		}
	};

	qodefCore.qodefSpinner = qodefSpinner;

})( jQuery );

(function ($) {
	"use strict";

	$( document ).ready(
		function () {
			qodefStickyColumn.init();
		}
	);

	$( window ).resize(
		function () {
			qodefStickyColumn.init();
		}
	);

	var qodefStickyColumn = {
		init: function () {
			var stickyColumnHolder = $( '.qodef-sticky-column--enable' );

			if ( stickyColumnHolder.length ) {
				stickyColumnHolder.each(
					function () {
						var height = $( this ).height();

						if ( $( this ).hasClass( 'qodef-sticky-column-snap-to--top' ) ) {
							$( this ).css(
								'top',
								'calc(0% + ' + qodefGlobal.vars.adminBarHeight + 'px)'
							);
						} else if ( $( this ).hasClass( 'qodef-sticky-column-snap-to--bottom' ) ) {
							$( this ).css(
								'top',
								'calc(100% - ' + height + 'px)'
							);
						} else {
							$( this ).css(
								'top',
								'calc(50% - ' + ( height - qodefGlobal.vars.adminBarHeight ) / 2 + 'px)'
							);
						}
					}
				);
			}
		}
	};

	qodefCore.qodefStickyColumn = qodefStickyColumn;
})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefSubscribeModal.init();
		}
	);

	var qodefSubscribeModal = {
		init: function () {
			this.holder = $( '#qodef-subscribe-popup-modal' );
			var $subscribeButtonOpener = $( '.qodef-subscribe-button' );

			if ( this.holder.length ) {
				var $preventHolder = this.holder.find( '.qodef-sp-prevent' ),
					$modalClose    = $( '.qodef-sp-close' ),
					disabledPopup  = 'no';

				if ( $preventHolder.length ) {
					var isLocalStorage = this.holder.hasClass( 'qodef-sp-prevent-cookies' ),
						$preventInput  = $preventHolder.find( '.qodef-sp-prevent-input' ),
						preventValue   = $preventInput.data( 'value' );

					if ( isLocalStorage ) {
						disabledPopup = localStorage.getItem( 'disabledPopup' );
						sessionStorage.removeItem( 'disabledPopup' );
					} else {
						disabledPopup = sessionStorage.getItem( 'disabledPopup' );
						localStorage.removeItem( 'disabledPopup' );
					}

					$preventHolder.children().on(
						'click',
						function () {
							if ( preventValue !== 'yes' ) {
								preventValue = 'yes';
								$preventInput.addClass( 'qodef-sp-prevent-clicked' ).data( 'value', 'yes' );
							} else {
								preventValue = 'no';
								$preventInput.removeClass( 'qodef-sp-prevent-clicked' ).data( 'value', 'no' );
							}

							if ( preventValue === 'yes' ) {
								if ( isLocalStorage ) {
									localStorage.setItem( 'disabledPopup', 'yes' );
								} else {
									sessionStorage.setItem( 'disabledPopup', 'yes' );
								}
							} else {
								if ( isLocalStorage ) {
									localStorage.setItem( 'disabledPopup', 'no' );
								} else {
									sessionStorage.setItem( 'disabledPopup', 'no' );
								}
							}
						}
					);
				}
				
				if ( $subscribeButtonOpener.length ) {
					$subscribeButtonOpener.each(
						function () {
							var $opener = $( this ).find('.qodef-subscribe-button-link');
							
							if ( $( this ).hasClass( 'qodef-sp-prevent--yes' ) ) {
								disabledPopup = 'yes';
								
								/* hide prevent box since it is already disabled */
								$preventHolder.remove( 'display', 'none' );
							}
							
							$opener.on(
								'click',
								function ( e ) {
									e.preventDefault();
									qodefSubscribeModal.handleClassAndScroll( 'add' );
								}
							);
							
							$modalClose.on(
								'click',
								function ( e ) {
									e.preventDefault();
									
									qodefSubscribeModal.handleClassAndScroll( 'remove' );
								}
							);
						}
					);
				}

				if ( disabledPopup !== 'yes' ) {
					if ( qodefCore.body.hasClass( 'qodef-sp-opened' ) ) {
						qodefSubscribeModal.handleClassAndScroll( 'remove' );
					} else {
						qodefSubscribeModal.handleClassAndScroll( 'add' );
					}

					$modalClose.on(
						'click',
						function ( e ) {
							e.preventDefault();

							qodefSubscribeModal.handleClassAndScroll( 'remove' );
						}
					);

					// Close on escape
					$( document ).keyup(
						function ( e ) {
							if ( e.keyCode === 27 ) { // KeyCode for ESC button is 27
								qodefSubscribeModal.handleClassAndScroll( 'remove' );
							}
						}
					);
				}
			}
		},

		handleClassAndScroll: function ( option ) {
			if ( option === 'remove' ) {
				qodefCore.body.removeClass( 'qodef-sp-opened' );
				qodefCore.qodefScroll.enable();
			}

			if ( option === 'add' ) {
				qodefCore.body.addClass( 'qodef-sp-opened' );
				qodefCore.qodefScroll.disable();
			}
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefWishlist.init();
		}
	);

	/**
	 * Function object that represents wishlist area popup.
	 * @returns {{init: Function}}
	 */
	var qodefWishlist = {
		init: function () {
			var $wishlistLink = $( '.qodef-wishlist .qodef-m-link' );

			if ( $wishlistLink.length ) {
				$wishlistLink.each(
					function () {
						var $thisWishlistLink = $( this ),
							wishlistIconHTML  = $thisWishlistLink.html(),
							$responseMessage  = $thisWishlistLink.siblings( '.qodef-m-response' );

						$thisWishlistLink.off().on(
							'click',
							function ( e ) {
								e.preventDefault();

								if ( qodefCore.body.hasClass( 'logged-in' ) ) {
									var itemID = $thisWishlistLink.data( 'id' );

									if ( itemID !== 'undefined' ) {
										$thisWishlistLink.html( '<span class="fa fa-spinner fa-spin" aria-hidden="true"></span>' );

										if ( ! $thisWishlistLink.hasClass( 'qodef--added' ) ) {
											qodefWishlist.addItem( $thisWishlistLink, wishlistIconHTML, $responseMessage, itemID );
										} else {
											qodefWishlist.removeItem( $thisWishlistLink, wishlistIconHTML, $responseMessage, itemID );
										}
									}
								} else {
									// Trigger event.
									$( document.body ).trigger( 'barabi_membership_trigger_login_modal' );
								}
							}
						);
					}
				);
			}
		},
		addItem: function( $thisWishlistLink, wishlistIconHTML, $responseMessage, itemID ) {
			var wishlistData = {
				type: 'add',
				itemID: itemID,
			};

			$.ajax(
				{
					type: 'POST',
					url: qodefGlobal.vars.restUrl + qodefGlobal.vars.wishlistRestRoute,
					data: {
						options: wishlistData,
					},
					beforeSend: function ( request ) {
						request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
					},
					success: function ( response ) {

						if ( response.status === 'success' ) {
							$thisWishlistLink.addClass( 'qodef--added' );
							$responseMessage.html( response.message ).addClass( 'qodef--show' ).fadeIn( 200 );

							$thisWishlistLink.html( wishlistIconHTML );

							var $wishlistTitle = $thisWishlistLink.find( '.qodef-m-link-label' );

							if ( $wishlistTitle.length ) {
								$wishlistTitle.text( $wishlistTitle.data( 'added-title' ) );
							}

							$( document ).trigger(
								'barabi_core_wishlist_item_is_updated',
								[itemID, response.data.user_id]
							);
						} else {
							$thisWishlistLink.html( wishlistIconHTML );
							$responseMessage.html( response.message ).addClass( 'qodef--show' ).fadeIn( 200 );
						}

						setTimeout(
							function () {
								$responseMessage.fadeOut( 300 ).removeClass( 'qodef--show' ).empty();
							},
							800
						);
					}
				}
			);
		},
		removeItem: function( $thisWishlistLink, wishlistIconHTML, $responseMessage, itemID ) {
			var wishlistData = {
				type: 'remove',
				itemID: itemID,
			};

			$.ajax(
				{
					type: 'POST',
					url: qodefGlobal.vars.restUrl + qodefGlobal.vars.wishlistRestRoute,
					data: {
						options: wishlistData,
					},
					beforeSend: function ( request ) {
						request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
					},
					success: function ( response ) {

						if ( response.status === 'success' ) {
							$thisWishlistLink.removeClass( 'qodef--added' );
							$responseMessage.html( response.message ).addClass( 'qodef--show' ).fadeIn( 200 );

							$thisWishlistLink.html( wishlistIconHTML );

							var $wishlistTitle = $thisWishlistLink.find( '.qodef-m-link-label' );

							if ( $wishlistTitle.length ) {
								$wishlistTitle.text( $wishlistTitle.data( 'title' ) );
							}

							$( document ).trigger(
								'barabi_core_wishlist_item_is_updated',
								[itemID, response.data.user_id]
							);
						} else {
							$thisWishlistLink.html( wishlistIconHTML );
							$responseMessage.html( response.message ).addClass( 'qodef--show' ).fadeIn( 200 );
						}

						setTimeout(
							function () {
								$responseMessage.fadeOut( 300 ).removeClass( 'qodef--show' ).empty();
							},
							800
						);
					}
				}
			);
		},
	};

	$( document ).on(
		'barabi_core_wishlist_dropdown_item_is_removed',
		function ( e, removedItemID ) {
			var $wishlistLink = $( '.qodef-wishlist .qodef-m-link' );

			if ( $wishlistLink.length ) {
				$wishlistLink.each(
					function () {
						var $thisWishlistLink = $( this ),
							$wishlistTitle    = $thisWishlistLink.find( '.qodef-m-link-label' );

						if ( $thisWishlistLink.data( 'id' ) === removedItemID && $thisWishlistLink.hasClass( 'qodef--added' ) ) {
							$thisWishlistLink.removeClass( 'qodef--added' );

							if ( $wishlistTitle.length ) {
								$wishlistTitle.text( $wishlistTitle.data( 'title' ) );
							}
						}
					}
				);
			}
		}
	);

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_accordion = {};

	$( document ).ready(
		function () {
			qodefAccordion.init();
		}
	);

	var qodefAccordion = {
		init: function () {
			var $holder = $( '.qodef-accordion' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						qodefAccordion.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			if ( $currentItem.hasClass( 'qodef-behavior--accordion' ) ) {
				qodefAccordion.initAccordion( $currentItem );
			}

			if ( $currentItem.hasClass( 'qodef-behavior--toggle' ) ) {
				qodefAccordion.initToggle( $currentItem );
			}

			$currentItem.addClass( 'qodef--init' );
		},
		initAccordion: function ( $accordion ) {
			$accordion.accordion(
				{
					animate: 'swing',
					collapsible: true,
					active: 0,
					icons: '',
					heightStyle: 'auto',
				}
			);
		},
		initToggle: function ( $toggle ) {
			var $toggleAccordionTitle = $toggle.find( '.qodef-accordion-title' );

			$toggleAccordionTitle.off().on(
				'mouseenter',
				function () {
					$( this ).addClass( 'ui-state-hover' );
				}
			).on(
				'mouseleave',
				function () {
					$( this ).removeClass( 'ui-state-hover' );
				}
			).on(
				'click',
				function ( e ) {
					e.preventDefault();
					e.stopImmediatePropagation();

					var $thisTitle = $( this );

					if ( $thisTitle.hasClass( 'ui-state-active' ) ) {
						$thisTitle.removeClass( 'ui-state-active' );
						$thisTitle.next().removeClass( 'ui-accordion-content-active' ).slideUp( 300 );
					} else {
						$thisTitle.addClass( 'ui-state-active' );
						$thisTitle.next().addClass( 'ui-accordion-content-active' ).slideDown( 400 );
					}
				}
			);
		}
	};

	qodefCore.shortcodes.barabi_core_accordion.qodefAccordion = qodefAccordion;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_banner = {};

	$( document ).ready(
		function () {
			qodefBanner.init();
		}
	);

	var qodefBanner = {
		init: function () {
			var $holder = $( '.qodef-banner.qodef-layout--link-button' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						qodefBanner.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {

			var $link = $currentItem.find( '.qodef-button' );

			$link.on(
				'mouseenter',
				function () {
					$currentItem.addClass( 'qodef--hover' );
				}
			).on(
				'mouseleave',
				function () {
					$currentItem.removeClass( 'qodef--hover' );
				}
			);
		}
	};

	qodefCore.shortcodes.barabi_core_banner.qodefBanner = qodefBanner;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_button = {};

	$( document ).ready(
		function () {
			qodefButton.init();
		}
	);

	var qodefButton = {
		init: function () {
			this.buttons = $( '.qodef-button' );

			if ( this.buttons.length ) {
				this.buttons.each(
					function () {
						qodefButton.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefButton.buttonHoverColor( $currentItem );
			qodefButton.buttonHoverBgColor( $currentItem );
			qodefButton.buttonHoverBorderColor( $currentItem );
		},
		buttonHoverColor: function ( $button ) {
			if ( typeof $button.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $button.data( 'hover-color' );
				var originalColor = $button.css( 'color' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'color', hoverColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'color', originalColor );
					}
				);
			}
		},
		buttonHoverBgColor: function ( $button ) {
			if ( typeof $button.data( 'hover-background-color' ) !== 'undefined' ) {
				var hoverBackgroundColor    = $button.data( 'hover-background-color' );
				var originalBackgroundColor = $button.css( 'background-color' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'background-color', hoverBackgroundColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'background-color', originalBackgroundColor );
					}
				);
			}
		},
		buttonHoverBorderColor: function ( $button ) {
			if ( typeof $button.data( 'hover-border-color' ) !== 'undefined' ) {
				var hoverBorderColor    = $button.data( 'hover-border-color' );
				var originalBorderColor = $button.css( 'borderTopColor' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'border-color', hoverBorderColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'border-color', originalBorderColor );
					}
				);
			}
		},
		changeColor: function ( $button, cssProperty, color ) {
			$button.css( cssProperty, color );
		}
	};

	qodefCore.shortcodes.barabi_core_button.qodefButton = qodefButton;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_counter = {};

	$( document ).ready(
		function () {
			qodefCounter.init();
		}
	);

	var qodefCounter = {
		init: function () {
			this.counters = $( '.qodef-counter' );

			if ( this.counters.length ) {
				this.counters.each(
					function () {
						qodefCounter.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $counterElement = $currentItem.find( '.qodef-m-digit' ),
				options         = qodefCounter.generateOptions( $currentItem );

			qodefCore.qodefIsInViewport.check(
				$currentItem,
				function () {
					qodefCounter.counterScript( $counterElement, options );
				},
				false
			);
		},
		generateOptions: function ( $counter ) {
			var options   = {};
			options.start = typeof $counter.data( 'start-digit' ) !== 'undefined' && $counter.data( 'start-digit' ) !== '' ? $counter.data( 'start-digit' ) : 0;
			options.end   = typeof $counter.data( 'end-digit' ) !== 'undefined' && $counter.data( 'end-digit' ) !== '' ? $counter.data( 'end-digit' ) : null;
			options.step  = typeof $counter.data( 'step-digit' ) !== 'undefined' && $counter.data( 'step-digit' ) !== '' ? $counter.data( 'step-digit' ) : 1;
			options.delay = typeof $counter.data( 'step-delay' ) !== 'undefined' && $counter.data( 'step-delay' ) !== '' ? parseInt( $counter.data( 'step-delay' ), 10 ) : 100;
			options.txt   = typeof $counter.data( 'digit-label' ) !== 'undefined' && $counter.data( 'digit-label' ) !== '' ? $counter.data( 'digit-label' ) : '';

			return options;
		},
		counterScript: function ( $counterElement, options ) {
			var defaults = {
				start: 0,
				end: null,
				step: 1,
				delay: 50,
				txt: '',
			};

			var settings = $.extend( defaults, options || {} );
			var nb_start = settings.start;
			var nb_end   = settings.end;

			$counterElement.text( nb_start + settings.txt );

			// Timer
			// Launches every "settings.delay"
			var counterInterval = setInterval(
				function () {
					// Definition of conditions of arrest
					if ( nb_end !== null && nb_start >= nb_end ) {
						return;
					}

					// incrementation
					nb_start = nb_start + settings.step;

					// Check is ended
					if ( nb_start >= nb_end ) {
						nb_start = nb_end;

						clearInterval( counterInterval );
					}

					// display
					$counterElement.text( nb_start + settings.txt );
				},
				settings.delay
			);
		}
	};

	qodefCore.shortcodes.barabi_core_counter.qodefCounter = qodefCounter;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_countdown = {};

	$( document ).ready(
		function () {
			qodefCountdown.init();
		}
	);

	var qodefCountdown = {
		init: function () {
			this.countdowns = $( '.qodef-countdown' );

			if ( this.countdowns.length ) {
				this.countdowns.each(
					function () {
						qodefCountdown.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var $countdownElement = $currentItem.find( '.qodef-m-date' ),
				dateFormats       = ['week', 'day', 'hour', 'minute', 'second'],
				options           = qodefCountdown.generateOptions( $currentItem, dateFormats );

			qodefCountdown.initCountdown( $countdownElement, options, dateFormats );
		},
		generateOptions: function ( $countdown, dateFormats ) {
			var options = {};

			options.date = typeof $countdown.data( 'date' ) !== 'undefined' ? $countdown.data( 'date' ) : null;

			for ( var i = 0; i < dateFormats.length; i++ ) {
				var label       = dateFormats[i] + 'Label',
					labelPlural = dateFormats[i] + 'LabelPlural';

				options[label]       = typeof $countdown.data( dateFormats[i] + '-label' ) !== 'undefined' ? $countdown.data( dateFormats[i] + '-label' ) : '';
				options[labelPlural] = typeof $countdown.data( dateFormats[i] + '-label-plural' ) !== 'undefined' ? $countdown.data( dateFormats[i] + '-label-plural' ) : '';
			}

			return options;
		},
		initCountdown: function ( $countdownElement, options, dateFormats ) {
			var countDownDate = new Date( options.date ).getTime();

			// Update the count down every 1 second
			var x = setInterval(
				function () {

					// Get today's date and time
					var now = new Date().getTime();

					// Find the distance between now and the count down date
					var distance = countDownDate - now;

					// Time calculations for days, hours, minutes and seconds
					this.weeks   = Math.floor( distance / (1000 * 60 * 60 * 24 * 7) );
					this.days    = Math.floor( (distance % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24) );
					this.hours   = Math.floor( (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60) );
					this.minutes = Math.floor( (distance % (1000 * 60 * 60)) / (1000 * 60) );
					this.seconds = Math.floor( (distance % (1000 * 60)) / 1000 );

					for ( var i = 0; i < dateFormats.length; i++ ) {
						var dateName = dateFormats[i] + 's';
						qodefCountdown.initiateDate( $countdownElement, this[dateName], dateFormats[i], options );
					}

					// If the count down is finished, write some text
					if ( distance < 0 ) {
						clearInterval( x );
						qodefCountdown.afterClearInterval( $countdownElement, dateFormats, options );
					}
				},
				1000
			);
		},
		initiateDate: function ( $countdownElement, date, dateFormat, options ) {
			var $holder = $countdownElement.find( '.qodef-' + dateFormat + 's' );

			$holder.find( '.qodef-label' ).html( ( 1 === date ) ? options[dateFormat + 'Label'] : options[dateFormat + 'LabelPlural'] );

			date = (date < 10) ? '0' + date : date;

			$holder.find( '.qodef-digit' ).html( date );
		},
		afterClearInterval: function( $countdownElement, dateFormats, options ) {
			for ( var i = 0; i < dateFormats.length; i++ ) {
				var $holder = $countdownElement.find( '.qodef-' + dateFormats[i] + 's' );

				$holder.find( '.qodef-label' ).html( options[dateFormats[i] + 'LabelPlural'] );
				$holder.find( '.qodef-digit' ).html( '00' );
			}
		}
	};

	qodefCore.shortcodes.barabi_core_countdown.qodefCountdown = qodefCountdown;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_google_map = {};

	$( document ).ready(
		function () {
			qodefGoogleMap.init();
		}
	);

	var qodefGoogleMap = {
		init: function () {
			this.holder = $( '.qodef-google-map' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefGoogleMap.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			if ( typeof window.qodefGoogleMap !== 'undefined' ) {
				window.qodefGoogleMap.init( $currentItem.find( '.qodef-m-map' ) );
			}
		},
	};

	qodefCore.shortcodes.barabi_core_google_map.qodefGoogleMap = qodefGoogleMap;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_image_gallery                    = {};
	qodefCore.shortcodes.barabi_core_image_gallery.qodefSwiper        = qodef.qodefSwiper;
	qodefCore.shortcodes.barabi_core_image_gallery.qodefMasonryLayout = qodef.qodefMasonryLayout;
	qodefCore.shortcodes.barabi_core_image_gallery.qodefMagnificPopup = qodef.qodefMagnificPopup;
	qodefCore.shortcodes.barabi_core_image_gallery.qodefCustomCursor  = qodefCore.qodefCustomCursor;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_icon = {};

	$( document ).ready(
		function () {
			qodefIcon.init();
		}
	);

	var qodefIcon = {
		init: function () {
			this.icons = $( '.qodef-icon-holder' );

			if ( this.icons.length ) {
				this.icons.each(
					function () {
						qodefIcon.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefIcon.iconHoverColor( $currentItem );
			qodefIcon.iconHoverBgColor( $currentItem );
			qodefIcon.iconHoverBorderColor( $currentItem );
		},
		iconHoverColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-color' ) !== 'undefined' ) {
				var spanHolder    = $iconHolder.find( 'span' ).length ? $iconHolder.find( 'span' ) : $iconHolder;
				var originalColor = spanHolder.css( 'color' );
				var hoverColor    = $iconHolder.data( 'hover-color' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							spanHolder,
							'color',
							hoverColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							spanHolder,
							'color',
							originalColor
						);
					}
				);
			}
		},
		iconHoverBgColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-background-color' ) !== 'undefined' ) {
				var hoverBackgroundColor    = $iconHolder.data( 'hover-background-color' );
				var originalBackgroundColor = $iconHolder.css( 'background-color' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'background-color',
							hoverBackgroundColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'background-color',
							originalBackgroundColor
						);
					}
				);
			}
		},
		iconHoverBorderColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-border-color' ) !== 'undefined' ) {
				var hoverBorderColor    = $iconHolder.data( 'hover-border-color' );
				var originalBorderColor = $iconHolder.css( 'borderTopColor' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'border-color',
							hoverBorderColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'border-color',
							originalBorderColor
						);
					}
				);
			}
		},
		changeColor: function ( iconElement, cssProperty, color ) {
			iconElement.css(
				cssProperty,
				color
			);
		}
	};

	qodefCore.shortcodes.barabi_core_icon.qodefIcon = qodefIcon;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_progress_bar = {};

	$( document ).ready(
		function () {
			qodefProgressBar.init();
		}
	);

	/**
	 * Init progress bar shortcode functionality
	 */
	var qodefProgressBar = {
		init: function () {
			this.holder = $( '.qodef-progress-bar' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefProgressBar.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var layout = $currentItem.data( 'layout' );

			qodefCore.qodefIsInViewport.check(
				$currentItem,
				function () {
					$currentItem.addClass( 'qodef--init' );

					var $container = $currentItem.find( '.qodef-m-canvas' ),
						data       = qodefProgressBar.generateBarData( $currentItem, layout ),
						number     = $currentItem.data( 'number' ) / 100;

					switch (layout) {
						case 'circle':
							qodefProgressBar.initCircleBar( $container, data, number );
							break;
						case 'semi-circle':
							qodefProgressBar.initSemiCircleBar( $container, data, number );
							break;
						case 'line':
							data = qodefProgressBar.generateLineData( $currentItem, number );
							qodefProgressBar.initLineBar( $container, data );
							break;
						case 'custom':
							qodefProgressBar.initCustomBar( $container, data, number );
							break;
					}
				},
				false
			);
		},
		generateBarData: function ( thisBar, layout ) {
			var activeWidth   = thisBar.data( 'active-line-width' );
			var activeColor   = thisBar.data( 'active-line-color' );
			var inactiveWidth = thisBar.data( 'inactive-line-width' );
			var inactiveColor = thisBar.data( 'inactive-line-color' );
			var easing        = 'linear';
			var duration      = typeof thisBar.data( 'duration' ) !== 'undefined' && thisBar.data( 'duration' ) !== '' ? parseInt( thisBar.data( 'duration' ), 10 ) : 1600;
			var textColor     = thisBar.data( 'text-color' );

			return {
				strokeWidth: activeWidth,
				color: activeColor,
				trailWidth: inactiveWidth,
				trailColor: inactiveColor,
				easing: easing,
				duration: duration,
				svgStyle: {
					width: '100%',
					height: '100%'
				},
				text: {
					style: {
						color: textColor
					},
					autoStyleContainer: false
				},
				from: {
					color: inactiveColor
				},
				to: {
					color: activeColor
				},
				step: function ( state, bar ) {
					if ( layout !== 'custom' ) {
						bar.setText( Math.round( bar.value() * 100 ) + '%' );
					}
				},
			};
		},
		generateLineData: function ( thisBar, number ) {
			var height         = thisBar.data( 'active-line-width' );
			var activeColor    = thisBar.data( 'active-line-color' );
			var inactiveHeight = thisBar.data( 'inactive-line-width' );
			var inactiveColor  = thisBar.data( 'inactive-line-color' );
			var duration       = typeof thisBar.data( 'duration' ) !== 'undefined' && thisBar.data( 'duration' ) !== '' ? parseInt( thisBar.data( 'duration' ), 10 ) : 1600;
			var textColor      = thisBar.data( 'text-color' );

			return {
				percentage: number * 100,
				duration: duration,
				fillBackgroundColor: activeColor,
				backgroundColor: inactiveColor,
				height: height,
				inactiveHeight: inactiveHeight,
				followText: thisBar.hasClass( 'qodef-percentage--floating' ),
				textColor: textColor,
			};
		},
		initCircleBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.Circle( $container[0], data );

				$bar.animate( number );
			}
		},
		initSemiCircleBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.SemiCircle( $container[0], data );

				$bar.animate( number );
			}
		},
		initCustomBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.Path( $container[0], data );

				$bar.set( 0 );
				$bar.animate( number );
			}
		},
		initLineBar: function ( $container, data ) {
			$container.LineProgressbar( data );
		},
		checkBar: function ( $container ) {
			// check if svg is already in container, elementor fix
			return ! $container.find( 'svg' ).length;
		}
	};

	qodefCore.shortcodes.barabi_core_progress_bar.qodefProgressBar = qodefProgressBar;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_simple_slider = {};

	qodefCore.shortcodes.barabi_core_simple_slider.qodefSwiper = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_image_with_text                    = {};
	qodefCore.shortcodes.barabi_core_image_with_text.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_single_image = {};

	$( document ).ready(
		function () {
			qodefSingleImage.init();
		}
	);

	var qodefSingleImage = {
		init: function () {
			this.holder = $( '.qodef-single-image' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefSingleImage.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			if ( $currentItem.hasClass( 'qodef-has-appear' ) ) {

				qodef.qodefWaitForImages.check(
					$currentItem,
					function () {
						qodefCore.qodefIsInViewport.check(
							$currentItem,
							function () {
								$currentItem.addClass( 'qodef--appeared' );
							}
						);
					}
				);
			}
		},
	};

	qodefCore.shortcodes.barabi_core_single_image.qodefSingleImage = qodefSingleImage;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_stacked_images = {};

	$( document ).ready(
		function () {
			qodefStackedImages.init();
		}
	);

	var qodefStackedImages = {
		init: function () {
			var holder = $( '.qodef-stacked-images' );

			if ( holder.length ) {
				holder.each(
					function () {
						var images = $( this ).find('.qodef-m-image');

						if ( images.length ) {
							images.each(
								function ( i ) {
									var image = $( this );

									setTimeout(
										function () {
											image.addClass( 'qodef--appeared' );
										},
										500 * i
									);
								}
							);
						}
					}
				);
			}
		},
	};

	qodefCore.shortcodes.barabi_core_stacked_images.qodefStackedImages = qodefStackedImages;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_tabs = {};

	$( document ).ready(
		function () {
			qodefTabs.init();
		}
	);

	var qodefTabs = {
		init: function () {
			this.holder = $( '.qodef-tabs' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefTabs.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			$currentItem.children( '.qodef-tabs-content' ).each(
				function ( index ) {
					index = index + 1;

					var $that    = $( this ),
						link     = $that.attr( 'id' ),
						$navItem = $that.parent().find( '.qodef-tabs-navigation li:nth-child(' + index + ') a' ),
						navLink  = $navItem.attr( 'href' );

					link = '#' + link;

					if ( link.indexOf( navLink ) > -1 ) {
						$navItem.attr(
							'href',
							link
						);
					}
				}
			);

			$currentItem.addClass( 'qodef--init' ).tabs();
		},
		setHeight ( $holder ) {
			var $navigation      = $holder.find( '.qodef-tabs-navigation' ),
				$content         = $holder.find( '.qodef-tabs-content' ),
				navHeight,
				contentHeight,
				maxContentHeight = 0;

			if ( $navigation.length ) {
				navHeight = $navigation.outerHeight( true );
			}

			if ( $content.length ) {
				$content.each(
					function () {
						contentHeight = $( this ).outerHeight( true );
						maxContentHeight = contentHeight > maxContentHeight ? contentHeight : maxContentHeight;
					}
				)
			}

			$holder.height(navHeight + maxContentHeight);
		}
	};

	qodefCore.shortcodes.barabi_core_tabs.qodefTabs = qodefTabs;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_video_button                    = {};
	qodefCore.shortcodes.barabi_core_video_button.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );

(function ($) {
	'use strict';

	qodefCore.shortcodes.barabi_core_text_marquee = {};

	$(document).ready(
		function () {
			qodefTextMarquee.init();
		}
	);

	$(window).resize(
		function () {
			qodefTextMarquee.init();
		}
	);

	var qodefTextMarquee = {
		init               : function () {
			this.holder = $('.qodef-text-marquee');

			if (this.holder.length) {
				this.holder.each(
					function () {
						qodefTextMarquee.prepareContent($(this));
						qodefTextMarquee.calculateWidthRatio($(this));
					}
				);
			}
		},
		prepareContent     : function ($currentItem) {
			var $contentInnerCopy = $currentItem.find('.qodef--copy');

			// remove holder init class
			$currentItem.removeClass('qodef--init');

			// remove duplicated content
			if ($contentInnerCopy.length) {
				$contentInnerCopy.remove();
			}
		},
		calculateWidthRatio: function ($currentItem) {
			var $content = $currentItem.find('.qodef-m-content'),
				$contentInner = $content.find('.qodef-m-content-inner'),
				multiplyCoef = $contentInner.outerWidth() > 0 ? Math.ceil($content.outerWidth() / $contentInner.outerWidth()) : 1,
				i;

			if ($contentInner.html().length) {
				// duplicate content at least once
				for (i = 0; i < multiplyCoef; i++) {
					qodefTextMarquee.duplicateContent($content, $contentInner);
				}
			}

			// add holder init class
			$currentItem.addClass('qodef--init');
		},
		duplicateContent   : function ($content, $contentInner) {
			$contentInner.clone().appendTo($content).addClass('qodef--copy');
		},
	};

	qodefCore.shortcodes.barabi_core_text_marquee.qodefTextMarquee = qodefTextMarquee;

})(jQuery);

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_video_slider                   = {};
	qodefCore.shortcodes.barabi_core_video_slider.qodefSwiper       = qodef.qodefSwiper;
	
	$( document ).ready(
		function () {
			qodefVideoSlider.init();
		}
	);
	
	$( document ).on(
		'barabi_trigger_swiper_is_initialized',
		function ( e, $holder ) {
			var swiper = $holder[0].swiper;
			qodefVideoSlider.initPlayPause( $holder, swiper );
		}
	);
	
	var qodefVideoSlider = {
		init: function () {
			this.holder = $( '.qodef-video-slider' );
			
			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefVideoSlider.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			var swiper = $currentItem[0].swiper;
			
			swiper.on( 'slideChange', function() {
				qodefVideoSlider.initPlayPause( $currentItem, swiper );
			} )
		},
		initPlayPause: function ( $currentItem, swiper ) {
			var swiperSlides = $currentItem.find( '.swiper-slide' ),
				allVideos = $currentItem.find( 'video' ),
				activeSlideVideo = $(swiperSlides[swiper.activeIndex]).find( 'video' );
			
			//First stop all videos from playing
			if( allVideos.length ) {
				allVideos.each( function() {
					$(this)[0].pause();
				} );
			}
			
			//Then play active slide video
			if( activeSlideVideo.length ) {
				activeSlideVideo[0].play();
			}
		}
	};
	
	qodefCore.shortcodes.barabi_core_video_slider.qodefVideoSlider = qodefVideoSlider;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefStickySidebar.init();
		}
	);

	var qodefStickySidebar = {
		init: function () {
			var info = $( '.widget_barabi_core_sticky_sidebar' );

			if ( info.length && qodefCore.windowWidth > 1024 ) {
				info.wrapper = info.parents( '#qodef-page-sidebar' );
				info.offsetM = info.offset().top - info.wrapper.offset().top;
				info.adj     = 15;

				qodefStickySidebar.callStack( info );

				$( window ).on(
					'resize',
					function () {
						if ( qodefCore.windowWidth > 1024 ) {
							qodefStickySidebar.callStack( info );
						}
					}
				);

				$( window ).on(
					'scroll',
					function () {
						if ( qodefCore.windowWidth > 1024 ) {
							qodefStickySidebar.infoPosition( info );
						}
					}
				);
			}
		},
		calc: function ( info ) {
			var content = $( '.qodef-page-content-section' ),
				headerH = qodefCore.body.hasClass( 'qodef-header-appearance--none' ) ? 0 : parseInt( qodefGlobal.vars.headerHeight, 10 );

			// If posts not found set content to have the same height as the sidebar
			if ( qodefCore.windowWidth > 1024 && content.height() < 100 ) {
				content.css( 'height', info.wrapper.height() - content.height() );
			}

			info.start = content.offset().top;
			info.end   = content.outerHeight();
			info.h     = info.wrapper.height();
			info.w     = info.outerWidth();
			info.left  = info.offset().left;
			info.top   = headerH + qodefGlobal.vars.adminBarHeight - info.offsetM;
			info.data( 'state', 'top' );
		},
		infoPosition: function ( info ) {
			if ( qodefCore.scroll < info.start - info.top && qodefCore.scroll + info.h && info.data( 'state' ) !== 'top' ) {
				gsap.to(
					info.wrapper,
					.1,
					{
						y: 5,
					}
				);
				gsap.to(
					info.wrapper,
					.3,
					{
						y: 0,
						delay: .1,
					}
				);
				info.data( 'state', 'top' );
				info.wrapper.css(
					{
						'position': 'static',
					}
				);
			} else if ( qodefCore.scroll >= info.start - info.top && qodefCore.scroll + info.h + info.adj <= info.start + info.end &&
				info.data( 'state' ) !== 'fixed' ) {
				var c = info.data( 'state' ) === 'top' ? 1 : -1;
				info.data( 'state', 'fixed' );
				info.wrapper.css(
					{
						'position': 'fixed',
						'top': info.top,
						'left': info.left,
						'width': info.w,
					}
				);
				gsap.fromTo(
					info.wrapper,
					.2,
					{
						y: 0
					},
					{
						y: c * 10,
						ease: Power4.easeInOut
					}
				);
				gsap.to(
					info.wrapper,
					.2,
					{
						y: 0,
						delay: .2,
					}
				);
			} else if ( qodefCore.scroll + info.h + info.adj > info.start + info.end && info.data( 'state' ) !== 'bottom' ) {
				info.data( 'state', 'bottom' );
				info.wrapper.css(
					{
						'position': 'absolute',
						'top': info.end - info.h - info.adj,
						'left': 'auto',
						'width': info.w,
					}
				);
				gsap.fromTo(
					info.wrapper,
					.1,
					{
						y: 0
					},
					{
						y: -5,
					}
				);
				gsap.to(
					info.wrapper,
					.3,
					{
						y: 0,
						delay: .1,
					}
				);
			}
		},
		callStack: function ( info ) {
			this.calc( info );
			this.infoPosition( info );
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'barabi_core_blog_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

	$( window ).on(
		'load',
		function () {
			qodefBlogList.init();
		}
	);

	$( document ).on(
		'barabi_trigger_get_new_posts',
		function () {
			qodefBlogList.init();
		}
	);

	var qodefBlogList = {
		init: function () {
			this.holder = $( '.qodef-shortcode.qodef-blog, .qodef-blog.qodef--list' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefBlogList.initHover( $( this ) );
					}
				);
			}
		},
		initHover: function ( $currentList ) {
			var $items = $currentList.find( '.qodef-e' );

			if ( $items.length ) {
				$items.each(
					function () {
						var $item  = $( this );
						var $links = $item.find( '.qodef-e-media-image a, .qodef-e-title-link, .qodef-e-read-more a' );

						$links.on(
							'mouseenter',
							function () {
								$item.addClass( 'qodef--hover' );
							}
						).on(
							'mouseleave',
							function () {
								$item.removeClass( 'qodef--hover' );
							}
						);
					}
				);
			}
		}
	};

	qodefCore.shortcodes[shortcode].qodefBlogList      = qodef.qodefBlogList;
	qodefCore.shortcodes[shortcode].qodefResizeIframes = qodef.qodefResizeIframes;

})( jQuery );

(function ( $ ) {
	'use strict';

	var fixedHeaderAppearance = {
		showHideHeader: function ( $pageOuter, $header ) {
			if ( qodefCore.windowWidth > 1024 ) {
				if ( qodefCore.scroll <= 0 ) {
					qodefCore.body.removeClass( 'qodef-header--fixed-display' );
					$pageOuter.css( 'padding-top', '0' );
					$header.css( 'margin-top', '0' );
				} else {
					qodefCore.body.addClass( 'qodef-header--fixed-display' );
					$pageOuter.css( 'padding-top', parseInt( qodefGlobal.vars.headerHeight + qodefGlobal.vars.topAreaHeight ) + 'px' );
					$header.css( 'margin-top', parseInt( qodefGlobal.vars.topAreaHeight ) + 'px' );
				}
			}
		},
		init: function () {

			if ( ! qodefCore.body.hasClass( 'qodef-header--vertical' ) ) {
				var $pageOuter = $( '#qodef-page-outer' ),
					$header    = $( '#qodef-page-header' );

				fixedHeaderAppearance.showHideHeader( $pageOuter, $header );

				$( window ).scroll(
					function () {
						fixedHeaderAppearance.showHideHeader( $pageOuter, $header );
					}
				);

				$( window ).resize(
					function () {
						$pageOuter.css( 'padding-top', '0' );
						fixedHeaderAppearance.showHideHeader( $pageOuter, $header );
					}
				);
			}
		}
	};

	qodefCore.fixedHeaderAppearance = fixedHeaderAppearance.init;

})( jQuery );

(function ( $ ) {
	'use strict';

	var stickyHeaderAppearance = {
		header: '',
		docYScroll: 0,
		init: function () {
			var displayAmount = stickyHeaderAppearance.displayAmount();

			// Set variables
			stickyHeaderAppearance.header 	  = $( '.qodef-header-sticky' );
			stickyHeaderAppearance.docYScroll = $( document ).scrollTop();

			// Set sticky visibility
			stickyHeaderAppearance.setVisibility( displayAmount );

			$( window ).scroll(
				function () {
					stickyHeaderAppearance.setVisibility( displayAmount );
				}
			);
		},
		displayAmount: function () {
			if ( qodefGlobal.vars.qodefStickyHeaderScrollAmount !== 0 ) {
				return parseInt( qodefGlobal.vars.qodefStickyHeaderScrollAmount, 10 );
			} else {
				return parseInt( qodefGlobal.vars.headerHeight + qodefGlobal.vars.adminBarHeight, 10 );
			}
		},
		setVisibility: function ( displayAmount ) {
			var isStickyHidden = qodefCore.scroll < displayAmount;

			if ( stickyHeaderAppearance.header.hasClass( 'qodef-appearance--up' ) ) {
				var currentDocYScroll = $( document ).scrollTop();

				isStickyHidden = (currentDocYScroll > stickyHeaderAppearance.docYScroll && currentDocYScroll > displayAmount) || (currentDocYScroll < displayAmount);

				stickyHeaderAppearance.docYScroll = $( document ).scrollTop();
			}

			stickyHeaderAppearance.showHideHeader( isStickyHidden );
		},
		showHideHeader: function ( isStickyHidden ) {
			if ( isStickyHidden ) {
				qodefCore.body.removeClass( 'qodef-header--sticky-display' );
			} else {
				qodefCore.body.addClass( 'qodef-header--sticky-display' );
			}
		},
	};

	qodefCore.stickyHeaderAppearance = stickyHeaderAppearance.init;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideAreaMobileHeader.init();
		}
	);

	var qodefSideAreaMobileHeader = {
		init: function () {
			var $holder = $( '#qodef-side-area-mobile-header' );

			if ( $holder.length && qodefCore.body.hasClass( 'qodef-mobile-header--side-area' ) ) {
				var $navigation = $holder.find( '.qodef-m-navigation' );

				qodefSideAreaMobileHeader.initOpenerTrigger( $holder, $navigation );
				qodefSideAreaMobileHeader.initNavigationClickToggle( $navigation );

				if ( typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
					qodefCore.qodefPerfectScrollbar.init( $holder );
				}
			}
		},
		initOpenerTrigger: function ( $holder, $navigation ) {
			var $openerIcon = $( '.qodef-side-area-mobile-header-opener' ),
				$closeIcon  = $holder.children( '.qodef-m-close' );

			if ( $openerIcon.length && $navigation.length ) {
				$openerIcon.on(
					'tap click',
					function ( e ) {
						e.stopPropagation();
						e.preventDefault();

						if ( $holder.hasClass( 'qodef--opened' ) ) {
							$holder.removeClass( 'qodef--opened' );
						} else {
							$holder.addClass( 'qodef--opened' );
						}
					}
				);
			}

			$closeIcon.on(
				'tap click',
				function ( e ) {
					e.stopPropagation();
					e.preventDefault();

					if ( $holder.hasClass( 'qodef--opened' ) ) {
						$holder.removeClass( 'qodef--opened' );
					}
				}
			);
		},
		initNavigationClickToggle: function ( $navigation ) {
			var $menuItems = $navigation.find( 'ul li.menu-item-has-children' );

			$menuItems.each(
				function () {
					var $thisItem        = $( this ),
						$elementToExpand = $thisItem.find( ' > .qodef-drop-down-second, > ul' ),
						$dropdownOpener  = $thisItem.find( '> .qodef-menu-item-arrow' ),
						slideUpSpeed     = 'fast',
						slideDownSpeed   = 'slow';

					$dropdownOpener.on(
						'click tap',
						function ( e ) {
							e.preventDefault();
							e.stopPropagation();

							if ( $elementToExpand.is( ':visible' ) ) {
								$thisItem.removeClass( 'qodef-menu-item--open' );
								$elementToExpand.slideUp( slideUpSpeed );
							} else if ( $dropdownOpener.parent().parent().children().hasClass( 'qodef-menu-item--open' ) && $dropdownOpener.parent().parent().parent().hasClass( 'qodef-vertical-menu' ) ) {
								$thisItem.parent().parent().children().removeClass( 'qodef-menu-item--open' );
								$thisItem.parent().parent().children().find( ' > .qodef-drop-down-second' ).slideUp( slideUpSpeed );

								$thisItem.addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							} else {

								if ( ! $thisItem.parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
									$menuItems.removeClass( 'qodef-menu-item--open' );
									$menuItems.find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								if ( $thisItem.parent().parent().children().hasClass( 'qodef-menu-item--open' ) ) {
									$thisItem.parent().parent().children().removeClass( 'qodef-menu-item--open' );
									$thisItem.parent().parent().children().find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								$thisItem.addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							}
						}
					);
				}
			);
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearchCoversHeader.init();
		}
	);

	var qodefSearchCoversHeader = {
		init: function () {
			var $searchOpener = $( 'a.qodef-search-opener' ),
				$searchForm   = $( '.qodef-search-cover-form' ),
				$searchClose  = $searchForm.find( '.qodef-m-close' );

			if ( $searchOpener.length && $searchForm.length ) {
				$searchOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchCoversHeader.openCoversHeader( $searchForm );
					}
				);
				$searchClose.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchCoversHeader.closeCoversHeader( $searchForm );
					}
				);
			}
		},
		openCoversHeader: function ( $searchForm ) {
			qodefCore.body.addClass( 'qodef-covers-search--opened qodef-covers-search--fadein' );
			qodefCore.body.removeClass( 'qodef-covers-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).focus();
				},
				600
			);
		},
		closeCoversHeader: function ( $searchForm ) {
			qodefCore.body.removeClass( 'qodef-covers-search--opened qodef-covers-search--fadein' );
			qodefCore.body.addClass( 'qodef-covers-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).val( '' );
					$searchForm.find( '.qodef-m-form-field' ).blur();
					qodefCore.body.removeClass( 'qodef-covers-search--fadeout' );
				},
				300
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearch.init();
		}
	);

	var qodefSearch = {
		init: function () {
			this.search = $( 'a.qodef-search-opener' );

			if ( this.search.length ) {
				this.search.each(
					function () {
						var $thisSearch = $( this );

						qodefSearch.searchHoverColor( $thisSearch );
					}
				);
			}
		},
		searchHoverColor: function ( $searchHolder ) {
			if ( typeof $searchHolder.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $searchHolder.data( 'hover-color' ),
					originalColor = $searchHolder.css( 'color' );

				$searchHolder.on(
					'mouseenter',
					function () {
						$searchHolder.css( 'color', hoverColor );
					}
				).on(
					'mouseleave',
					function () {
						$searchHolder.css( 'color', originalColor );
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefPredefinedSpinner.init();
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			const isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				qodefPredefinedSpinner.init( isEditMode );
			}
		}
	);

	const qodefPredefinedSpinner = {
		init( isEditMode ) {
			const $holder = $( '#qodef-page-spinner.qodef-layout--predefined' );

			if ( $holder.length ) {
				if ( isEditMode ) {
				} else {
					qodefPredefinedSpinner.animateSpinner( $holder );
				}
			}
		},
		animateSpinner( $holder ) {
			let $svg         = $holder.find( 'svg' ),
				tlOutStarted = false,
				circles      = $svg.find( 'circle' );

			let tl = gsap.timeline(
				{
					paused: true,
					onStart: () => {
						$holder.addClass( 'qodef--init' );
					},
					onComplete: () => {
						if ( qodefCore.qodefSpinner.windowLoaded && ! tlOutStarted ) {
							tlOut.play();
						} else {
							tl.restart();
						}
					},
				}
			);

			var tlOut = gsap.timeline(
				{
					paused: true,
					onStart: () => {
						tlOutStarted = true;
						$holder.addClass( 'qodef--animation-out-started' );
					},
					onComplete: () => {
						$holder.addClass( 'qodef--finished' );
					},
				}
			);

			tlOut
			.to(
				circles,
				{
					scale: 0,
					duration: 1,
					ease: 'Quad.easeOut',
				},
			);

			tl
			.to(
				circles,
				{
					'--qode-delta': 3,
					duration: 2,
					// ease: 'power2.out',
					stagger: {
						from: 'random',
						amount: .2,
					}
				},
				'<'
			);

			qodef.qodefWaitForImages.check(
				$holder,
				function () {
					tl.play();
				}
			);
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function() {
			qodefProgressBarSpinner.init();
		}
	);

	$( window ).on(
		'load',
		function () {
			qodefProgressBarSpinner.windowLoaded = true;
			qodefProgressBarSpinner.completeAnimation();
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				qodefProgressBarSpinner.init( isEditMode );
			}
		}
	);

	var qodefProgressBarSpinner = {
		holder: '',
		windowLoaded: false,
		percentNumber: 0,
		init: function ( isEditMode ) {
			this.holder = $( '#qodef-page-spinner.qodef-layout--progress-bar' );

			if ( this.holder.length ) {
				qodefProgressBarSpinner.animateSpinner( this.holder, isEditMode );
			}
		},
		animateSpinner: function ( $holder, isEditMode ) {
			var $numberHolder = $holder.find( '.qodef-m-spinner-number-label' ),
				$spinnerLine  = $holder.find( '.qodef-m-spinner-line-front' );

			$spinnerLine.animate(
				{ 'width': '100%' },
				10000,
				'linear'
			);

			var numberInterval = setInterval(
				function () {
					qodefProgressBarSpinner.animatePercent( $numberHolder, qodefProgressBarSpinner.percentNumber );

					if ( qodefProgressBarSpinner.windowLoaded ) {
						clearInterval( numberInterval );
					}
				},
				100
			);

			if ( isEditMode ) {
				qodefProgressBarSpinner.fadeOutLoader( $holder );
			}
		},
		completeAnimation: function () {
			var $holder = qodefProgressBarSpinner.holder.length ? qodefProgressBarSpinner.holder : $( '#qodef-page-spinner.qodef-layout--progress-bar' );

			var numberIntervalFastest = setInterval(
				function () {

					if ( qodefProgressBarSpinner.percentNumber >= 100 ) {
						clearInterval( numberIntervalFastest );

						$holder.find( '.qodef-m-spinner-line-front' ).stop().animate(
							{ 'width': '100%' },
							500
						);

						$holder.addClass( 'qodef--finished' );

						setTimeout(
							function () {
								qodefProgressBarSpinner.fadeOutLoader( $holder );
							},
							600
						);
					} else {
						qodefProgressBarSpinner.animatePercent(
							$holder.find( '.qodef-m-spinner-number-label' ),
							qodefProgressBarSpinner.percentNumber
						);
					}
				},
				6
			);
		},
		animatePercent: function ( $numberHolder, percentNumber ) {
			if ( percentNumber < 100 ) {
				percentNumber += 5;
				$numberHolder.text( percentNumber );

				qodefProgressBarSpinner.percentNumber = percentNumber;
			}
		},
		fadeOutLoader: function ( $holder, speed, delay, easing ) {
			speed  = speed ? speed : 600;
			delay  = delay ? delay : 0;
			easing = easing ? easing : 'swing';

			$holder.delay( delay ).fadeOut( speed, easing );

			$( window ).on(
				'bind',
				'pageshow',
				function ( event ) {
					if ( event.originalEvent.persisted ) {
						$holder.fadeOut( speed, easing );
					}
				}
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefTextualSpinner.init();
		}
	);

	$( window ).on(
		'load',
		function () {
			qodefTextualSpinner.windowLoaded = true;
		}
	);

	$( window ).on(
		'elementor/frontend/init',
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );

			if ( isEditMode ) {
				qodefTextualSpinner.init( isEditMode );
			}
		}
	);

	var qodefTextualSpinner = {
		init ( isEditMode ) {
			var $holder = $( '#qodef-page-spinner.qodef-layout--textual' );

			if ( $holder.length ) {
				if ( isEditMode ) {
					qodefTextualSpinner.fadeOutLoader( $holder );
				} else {
					qodefTextualSpinner.splitText( $holder );
				}
			}
		},
		splitText ( $holder ) {
			var $textHolder = $holder.find( '.qodef-m-text' );

			if ( $textHolder.length ) {
				var text     = $textHolder.text().trim(),
					chars    = text.split( '' ),
					cssClass = '';

				$textHolder.empty();

				chars.forEach(
					( element ) => {
						cssClass = (element === ' ' ? 'qodef-m-empty-char' : ' ');
						$textHolder.append( '<span class="qodef-m-char ' + cssClass + '">' + element + '</span>' );
					}
				);

				setTimeout(
					() => {
						qodefTextualSpinner.animateSpinner( $holder );
					}, 100
				);
			}
		},
		animateSpinner ( $holder ) {
			$holder.addClass( 'qodef--init' );

			function animationLoop ( animationProps ) {
				var $chars      = $holder.find( '.qodef-m-char' ),
					charsLength = $chars.length - 1;

				if ( $chars.length ) {
					$chars.each(
						( index, element ) => {
							var $thisChar = $( element );

							setTimeout(
								() => {
									$thisChar.animate(
									    animationProps.type,
										animationProps.duration,
										animationProps.easing,
										() => {
											if ( index === charsLength ) {
												if ( 1 === animationProps.repeat ) {
													animationLoop(
													    {
                                                            type: { opacity: 0 },
                                                            duration: 1200,
                                                            easing: 'swing',
                                                            delay: 0,
                                                            repeat: 0,
                                                        }
													);
												} else {
													if ( ! qodefTextualSpinner.windowLoaded ) {
														animationLoop(
														    {
                                                                type: { opacity: 1 },
                                                                duration: 1800,
                                                                easing: 'swing',
                                                                delay: 160,
                                                                repeat: 1,
                                                            }
														);
													} else {
														qodefTextualSpinner.fadeOutLoader(
															$holder,
															600,
															0,
															'swing'
														);

														setTimeout(
															() => {
																var $revSlider = $( '.qodef-after-spinner-rev rs-module' );

																if ( $revSlider.length ) {
																	$revSlider.revstart();
																}
															}, 800
														);
													}
												}
											}
										}
									);
								}, index * animationProps.delay
							);
						}
					);
				}
			}

			animationLoop (
			    {
                    type: { opacity: 1 },
                    duration: 1800,
                    easing: 'swing',
                    delay: 160,
                    repeat: 1,
                }
			);
		},
		fadeOutLoader( $holder, speed, delay, easing ) {
			speed  = speed ? speed : 500;
			delay  = delay ? delay : 0;
			easing = easing ? easing : 'swing';

			if ( $holder.length ) {
				$holder.delay( delay ).fadeOut( speed, easing );

				$( window ).on(
					'bind',
					'pageshow',
					function( event ) {

						if ( event.originalEvent.persisted ) {
							$holder.fadeOut( speed, easing );
						}
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefWishlistDropdown.init();
		}
	);

	/**
	 * Function object that represents wishlist dropdown.
	 * @returns {{init: Function}}
	 */
	var qodefWishlistDropdown = {
		init: function () {
			var $holder = $( '.qodef-wishlist-dropdown' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						var $thisHolder = $( this ),
							$link       = $thisHolder.find( '.qodef-m-link' );

						$link.on(
							'click',
							function ( e ) {
								e.preventDefault();
							}
						);

						qodefWishlistDropdown.removeItem( $thisHolder );
					}
				);
			}
		},
		removeItem: function ( $holder ) {
			var $removeLink = $holder.find( '.qodef-e-remove' );

			$removeLink.off().on(
				'click',
				function ( e ) {
					e.preventDefault();

					var $thisRemoveLink = $( this ),
						removeLinkHTML  = $thisRemoveLink.html(),
						removeItemID    = $thisRemoveLink.data( 'id' );

					$thisRemoveLink.html( '<span class="fa fa-spinner fa-spin" aria-hidden="true"></span>' );

					var wishlistData = {
						type: 'remove',
						itemID: removeItemID,
					};

					$.ajax(
						{
							type: 'POST',
							url: qodefGlobal.vars.restUrl + qodefGlobal.vars.wishlistRestRoute,
							data: {
								options: wishlistData,
							},
							beforeSend: function ( request ) {
								request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
							},
							success: function ( response ) {
								if ( response.status === 'success' ) {
									var newNumberOfItemsValue = parseInt( response.data['count'], 10 );

									$holder.find( '.qodef-m-link-count' ).html( newNumberOfItemsValue );

									if ( newNumberOfItemsValue === 0 ) {
										$holder.removeClass( 'qodef-items--has' ).addClass( 'qodef-items--no' );
									}

									$thisRemoveLink.closest( '.qodef-m-item' ).fadeOut( 200 ).remove();

									$( document ).trigger(
										'barabi_core_wishlist_dropdown_item_is_removed',
										[removeItemID]
									);
								} else {
									$thisRemoveLink.html( removeLinkHTML );
								}
							}
						}
					);
				}
			);
		}
	};

	$( document ).on(
		'barabi_core_wishlist_item_is_updated',
		function ( e, itemID, userID ) {
			var $holder = $( '.qodef-wishlist-dropdown' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						var $thisHolder        = $( this ),
							$link              = $thisHolder.find( '.qodef-m-link' ),
							numberOfItemsValue = $link.find( '.qodef-m-link-count' ),
							$itemsHolder       = $thisHolder.find( '.qodef-m-items' );

						var wishlistData = {
							itemID: itemID,
							userID: userID,
						};

						$.ajax(
							{
								type: 'POST',
								url: qodefGlobal.vars.restUrl + qodefGlobal.vars.wishlistDropdownRestRoute,
								data: {
									options: wishlistData,
								},
								beforeSend: function ( request ) {
									request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
								},
								success: function ( response ) {
									if ( response.status === 'success' ) {
										numberOfItemsValue.html( parseInt( response.data['count'], 10 ) );

										if ( $thisHolder.hasClass( 'qodef-items--no' ) ) {
											$thisHolder.removeClass( 'qodef-items--no' ).addClass( 'qodef-items--has' );
										}

										$itemsHolder.html( response.data['new_html'] );
									}
								},
								complete: function () {
									qodefWishlistDropdown.init();
								}
							}
						);
					}
				);
			}
		}
	);

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_instagram_list = {};

	$( document ).ready(
		function () {
			qodefInstagram.init();
		}
	);

	var qodefInstagram = {
		init: function () {
			this.holder = $( '.qodef-instagram-list #sb_instagram' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {

						if ( $( this ).parent().hasClass( 'qodef-instagram-columns' ) ) {
							var $imagesHolder  = $( this ).find( '#sbi_images' ),
								$images        = $imagesHolder.find( '.sbi_item.sbi_type_image, .sbi_item.sbi_type_carousel' ),
								initialPadding = $imagesHolder.css( 'padding' );

							// remove some unnecessary paddings
							$imagesHolder.css('padding', '0');
							$imagesHolder.css('margin', '-' + initialPadding);
							$imagesHolder.css('width', 'calc(100% + ' + ( initialPadding) + ' + ' + ( initialPadding) + ')');

							$images.attr('style', 'padding: ' + initialPadding + '!important');
						} else if ( $( this ).parent().hasClass( 'qodef-instagram-slider' ) ) {
							qodefInstagram.initSlider( $( this ) );
						}
					}
				);
			}
		},
		initSlider: function ( $currentItem, $initAllItems ) {

			var $imagesHolder  = $currentItem.find( '#sbi_images' ),
				$images        = $currentItem.find( '.sbi_item.sbi_type_image' ),
				initialPadding = $imagesHolder.css( 'padding' );

			// remove some unnecessary paddings
			$imagesHolder.css('padding', '0');
			$images.css('padding', '0');

			// items will inherit this margin
			$imagesHolder.attr('style', 'margin-right: ' + (parseInt( initialPadding ) * 2) + 'px !important');

			var sliderOptions = {};

			sliderOptions.spaceBetween      = parseInt( initialPadding ) * 2;
			sliderOptions.customStages      = true;
			sliderOptions.slidesPerView     = $currentItem.data( 'cols' ) !== undefined && $currentItem.data( 'cols' ) !== '' ? $currentItem.data( 'cols' ) : 3;
			sliderOptions.slidesPerView1024 = $currentItem.data( 'cols' ) !== undefined && $currentItem.data( 'cols' ) !== '' ? $currentItem.data( 'cols' ) : 3;
			sliderOptions.slidesPerView680  = $currentItem.data( 'colstablet' ) !== undefined && $currentItem.data( 'colstablet' ) !== '' ? $currentItem.data( 'colstablet' ) : 2;
			sliderOptions.slidesPerView480  = $currentItem.data( 'colsmobile' ) !== undefined && $currentItem.data( 'colsmobile' ) !== '' ? $currentItem.data( 'colsmobile' ) : 1;

			$currentItem.attr( 'data-options', JSON.stringify(sliderOptions) );

			$imagesHolder.addClass( 'swiper-wrapper' );

			if ( $images.length ) {
				$images.each(
					function () {
						$( this ).addClass( 'qodef-e qodef-image-wrapper swiper-slide' );
					}
				);
			}

			if ( typeof qodef.qodefSwiper === 'object' ) {

				if ( false === $initAllItems ) {
					qodef.qodefSwiper.initSlider( $currentItem );
				} else {
					qodef.qodefSwiper.init( $currentItem );
				}
			}
		},
	};

	qodefCore.shortcodes.barabi_core_instagram_list.qodefInstagram = qodefInstagram;
	qodefCore.shortcodes.barabi_core_instagram_list.qodefSwiper    = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	/*
	 **	Re-init scripts on gallery loaded
	 */
	$( document ).on(
		'yith_wccl_product_gallery_loaded',
		function () {
			
			if ( typeof qodef.qodefWooMagnificPopup === 'object' ) {
				qodef.qodefWooMagnificPopup.init();
			}
		}
	);

})( jQuery );

(function ($) {
	'use strict';

	$(document).on(
		'qv_loader_stop qv_variation_gallery_loaded',
		function () {
			qodefYithSelect2.init();
		}
	);

	var qodefYithSelect2 = {
		init: function (settings) {
			this.holder = [];
			this.holder.push(
				{
					holder: $('#yith-quick-view-modal .variations select'),
					options: {
						minimumResultsForSearch: Infinity
					}
				}
			);

			// Allow overriding the default config
			$.extend(this.holder, settings);

			if (typeof this.holder === 'object') {
				$.each(
					this.holder,
					function (key, value) {
						qodefYithSelect2.createSelect2(value.holder, value.options);
					}
				);
			}
		},
		createSelect2: function ($holder, options) {
			if (typeof $holder.select2 === 'function') {
				$holder.select2(options);
			}
		}
	};

})(jQuery);

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefDropDownCart.init();
		}
	);

	var qodefDropDownCart = {
		init: function () {
			var $holder = $( '.qodef-widget-dropdown-cart-content' );

			if ( $holder.length ) {
				$holder.off().each(
					function () {
						var $thisHolder = $( this );

						qodefDropDownCart.trigger( $thisHolder );

						qodefCore.body.on(
							'added_to_cart removed_from_cart',
							function () {
								qodefDropDownCart.init();
							}
						);
					}
				);
			}
		},
		trigger: function ( $holder ) {
			var $items = $holder.find( '.qodef-woo-mini-cart' );
			if ( $items.length && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $items );
			}
		},
	};

})( jQuery );

(function ($) {
    'use strict';

    $(document).ready(
        function () {
            qodefSideAreaCart.init();
        }
    );

    var qodefSideAreaCart = {
        init: function () {
            var $holder = $('.qodef-widget-side-area-cart-inner');

            if ($holder.length) {
                $holder.off().each(
                    function () {
                        var $thisHolder = $(this);

                        if (qodefCore.windowWidth > 680) {
                            qodefSideAreaCart.trigger($thisHolder);
                            qodefSideAreaCart.start($thisHolder);

                            qodefCore.body.on(
                                'added_to_cart removed_from_cart wc_fragments_refreshed',
                                function () {
                                    qodefSideAreaCart.init();
                                }
                            );

                        }
                    }
                );
            }
        },
        trigger: function ($holder) {
            var $items = $holder.find('.qodef-woo-side-area-cart');
            if ($items.length && typeof qodefCore.qodefPerfectScrollbar === 'object') {
                qodefCore.qodefPerfectScrollbar.init($items);
            }
        },
        start: function ($holder) {
            $holder.on(
                'click',
                '.qodef-m-opener',
                function (e) {
                    e.preventDefault();

                    if (!$holder.hasClass('qodef--opened')) {
                        qodefSideAreaCart.openSideArea($holder);
                        qodefSideAreaCart.trigger($holder);

                        $(document).keyup(
                            function (e) {
                                if (e.keyCode === 27) {
                                    qodefSideAreaCart.closeSideArea($holder);
                                }
                            }
                        );
                    } else {
                        qodefSideAreaCart.closeSideArea($holder);
                    }
                }
            );

            $holder.on(
                'click',
                '.qodef-m-close',
                function (e) {
                    e.preventDefault();
                    qodefSideAreaCart.closeSideArea($holder);
                }
            );
        },
        openSideArea: function ($holder) {
            qodefCore.qodefScroll.disable();

            $holder.addClass('qodef--opened');
            $('#qodef-page-wrapper').prepend('<div class="qodef-woo-side-area-cart-cover"/>');

            $('.qodef-woo-side-area-cart-cover').on(
                'click',
                function (e) {
                    e.preventDefault();

                    qodefSideAreaCart.closeSideArea($holder);
                }
            );
        },
        closeSideArea: function ($holder) {
            if ($holder.hasClass('qodef--opened')) {
                qodefCore.qodefScroll.enable();

                $holder.removeClass('qodef--opened');
                $('.qodef-woo-side-area-cart-cover').remove();
            }
        }
    };

})(jQuery);
(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_product_category_list                    = {};
	qodefCore.shortcodes.barabi_core_product_category_list.qodefMasonryLayout = qodef.qodefMasonryLayout;
	qodefCore.shortcodes.barabi_core_product_category_list.qodefSwiper        = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'barabi_core_product_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_clients_list             = {};
	qodefCore.shortcodes.barabi_core_clients_list.qodefSwiper = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.barabi_core_testimonials_list = {};

	$( document ).ready(
		function () {
			qodefTestimonialsSlider.init();
		}
	);

	$( window ).on(
		'resize',
		function () {
			qodefTestimonialsSlider.init();
		}
	);

	var qodefTestimonialsSlider = {
		init: function () {
			var holder = $( '.qodef-testimonials-list.qodef-item-layout--side-by-side.qodef-swiper-container' );

			if ( holder.length ) {
				holder.each(
					function () {
						var thisHolder = $( this );

						if ( qodef.windowWidth < 481 ) {
							qodefTestimonialsSlider.calculateHeight( thisHolder );
						}
					}
				);
			}
		},
		calculateHeight: function ( $holder ) {
			var items = $holder.find('.qodef-e'),
				content = $holder.find('.qodef-e-content'),
				maxContentHeight = 0;

			content.css(
				'min-height',
				'auto'
			);

			if ( items.length ) {
				items.each(
					function () {
						var thisItem = $( this ),
							itemContent = thisItem.find('.qodef-e-content'),
							contentHeight = itemContent.outerHeight();

						if ( maxContentHeight < contentHeight ) {
							maxContentHeight = contentHeight;
						}
					}
				)
			}

			content.css(
				'min-height',
				maxContentHeight
			);
		}
	};

	qodefCore.shortcodes.barabi_core_testimonials_list.qodefSwiper = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'barabi_core_tutorial_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

	$( window ).on(
		'load',
		function () {
			qodefTutorialList.init();
		}
	);

	$( document ).on(
		'barabi_trigger_get_new_posts',
		function () {
			qodefTutorialList.init();
		}
	);

	var qodefTutorialList = {
		init: function () {
			this.holder = $( '.qodef-shortcode.qodef-tutorial-list' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefTutorialList.initHover( $( this ) );
					}
				);
			}
		},
		initHover: function ( $currentList ) {
			var $items = $currentList.find( '.qodef-e' );

			if ( $items.length ) {
				$items.each(
					function () {
						var $item  = $( this );
						var $links = $item.find( '.qodef-e-media-image a, .qodef-e-title-link' );

						$links.on(
							'mouseenter',
							function () {
								$item.addClass( 'qodef--hover' );
							}
						).on(
							'mouseleave',
							function () {
								$item.removeClass( 'qodef--hover' );
							}
						);
					}
				);
			}
		}
	};

	qodefCore.shortcodes[shortcode].qodefTutorialList = qodef.qodefTutorialList;

})( jQuery );
