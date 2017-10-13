<script src="{{ url('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(function(){
        $('.daterange').daterangepicker({
            endDate: moment().add(30, 'days'),
            locale: {
                format: '{{ config('app.date_format_moment') }}',
            },
        });
    });
</script>