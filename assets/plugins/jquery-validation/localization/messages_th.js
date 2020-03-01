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
	required: "จำเป็นต้องกรอก",
	remote: "กรุณาแก้ไขข้อมูลให้ถูกต้อง",
	email: "กรุณากรอกที่อยู่อีเมล",
	url: "กรุณากรอกที่อยู่เว็บไซต์",
	date: "กรุณากรอกวันที่",
	dateISO: "กรุณากรอกวันที่(ปปปป/ดด/วว)",
	number: "กรุณากรอกจำนวนที่ถูกต้อง",
	digits: "กรอกได้เฉพาะตัวเลขเท่านั้น",
	creditcard: "กรุณากรอกหมายเลขบัตรเครดิต",
	equalTo: "กรุณากรอกข้อมูลอีกครั้ง",
	extension: "กรุณากรอกคำต่อท้ายที่ถูกต้อง",
	maxlength: $.validator.format( "มากที่สุด {0} คำ" ),
	minlength: $.validator.format( "น้อยที่สุด {0} คำ" ),
	rangelength: $.validator.format( "กรุณากรอกข้อความที่มีความยาวอยู่ระหว่าง {0} ถึง {1}" ),
	range: $.validator.format( "กรุณากรอกจำนวนที่อยู่ระหว่าง {0} ถึง {1}" ),
	max: $.validator.format( "กรุณากรอกจำนวนที่ไม่เกิน {0}" ),
	min: $.validator.format( "กรุณากรอกจำนวนที่ไม่น้อยกว่า {0}" )
} );
return $;
}));