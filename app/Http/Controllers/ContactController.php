<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use DB;
use Illuminate\Http\Request;
use Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $contacts = DB::table('contacts')->when($search, function ($query, $search) {
                return $query->where('id', $search);
            })->paginate(10);
            return view("admin.contact.index", compact("contacts"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load contacts: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            return view("admin.contact.create");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load contact form: ' . $e->getMessage()]);
        }
    }

    public function contact()
    {
        try {
            return view("user.contact");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load contact form: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
                'phone' => 'nullable|string|max:20',
            ]);
            $validated = $validator->validate();

            Contact::create($validated);
            dispatch(function () use ($validated) {
                \Mail::to($validated['email'])->cc(config('mail.from.address'))->send(new \App\Mail\ContactFormSubmitted($validated));
            })->afterResponse();

            return redirect()->back()->with('success', 'Your message has been sent successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to send message: ' . $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            return view("admin.contact.show", compact("contact"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load contact details: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            return view("admin.contact.edit", compact("contact"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load contact for editing: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $contact = Contact::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string',
                'phone' => 'nullable|string|max:20',
            ]);
            $validated = $validator->validate();

            $contact->update($validated);

            return redirect()->route('admin.contact.index')
                ->with('success', 'Contact updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update contact: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();

            return redirect()->route('admin.contact.index')
                ->with('success', 'Contact deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete contact: ' . $e->getMessage()]);
        }
    }
}
