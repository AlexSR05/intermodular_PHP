<?php
declare(strict_types=1);

namespace App\Controllers;
use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Models\Contact;

class ContactController
{

    public function store(Request $request): void
    {
        $contact = new Contact();
        $contact->email = $request->email;
        $contact->nombre = $request->nombre;
        $contact->mensaje = $request->mensaje;
        $contact->save();
        redirect('/instrumentales/index.php')->with('success', 'Su consulta ha quedado registrada')->send();
    }

    public function index(): void
    {
        view('contact.contact_index');
    }
}
