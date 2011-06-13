/**
 * 
 */
$(document).ready(function() {
	var content = $('#comment');
	$('#link').click(function(){
		content.val(content.val() + '[url=http://][/url]');
	});
	$('#code').click(function(){
		content.val(content.val() + '[code][/code]');
	});
	$('#italic').click(function(){
		content.val(content.val() + '[italic][/italic]');
	});
	$('#strike').click(function(){
		content.val(content.val() + '[del][/del]');
	});
	$('#strong').click(function(){
		content.val(content.val() + '[strong][/strong]');
	});
	$('#sup').click(function(){
		content.val(content.val() + '[sup][/sup]');
	});
	$('#sub').click(function(){
		content.val(content.val() + '[sub][/sub]');
	});
	$('#img').click(function(){
		content.val(content.val() + '[img][/img]');
	});
	$('#h1').click(function(){
		content.val(content.val() + '[h1][/h1]');
	});
});