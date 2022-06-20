<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Cache\TagSet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpParser\Node\Expr\List_;

class ListingController extends Controller
{
    //
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
        ]);
    }

    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'website' => 'required',
            'email' => ['required', 'email'],
            'description' => 'required',
            'location' => 'required',
            'tags' => 'required'

        ]);
        Listing::create($formFields);
        return redirect('/')->with('message', 'Listing created successfully.');
    }
}
