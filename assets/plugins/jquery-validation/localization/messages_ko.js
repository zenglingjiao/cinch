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
	required: "입력해야하십시오.",
	remote: "이 난위를 수정해 주십시오.",
	email: "유효한 이메일을 입력하십시오.",
	url: "유효한 인터넷 주소를 입력하십시오.",
	date: "유효한 날짜를 입력하십시오.",
	dateISO: "유효한 날짜를 입력하십시오. (YYYY-MM-DD)",
	number: "정확한 수치를 입력하십시오.",
	digits: "숫자 만 입력하십시오.",
	creditcard: "유효한 신용 카드 번호를 입력하십시오.",
	equalTo: "다시 입력하십시오.",
	extension: "유효한 접미사를 입력하십시오.",
	maxlength: $.validator.format( "최대 {0} 문자" ),
	minlength: $.validator.format( "최소 {0} 문자" ),
	rangelength: $.validator.format( "{0} ~ {1} 사이에 문자열을 입력하십시오." ),
	range: $.validator.format( "{0} ~ {1} 사이의 수치을 입력하십시오." ),
	max: $.validator.format( "{0}보다 크지 않은 수치를 입력하십시오." ),
	min: $.validator.format( "{0}보다 작지 않은 수치를 입력하십시오." )
} );
return $;
}));