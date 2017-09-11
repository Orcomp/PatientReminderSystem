<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactsController extends Controller
{
    public function contactsByPatient($patient_id)
    {
        if (is_null(request('q'))) {
            $contacts = Contact::where('patient_id', $patient_id)
                ->get(['id', 'first_name', 'last_name']);
        } else {
            $contacts = Contact::where('patient_id', $patient_id)
                ->where('first_name', 'LIKE', '%' . request('q') . '%')
                ->orWhere('last_name', 'LIKE', '%' . request('q') . '%')
                ->get(['id', 'first_name', 'last_name']);
        }

        return response()->json($contacts, 200);
    }
}
