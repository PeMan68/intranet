<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\StoreContact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all()->map(function($item) {
            return [
                'Id' => $item->id,
                'Namn' => $item->name,
                'Företag' => $item->company,
                'E-post' => $item->mail,
                'Telefon' => $item->telephone,
                'Adress_1' => $item->adress1,
                'Adress_2' => $item->adress2,
                'Postnummer' => $item->zip_city,
                'Kundnummer' => $item->customer_number,
                'Intern' => $item->external,
            ];
        });

        $fields = collect([]);
        $fields->push(['key' => 'Namn']);
        $fields->push(['key' => 'Företag']);
        $fields->push(['key' => 'E-post']);
        $fields->push(['key' => 'Telefon']);
        $fields->push(['key' => 'Intern']);
        $fields->push(['key' => 'Ändra']);


        return view('contacts.index', ['contacts' => $contacts, 'fields' => $fields]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContact $request)
    {
        $validatedData = $request->validated();
        
    }

    public function delete($id)
    {
        Contact::destroy($id);
        return response()->json("ok");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
