jQuery(document).ready(function($) {
	if (typeof(tinymce) != "undefined") {
	tinymce.create( 
		'tinymce.plugins.backend', 
		{
		    /**
		     * @param tinymce.Editor editor
		     * @param string url
		     */
		    init : function( editor, url ) {
				/**
				*  register a new button
				*/
				editor.addButton(
					'backend_button', 
					{
						cmd   : 'backend_button_cmd',
						title : editor.getLang( 'backend.buttonTitle', 'backend Shortcode adder' ),
						image : url + '/../../toolbar-icon.png',
						onclick: function(){ editor.selection.setContent('[Backend action=\'index\']' + editor.selection.getContent() + '[/Backend]');}
					}
				);
				/**
				* and a new command
				*/
				editor.addCommand(
					'backend_button_cmd',
					function() {
						/**
						* @param Object Popup settings
						* @param Object Arguments to pass to the Popup
						*/
						editor.windowManager.open(
							{
								// this is the ID of the popups parent element
								id       : 'cubetech_image_carousel_dialog',
								width    : 480,
								title    : editor.getLang( 'backend.popupTitle', 'backend Shortcode adder' ),
								height   : 'auto',
								wpDialog : true,
								display  : 'block',
							},
							{
								plugin_url : url
							}
						);
					}
				);
			}
		}
	);
	
	// register plugin
	tinymce.PluginManager.add( 'backend', tinymce.plugins.backend );
	}
});