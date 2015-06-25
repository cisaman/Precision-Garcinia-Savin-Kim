<?php include_once 'includes/header.php'; ?>

<div class="container after-buy">
    <div class="top-container-after">
        <div class="top-strip-after">Melt Belly Fat</div>
        <div class="after-container">
            <div class="modal-image"><img src="<?php echo base_url('assets/images') ?>/mod2..png" alt=""/></div>
            <div class="after-text">
                <h1>A <span>Rapid Belly<br/>
                        Melt</span> Solution<br/>
                    For Every BOdy<br/>
                    Type</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In et erat id eros imperdiet pellentesque quis sed enim. Mauris vitae venenatis nibh. Ut ac turpis a justo dignissim lacinia. Nulla elementum pharetra nunc, a aliquam ligula varius at. Donec porttitor, urna sed blandit varius, eros sem rutrum erat, vitae sagittis turpis ligula ut neque. </p>
                <p>Duis dictum, augue ac egestas dictum, orci erat euismod diam, hendrerit vehicula leo tortor ut felis. Vestibulum pharetra iaculis arcu quis condimentum. Ut eget quam magna. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="green-add">
            <div class="bottle-img"><img src="<?php echo base_url('assets/images') ?>/free.png" alt=""/></div>
            <div class="red-tag"><img src="<?php echo base_url('assets/images') ?>/tag-red.png" alt=""/></div>
            <div class="green-add-text">
                <h1>2 Month Supply</h1>
                <p>RRP : $139.95</p>
                <div class="yellow-tag">Get 2 for :  $39.99</div>
                <div class="pink-btn">
                    <button type="submit"> Yes, I want a slimmer body!</button>
                </div>
                <a href="javascript:void(0);">No thanks, I already have slim body</a> </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        $('html, body').animate({
            scrollTop: $('.container.after-buy').offset().top + 10
        }, 1500);
    });
</script>

<?php include_once 'includes/footer.php'; ?>