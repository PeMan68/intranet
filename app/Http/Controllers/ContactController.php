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
                'E-post' => $item->email,
                'Telefon' => $item->telephone,
                'Adress_1' => $item->address1,
                'Adress_2' => $item->address2,
                'Postnummer' => $item->zip_city,
                'Kundnummer' => $item->customer_number,
                'Intern' => $item->internal,
            ];
        });

        $fields = collect([]);
        $fields->push(['key' => 'Namn']);
        $fields->push(['key' => 'Företag', 'sortable' => true]);
        $fields->push(['key' => 'E-post']);
        $fields->push(['key' => 'Telefon']);
        $fields->push(['key' => 'Intern', 'sortable' => true]);
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
        $contact = Contact::create($validatedData);
        return redirect('/contacts')->with('message', 'Kontakt tillagd ('.$contact->name.')');
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
        return view('contacts.edit', ['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(StoreContact $request, Contact $contact)
    {
        if ($request->has('delete')) {
            Contact::find($contact->id)->delete();
            return redirect('/contacts')->with('message', $contact->name.' raderad');
        }
        if ($request->has('abort')) {
            return redirect('/contacts');
        }
        if ($request->has('save')) {
            $validatedData = $request->validated();
            if (!$request->has('internal')) {
                $validatedData['internal'] = 0;
            }
            Contact::whereId($contact->id)->update($validatedData);
            return redirect('/contacts')->with('message', $contact->name.' uppdaterad');
        }
        return redirect('/contacts');
    }
}
