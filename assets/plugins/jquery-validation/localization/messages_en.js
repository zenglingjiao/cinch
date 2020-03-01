(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "../jquery.validate"], factory );
	} else if (typeof module === "object" && module.exports) {
		module.exports = factory( require( "jquery" ) );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: ZH (Chinese; 中文 (Zhōngwén), 汉语, 漢語)
 * Region: TW (Taiwan)
 */
$.extend( $.validator.messages, {
	required: "Must be filled in",
	remote: "Please correct this blank",
	email: "Please fill in a valid email",
	url: "Please fill in a valid internet site",
	date: "Please fill in a valid date",
	dateISO: "Please fill in a valid date (YYYY-MM-DD)",
	number: "Please fill in the correct value",
	digits: "Please only enter numbers",
	creditcard: "Please fill in the valid numbers of credit card",
	equalTo: "Please fill in again",
	extension: "Please fill in a valid suffix",
	maxlength: $.validator.format( "Maximum {0} words" ),
	minlength: $.validator.format( "Minimum {0} words" ),
	rangelength: $.validator.format( "Please enter a string between {0} and {1}" ),
	range: $.validator.format( "Please enter the value between {0} and {1}" ),
	max: $.validator.format( "Please enter the value greater than {0}" ),
	min: $.validator.format( "Please enter a value less than {0}" )
} );
return $;
}));