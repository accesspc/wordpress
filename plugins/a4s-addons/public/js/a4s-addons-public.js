//(function( $ ) {
	//'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
	
	// A4sAddons_Widget_PwGen
	jQuery.fn.pwgen = function (length, upper, lower, num, special) {
		var i = 0;
		var p = "";
		var rn;
		if (length == undefined) length = 9;
		if (upper == undefined) upper = false;
		if (lower == undefined) lower = false;
		if (num == undefined) num = false;
		if (special == undefined) special = false;
		if (!upper && !lower && !num && !special) lower = true;
		while (i < length) {
			rn = (Math.floor((Math.random() * 100)) % 94) + 33;
			// A-Z
			if (!upper && ((rn >= 65) && (rn <= 90))) { continue; }
			// a-z
			if (!lower && ((rn >= 97) && (rn <= 122))) { continue; }
			// 0-9
			if (!num && ((rn >= 48) && (rn <= 57))) { continue; }
			if (!special) {
				// !"#$%&'()*+,-./
				if ((rn >= 33) && (rn <= 47 )) { continue; }
				// :;<=>?@
				if ((rn >= 58) && (rn <= 67 )) { continue; }
				// [\]^_`
				if ((rn >= 91) && (rn <= 96 )) { continue; }
				// {|}~
				if ((rn >= 123) && (rn <= 126 )) { continue; }
			}
			i++;
			p += String.fromCharCode(rn);
		}
		return p;
	};
	
	jQuery.fn.pwgenall = function() {
		var length = jQuery("#pwgen_length").val();
		var count = jQuery("#pwgen_count").val();
		var upper = jQuery("#pwgen_upper").attr('checked'); 
		var lower = jQuery("#pwgen_lower").attr('checked');
		var num = jQuery("#pwgen_num").attr('checked');
		var special = jQuery("#pwgen_special").attr('checked');
		
		jQuery(".pwgen_output").html("");
		
		var i = 0;
		for (i=0; i<count; i++) {
			jQuery(".pwgen_output").append('<div class="password password-' + i + '"></div>');
			jQuery('.password-' + i).text(jQuery.fn.pwgen(length, upper, lower, num, special));
		}
	};
	jQuery(document).on('change', '.pwgen_opt', function() {
		jQuery.fn.pwgenall();
	});
	jQuery(document).on('click', '.pwgen_generate', function() {
		jQuery.fn.pwgenall();
		return false;
	});
	
	// Categories and posts quick search
	jQuery(document).on('keyup', '.a4s-cpt-qs .qs', function() {
		var filter = jQuery(this).val();
		if (filter.length == 0) {
			jQuery(".a4s-cpt ul.cat-list li").show();
		} else {
			// Loop through list items
			jQuery(".a4s-cpt ul.cat-list li.cat-item").each(function() {
				if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
					jQuery(this).hide();
				} else {
					jQuery(this).show();
				}
			});
			// Loop through list titles
			jQuery(".a4s-cpt ul.cat-list li.cat-title").show();
			jQuery(".a4s-cpt ul.cat-list li.cat-title").each(function() {
				var li_title = jQuery(this);
				if (li_title.find("li.cat-item:visible").length > 0) {
					jQuery(this).show();
				} else {
					jQuery(this).hide();
				}
			});
		}
		console.log(jQuery(".a4s-cpt ul.cat-list li:visible").length);
	});

//})( jQuery );
