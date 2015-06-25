                <div class="fotter-section">
                    <div class="fotter-first-wrp">
                        <h1>WARNING: NOT ALL GARCINIA CAMBOGIA IS THE SAME!</h1>
                        <p>It’s important to know what you’re buying with Garcinia Cambogia. There are plenty of companies out there that says ‘Garcinia Cambogia’ on the label, but not all Garcinia Cambogia Extracts are created equal. Without the correct dose of Hydroxycitric Acid (HCA), it won’t work at all.</p>
                        <span>Other products out there can sometimes only contain between 30-50% HCA.</span> <strong>OURS CONTAIN 60%</strong> </div>
                    <div class="copy-right">© 2015Copyright . All Rights reserved.</div>
                    <div class="fotter-first-wrp second-wrp">
                        <ul class="fotter-txt">
                            <li><a href="javascript:void(0);" id="terms">TERMS</a></li>
                            <li><a href="javascript:void(0);" id="privacy">PRIVACY POLICY</a></li>
                            <li><a href="javascript:void(0);" id="contact">CONTACT US</a></li>
                        </ul>
                        <p>
                            This product should be used only as directed on the label. This product is not for use by or sale to persons under the age of 18. A Doctor's advice should be sought before using this and any supplemental dietary product. It should not be used if you are pregnant or nursing. Consult with a physician before use if you have a serious medical condition or use prescription medication. All trademarks and copyrights are the property of their respective owners and are not affiliated with nor do they endorse Garcinia Cambogia. These statements have not been evaluated by the FDA. This product is not intended to diagnose, treat, cure or prevent any disease. Individual weight loss results will vary. By using this site you agree to follow the Privacy Policy and Terms & Conditions printed on this site. Void Where Prohibited By Law. Precisiongarcinia.com is not affiliated with Dr. Mehmet Oz, ZoCo Productions LLC or to ZoCo 1 LLC. ZoCo 1 LLC is the owner of the following trademarks: DR. OZ™, ASK DR. OZ™ and THE DOCTOR OZ SHOW™.
                        </p>
                    </div>
                </div>
            </div>
        </div>   

        <div class="apply-coupon" id="popup" style="display:none;">
            <div class="bg-apply2">
                <p class="titlepara"></p>
                <div id="showContent"></div>                
                <p class="closepara"><a href="javascript:void(0);" class="closepop">Close</a></p>
            </div>
        </div>   
        <div class="apply-coupon" id="pop1" style="display:none;">
            <div class="bg-apply">
                <div class="text-coupon">
                    <h2>Shipping</h2>
                    <h1>$ 1.99</h1>
                    <h3>$4.99 shipping</h3>
                    <div class="">
                        <button class="red-btn" type="submit" id="apply">Apply Coupon</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="<?php echo base_url("assets/js") ?>/jquery.selectbox-0.2.js"></script> 
        <script type="text/javascript" src="<?php echo base_url("assets/js") ?>/custom.js"></script>
        <script>
            $(document).ready(function() {
                //$(".s-box").selectbox();
        
                $('.navigate_to_home').click(function() {
                    window.location.href = '<?php echo base_url('front/index'); ?>';
                });

                $('#privacy_policy, #privacy').click(function() {                    
                    getPage(1);

                    $('#popup').show();
                });

                $('#terms, #terms2').click(function() {
                    getPage(2);

                    $('#popup').show();
                });

                $('#contact').click(function() {
                    getPage(3);
                });              

                $('.closepop').click(function() {
                    $(this).parent().parent().parent().hide();
                });

                function getPage(id) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>/front/getPageByID',
                        data: {'id': id},
                        type: 'POST',
                        async: false,
                        dataType: 'JSON',
                        success: function(res) {                            
                            $('.titlepara').html(res.page_name);
                            $('#showContent').html(res.page_desc);                            
                        }
                    });
                  //  console.clear();

                    $('#popup').show();
                }               
            });

            setTimeout(function() {
                //console.clear();
            }, 1000);

        </script>

        <style type="text/css">
            .bg-apply2 {background: #fff;height: auto;margin: 0 auto;position: relative;text-align: left;top: 30px;width: 701px;border-radius: 10px;padding: 15px;}
            .closepara, .titlepara {text-align: center;}
            .titlepara {border-bottom: 1px solid #ddd;font-size: 20px;margin-bottom: 10px;padding-bottom: 10px;}
            .closepara {margin-top: 10px;}
            #showContent > p {margin-bottom: 10px;}
            #showContent {overflow-y: scroll;height: 500px;}
        </style>

    </body>
</html>
