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
	required: "必須記入",
	remote: "この欄を修正してください",
	email: "メールアドレスを入力してください。",
	url: "URLを入力してください。",
	date: "日付を入力してください。",
	dateISO: "日付を入力してください（YYYY-MM-DD）",
	number: "正しい数値を入力してください。",
	digits: "数字のみ入力できます",
	creditcard: "クレジットカード番号を入力してください。",
	equalTo: "もう一度入力してください。",
	extension: "拡張子を入力してください。",
	maxlength: $.validator.format( "最大{0}文字" ),
	minlength: $.validator.format( "最小{0}文字" ),
	rangelength: $.validator.format( "長さが{0}から{1}の文字列を入力してください。" ),
	range: $.validator.format( "{0}から{1}の値を入力してください。" ),
	max: $.validator.format( "{0}より小さい値を入力してください。" ),
	min: $.validator.format( "{0}以下の値を入力してください。" )
} );
return $;
}));