<?php
    echo form_open('', array(
        'method' => 'post',
        'id' => 'cart_form_singl'
    ));
?>
<input type="hidden" name="color" value="">
<input type="hidden" name="qty" value="1">
</form>
		<script src="<?php echo base_url(); ?>template/front/js/ajax_method.js"></script>
<script>
function set_loggers(){
    var state = check_login_stat('state');
    var name = check_login_stat('username');
    state.success(function (data) {
        if(data == 'hypass'){
            name.success(function (data) {
                document.getElementById('loginsets').innerHTML = ''
                // +'    <li>'
                +'        <a class="link-th" href="<?php echo base_url(); ?>index.php/home/profile/">'+data+'</a>'
                // +'    </li>'
                +'    <span class="dash-v">|</span>'
                // +'    <li>'
                +'       <a class="link-th" href="<?php echo base_url(); ?>index.php/home/logout/"><?php echo translate('logout');?></a>'
                // +'    </li>'
                +'';
            });
            if($('body').find('.shopping-cart').length){
                set_cart_form();
            }
        } else {
            document.getElementById('loginsets').innerHTML = ''
			<?php
				if($vendor_system == 'ok'){
			?>
            +'    <li>'
            +'        <a data-toggle="modal" data-target="#v_registration" class="point"><?php echo translate('vendor_registration');?></a>'
            +'    </li>'
			<?php
				}
			?>
            // +'    <li>'
            // +'        <a data-toggle="modal" data-target="#login" class="point"><?php echo translate('customer_login');?></a>'
            +'        <a class="link-login" data-toggle="modal" data-target="#login" ><i class="fa fa-user" aria-hidden="true"></i> <?php echo translate('Login'); ?></a>'
            // +'    </li>'
            // +'    <li>'
            +'    <span class="dash-v">|</span>'
            +'       <a data-toggle="modal" data-target="#registration" class="link-th"><?php echo translate('customer_registration');?></a>'
            // +'    </li>'
            +'';
        }
    }); 
    //onclick="ajax_load('+"'<?php echo base_url(); ?>index.php/home/login_set/login','login')"+';"
    var cart = '';
    if($('body').find('.shopping-cart').length){
        cart = 'cart';
    }
    ajax_load('<?php echo base_url(); ?>index.php/home/vendor_logup/registration/','ajvlup');
    ajax_load('<?php echo base_url(); ?>index.php/home/login_set/registration/'+cart,'ajlup');
    ajax_load('<?php echo base_url(); ?>index.php/home/login_set/login/'+cart,'ajlin');
}
	$(document).ready(function() {
		set_loggers();
        ajax_load('<?php echo base_url(); ?>index.php/home/cart/added_list/','added_list');
    });
</script>