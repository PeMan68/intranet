@section('stylesheets')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('scriptsHead')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

@endsection

@section('scriptsBody')
<script>
$('input[name="daterange"]').daterangepicker({
	"timePicker": true,
	"timePickerIncrement":15,
	"timePicker24Hour":true,
	"startDate": moment().startOf('hour'),
    "endDate": moment().startOf('hour').add(2, 'hour'),
    "showWeekNumbers": true,
    "locale": {
        "format": "YYYY-MM-DD HH:mm",
        "separator": " till ",
        "applyLabel": "Välj",
        "cancelLabel": "Avbryt",
        "fromLabel": "Från",
        "toLabel": "Till",
        "customRangeLabel": "Custom",
        "weekLabel": "V",
        "daysOfWeek": [
            "Sön",
            "Mån",
            "Tis",
            "Ons",
            "Tor",
            "Fre",
            "Lör"
        ],
        "monthNames": [
            "Januari",
            "Februari",
            "Mars",
            "April",
            "Maj",
            "Juni",
            "Juli",
            "Augusti",
            "September",
            "Oktober",
            "November",
            "December"
        ],
        "firstDay": 1
    },
});
</script>
@endsection
