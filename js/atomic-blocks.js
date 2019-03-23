(function($) {
	"use strict";

	$(document).ready(function() {

        $(window).on('load', function() {
            var current_width = $(window).width();

			// Only run on desktop
            if ( current_width > 768 ) {

				// Find menu items with a drop menu and center them
		        $('.main-navigation li').each(function() {
		            if ($(this).find('ul:first-of-type').length > 0) {
		                var parent_width = $(this).outerWidth(true);
		                var child_width  = $(this).find('ul').outerWidth(true);
		                var new_width    = parseInt((child_width - parent_width) / 2);
		                $(this).find('ul').css('margin-left', -new_width + 'px');
		            }
		        });
        	}
        });


		// Standardize drop menu types
		$('.main-navigation .children').addClass('sub-menu');
		$('.main-navigation .page_item_has_children').addClass('menu-item-has-children');


		// Toggle the mobile menu
		$('.menu-toggle').click(function() {
			$('.mobile-navigation').toggleClass('toggle-active');
			$('.drawer').toggle();
			$(this).find('span').toggle();
		});

		// Append a clickable icon to mobile drop menus
		var item = $('<button class="toggle-sub" aria-expanded="false"><i class="fa fa-angle-down"></i></button>');

		// Append clickable icon for mobile drop menu
		if ($('.drawer .menu-item-has-children .toggle-sub').length == 0) {
			$('.drawer .menu-item-has-children,.drawer .page_item_has_children').append(item);
		}

		// Show sub menu when toggle is clicked
		$('.drawer .menu-item-has-children .toggle-sub').click(function(e) {
			$(this).each(function() {
				e.preventDefault();

				// Change aria expanded value
				$(this).attr('aria-expanded', ($(this).attr('aria-expanded')=='false') ? 'true':'false');

				// Open the drop menu
				$(this).closest('.menu-item-has-children').toggleClass('drop-open');
				$(this).prev('.sub-menu').toggleClass('drop-active');

				// Change the toggle icon
				$(this).find('i').toggleClass('fa-angle-down').toggleClass('fa-angle-up');
			});
		});


		// Fitvids
		function fitVids() {
			$('.post,.featured-image').fitVids();
		}
		fitVids();


		// Scroll back to top
		$('.back-to-top a, .sticky-title').click(function(e) {
			e.preventDefault();

			$('html,body').animate({
			    scrollTop: 0
			}, 700);

			return false;
		} );


		// Infinite scroll
		$(document.body).on('post-load', function () {
			var $container = $('#post-wrap');
			var $newItems  = $('.new-infinite-posts').not('.is--replaced');
			var $elements  = $newItems.find('.post');

			// Remove the empty elements that break the grid
			$('.new-infinite-posts,.infinite-loader').remove();

			// Append IS posts
			$container.append($elements);

			// Run fitvids on newly arrived posts
			fitVids();
		});


		// Create the sticky nav bar if we're on the single page
		if ($('.single .header-text h1')[0]){
			var section_single = $('#page').offset().top;

			// Show the nav bar when we get to the post title
			$(window).scroll(function() {
				if($(window).scrollTop() > section_single) {
					$('.home-nav').addClass('show-nav');
				} else {
					$('.home-nav').removeClass('show-nav');
				}
			});
		}


		// Search togle
		$('.search-toggle').click(function(e) {
			
			// Add a class to the header
			$('.site-header').toggleClass('search-drawer-open');

			// Toggle the expanded tag
			$('.search-drawer').attr('aria-expanded', ($('.search-drawer').attr('aria-expanded')=='false') ? 'true':'false').slideToggle(200);

			// Set the focus when the search is opened
			$('.big-search .search-input').focus();

			// Change the toggle icon
			$('.search-toggle i').toggle();

			return false;
		});


		// Close the search drawer
		function closeDrawer() {
			$('.search-drawer').attr('aria-expanded','false').slideUp(200);
			$('.search-toggle span').hide();
			$('.search-drawer-open .search-toggle i').toggle();
			$('.site-header').removeClass('search-drawer-open');
		}


		// Escape key closes drawer
		$(document).keyup(function(e) {
		    if (e.keyCode == 27) {
				// Hide any drawers that are open
				closeDrawer();
		    }
		});


		// Allow clicking in the drawer when it's open
		$('.search-drawer').click(function(event){
		    event.stopPropagation();
		});

	});

})(jQuery);
