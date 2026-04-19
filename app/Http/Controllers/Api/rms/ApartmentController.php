<?php

namespace App\Http\Controllers\Api\rms;
// use App\Http\Controllers\Api\rms\ApartmentController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment\Apartment;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::with(['building', 'apartmentType'])->paginate(5);
        return json_encode (["apartments" => $apartments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'apartment_no' => 'required',
            'building_id' => 'required',
            'type_id' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $apartment = new Apartment;
        $apartment->apartment_no = $request->apartment_no;
        $apartment->building_id = $request->building_id;
        $apartment->type_id = $request->type_id;
        $apartment->floor = $request->floor;
        $apartment->rent = $request->rent;
        $apartment->size_sqft = $request->size_sqft;
        $apartment->status = $request->status;
        
        $apartment->save();

        if($request->hasFile('photo')){
            $imageName = $apartment->id . '.' . $request->photo->extension();
            $apartment->photo = $imageName;
            $apartment->update();
            $request->photo->move(public_path('img/apartments'), $imageName);
        }

        return back()->with('success', 'Apartment Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apartment = Apartment::with(['building', 'apartmentType'])->findOrFail($id);
        return json_encode(["apartment" => $apartment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
