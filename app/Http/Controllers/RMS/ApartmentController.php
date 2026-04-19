<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RMS\Apartment;
use App\Models\RMS\Building;
use App\Models\RMS\ApartmentType;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartments = Apartment::with(['building', 'apartmentType'])->paginate(10);
        return view('pages.apartment.index', compact('apartments'));
    }

    public function create()
    {
        $buildings = Building::all();
        $types     = ApartmentType::all();
        return view('pages.apartment.create', compact('buildings', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'apartment_no' => 'required',
            'building_id'  => 'required',
            'type_id'      => 'required',
            'floor'        => 'required',
            'rent'         => 'required|numeric',
            'photo'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $apartment = Apartment::create([
            'company_id'   => Auth::user()->company_id,
            'building_id'  => $request->building_id,
            'type_id'      => $request->type_id,
            'apartment_no' => $request->apartment_no,
            'floor'        => $request->floor,
            'rent'         => $request->rent,
            'size_sqft'    => $request->size_sqft,
            'num_bedrooms' => $request->num_bedrooms,
            'num_bathrooms'=> $request->num_bathrooms,
            'has_parking'  => $request->has_parking ?? 0,
            'is_furnished' => $request->is_furnished ?? 0,
            'facing'       => $request->facing,
            'description'  => $request->description,
            'status'       => $request->status ?? 'Available',
            'created_by'   => Auth::id(),
        ]);

        if ($request->hasFile('photo')) {
            $imageName = $apartment->id . '.' . $request->photo->extension();
            $apartment->update(['photo' => $imageName]);
            $request->photo->move(public_path('img/apartments'), $imageName);
        }

        return redirect()->route('apartments.index')->with('success', 'Apartment created successfully.');
    }

    public function show($id)
    {
        $apartment = Apartment::with(['building', 'apartmentType', 'activeLease.tenant'])->findOrFail($id);
        return view('pages.apartment.show', compact('apartment'));
    }

    public function edit(Apartment $apartment)
    {
        $buildings = Building::all();
        $types     = ApartmentType::all();
        return view('pages.apartment.edit', compact('apartment', 'buildings', 'types'));
    }

    public function update(Request $request, Apartment $apartment)
    {
        $request->validate([
            'apartment_no' => 'required',
            'building_id'  => 'required',
            'type_id'      => 'required',
            'floor'        => 'required',
            'rent'         => 'required|numeric',
        ]);

        $apartment->update([
            'building_id'  => $request->building_id,
            'type_id'      => $request->type_id,
            'apartment_no' => $request->apartment_no,
            'floor'        => $request->floor,
            'rent'         => $request->rent,
            'size_sqft'    => $request->size_sqft,
            'num_bedrooms' => $request->num_bedrooms,
            'num_bathrooms'=> $request->num_bathrooms,
            'has_parking'  => $request->has_parking ?? 0,
            'is_furnished' => $request->is_furnished ?? 0,
            'facing'       => $request->facing,
            'description'  => $request->description,
            'status'       => $request->status,
            'updated_by'   => Auth::id(),
        ]);

        if ($request->hasFile('photo')) {
            $imageName = $apartment->id . '.' . $request->photo->extension();
            $apartment->update(['photo' => $imageName]);
            $request->photo->move(public_path('img/apartments'), $imageName);
        }

        return redirect()->route('apartments.index')->with('success', 'Apartment updated successfully.');
    }

    public function delete($id)
    {
        $apartment = Apartment::with(['building', 'apartmentType'])->findOrFail($id);
        return view('pages.apartment.delete', compact('apartment'));
    }

    public function destroy($id)
    {
        $apartment = Apartment::findOrFail($id);
        $apartment->delete();
        return redirect()->route('apartments.index')->with('success', 'Apartment deleted successfully.');
    }
}
