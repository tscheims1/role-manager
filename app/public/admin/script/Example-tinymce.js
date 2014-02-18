jQuery(document).ready(function($) {
	if (typeof(tinymce) != "undefined") {
	tinymce.create( 
		'tinymce.plugins.example', 
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
					'example_button', 
					{
						cmd   : 'example_button_cmd',
						title : editor.getLang( 'example.buttonTitle', 'Example Shortcode adder' ),
						image : url + '/../../toolbar-icon.png',
						onclick: function(){ editor.selection.setContent('[Example action=\'index\']' + editor.selection.getContent() + '[/Example]');}
					}
				);
				/**
				* and a new command
				*/
				editor.addCommand(
					'example_button_cmd',
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
								title    : editor.getLang( 'example.popupTitle', 'Example Shortcode adder' ),
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
	tinymce.PluginManager.add( 'example', tinymce.plugins.example );
	}
});