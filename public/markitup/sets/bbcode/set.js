// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// BBCode tags example
// http://en.wikipedia.org/wiki/Bbcode
// ----------------------------------------------------------------------------
// Feel free to add more tags
// ----------------------------------------------------------------------------
mySettings = {
	previewParserPath:	'', // path to your BBCode parser
	markupSet: [
		{name:'Strong', key:'S', openWith:'[strong]', closeWith:'[/strong]'},
		{name:'Italic', key:'I', openWith:'[italic]', closeWith:'[/italic]'},
		{name:'Underline', key:'U', openWith:'[ins]', closeWith:'[/ins]'},
		{separator:'---------------' },
		{name:'Picture', key:'P', replaceWith:'[img][![Url]!][/img]'},
		{name:'Link', key:'L', openWith:'[url=[![Url]!]]', closeWith:'[/url]', placeHolder:'Your text to link here...'},
		{separator:'---------------' },
		{name:'Quotes', openWith:'[cite]', closeWith:'[/cite]'},
		{name:'Code', openWith:'[pre]', closeWith:'[/pre]',
			dropMenu :[
			           {name:'PHP', openWith:'[pre class="brush: php;"]', closeWith:'[/pre]' },
			           {name:'HTML', openWith:'[pre class="brush: html;"]', closeWith:'[/pre]' },
			           {name:'CSS', openWith:'[pre class="brush: css;"]', closeWith:'[/pre]' }
			           ]
		},
		{separator:'---------------' },
		{name:'Clean', className:"clean", replaceWith:function(markitup) { return markitup.selection.replace(/\[(.*?)\]/g, "") } },
		{name:'Preview', className:"preview", call:'preview' }
	]
}