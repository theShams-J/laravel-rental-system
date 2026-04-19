<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RMS\Building;
use App\Models\RMS\Country;
use App\Models\RMS\City;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::with(['city', 'country'])
            ->withCount('apartments')
            ->latest()
            ->paginate(10);

        return view('pages.building.index', compact('buildings'));
    }

    public function create()
    {
        $countries = Country::all();
        $cities    = City::all();
        return view('pages.building.create', compact('countries', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'city_id'    => 'required|numeric',
            'country_id' => 'required|numeric',
        ]);

        Building::create([
            'company_id'   => Auth::user()->company_id,
            'name'         => $request->name,
            'contact'      => $request->contact,
            'email'        => $request->email,
            'address'      => $request->address,
            'city_id'      => $request->city_id,
            'country_id'   => $request->country_id,
            'total_floors' => $request->total_floors,
            'total_units'  => $request->total_units,
            'description'  => $request->description,
            'is_active'    => 1,
            'created_by'   => Auth::id(),
        ]);

        return redirect()->route('buildings.index')->with('success', 'Building created successfully.');
    }

    public function show(Building $building)
    {
        $building->load(['city', 'country', 'apartments.apartmentType']);
        return view('pages.building.show', compact('building'));
    }

    public function edit(Building $building)
    {
        $countries = Country::all();
        $cities    = City::all();
        return view('pages.building.edit', compact('building', 'countries', 'cities'));
    }

    public function update(Request $request, Building $building)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'city_id'    => 'required|numeric',
            'country_id' => 'required|numeric',
        ]);

        $building->update([
            'name'         => $request->name,
            'contact'      => $request->contact,
            'email'        => $request->email,
            'address'      => $request->address,
            'city_id'      => $request->city_id,
            'country_id'   => $request->country_id,
            'total_floors' => $request->total_floors,
            'total_units'  => $request->total_units,
            'description'  => $request->description,
            'is_active'    => $request->is_active ?? 1,
            'updated_by'   => Auth::id(),
        ]);

        return redirect()->route('buildings.index')->with('success', 'Building updated successfully.');
    }

    public function delete($id)
    {
        $building = Building::findOrFail($id);
        return view('pages.building.delete', compact('building'));
    }

    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('buildings.index')->with('success', 'Building deleted successfully.');
    }
}
