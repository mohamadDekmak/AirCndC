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
        'user_id'
        ];


    public function store(Request $request , $locale = null)
    {
        $request->validate([
            'city' => 'required|string|max:255',
            'area' => 'required|string',
            'floor_no' => 'required',
            'nb_of_rooms' => 'required',
            'capacity' => 'required|string',
            'rent' => 'nullable|boolean',
            'furnished' => 'nullable|boolean',
            'elevator' => 'nullable|boolean',
            'price' => 'nullable',
        ]);
        $user = Auth::user();
        Shelter::create([
            'city' => $request->city,
            'area' => $request->area,
            'floor_no' => $request->floor_no,
            'nb_of_rooms' => $request->nb_of_rooms,
            'capacity' => $request->capacity,
            'rent' => $request->rent,
            'furnished' => $request->furnished,
            'elevator' => $request->elevator,
            'price' => $request->price,
            'user_id' => $user->id,
        ]);

        return redirect()->route('user.index' , ['locale' => $locale])->with('success', 'Shelter added successfully.');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
