<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Barryvdh\Debugbar\Facades\Debugbar;

class SiteController extends Controller
{
    public function home(): View 
    {
        Log::info('Loading welcome page');
        Debugbar::info('Loading welcome page!!!');
        return view('welcome');
    }

    public function contact(): View 
    {
        return view('contact');
    }

    public function sendMail(Request $request): RedirectResponse 
    {
        // Validació de les dades del formulari
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:15',
            'body'    => 'required|string|min:5',
        ]);

        // Enviament del correu
        Mail::send('emails.contact', $validatedData, function ($message) use ($validatedData) {
            $message->to(config('mail.from.address'))
                    ->subject(__('New contact message'))
                    ->replyTo($validatedData['email']);
        });

        return redirect()->route('contact.form')
                         ->with('success', __('Message sent!'));
    }

    public function language($locale)
    {
        $default = config('app.locale', 'en');
        $locales = config('app.available_locales', ['en' => 'English']);
        
        if (!array_key_exists($locale, $locales)) {
            Log::error("Locale '{$locale}' not exists");
            abort(400);
        }
        
        // Session storage
        $current = Session::get('locale', $default);
        Log::debug("Change locale '{$current}' to '{$locale}'");
        Session::put('locale', $locale);
        // Set locale
        App::setLocale($locale);
        // Go to previous page
        return redirect()->back();
    }
}
