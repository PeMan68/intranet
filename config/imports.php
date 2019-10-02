<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Path and filenames for imports
    |--------------------------------------------------------------------------
    |
    */

    'path_booking' => env('IMPORT_PATH_BOOKING', 'c:\temp\booking'),
    'file_booking' => env('IMPORT_FILE_BOOKING', 'booking.csv'),

    'path_billing' => env('IMPORT_PATH_BILLING', 'c:\temp\billing'),
    'file_billing' => env('IMPORT_FILE_BILLING', 'billing.csv'),

    'path_prevBilling' => env('IMPORT_PATH_PREV_BILLING', 'c:\temp\prevBilling'),
    'file_prevBilling' => env('IMPORT_FILE_PREV_BILLING', 'prevBilling.csv'),

    'path_budget' => env('IMPORT_PATH_BUDGET', 'c:\temp\budget'),
    'file_budget' => env('IMPORT_FILE_BUDGET', 'budget.csv'),
];