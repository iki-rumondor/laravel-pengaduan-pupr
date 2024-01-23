<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareAppController extends Controller
{

    public function share($provider)
    {
        $provider = strtolower($provider);
        $app_link = route('welcome');
        $external_link = '';
        if ($provider == 'facebook') 
            $external_link = 'https://www.facebook.com/sharer/sharer.php?u=' . $app_link;
        else if ($provider == 'whatsapp')
            $external_link = 'whatsapp://send?text=' . $app_link;
        else if ($provider == 'twitter')
            $external_link = 'https://twitter.com/intent/tweet?url=' . $app_link;
        else
            abort(404);
        return redirect()->away($external_link);
    }
    
}