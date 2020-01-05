
    $('#sky-form3').on('click','.submittertt', function(){
        //alert('vdv');
        var herea = $(this); // alert div for show alert message
        var form = herea.closest('form');
		var ing = herea.data('ing');
		var msg = herea.data('msg');
		var prv = herea.html();
        var can = '';
		var l = '';
		
        //var form = $(this);
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }

        var a = 0;
        var take = '';
        $("#sky-form3 .required").each(function(){
        	var txt = '*'+required;
            a++;
            if(a == 1){
                take = 'scroll';
            }
            var here = $(this);
            if(here.val() == ''){
                if(!here.is('select')){
                    here.css({borderColor: 'red'});
                    if(here.attr('type') == 'email'){
                        txt = '*'+valid_email;
                    }
                    
                    if(here.closest('label').find('.require_alert').length){

                    } else {
                        sound('form_submit_problem');
                        here.closest('label').append(''
                            +'  <span id="'+take+'" class="require_alert" >'
                            +'      '+txt
                            +'  </span>'
                        );
                    }
                } else if(here.is('select')){
                    here.closest('div').find('.chosen-single').css({borderColor: 'red'});
                    if(here.closest('div').find('.require_alert').length){

                    } else {
                        sound('form_submit_problem');
                        here.closest('div').append(''
                            +'  <span id="'+take+'" class="label label-danger require_alert" >'
                            +'      *'+required
                            +'  </span>'
                        );
                    }

                }
                can = 'no';
                l = 'empty:'+here.val()+'--';
            } 
			
            if (here.attr('type') == 'email'){
				if(!isValidEmailAddress(here.val())){
					here.css({borderColor: 'red'});
					if(here.closest('label').find('.require_alert').length){
	
					} else {
						sound('form_submit_problem');
						here.closest('label').append(''
							+'  <span id="'+take+'" class="require_alert" >'
							+'      *'+valid_email
							+'  </span>'
						);
					}
					can = 'no';
                    l = 'email';
				}
			}

        });

        var topp = 100;
        if($("#scroll").length){
            $('html, body').animate({
                scrollTop: $("#scroll").offset().top - topp
            }, 500);                    
        }

        if(can !== 'no'){
            $.ajax({
                url: form.attr('action'), // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                data: formdata ? formdata : form.serialize(), // serialize form data 
                cache       : false,
                contentType : false,
                processData : false,
                beforeSend: function() {
                    herea.html(ing); // change submit button text
                },
                success: function(data) {
                    herea.fadeIn();
                    herea.html(prv);
					if(data == 'sent'){
						sound('message_sent');
						notify('sent','success','bottom','right');
                        location.href= base_url+'index.php/home/payment_success';
					} else if (data == 'incor'){
						sound('captcha_incorrect');
						notify('incor','warning','bottom','right');
                        location.reload();
					} else {
                        notify(data,'warning','bottom','right');
                    }
                },
                error: function(e) {
                    console.log(e)
                }
            });
        } else {
            sound('form_submit_problem');
            return false;
        }
    });
	
	
	$("body").on('change','.required',function(){
		var here = $(this);
		here.css({borderColor: '#dcdcdc'});
		if (here.attr('type') == 'email'){
			if(isValidEmailAddress(here.val())){
				here.closest('div').find('.require_alert').remove();
			}
		} else {
			here.closest('div').find('.require_alert').remove();
		}
		if(here.is('select')){
			here.closest('div').find('.chosen-single').css({borderColor: '#dcdcdc'});
		}
	});
	
	
	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
	}
