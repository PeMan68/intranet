<?php

namespace App\Http\Controllers;

use App\Holiday;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToArray;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->delete_old_data(13);
        $result = $this->import_next_public_holidays();
        
        $holidays =  Holiday::where('disabled', '<>', true)
                            ->orderBy('date')
                            ->get()
                            ->map(function ($item) {
            return [
                'Ändra' => $item->id,
                'Datum' => date('Y-m-d (l)', strtotime($item->date)),
                'Halvdag' => $item->half_day,
                'Beskrivning' => $item->description,
            ];
        });
        $fields = collect([]);
        $fields->push(['key' => 'Ändra']);
        $fields->push(['key' => 'Datum']);
        $fields->push(['key' => 'Halvdag']);
        $fields->push(['key' => 'Beskrivning']);
        //? $result message is not shown?
        return view('holidays.index')->with(['message' => $result, 'holidays' => $holidays, 'fields' => $fields]);
    }
    /**
     * Delete old holidays dates
     *
     * @param Int $months
     * @return void
     */
    private function delete_old_data(Int $months)
    {
        // Delete data from model older than months
        $oldHolidays = Holiday::whereDate('date', '<', now()->subMonths($months));
        if (!is_null($oldHolidays)) {
            $oldHolidays->delete();
            return true;
        }
        return false;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('holidays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $holiday = new Holiday();

        $holiday->date = $request->date;
        if ($request->has('half_day')) {
            $holiday->half_day = true;
        }
        $holiday->user_id = Auth::user()->id;
        $holiday->description = $request->description;
        $holiday->save();
        return redirect('/holidays');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('holidays.edit')->with(['holiday' => Holiday::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('reset')) {
            return redirect('/holidays');
        }
        $holiday = Holiday::find($id);
        if ($request->has('delete')) {
            $holiday->disabled = true;
            $holiday->save();
            return redirect('/holidays');
        }
        $holiday->date = $request->date;
        if ($request->has('half_day')) {
            $holiday->half_day = true;
        } else {
            $holiday->half_day = false;
        }
        $holiday->user_id = Auth::user()->id;
        $holiday->description = $request->description;
        $holiday->save();
        return redirect('/holidays');
    }

    /**
     * Importing public holidays
     * next 365 days for given country
     *
     * @return void
     */
    public function import_next_public_holidays()
    {
        $uri='https://date.nager.at/Api/v2/NextPublicHolidays/';
        $country= 'SE';
        $client = new \GuzzleHttp\Client();
        try {
            $request = $client->get($uri.$country);

            $response = json_decode($request->getBody());
            for ($i = 0; $i < count($response); $i++) {
                if (is_null(Holiday::whereDate('date', $response[$i]->date)->value('date'))) {
                    $holiday = new Holiday();

                    $holiday->date = $response[$i]->date;

                    $holiday->user_id = Auth::user()->id;
                    $holiday->description = $response[$i]->localName;
                    $holiday->save();
                }
            }
            return 'Röda dagar uppdaterade från '.$uri;
        } catch (Exception $e) {
            return 'Kunde inte hämta data från '.$uri.$country;

        }
    }
}
