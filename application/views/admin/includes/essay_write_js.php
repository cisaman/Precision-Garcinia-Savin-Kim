<script>
$(document).ready(function(){
	$("#form_write_essay #package_id,#form_write_essay #urgency,#form_write_essay #pages_needed").change(function(){
    var current_feild_id=this.id;
    var current_feild_value=$(this).val();
    if(current_feild_value!=''){
     $.ajax({
                        type : "POST",
                        async: false,
                        url : "<?php echo base_url(); ?>get_final_price_of_attribute/"+current_feild_id+"/"+current_feild_value,
                        
                        success : function(response) {
                           
                           if(current_feild_id == 'urgency'){
                           	  
                           	  if(response>1){
                           	  	$("#sign_indicator").html("+");
                           	  }
                           	  else{
                           	  	$("#sign_indicator").html("");
                           	  }
                           	  response = (response -1).toFixed(1);
                           	
                           	  $("#indi_orig_urgency").val(response);
                           }
                           if(current_feild_id == 'pages_needed'){
                           	    $("#page_value").val(response);
                           	    spacing_value=$("#spacing").val();
                           		$("#indi_"+current_feild_id).html(response/spacing_value);
                           }
                           else{
                           // var package_price=$("#indi_package_id").html();
                           // alert(package_price);
                            $("#indi_"+current_feild_id).html(response);
                          }  
                           
                        },
                        error : function(response) {
                         
                           
                        }
                    });
    }
    else{
    	$("#indi_"+current_feild_id).html(0);
    }

    	calulate_price_with_code();
        
    
  });

	$('#labCode').click(function(){
		$(this).hide();
		$('#discount_code_hide').show();
	});

	$('#discount_code').focusout(function(){
		var discount_code=$(this).val();
		if(discount_code!=''){
			$.ajax({
	                        type : "POST",
	                        async: false,
	                        url : "<?php echo base_url(); ?>get_discount_details_by_code/"+discount_code,
	                        
	                        success : function(response) {
	                           
	                        	
	                           if(response==0){
	                           	 $("#discount_message").html("Invalid Coupon Code.") 
	                           	 $("#showdiscountmsg").show();
	                           }
	                           $("#final_price_discount").html(response);
	                           
	                        },
	                        error : function(response) {
	                         
	                           
	                        }
	                    });
			calulate_price_with_code();
		}
	})
});

function calulate_price_with_code(){

	var cal_type_of_service =parseFloat($("#indi_package_id").html());
	var cal_urgency         =parseFloat($("#indi_orig_urgency").val())+1;
	var cal_pages_needed    =parseFloat($("#page_value").val());
	var coupan_discount 	=$("#final_price_discount").html();
    
	if(coupan_discount=='0'){
	
		total=cal_type_of_service*cal_urgency*cal_pages_needed;
	}
	else{

		coupan_discount = parseFloat(coupan_discount);
		
		discount_ammount = cal_type_of_service*cal_urgency*cal_pages_needed*(coupan_discount/100);
		
		total=cal_type_of_service*cal_urgency*cal_pages_needed-discount_ammount ;

	}
	
	//urgency_ammount=(cal_type_of_service*cal_urgency).toFixed(2) +" ("+ cal_type_of_service+"*"+cal_urgency  +")";
	urgency_ammount=(cal_type_of_service*cal_urgency-cal_type_of_service).toFixed(1) ;
	
	if(total==0 || isNaN(total) ){
		$("#final_price_total").removeClass("success_class");
		$("#final_price_total").addClass("error_class");
		total="Please select all values.";
	}else{
		$("#final_price_total").removeClass("error_class");
		$("#final_price_total").addClass("success_class");
		total=total.toFixed(1);
	}
	$("#indi_urgency").html(urgency_ammount);
	$("#final_price_total").html(total);
	//urgency_ammount=cal_type_of_service*cal_urgency +"("+ cal_type_of_service+"*"+cal_urgency  +")";
	//urgency_ammount=cal_type_of_service*cal_urgency.toFixed(2); ;

}
</script>