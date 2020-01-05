<div class="container">
    <div class="row text-center">
        <div class="col-sm-6 col-sm-offset-3">
            <br><br> <h2 style="color:#0fad00"><?php
                echo $message;
                ?></h2>
            <img src="http://osmhotels.com//assets/check-true.jpg">
            <h3>Dear, <?=$this->session->userdata('pre_username');?></h3>
            <a data-toggle="modal" data-target="#login" class="btn btn-success point">     Log in      </a>
            <br><br>
        </div>

    </div>
</div>