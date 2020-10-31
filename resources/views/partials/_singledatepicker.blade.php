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
    "singleDatePicker": true,
    "showDropdowns": true,
    "minYear": 1990,
    "maxYear": 2020,
    "startDate": moment(),
    
    "locale": {
        "format": "YYYY-MM-DD",
        "applyLabel": "Välj",
        "cancelLabel": "Avbryt",
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
