var demo_h5_upload_ops = {
    init: function () {
        this.eventBind();
    },
    eventBind: function () {
        var that = this;
        $("#upload").change(function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                that.compress(this.result);
            };
            reader.readAsDataURL(this.files[0]);
            
        });
        $("#File1").change(function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                that.compress2(this.result);
            };
            reader.readAsDataURL(this.files[0]);
            
        });
    },
    compress: function (res) {
        var that = this;
        var img = new Image(),
            maxH = 300;
        console.log(res);
        console.log(that.innerHTML);
        img.onload = function () {
            var cvs = document.createElement('canvas'),
                ctx = cvs.getContext('2d');

            if (img.height > maxH) {
                img.width *= maxH / img.height;
                img.height = maxH;
            }
            cvs.width = img.width;
            cvs.height = img.height;

            ctx.clearRect(0, 0, cvs.width, cvs.height);
            ctx.drawImage(img, 0, 0, img.width, img.height);
            var dataUrl = cvs.toDataURL('image/jpeg', 1);
            $(".img_wrap").attr("src", dataUrl);
            $(".img_wrap").show();
            // 上传略
            that.upload(dataUrl);
        };

        img.src = res;
    },
    compress2: function (res) {
        var that = this;
        var img = new Image(),
            maxH = 300;
        console.log(res);
        img.onload = function () {
            var cvs = document.createElement('canvas'),
                ctx = cvs.getContext('2d');

            if (img.height > maxH) {
                img.width *= maxH / img.height;
                img.height = maxH;
            }
            cvs.width = img.width;
            cvs.height = img.height;

            ctx.clearRect(0, 0, cvs.width, cvs.height);
            ctx.drawImage(img, 0, 0, img.width, img.height);
            var dataUrl = cvs.toDataURL('image/jpeg', 1);
            $(".img_wrap2").attr("src", dataUrl);
            $(".img_wrap2").show();
            // 上传略
            that.upload(dataUrl);
        };

        img.src = res;
    },
    upload: function (image_data) {
        /*这里写上次方法,图片流是base64_encode的*/
    }
};


$(document).ready(function () {
    demo_h5_upload_ops.init();
});