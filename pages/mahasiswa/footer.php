<!--**********************************
            Footer start
        ***********************************-->
<div class="footer">
    <div class="copyright">
        <p>Copyright © Designed &amp; Developed by <a href="../index.htm" target="_blank">DexignLab</a> 2021</p>
    </div>
</div>
<!--**********************************
            Footer end
        ***********************************-->

<!--**********************************
        Scripts
    ***********************************-->
<!-- Required vendors -->
<script src="../../assets/template/vendor/global/global.min.js"></script>
<script src="../../assets/template/vendor/chart.js/Chart.bundle.min.js"></script>
<script src="../../assets/template/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

<!-- Apex Chart -->
<script src="../../assets/template/vendor/apexchart/apexchart.js"></script>

<script src="../../assets/template/vendor/chart.js/Chart.bundle.min.js"></script>

<!-- Chart piety plugin files -->
<script src="../../assets/template/vendor/peity/jquery.peity.min.js"></script>
<!-- Dashboard 1 -->
<script src="../../assets/template/js/dashboard/dashboard-1.js"></script>

<script src="../../assets/template/vendor/owl-carousel/owl.carousel.js"></script>

<script src="../../assets/template/js/custom.min.js"></script>
<script src="../../assets/template/js/dlabnav-init.js"></script>
<!-- <script src="../template/Fillow/js/demo.js"></script>
		<script src="../template/Fillow/js/styleSwitcher.js"></script> -->
<script>
    function cardsCenter() {

        /*  testimonial one function by = owl.carousel.js */



        jQuery('.card-slider').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            //center:true,
            slideSpeed: 3000,
            paginationSpeed: 3000,
            dots: true,
            navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 1
                },
                800: {
                    items: 1
                },
                991: {
                    items: 1
                },
                1200: {
                    items: 1
                },
                1600: {
                    items: 1
                }
            }
        })
    }

    jQuery(window).on('load', function() {
        setTimeout(function() {
            cardsCenter();
        }, 1000);
    });
</script>