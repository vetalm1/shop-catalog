<?php

namespace App\Services\Contact;

use App\Models\Contact;

class ContactService
{
    public function getContact($place, $type): Contact
    {
        return Contact::place($place)->type( $type)->isActive()->firstOrNew();
    }
}
