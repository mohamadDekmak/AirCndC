<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    public function shelters()
    {
        return $this->hasMany(Shelter::class);
    }
    public static function login(Request $request , $locale = null)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ], [
            'name.required' =>  __('The username field is required.'),
            'password.required' => __('The password field is required.'),
        ]);

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            return redirect()->route('user.index' , ['locale' => $locale ?: app()->getLocale()]);
        }
        throw ValidationException::withMessages([
            'name' => [__('The provided credentials are incorrect.')],
        ]);
    }
    public static function store(Request $request , $locale = null)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|unique:users,name',
            'password' => 'required|min:8',
            'phone' => 'required|regex:/^[0-9]{8,}$/',
            'self_image' => 'required|image',
            'driving_license' => 'required|image',
        ], [
            // Custom error messages can be specified here as needed
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters long.',
            'phone.required' => 'The phone number field is required.',
            'phone.regex' => 'The phone number must be a valid 8-digit number.',
            'self_image.required' => 'An image is required.',
            'driving_license.required' => 'An image is required.',
            'self_image.image' => 'The file must be an image.',
            'driving_license.image' => 'The file must be an image.',
        ]);

        $imageName1 = time() . '.' . $request->self_image->extension();
        $request->self_image->move(public_path('images'), $imageName1);
        $imageName2 = time() . '.' . $request->driving_license->extension();
        $request->driving_license->move(public_path('images'), $imageName2);

        $user = new User();
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->self_image = 'images/' . $imageName1;
        $user->driving_license = 'images/' . $imageName2;
        $user->save();
        $login = true;
        return redirect()->route('home' , ['locale' => $locale ?: app()->getLocale() , 'login' => $login]);
    }

}
