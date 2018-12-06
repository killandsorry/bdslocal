<div id="form_contact">
    <p id="contact_title" class="contact_title" onclick="vua.toggleContact();">Nhận tài liệu chi tiết và những thông tin mới nhất về dự án <?=$pro_name?></p>
    <ul id="contact_field" class="">
        <li>
            Họ tên:
            <input type="text" value="" id="cname" placeholder="vd: Nguyễn Văn An">
        </li>
        <li>
            Số điện thoại:
            <input class="autocomplete" type="text" value="" id="cphone" placeholder="vd: 0989 xxx xxx">
        </li>
        <li>
            Email:
            <input class="autocomplete" type="text" value="" id="cemail" placeholder="vd: nguyenvana@gmail.com">
        </li>
        <li>
            <input type="button" class="btn" value="Nhận tài liệu" onclick="vua.sendContact()">
            <input type="hidden" value="<?=(isset($pro_id)? $pro_id : 0)?>" id="pid">
            <span class="btn_un" onclick="vua.hideContact()">Ẩn xuống</span>
        </li>
    </ul>
</div>
<style>
    #form_contact{
        position: fixed;
        bottom: 0;
        right: 30px;
        width: 100%;
        max-width: 300px;
        z-index: 2;
        overflow: hidden;
        box-shadow: 0px 0px 20px rgba(0,0,0,0.3);
        border-radius: 5px 5px 0 0;
        background-color: #fff;
    }
    #form_contact p{
        line-height: 20px;
        font-size: 16px;
        text-align: center;
        background-color: #009933;
        color: #fff;
        padding: 10px 20px;
        cursor: pointer;
    }
    #form_contact ul{
        padding: 20px 20px 10px 20px;
    }
    #form_contact ul li{
        margin-bottom: 15px;
        font-size: 14px;
    }
    #form_contact input[type=text]{
        display: block;
        width: 100%;
        margin-top: 4px;
        padding: 5px;
        font-size: 14px;
        text-transform: capitalize;
        border: 1px solid #ddd;
    }
    #form_contact .btn{
        padding: 5px 10px;
        font-size: 16px;
        cursor: pointer;
    }
    #form_contact .btn_un{
        display: inline-block;
        padding: 7px 10px;
        color: #888;
        font-size: 14px;
        cursor: pointer;
    }
    #form_contact .btn_un:hover{
        color: #000;
    }
</style>
<script>
    function hideForm(obj){
        $(obj).parent('ul').toggle();
    }

</script>