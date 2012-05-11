﻿/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	 config.uiColor = '#F6F6F6';
	
	config.toolbar = 'MXICToolbar';
    config.toolbar_MXICToolbar =
    [
    ['Source','Templates','PasteFromWord','Find','Replace','RemoveFormat'],
    ['Bold','Italic','Underline','Strike','-'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Image','Table','HorizontalRule','SpecialChar','PageBreak'],
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize','ShowBlock'],
    ];
    config.width = 900;
    config.height = 150;	

};
