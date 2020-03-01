//var imgSrc = []; //图片路径
//var imgFile = []; //文件流
//var imgName = []; //图片名字
var imgSrcL = [];
var upimgBtn;
//选择图片
function imgUpload(obj) {
    var oInput = '#' + obj.inputId;
    upimgBtn = '#' + obj.inputId;
	var imgBox = '#' + obj.imgBox;
	var multiple = obj.multiple;
	var size = obj.size;
	var sizeunit = obj.sizeunit;
    //var btn = '#' + obj.buttonId;
	$(oInput).on("change", function () {
	    var fileImg = $(oInput)[0];
	    var fileList = fileImg.files;
	    imgSrcL = [];
	    for (var i = 0; i < fileList.length; i++) {
	        if (fileList[i].size / 1024 > size)
	        {
	            alert("單一圖片大小不得超過" + size + "" + sizeunit);
	            return false;
	        } else {
	            var imgSrcI = getObjectURL(fileList[i]);
	            imgName.push(fileList[i].name);
	            imgSrc.push(imgSrcI);
	            imgSrcL.push(imgSrcI);
	            //單圖不加入imgFile
	            if(multiple)
				{
					imgFile.push(fileList[i]);
				}else{

				}

	        }
	    }
	    addNewContent(imgBox, multiple);
	})
	
	//$(btn).on('click', function() {
		//var data = new Object;
		//data[obj.data] = imgFile;
		//submitPicture(obj.upUrl, data);
	//})
}
//图片展示
function addNewContent(obj, multiple) {
    //$(obj).html("");
    if (multiple) {
        for (var a = 0; a < imgSrc.length; a++) {
            var oldBox = $(obj).html();
            if ($.inArray(imgSrc[a], imgSrcL) > -1) {
                $(obj).html(oldBox + '<div class="imgContainer"><img title=' + imgName[a] + ' alt=' + imgName[a] + ' src=' + imgSrc[a] + '><p onclick="removeImg(this,' + a + ')" class="imgDelete">删除</p></div>');
            }
        }
    }
    else {
        for (var a = 0; a < imgSrc.length; a++) {
            //var oldBox = $(obj).html();
            if ($(obj).children('.imgContainer').children()[0]) {
                var src = $(obj).children().children()[0].src;
                if ($.inArray(src, imgSrc) > -1) {
                    var index = $.inArray(src, imgSrc);
                    imgSrc.splice(index, 1);
                    imgFile.splice(index, 1);
                    imgName.splice(index, 1);
                }
            }
            if ($.inArray(imgSrc[a], imgSrcL) > -1) {
                if (imgSrc[a]) {
                    $(obj).html('<div class="imgContainer"><img title=' + imgName[a] + ' alt=' + imgName[a] + ' src=' + imgSrc[a] + '></div>');
                }
            }
        }
    }
}

//删除
function removeImg(obj, index) {
	imgSrc.splice(index, 1);
	imgFile.splice(index, 1);
	imgName.splice(index, 1);
	//var boxId = "#" + $(obj).parent('.imgContainer').parent().attr("id");
	$(obj).parent('.imgContainer').remove();
	$(upimgBtn).val('');
}

//上传(将文件流数组传到后台)
function submitPicture(url,data) {
	console.log(data);
	alert('请打开控制台查看传递参数！');
	if(url&&data){
		$.ajax({
			type: "post",
			url: url,
			async: true,
			data: data,
			traditional: true,
			success: function(dat) {
	//			console.log(dat);
			}
		});
	}
}
//图片灯箱
//function imgDisplay(obj) {
//	var src = $(obj).attr("src");
//	var imgHtml = '<div style="width: 100%;height: 100vh;overflow: auto;background: rgba(0,0,0,0.5);text-align: center;position: fixed;top: 0;left: 0;z-index: 1000;"><img src=' + src + ' style="margin-top: 100px;width: 70%;margin-bottom: 100px;"/><p style="font-size: 50px;position: fixed;top: 30px;right: 30px;color: white;cursor: pointer;" onclick="closePicture(this)">×</p></div>'
//	$('body').append(imgHtml);
//}
//关闭
function closePicture(obj) {
	$(obj).parent("div").remove();
}

//图片预览路径
function getObjectURL(file) {
	var url = null;
	if(window.createObjectURL != undefined) { // basic
		url = window.createObjectURL(file);
	} else if(window.URL != undefined) { // mozilla(firefox)
		url = window.URL.createObjectURL(file);
	} else if(window.webkitURL != undefined) { // webkit or chrome
		url = window.webkitURL.createObjectURL(file);
	}
	return url;
}