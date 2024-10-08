<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shelter extends Model
{
    protected $fillable =
        ['city',
        'area',
        'floor_no',
        'nb_of_rooms',
        'capacity',
        'rent',
        'furnished',
        'elevator',
        'price',
        'phone_number',
        'user_id',
        ];


    public function store(Request $request , $locale = null)
    {
        $request->validate([
            'city' => 'required|string|max:255',
            'area' => 'required|string',
            'floor_no' => 'required',
            'nb_of_rooms' => 'required',
            'rent_or_no' => 'required',
            'capacity' => 'required|string',
            'price' => 'nullable',
            'phone_number' => 'required',
        ]);
        $user = Auth::user();
        $shelter = new Shelter();
        $shelter->city = $request->city;
        $shelter->area = $request->area;
        $shelter->floor_no = $request->floor_no;
        $shelter->nb_of_rooms = $request->nb_of_rooms;
        $shelter->capacity = $request->capacity;
        $shelter->rent_or_no = $request->rent_or_no;
        $shelter->furnished = $request->furnished;
        $shelter->elevator = $request->elevator;
        $shelter->accessibility = $request->accessibility;
        $shelter->price = $request->price;
        $shelter->currency = $request->currency;
        $shelter->phone_number = $request->phone_number;
        $shelter->user_id = $user->id;

        $shelter->save();
        $location = new Location();

        $location->city = $request->city;
        $location->area = $request->area;

        $location->save();
        return redirect()->route('user.index' , ['locale' => $locale])->with('success', 'Shelter added successfully.');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function destroy($id ,$locale = null)
    {
        $shelter = Shelter::findOrFail($id);
        $shelter->delete();

        return redirect()->route('user.index' , ['locale' => $locale]);
    }

    public function edit(Request $request, $id , $locale = null)
    {
        $shelter = Shelter::findOrFail($id);
        $user = Auth::user();
        $shelter->city = $request->city;
        $shelter->area = $request->area;
        $shelter->floor_no = $request->floor_no;
        $shelter->nb_of_rooms = $request->nb_of_rooms;
        $shelter->capacity = $request->capacity;
        $shelter->rent_or_no = $request->rent_or_no;
        $shelter->furnished = $request->furnished;
        $shelter->elevator = $request->elevator;
        $shelter->accessibility = $request->accessibility;
        $shelter->price = $request->price;
        $shelter->currency = $request->currency;
        $shelter->phone_number = $request->phone_number;
        $shelter->user_id = $user->id;

        $shelter->save();

        // Redirect to user.index after successful update rather than user.login.
        return redirect()->route('user.index' ,  ['locale' => $locale]);
    }
}
