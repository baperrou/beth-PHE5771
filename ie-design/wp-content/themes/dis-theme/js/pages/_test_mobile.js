var isMobile = { 
Android: function() { return navigator.userAgent.match(/Android/i); }, 
BlackBerry: function() { return navigator.userAgent.match(/BlackBerry/i); }, 
iOS: function() { return navigator.userAgent.match(/iPhone|iPad|iPod/i); }, 
Opera: function() { return navigator.userAgent.match(/Opera Mini/i); }, 
Windows: function() { return navigator.userAgent.match(/IEMobile/i); }, 
any: function() { return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows()); } };

var isTablet = {};
// to support IE8 moved here
(function ($) {
if(isMobile.any()) {
			//modifying html to suit 2 people per row on people type pages
					  $('.page-template-people-php .container.main .row').each(function(){
					  		//var total = $(this).children().length;
					  		//var half = Math.ceil(total / 2) - 1;
					  		$(this).children(':gt('+1+')').detach().wrapAll('<div class="row"></div>').parent().insertAfter(this);	
					  		});
					
			}
			
})(jQuery);