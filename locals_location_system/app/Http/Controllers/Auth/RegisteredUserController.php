<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\QrCodeMail;
use App\Models\User;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use karmabunny\BaconBackends\GdImageBackEnd;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'qr_code' => Str::random(32),
        ]);
    $renderer = new ImageRenderer(
        new RendererStyle(300),
        new GdImageBackEnd()
    );

        $writer = new Writer($renderer);
        $pngString = $writer->writeString($user->qr_code);
        Storage::disk('public')->put("qrcodes/{$user->email}.qrcode.png", $pngString);
        $pngBase64 = base64_encode($pngString);
        event(new Registered($user));


        // send the qr code image to user email
        Mail::to($user->email)->send(new QrCodeMail($user->email, $pngBase64));
        Auth::login($user);

        return to_route('dashboard');
    }
}
