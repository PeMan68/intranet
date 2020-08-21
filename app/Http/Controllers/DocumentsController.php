<?php

namespace App\Http\Controllers;

use App\Documents;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
   		$files = Documents::all();
		return view('documents.index',[
			'files' => $files,
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocument $request)
    {
		$validatedData = $request->validated();
		$tmpFileName=$request->document;
		$realFileName=$tmpFileName->getClientOriginalName();
		$documentExtension = $tmpFileName->getClientOriginalExtension();
		$pathToFile = $request->document->store('public/documents');
		$validatedData['path'] = $pathToFile;
		$validatedData['filename'] = $realFileName;
		$validatedData['size'] = Storage::size($pathToFile);
		$validatedData['user_id'] = Auth::id();
		$highestVersion = Documents::where('filename', $realFileName)->max('version');
		if (!is_null($highestVersion)) {
			$validatedData['version'] = $highestVersion + 1;
		} else {
			$validatedData['version'] = 1;
		}
		$document = Documents::create($validatedData);
		return redirect('/documents')->with('success','Fil uppladdad');
    }

    /**
     * Download the specified resource.
     *
     * @param  \App\Documents  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $document = Documents::find($id);
		return Storage::download($document->path, $document->filename);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documents  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$file = Documents::find($id);
		Storage::delete($file->path);
		$file->delete();				
		return redirect('/documents')->with('warning','Fil raderad!');
    }
}
