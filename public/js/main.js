/**
 * 
 */
$(document).ready(function() {
	var content = $('#comment');
	$('#link').click(function(){
		content.val(content.val() + '[link][/link]');
	});
	$('#code').click(function(){
		content.val(content.val() + '[code][/code]');
	});
	$('#italic').click(function(){
		content.val(content.val() + '[italic][/italic]');
	});
	$('#strike').click(function(){
		content.val(content.val() + '[strike][/strike]');
	});
	$('#strong').click(function(){
		content.val(content.val() + '[strong][/strong]');
	});
});