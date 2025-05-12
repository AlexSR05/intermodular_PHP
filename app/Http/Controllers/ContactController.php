<?php
declare(strict_types=1);

namespace App\Controllers;
use App\Core\DB;
use App\Models\Contact;

class ContactController
{

    public function store(): void
    {
        $contact = new Contact($_POST);
        $contact->insert();
        header('Location: /instrumentales');
        exit;
    }

    public function index(): void
    {
        view('contact.contact_index');
    }
}
