<?php include_once 'includes/header.php'; ?>
<div class="container home-page">
    <div class="banner-image"> <a href="javascript:void(0);"><img src="<?php echo base_url('assets/images') ?>/logo.png" alt=""/></a> </div>
    <!-- banner img-->        
    <div class="left-ban">
        <div class="modal-bg"> <img src="<?php echo base_url('assets/images') ?>/b&g1.png" alt=""/> </div>
        <div class="badge-home"><img src="<?php echo base_url('assets/images') ?>/badge-new.png" alt=""/></div>
        <div class="fat"><img src="<?php echo base_url('assets/images') ?>/text.png" alt=""/></div>
        <div class="lemon"><img src="<?php echo base_url('assets/images') ?>/lem1.png" alt=""/></div>
        <div class="claim"><img src="<?php echo base_url('assets/images') ?>/arrow.png" alt=""/>
            <div class="claim-mb">Claim your <br/>
                Free Trial Bottle Today</div>
        </div>
    </div>
    <div class="right-ban">
        <div class="right-container">
            <div class="top-heading">
                <h1> Tell Us where <span class="lato-heavy">to send </span> <span class="lato-bold">Your Package</span> </h1>
            </div>
            <div class="middle-content">
                <input type="hidden" id="count_states" name="count_states" value="1"/>
                <?php if(isset($email_check_msg) && !empty($email_check_msg)) { ?>
                    <div id="alert-message" class="alert-message <?php echo $this->session->flashdata('flag-msg'); ?>">
                        <a class="close" href="javascript:void(0)">×</a>
                        <p><strong id="text-alert-flag"></strong> <span id="text-alert-message"><?php echo $email_check_msg; ?> </p></span>
                    </div>
                <?php } ?>
                <?php if ($this->session->flashdata('msg')) { ?>
                    <div id="alert-message" class="alert-message <?php echo $this->session->flashdata('flag-msg'); ?>">
                        <a class="close" href="javascript:void(0)">×</a>
                        <p><strong id="text-alert-flag"></strong> <span id="text-alert-message"><?php echo $this->session->flashdata('msg'); ?> </p></span>
                    </div>
                <?php } ?>
                <?php echo form_open('front/index', 'method="post" name="register" id="register" autocomplete="off"') ?>
                
                <input type="hidden" id="base_url" value="<?php echo base_url() ?>" />
                <ul class="form-prd">
                    <li>
                        <input type="hidden" id="product_id" name="product_id" value="1"/>
                        <input type="text" value="<?php echo @$_REQUEST['first_name']; ?>" placeholder="First Name" class="validate[required] full-width" name="first_name">
                    </li>
                    <li>
                        <input type="text" value="<?php echo @$_REQUEST['last_name']; ?>" placeholder="Last Name" class="validate[required] full-width" name="last_name">
                    </li>
                    <li>
                        <input type="text" value="<?php echo @$_REQUEST['address']; ?>" placeholder="Address" class="validate[required] full-width" name="address">
                    </li>                    
                    <li> 
                        <select class="validate[required] s-box" name="country" id="country">                                                        
                            <option value="">Country</option>
                            <?php foreach ($country as $key => $value) { ?>                            
                                <option value="<?php echo $value['country_id'] ?>"><?php echo $value['country_name'] ?></option>
                            <?php } ?>
                        </select>                        
                    </li>                                                            
                    <li>
                        <input maxlength="6"  value="<?php echo @$_REQUEST['zipcode']; ?>"type="text" placeholder="Zip Code" class="validate[required, custom[zipcode, maxSize[8]]] full-width" name="zipcode">
                    </li>
                    <li id="li_state_dropdown">
                        <select class="validate[required] s-box" name="state" id="state">
                            <option value="">State</option>
                        </select>                        
                    </li>
                    <li>
                        <input type="text" value="<?php echo @$_REQUEST['city']; ?>"placeholder="City" class="validate[required] full-width" name="city">
                    </li>
                    <li>
                        <input maxlength="12" type="text" value="<?php echo @$_REQUEST['phone_number']; ?>" placeholder="Phone Number" class="validate[required, custom[phone, maxSize[15]]] full-width" name="phone_number">
                    </li>
                    <li>
                        <input type="text" value="<?php echo @$_REQUEST['email_address']; ?>" placeholder="Email Address" class="validate[required, custom[email], ajax[ajaxEmailid]] full-width" name="email_address" id="email_address">
                    </li>
                    <li>
                        <button type="button" class="red-btn" id="top13">GET MY Package</button>
                    </li>
                    <li class="text-privacy">
                        <a href="javascript:void(0);" title="Privacy Policy" id="privacy_policy">Privacy Policy</a>
                    </li>
                </ul>
                <?php echo form_close() ?>
            </div>
            <ul class="support">
                <li><a href="javascript:void(0);"><img src="<?php echo base_url('assets/images') ?>/r3.png" alt=""/></a></li>
                <li><a href="javascript:void(0);"><img src="<?php echo base_url('assets/images') ?>/r2.png" alt=""/></a></li>
                <li><a href="javascript:void(0);"><img src="<?php echo base_url('assets/images') ?>/r1.png" alt=""/></a></li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="color-strip">
        <div class="top-color"></div>
        <div class="bottom-color"> <a href="javascript:void(0);">As seen on</a> </div>
        <ul>
            <li><a href=""><img alt="" src="<?php echo base_url('assets/images') ?>/l1.png"></a></li>
            <li><a href=""><img alt="" src="<?php echo base_url('assets/images') ?>/l2.png"></a></li>
            <li><a href=""><img alt="" src="<?php echo base_url('assets/images') ?>/l3.png"></a></li>
            <li><a href=""><img alt="" src="<?php echo base_url('assets/images') ?>/l4.png"></a></li>
            <li><a href=""><img alt="" src="<?php echo base_url('assets/images') ?>/l5.png"></a></li>
            <li><a href=""><img alt="" src="<?php echo base_url('assets/images') ?>/l6.png"></a></li>
            <li><a href=""><img alt="" src="<?php echo base_url('assets/images') ?>/l7.png"></a></li>
        </ul>
    </div>
    <div class="video-section">
        <div class="video-left">
            <div class="video">
                <iframe width="480" height="300" src="https://www.youtube.com/embed/qL6IHNqySu0" frameborder="0" allowfullscreen></iframe>
            </div>
            <p><a href="javascript:void(0);">In the Media</a></p>
        </div>
        <div class="video-right">
            <div class="video myvideo">
                <img alt="" src="<?php echo base_url('assets/images') ?>/video.jpg" id="video1">
                <iframe width="480" height="300" src="https://www.youtube.com/embed/xWUpTfQwU4k" frameborder="0" allowfullscreen style="display:none;" id="videoframe"></iframe>
            </div>
            <p><a href="javascript:void(0);">Dr. Oz on Garcinia</a></p>
        </div>
        <div class="clearfix"></div>
        <div class="v-leaf"><img src="<?php echo base_url('assets/images') ?>/p7_img.png" alt=""/></div>
        <div class="v-leaf2"><img src="<?php echo base_url('assets/images') ?>/p6_img.png" alt=""/></div>
    </div>

    <!--video-section ends-->

    <div class="white-bg buzz">
        <h1 style="text-transform: uppercase">What is all the buzz about?</h1>
        <h2>The Miraculous Weight Loss Fruit</h2>
        <p>Garcinia Cambogia is the NEWEST, FASTEST, FAT BUSTER. Celebrity doctors and news channels have talked about, and recommended, Garcinia Cambogia. Garcinia Cambogia comes from the exotic jungles of Southeast Asia, where locals have called it the magic weight loss fruit. The makers of Garcinia Cambogia had a simple goal, discover the secrets of this local legend and create the fastest and most effective weight loss supplement ever. Join millions of people today from around the world to find out what the buzz is all about.</p>
        <div class="red-btn-div">
            <button class="red-btn" type="submit" id="top11">Get My Package</button>
        </div>
        <div class="buzz-img"> <img src="<?php echo base_url('assets/images') ?>/buzz.png" alt=""/> </div>
    </div>
    <!--imzz section-->
    <div class="yellow-section">
        <div class="yellow-right">
            <h1><span>Benefits of</span> <br/>
                Garcinia <br/>
                Cambogia </h1>
            <p>The HCA from Garcinia Cambogia aids in weight loss by doing two things at the same time: It blocks fat and suppresses your appetite. These two things work together to stop and prevent the absorption of fat and ultimately stop weight gain.</p>
            <div class="red-btn-div">
                <button type="submit" class="red-btn" id="top12">Get My Package</button>
            </div>
            <div class="yellow-img"><img src="<?php echo base_url('assets/images') ?>/p10_img.png" alt="" /></div>
        </div>
        <div class="yellow-right-new"><!--<img src="<?php echo base_url('assets/images') ?>/right-text.png" alt=""/>-->
            <h1>Why choose <span>Garcinia Cambogia pure extract</span></h1>
            <ul>
                <li>
                    <p><span>1</span>Reduction of fat cells forming</p>
                </li>
                <li>
                    <p><span>2</span>Feel more energized</p>
                </li>
                <li>
                    <p><span>3</span>Helps lower stress levels which will burn belly fat</p>
                </li>
                <li>
                    <p><span>4</span>Increase serotonin and decrease emotionally eating</p>
                </li>
                <li>
                    <p><span>5</span>Decrease appetite, control your sugar cravings</p>
                </li>
                <strong></strong>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>

    <!--yellow section--> 

    <!--green section starts-->
    <div class="green-section">
        <div class="green-img"><img src="<?php echo base_url('assets/images') ?>/grren-img.png" alt=""/></div>
        <div class="green_text">
            <h2 style="text-transform: uppercase;">What Should I Expect?</h2>
            <p>With Garcinia Cambogia, weight loss can be 3-4 times more effective than with diet and exercise alone. What this means is that a weight loss of 6 pounds a month can be improved  to 24 pounds a month with proper diet and exercise. Those taking Garcinia Cambogia have reported a reduction in both appetite and sugar cravings. In addition to all this, users have also reported increased lean muscle mass and energy.</p>
            <div class="red-btn-div green-btn-div">
                <button type="submit" class="red-btn green-btn" id="top14">Get My Package</button>
            </div>
        </div>
    </div>
    <!--green section ends--> 

    <!--brown section starts-->

    <div class="brown-section">
        <div class="brown_head"> <img src="<?php echo base_url('assets/images') ?>/add-banner.png" alt=""/> </div>
    </div>

    <!--brown section ends--> 
    <!--banner section starts-->
    <div class="new-banner">
        <div class="brown_head">
            <div class="banner-imagee"><img src="<?php echo base_url('assets/images') ?>/banner2.png" alt=""/>
                <div class="banner-btn"><a class="red-btn" id="btn_order_now" href="javascript:void(0)">Order Now!</a></div> 
            </div>
        </div>
    </div>
    <!--banner section starts--> 
