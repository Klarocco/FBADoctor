/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 *

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'en';
	config.removePlugins = 'flash,forms,preview,about,smiley';
	config.removeButtons ='Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar';
	config.height = 350;
	config.autoGrow_maxHeight = 500;
	config.autoGrow_minHeight = 350;
	config.fullPage = true;
	config.allowedContent = true;
	config.extraPlugins = 'autogrow';
	config.autoGrow_bottomSpace = 50;

	config.extraPlugins = 'codemirror';

	toolbar = [
		{ name: 'document', groups: [ 'mode', 'doctools' ], items: [ 'Source', '-', 'Templates' ] },
		{ name: 'clipboard', groups: [  'undo' ], items: [  'Undo', 'Redo' ] },
		{ name: 'editing', groups: [ 'spellchecker' ], items: [ 'Scayt' ] },			
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', '-', 'RemoveFormat' ] },
		{ name: 'paragraph', groups: [ 'list', 'blocks'], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', '-', 'Blockquote',] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: [ 'Image', 'Table', 'SpecialChar' ] },
		
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		
		
		{ name: 'others', items: [ '-' ] }

	]


	
	//config.
		// config.uiColor = '#AADC6E';
};*/

//	TINYMCE INITIALIZTION
	//RESELLER Email Template
	/*tinymce.init({
		selector: "textarea#clients",
		theme: "modern",
	   
		plugins: [
			 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker code",
			 "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime media nonbreaking",
			 "save table contextmenu directionality emoticons template paste textcolor codemirror fullpage"
	   ],
	   cleanup : true,

	   valid_elements: "*[*]",
		valid_children: "*[*]",
	   visual: true,
	   menubar: false,
	   skin : '',
	   toolbar: " undo | redo | styleselect | bold | italic | alignleft | aligncenter | alignright | alignjustify | outdent | indent | table | link | image | preview | forecolor | backcolor | code | visualblocks | visualchars",
		toolbar_items_size: 'large',
		codemirror:{
			indentOnInit: true,}
	
	});
	//EMAIL TAB EDITOR 1 Email Template
	tinymce.init({
		selector: "textarea#htmlmsg",
		theme: "modern",
	   
		plugins: [
			 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker code",
			 "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime media nonbreaking",
			 "save table contextmenu directionality emoticons template paste textcolor codemirror fullpage"
	   ],
	   cleanup : true,

	   valid_elements: "*[*]",
		valid_children: "*[*]",
	   visual: true,
	   menubar: false,
	   skin : '',
	   toolbar: " undo | redo | styleselect | bold | italic | alignleft | aligncenter | alignright | alignjustify | outdent | indent | table | link | image | preview | forecolor | backcolor | code | visualblocks | visualchars",
		toolbar_items_size: 'large',
		codemirror:{
			indentOnInit: true,}
	
	});
	tinymce.init({
		selector: "textarea#previewresults",
		theme: "modern",
	   
		plugins: [
			 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker code",
			 "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime media nonbreaking",
			 "save table contextmenu directionality emoticons template paste textcolor codemirror fullpage"
	   ],
	   cleanup : true,

	   valid_elements: "*[*]",
		valid_children: "*[*]",
	   visual: true,
	   menubar: false,
	   skin : '',
	   toolbar: "preview | code",
		toolbar_items_size: 'large',
		codemirror:{
			indentOnInit: true,}
	
	});
	//EMAIL TAB MESSAGE CREATOR
	
	

	tinymce.init({
		selector: "textarea#body_message",
		theme: "modern",
	   
		plugins: [
			 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker code",
			 "searchreplace wordcount visualblocks visualchars fullscreen insertdatetime media nonbreaking textpattern textcolor colorpicker",
			 "save table contextmenu directionality emoticons template paste textcolor codemirror fullpage personalizeField"
	   ],
	   cleanup : true,

	   valid_elements: "*[*]",
		valid_children: "*[*]",
	   visual: true,
	   menubar: false,
	   //skin : 'blued-grinder',
	   toolbar1: " undo redo | styleselect formatselect | fontselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table ",
	   toolbar2: "spellchecker | link image | preview | forecolor backcolor | code | visualchars | visualblocks | facebook | twitter | linkedIn | googlePlus | forwardEmail  | viewWebPage | personalizeField | print",
	   toolbar_items_size: 'medium',
	   image_advtab: true,
		
		codemirror:{
			indentOnInit: true,},
			
	   setup: function(editor) {
				editor.addButton('facebook', {
				tooltip: 'Insert Social Share Facebook',
				image: '/images/social/fonts/facebook.png',
				onclick: function() {
					editor.focus();
					editor.insertContent('{FACEBOOK}');
				}
			});
			editor.addButton('twitter', {
				tooltip: 'Insert Social Share Twitter',
				image: '/images/social/fonts/twitter.png',
				onclick: function() {
					editor.focus();
					editor.insertContent('{TWITTER}');
				}
			});
			editor.addButton('linkedIn', {
				tooltip: 'Insert Social Share LinkedIn',
				image: '/images/social/fonts/linkedin.png',
				onclick: function() {
					editor.focus();
					editor.insertContent('{LINKEDIN}');
				}
			});
			editor.addButton('googlePlus', {
				tooltip: 'Insert Social Share Google+',
				image: '/images/social/fonts/googleplus.png',
				onclick: function() {
					editor.focus();
					editor.insertContent('{GOOGLE}');
				}
			});
			editor.addButton('forwardEmail', {
				tooltip: 'Insert Forward to a Friend',
				image: '/images/social/fonts/mail-forward.png',
				onclick: function() {
					editor.focus();
					editor.insertContent('{FORWARDFRIEND}');
				}
			});
			editor.addButton('viewWebPage', {
				tooltip: 'Insert View as WebPage',
				image: '/images/social/fonts/globe.png',
				onclick: function() {
					editor.focus();
					editor.insertContent('{VIEWWEBPAGE}');
				}
			});
			tinymce.PluginManager.add('personalizeField', function(editor, url) {
			// Add a button that opens a window
				editor.addButton('personalizeField', {
					text: 'Insert Field',
					tooltip: 'Insert Personalized Field',
					image: '/images/social/fonts/crosshairs.png',
					onclick: function() {
						// Open window
						editor.windowManager.open({
							title: 'Insert Personalized Field',
							width: 600,
							height: 500,
							body: [
								{type: 'listbox', text: 'My listbox', name: 'title', values: [
                {text: 'Menu item 1', value: 'Some text 1'},
                {text: 'Menu item 2', value: 'Some text 2'},
                {text: 'Menu item 3', value: 'Some text 3'}
            ], label: 'Title'}
							],
							onsubmit: function(e) {
								// Insert content when the window form is submitted
								editor.insertContent(e.data.title);
							}
						});
					}
				});
			
			});
		}
	
	});
	tinymce.init({
		selector: "textarea.faqEdit",
		theme: "modern",
		
		height: 350,
	   
		plugins: [
			 "spellchecker code image link hr preview",
			 "nonbreaking codemirror fullpage",
			 "contextmenu directionality paste textcolor"
	   ],
	   cleanup : true,

	   valid_elements: "*[*]",
		valid_children: "*[*]",
	   visual: true,
	   menubar: false,
	   
	   skin : 'nogradientbd',
	   toolbar: "undo | redo | bold | italic | outdent | indent | forecolor | link | image | preview | code",
	   
		toolbar_items_size: 'medium',
		codemirror:{
			indentOnInit: true,}
	
	}); */
	

	//ckEditor