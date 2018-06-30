/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	//needed plugins and settings
	config.language = 'en';
	config.removePlugins = 'flash,forms,preview,about,smiley';
	config.height = 400;
	config.autoGrow_maxHeight = 800;
	config.autoGrow_minHeight = 400;
	config.fullPage = true;
	config.allowedContent = true;
	config.autoGrow_bottomSpace = 50;
	config.pasteFromWordPromptCleanup = true;
    config.disallowedContent = 'script; *[on*]';
	config.skin = 'moonocolor';
	//config.scayt_autoStartup = true;
	//domain for imagehosting
	config.imageBrowser_listUrl = "/feedback/insertimagehostingjson.php";

	//config for social buttons
	config.strinsert_button_label = 'Custom Fields List';
	config.strinsert_button_title = 'Custom Fields List';
	config.strinsert_button_voice = 'Custom Fields List';
	config.strinsert_strings =	 [
			{'name': 'Order Number', 'value': '[ordernumber]', 'label': 'Insert Order Number'},
			{'name': 'Order Link', 'value': '[order-link]', 'label': 'Insert Order Link'},
			{'name': 'Amazon Store Name', 'value': '[amazonstorename]', 'label': 'Insert Amazon Store Name'},
			{'name': 'Customer Name', 'value': '[customername]', 'label': 'Insert Full Customer Name'},
			{'name': 'Customer First Name', 'value': '[customerfirstname]', 'label': 'Insert Customer First Name'},
			{'name': 'Customer Last Name', 'value': '[customerlastname]', 'label': 'Insert Customer Last Name'},
			{'name': 'Order Date', 'value': '[orderdate]', 'label': 'Insert Order Date'},
			{'name': 'Seller Feedback Link', 'value': '[sellerfeedback-link]', 'label': 'Insert Seller Feedback Link'},
			{'name': 'Seller Feedback Url', 'value': '[sellerfeedback-url]', 'label': 'Insert Seller Feedback Url'},
			{'name': 'Excellent Seller Feedback Link', 'value': '[sellerfeedbackexcellent-link]', 'label': 'Insert Excellent Seller Feedback Link'},
			{'name': 'Product Review Link', 'value': '[productreview-link]', 'label': 'Insert Product Review Link'},
			{'name': 'Amazon Store Link', 'value': '[amazonstore-link]', 'label': 'Insert Amazon Store Link'},
			{'name': 'Order items with review link with bullets', 'value': '[orderitemsreviewlink]', 'label': 'Insert order items with review link using bullets'},
			{'name': 'Order Items using bullets', 'value': '[orderitems]', 'label': 'Insert Order Items using bullets'},
			{'name': 'Order items with review link', 'value': '[orderitemsreviewlinknobullet]', 'label': 'Insert order items'},
			{'name': 'Order Items', 'value': '[orderitemsnobullet]', 'label': 'Insert Order Items'},
			{'name': 'SKU', 'value': '[sku]', 'label': 'Insert SKU'},
			{'name': 'Buyer Email', 'value': '[buyeremail]', 'label': 'Insert Buyer Email'},
			{'name': 'Contact Link', 'value': '[contact-link]', 'label': 'Insert Contact Link'},
			{'name': 'Item Price', 'value': '[itemprice]', 'label': 'Insert Item Price'},
			{'name': 'Shpping Price', 'value': '[shippingprice]', 'label': 'Insert Shpping Price'},
			{'name': 'Product Name', 'value': '[productname]', 'label': 'Insert Product Name'},
			{'name': 'Quantity', 'value': '[quantity]', 'label': 'Insert Quantity'},
			{'name': 'Recipient name', 'value': '[recipient]', 'label': 'Insert Recipient name'},
			{'name': 'Shipping Address 1', 'value': '[shipaddress1]', 'label': 'Insert Shipping Address 1'},
			{'name': 'Shipping Address 2', 'value': '[shipaddress2]', 'label': 'Insert Shipping Address 2'},
			{'name': 'Shipping City', 'value': '[shipcity]', 'label': 'Insert Shipping City'},
			{'name': 'Shipping Country', 'value': '[shipcountry]', 'label': 'Insert Shipping Country'},
			{'name': 'Shipping State', 'value': '[shipstate]', 'label': 'Insert Shipping State'},
			{'name': 'Shipping Zip', 'value': '[shipzip]', 'label': 'Insert Shipping Zip'},
			{'name': 'Estimated Arrival Date FBA Only', 'value': '[estimatedarrivaldate]', 'label': 'Insert Estimated Arrival Date FBA Only'},
			{'name': 'Shpping Carrier FBA Only', 'value': '[shippingcarrier]', 'label': 'Insert Shpping Carrier FBA Only'},
			{'name': 'Tracking Number FBA Only', 'value': '[trackingnumber]', 'label': 'Insert Tracking Number FBA Only'},




		];

//sourcedialog,sourcearea'document',

	config.extraPlugins = 'codemirror,simple-image-browser,autogrow,socialbuttons,docprops,imagebrowser';

	//toolbar
	config.toolbar = [
		{ name: 'document', groups: [ 'mode','document' ,'doctools' ], items: [ 'Source', '-', 'CommentSelectedRange', 'UncommentSelectedRange' , '-','Templates','-','DocProps'] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
		{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', '-', 'RemoveFormat' ] },
		{ name: 'paragraph', groups: [ 'list','indent', 'blocks'], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',] },
		{ name: 'insert', items: [ 'Image', 'Table', 'SpecialChar' ] },
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		{ name: 'others', items: [ 'socialbuttons' ] } //CustomField','-','SimpleImageBrowser

	];



};
