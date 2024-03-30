$(document).on('mouseover', '.has-tooltip', function(e) {
	
	if ($(this).hasClass('tooltip-on-overflow') && $(this)[0].scrollWidth <= $(this).innerWidth() ) {
		
	  return false;
	}
	let text = $(this).attr('aria-label');
	let offset = $(this).offset();
	let width = $(this).outerWidth();
	let height = $(this).height();

	let tooltip = $('#custom_tooltip');
	let type = '';

	if($(this).hasClass('tooltip-warning')){
		type = 'warning';
	}
	if($(this).hasClass('tooltip-light')){
		type = 'light';
	}

	renderTooltip({
		text: text,
		offset: offset,
		width: width,
		height: height,
		tooltip: tooltip,
		type: type
	});

      
});

var dt = {
	tooltipTypes: ['light', 'warning']
};

function renderTooltip(settings = {}){
	if(!settings || typeof settings !== 'object'){
		console.warn('provide renderTooltip with proper settings')
	}
	let expected_settings = ['text', 'offset', 'width', 'height'];

	Object.keys(settings).forEach(function(key){
		if(typeof settings[key] === 'undefined' || settings[key] === null){
			console.warn('provide renderTooltip with '+key+' argument')
		}
	});
	let width = settings.width;
	let height = settings.height;
	let text = settings.text;
	let offset = settings.offset;
	let tooltip = settings.tooltip;
	let type = settings.type || null;

	if(!tooltip){
		tooltip = $('#custom_tooltip');
	}

	tooltip.show();
	tooltip.find('.custom_tooltip-text').text(text);
	let span = tooltip.find('.custom_tooltip-text');
	let renderer = tooltip.find('.custom_tooltip_wrapper');

	if(dt.tooltipTypes.includes(type)){
		span.addClass('custom_tooltip-'+type);
	}


	let shift_left = 0;
	let distance = 7;
	if(renderer.outerWidth() > width){
		shift_left = (renderer.outerWidth() - width)/2;
	}else if(renderer.outerWidth() < width){
		shift_left = -((width - renderer.outerWidth())/2);
	}
	let left = offset.left - shift_left;
	// console.log('offset.top', offset.top);
	// console.log('renderer.outerHeight()', renderer.outerHeight());
	// console.log('distance', distance);
	let top = offset.top - renderer.outerHeight() - distance;

	// scroll correction
	// let documentElement = document.documentElement;
	// left = left + window.pageXOffset - documentElement.clientLeft;

	// console.log('top before',top);
	// top = top + window.pageYOffset - documentElement.clientTop;

	// console.log('top after (+ window.pageYOffset - documentElement.clientTop)',top);
	// console.log('window.pageYOffset',window.pageYOffset);
	// console.log('documentElement.clientTop',documentElement.clientTop);
	// console.log('window.pageYOffset - documentElement.clientTop', window.pageYOffset - documentElement.clientTop);

	// console.log('left', left);
	// console.log('top', top);
	tooltip.css({'left': left+'px', top:  top+'px'});

	let tooltipRect = tooltip[0].getBoundingClientRect();
	// console.log('tooltipRect.top',tooltipRect.top);
	if(tooltipRect.top <= 0){
		// top += (height*2 + distance*2);
		top += (height + renderer.outerHeight() + distance*2);
		tooltip.css({top:  top+'px'});
	}

	if(tooltipRect.left <= 0){
		tooltip.css({left:  '0px', right: 'auto'});
	}

	if(Math.ceil(tooltipRect.left) + Math.ceil(renderer.outerWidth()) + 10 >= window.innerWidth){
		tooltip.css({left:  'auto', 'right': '0px'});
	}

	// console.log('_______________________________________________________________________');

}

function hideTooltip(tooltip){
	if(!tooltip){
		tooltip = $('#custom_tooltip');
	}
	tooltip.find('.custom_tooltip-text').text('');
	tooltip.find('.custom_tooltip-text').removeClass('custom_tooltip-warning').removeClass('custom_tooltip-light');
	tooltip.hide();
}


$(document).on('mouseout', '.has-tooltip', function(e) {
	hideTooltip($('#custom_tooltip'));
});


$('.menu_button_position').on('click', function(){
	$(this).find('.menu_button').toggleClass('is-active');
	$('#mobile-menu-items').toggleClass('is-active');
})

$('.trigger-load-more-blockchains').on('click', function(){
	let container = $(this).closest('.b-c');
	container.find('.other-blockchain').toggleClass('other-blockchain-off');
	container.find('.load-more-blockchains-button').find('div').toggleClass('arrow-down arrow-up');
	container.find('.first-blockchain').toggleClass('others-off');
	
})


function number_format(number, decimals, decPoint, thousandsSep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
	const n = !isFinite(+number) ? 0 : +number
	const prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
	const sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
	const dec = (typeof decPoint === 'undefined') ? '.' : decPoint
	let s = ''
	const toFixedFix = function (n, prec) {
		if (('' + n).indexOf('e') === -1) {
		return +(Math.round(n + 'e+' + prec) + 'e-' + prec)
		} else {
		const arr = ('' + n).split('e')
		let sig = ''
		if (+arr[1] + prec > 0) {
			sig = '+'
		}
		return (+(Math.round(+arr[0] + 'e' + sig + (+arr[1] + prec)) + 'e-' + prec)).toFixed(prec)
		}
	}
	s = (prec ? toFixedFix(n, prec).toString() : '' + Math.round(n)).split('.')
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || ''
		s[1] += new Array(prec - s[1].length + 1).join('0')
	}
	return s.join(dec)
}