<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.login_register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'max:10', 'min:9'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'] // Added validation for image
        ]);

        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            try {
                // Generate a unique name for the image
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                // Move the image to the public/profile_pictures directory
                $request->file('image')->move(public_path('profile_pictures'), $imageName);
                // Set the image path
                $imagePath = 'profile_pictures/' . $imageName;
            } catch (\Exception $e) {
                // Log the error for debugging
                \Log::error('Image Upload Error: ' . $e->getMessage());
                return back()->withErrors(['image' => 'Failed to upload image. Please try again.']);
            }
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'role_id' => Role::where('name', 'trainee')->first()->id,
                'image' => $imagePath, // Save image path to the database
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('User Registration Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to register user. Please try again.']);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('posts');
    }
}
