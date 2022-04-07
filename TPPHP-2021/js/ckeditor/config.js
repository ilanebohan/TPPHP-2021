/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.filebrowserUploadMethod = 'form';
	config.filebrowserBrowseUrl = '../TPPHP-2021/js/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = '../TPPHP-2021/js/kcfinder/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl = '../TPPHP-2021/js/kcfinder/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl = '../TPPHP-2021/js/kcfinder/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl = '../TPPHP-2021/js/kcfinder/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl = '../TPPHP-2021/js/kcfinder/upload.php?opener=ckeditor&type=flash';

};
