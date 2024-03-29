<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script> 
<script src="/assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ url('/assets/scripts/global/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/global/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/global/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/global/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/global/bootbox.all.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/global/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/global/vue.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/global/highcharts.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/global/moment.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ url('/assets/scripts/layouts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ url('/assets/scripts/layouts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/layouts/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/layouts/quick-sidebar.min.js') }}" type="text/javascript"></script>
<script src="{{ url('/assets/scripts/layouts/quick-nav.min.js') }}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script src="{{ url('/assets/scripts/global/main.js') }}" type="text/javascript"></script>
<script>
    function url(path = "") {
        return initURL(path, '<?= url() ?>')
    }

    if (!sessionStorage.hasOwnProperty("token")) {
        window.location = url("/login");
    }

    $(document).ready(function() {
        $('#clickmewow').click(function() {
            $('#radio1003').attr('checked', 'checked');
        });
    })
</script>
<script src="{{ url('/assets/scripts/pages/app.js') }}" type="text/javascript"></script>
@yield('scripts')