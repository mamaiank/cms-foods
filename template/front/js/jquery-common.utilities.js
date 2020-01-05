function stickyHeader() {
	$(window).scroll(function(){
		var sticky = $('#sticky'),
			scroll = $(window).scrollTop();
		if (scroll >= 1) sticky.addClass('fixed');
		else sticky.removeClass('fixed');
	});
}

function fixedHeader() {
	$("#fixedHeader").sticky({
		topSpacing:0,
		zIndex: 999,
	});
}

function backToTop() {
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('#scroll').fadeIn();
		} else {
			$('#scroll').fadeOut();
		}
	}); 
	$('#scroll').click(function(){ 
		$("html, body").animate({ scrollTop: 0 }, 600); 
		return false; 
	});
}

function gallerySpafoods() {
	var slider = $('#image-gallery').lightSlider({
		gallery:true,
		item:1,
		controls: false,
		vThumbWidth: 80,
		thumbItem:4,
		slideMargin: 0,
		speed:500,
		loop:true,
		onSliderLoad: function() {
			$('#image-gallery').removeClass('cS-hidden');
		}
	});
	$('#goToPrevSlide').click(function(){
		slider.goToPrevSlide(); 
	});
	$('#goToNextSlide').click(function(){
		slider.goToNextSlide(); 
	});
}

function initSpiner() {
	$( "#spinner" ).spinner({
		spin: function( event, ui ) {
			if ( ui.value < 0 ) {
				$( this ).spinner( "value", 0 );
				return false;
			}
		}
	});
}

function initLayerSlider() {
	jQuery("#layerslider").layerSlider({
		pauseOnHover: true,
		autoPlayVideos: false,
		skinsPath: '/spafood/template/front/layerslider/skins/'
	});
}

function initBxsliderUnderhero() {
	$('.bxsliderUnderhero').bxSlider({
		auto: true,
		mode: 'fade',
		captions: true
	});
}
function initScrollbar() {
	$('.scrollbar-inner').scrollbar();
}

function detectBrowser() {
	// Opera 8.0+
	var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
	// Firefox 1.0+
	var isFirefox = typeof InstallTrigger !== 'undefined';
	// Safari 3.0+ "[object HTMLElementConstructor]" 
	var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);
	// Internet Explorer 6-11
	var isIE = /*@cc_on!@*/false || !!document.documentMode;
	// Edge 20+
	var isEdge = !isIE && !!window.StyleMedia;
	// Chrome 1+
	var isChrome = !!window.chrome && !!window.chrome.webstore;
	// Blink engine detection
	var isBlink = (isChrome || isOpera) && !!window.CSS;
	var browser_name = '';
	if (isOpera){
		browser_name = 'opera';
	} else if(isFirefox){
		browser_name = 'firefox';
	} else if(isSafari){
		 browser_name = 'safari';
	} else if(isIE){
		browser_name = 'ie';
	} else if(isEdge){
		browser_name = 'edge';
	} else if(isChrome){
		browser_name = 'chrome';
	} else if(isBlink){
		browser_name = 'blink';
	}
	$('html').addClass(browser_name);
}