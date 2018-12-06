var vua = {

    /**
     * ẩn form nhập thông tin
     */
    hideContact : function () {
        $('#contact_field').addClass('hide');
    },

    /**
     * bật, tắt form nhập thông tin
     */
    toggleContact : function () {
        $('#contact_field').toggleClass('hide');
    },

    /**
     * Gửi thông tin
     */
    sendContact : function () {
        var email = $('#cemail').val() || '';
        var name = $('#cname').val() || '';
        var phone = $('#cphone').val() || '';
        var pid     = $('#pid').val() || 0;

        if (name != '' && phone != '' && pid > 0){
            $.post(

                '/ajaxs/api_contact.php',
                {
                    pid : pid,
                    phone : phone,
                    name : name,
                    email : email
                },
                function (res) {
                    if (res.code != 200){
                        alert(res.msg);
                        return false;
                    }else{
                        vua.hideContact();
                        $('#contact_title').text(res.msg);
                    }
                },
                'json'
            )
        }else{
            alert('Chúng tôi cần [Họ tên], [Số điện thoại] để có thể gửi tài liệu cho bạn');
        }
    }

};