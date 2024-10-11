<?php

namespace App\Listeners;

use App\Events\UserSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUserAddresses
{
    public function handle(UserSaved $event)
    {
        $user = $event->user;

        // Example: Saving default address data
        $user->addresses()->create([
            'address_line1' => '123 Main St',
            'city' => 'City Name',
            'state' => 'State Name',
            'postal_code' => '12345',
            'country' => 'Country Name'
        ]);
    }
}

