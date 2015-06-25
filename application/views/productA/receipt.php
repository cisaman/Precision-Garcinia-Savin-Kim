<?php include_once 'includes/header.php'; ?>

<div class="container receipt">
    <div class="top-container-after">
        <div class="top-strip-after">Thank you for your Purchase</div>
        <div class="after-container">
            <div class="modal-image"><img src="<?php echo base_url('assets/images') ?>/mod3..png" alt=""/></div>
            <div class="after-text">
                <h1>A <span>Rapid Belly<br/>
                        Melt</span> Solution<br/>
                    For Every BOdy<br/>
                    Type</h1>
                <p>Thank you for your purchase! Your purchase has been successfully processed. You will be receiving an automatic email receipt very shortly. Please keep it for your records. If you have any questions please contact our customer service department at <a href="mailto:support@precisiongarcinia.com">support@precisiongarcinia.com</a>. </p>
                <div class="clensing">
                    <div class="left-right-content">
                        <div class="first-prd">
                            <div class="img-clensing"> <img src="<?php echo base_url('assets/images') ?>/CLENSING-IMG1.png" alt=""/> </div>
                            <div class="left-price">
                                <h3>Garcinia <br>
                                    Cambogia</h3>
                                <p class="green-text">trial bottle</p>
                            </div>
                            <div class="right-price">
                                <h4>$0.00</h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="first-prd">
                            <div class="img-clensing"> <img src="<?php echo base_url('assets/images') ?>/CLENSING-IMG2.png" alt=""/> </div>
                            <div class="left-price">
                                <h3>Cleanser</h3>
                                <p class="green-text">trial bottle</p>
                            </div>
                            <div class="right-price">
                                <h4>$0.00</h4>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="close-btn">
                        <button class="red-btn" id="close">Close</button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">
    $('#close').click(function() {
        window.location.href = '<?php echo base_url('front/after_buy'); ?>';
    });

    jQuery(document).ready(function() {
        $('html, body').animate({
            scrollTop: $('.container.receipt').offset().top + 10
        }, 1500);
    });
</script>

<?php include_once 'includes/footer.php'; ?>