</div><!-- end content -->

<footer role="contentinfo">

    <div id="footer-content" class="center-div">
        <?php if($footerText = get_theme_option('Footer Text')): ?>
        <div id="custom-footer-text">
            <p><?php echo get_theme_option('Footer Text'); ?></p>
        </div>
        <?php endif; ?>
        <?php if ((get_theme_option('Display Footer Copyright') == 1) && $copyright = option('copyright')): ?>
        <p><?php echo $copyright; ?></p>
        <?php endif; ?>
        <nav id="bottom-nav"><?php echo public_nav_main()->setMaxDepth(0); ?></nav>

       <p>
            <a href="http://library.bc.edu/" class="bc_logo" title="Boston College Libraries" ></a> <?php echo __('Proudly powered by <a href="http://omeka.org">Omeka</a>.'); ?></p>


    </div><!-- end footer-content -->

     <?php fire_plugin_hook('public_footer', array('view'=>$this)); ?>

</footer>

<script type="text/javascript">
    jQuery(document).ready(function(){
        Omeka.skipNav();
    });
</script>


<script type="text/javascript">
    jQuery(document).ready(function(){
        allimg = jQuery("#itemfiles-nav img")
        if(allimg && allimg.length < 2){
           jQuery(".chocolat-right, .chocolat-left").hide()
        }

        jQuery(".element-set .element:not(:has(>.element-text))").each(function() {
            jQuery(this).addClass("element-hide")
        })
        
    });
</script>



</body>

</html>
