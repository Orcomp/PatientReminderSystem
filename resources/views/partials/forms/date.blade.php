<script src="{{ url('adminlte/plugins/datetimepicker/moment-with-locales.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script>
$(function(){
    moment.updateLocale('en', {
        week: { dow: 1 } // Monday is the first day of the week
    });
    $('.date').datetimepicker({
        format: "{{ config('app.date_format_moment') }}",
        locale: "{{ App::getLocale() }}",
    });
});
</script>