</div>

<link href="<?php echo base_url("assets/css") ?>/validationEngine.jquery.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url("assets/js") ?>/jquery.validationEngine-en.js"></script> 
<script src="<?php echo base_url("assets/js") ?>/jquery.validationEngine.js"></script>

<style type="text/css">
    .myvideo{cursor: pointer;}
    #video1{height: 300px;width: 480px;}
</style>

<script type="text/javascript">
    jQuery(document).ready(function() {    	
    	 id_data="";
    	 setTimeout(function() {
          id_data1 = $("#country").attr('sb');                 
          $("#sbHolder_"+id_data1).click(function(){            
        	 checkvalue("country" ,"" ,"233px", "240px"); 
     	  });      	  
          }, 1000);
    	
         jQuery("#register").validationEngine();         
         $("#top13").click(function(){
         	$("#email_address").focus() ;
         	$("input").focus() ;

            res2=checkselected();  
            console.log(res2)         
            if(res2){
            	jQuery("#register").submit();
            }
         });
    	  
        $('.myvideo').hover(           
            function () {
                $('#video1').attr('src', "<?php echo base_url('assets/images') ?>/video-hover.jpg");
            }, 
            function () {
                $('#video1').attr('src', "<?php echo base_url('assets/images') ?>/video.jpg");
            }
        );

        $('.myvideo').click(           
            function () {
                $('#video1').hide();
                $('#videoframe').show();
                var videoURL = $('#videoframe').prop('src') + "?&autoplay=1";
                $('#videoframe').prop('src',videoURL);
            }
        );

        $('#top11, #top12, #top13, #top14,#btn_order_now').click(function() {
            $('html, body').animate({
                scrollTop: $('.top-heading').offset().top
            }, 1500);
        });
        //$("#state").hide();
        $("#country").selectbox({
            onChange: function(val, inst) {
                var count = cities();
                $("#state" + count).selectbox();
            },
            effect: "slide"
        });
        $("#state").selectbox({
            effect: "slide"
        });
        function cities() {
            var id = $('#country').val();
            var count_select = $("#count_states").val();
            $.ajax({
                url: '<?php echo base_url(); ?>front/getCityListByCountryID',
                data: {'id': id},
                type: 'POST',
                async: false,
                dataType: 'JSON',
                success: function(res) {
                    $("#li_state_dropdown").html('');
                    var select_state = "<select class='validate[required] s-box' name='state' id='state" + count_select + "'><option value=''>State</option>";
                    $.each(res, function(key, value) {
                        select_state += '<option value="' + value.state_id + '">' + value.state_name + '</option>';
                    });
                    select_state += "</select>";
                    $("#li_state_dropdown").html(select_state);
                    $("#count_states").val(parseInt($("#count_states").val()) + 1);
                     setTimeout(function() {         
                            id_data2 = $("select[name='state']").attr('sb'); 
                             $("#sbHolder_"+id_data2).click(function(){            
        						 checkvalue("state" ,"", "233px", "315px"); 
     	 						 }); 
         				 }, 2000);

                }
            });
            //console.clear();
            return count_select;
        }
    });


function checkselected(){   
 f1= checkvalue("country" ,"" ,"233px", "240px");
 f2= checkvalue("state" ,"", "233px", "315px"); 
  if(f1 == true && f2 ==true ){
  	return true;
  }else{
  	return false;
  }
}

function checkvalue(id,msg, left, margin_top){
       
   if( $("select[name='"+id+"']").val()==msg){  
       var cont ='<div id="'+id+'_1" class="form-validation-field-5formError parentFormresgistration_form formError" style="opacity: 0.87; position: absolute; top: 37.85px; left: '+left+'; margin-top: '+margin_top+';"><div class="formErrorContent">* This field is required<br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
         $("#"+id+"_"+1).remove();
         $("select[name='"+id+"']").parent().prepend(cont);
        return false;
   }else{
        $("#"+id+"_1").remove();
        return true;
   } 
}
</script>  
<?php include_once 'includes/footer.php'; ?>
