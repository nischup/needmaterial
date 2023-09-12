<script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('frontend/js/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/js/plugins.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/js/wow.min.js') }}"></script>
<script src="{{ asset('frontend/js/waypoints.js') }}"></script>
<script src="{{ asset('frontend/js/nice-select.js') }}"></script>
<script src="{{ asset('frontend/js/counterup.min.js') }}"></script>
<script src="{{ asset('frontend/js/owl.min.js') }}"></script>
<script src="{{ asset('frontend/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('frontend/js/yscountdown.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>

@yield('scripts')
@stack('scripts')

<script>
    let url = "{{ route('changeLang') }}";

    $('body').on('change', '#changeLang', function() {
        window.location.href = url + "?lang="+ $(this).val();
    });
</script>
