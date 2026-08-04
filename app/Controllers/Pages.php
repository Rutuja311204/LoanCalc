<?php

namespace App\Controllers;

use App\Models\ContactMessageModel;

class Pages extends BaseController
{
    public function about()
    {
        return view('pages/about', ['title' => 'About Us - LoanCalc']);
    }

    public function contact()
    {
        return view('pages/contact', ['title' => 'Contact Us - LoanCalc']);
    }

    public function submitContact()
    {
        $rules = [
            'name'    => 'required|min_length[3]|max_length[150]',
            'email'   => 'required|valid_email',
            'phone'   => 'permit_empty|max_length[20]',
            'subject' => 'permit_empty|max_length[200]',
            'message' => 'required|min_length[10]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new ContactMessageModel())->insert([
            'name'       => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'subject'    => $this->request->getPost('subject'),
            'message'    => $this->request->getPost('message'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        send_acknowledgement_email(
            $this->request->getPost('email'),
            'We received your message - LoanCalc',
            "Thank you for contacting LoanCalc. We have received your message and will respond within 24 hours.",
            'contact_message'
        );

        return redirect()->to('/contact')->with('success', 'Thank you! Your message has been sent. We will get back to you soon.');
    }
}
