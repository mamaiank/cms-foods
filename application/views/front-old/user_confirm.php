<div class="container">
    <div class="row text-center">
        <div class="col-sm-6 col-sm-offset-3">
            <br><br> <h2 style="color:#0fad00"><?php
                echo $message;
                ?></h2>
            <img src="http://osmhotels.com//assets/check-true.jpg">
            <h3>Dear, <?=$this->session->userdata('pre_username');?></h3>
            <p style="font-size:20px;color:#5C5C5C;">Thank you for registration.We have sent you an email "<?=$this->session->userdata('pre_email');?>" with your details
                Please go to your above email now and login.</p>
            <p>"ขอบคุณสำหรับการลงทะเบียนการเป็นสมาชิกเว็บไซท์ Heelcare (Thailand)
                กรุณาเช็ครายละเอียดและยืนยันตัวตนที่ e-mail ของท่าน</p>
            <a data-toggle="modal" data-target="#login" class="btn btn-success point">     Log in      </a>
            <br><br>
        </div>
    </div>
</div>