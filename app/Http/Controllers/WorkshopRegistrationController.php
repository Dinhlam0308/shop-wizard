<?php

namespace App\Http\Controllers;

use App\Mail\WorkshopCancelledMail;
use App\Mail\WorkshopConfirmedMail;
use App\Mail\WorkshopRegistrationSuccess;
use DB;
use Illuminate\Http\Request;
use Mail;
use Validator;

class WorkshopRegistrationController extends Controller
{

    public function index()
    {
        try {
            $workshopRegistrations = DB::table('workshop_registrations')->orderByDesc('created_at')->paginate(10);
            return view("user.workshop_registrations.index", compact("workshopRegistrations"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load workshop registrations: ' . $e->getMessage()]);
        }
    }

    public function adminIndex(Request $request)
    {
        try {
            $search = $request->input('search');
            $workshopRegistrations = DB::table('workshop_registrations')->when($search, function ($query, $search) {
                return $query->where('id', $search);
            })->paginate(10);
            return view("admin.workshop_registrations.index", compact("workshopRegistrations"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load workshop registrations: ' . $e->getMessage()]);
        }
    }

    public function createAdmin()
    {
        try {
            return view("admin.workshop_registrations.create");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load create workshop registration form: ' . $e->getMessage()]);
        }
    }

    public function create(string $id)
    {
        try {
            $match = \App\Models\Workshop::findOrFail($id);
            if (!$match) {
                return redirect()->back()->withErrors(['error' => 'Workshop not found.']);
            }
            return view("user.workshop_registrations.create", compact('match'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load create workshop registration form: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'workshop_id' => 'required|exists:workshops,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'note' => 'nullable|string',
            ]);
            $validated = $validator->validate();
            $existingRegistration = \App\Models\WorkshopRegistration::where('workshop_id', $validated['workshop_id'])
                ->where(function ($query) use ($validated) {
                    $query->where('email', $validated['email']);
                    if (!empty($validated['phone'])) {
                        $query->orWhere('phone', $validated['phone']);
                    }
                })->first();
            if ($existingRegistration) {
                DB::rollBack();
                return redirect()->back()
                    ->withErrors(['error' => 'You have already registered for this workshop with the same email or phone number.'])->withInput();
            }
            $registration = \App\Models\WorkshopRegistration::create($validated);
            DB::commit();
            dispatch(function () use ($registration) {
                Mail::to($registration->email)->cc(config('mail.from.address'))->send(new WorkshopRegistrationSuccess($registration));
            })->afterResponse();
            return redirect()->back()->with('success', 'Workshop registration created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create workshop registration: ' . $e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $workshopRegistration = \App\Models\WorkshopRegistration::findOrFail($id);
            if (!$workshopRegistration) {
                return redirect()->route('admin.workshop_registrations.index')->withErrors(['error' => 'Workshop registration not found.']);
            }
            return view('admin.workshop_registrations.show', compact('workshopRegistration'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load workshop registration: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $workshopRegistration = \App\Models\WorkshopRegistration::findOrFail($id);
            if (!$workshopRegistration) {
                return redirect()->route('admin.workshop_registrations.index')->withErrors(['error' => 'Workshop registration not found.']);
            }
            return view('admin.workshop_registrations.edit', compact('workshopRegistration'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load workshop registration edit form: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $registration = \App\Models\WorkshopRegistration::findOrFail($id);
            if (!$registration) {
                return redirect()->route('admin.workshop_registrations.index')->withErrors(['error' => 'Workshop registration not found.']);
            }
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:pending,confirmed,cancelled',
            ]);
            $validated = $validator->validate();
            $registration->update($validated);
            DB::commit();
            dispatch(function () use ($validated, $registration) {
                if ($validated['status'] === 'confirmed') {
                    Mail::to($registration->email)->send(new WorkshopConfirmedMail($registration));
                }

                if ($validated['status'] === 'cancelled') {
                    Mail::to($registration->email)->send(new WorkshopCancelledMail($registration));
                }
            })->afterResponse();
            return redirect()->route('admin.workshop_registrations.index')->with('success', 'Workshop registration updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load workshop registration: ' . $e->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $registration = \App\Models\WorkshopRegistration::findOrFail($id);
            if (!$registration) {
                return redirect()->route('admin.workshop_registrations.index')->withErrors(['error' => 'Workshop registration not found.']);
            }
            $registration->delete();
            DB::commit();
            return redirect()->route('admin.workshop_registrations.index')->with('success', 'Workshop registration deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete workshop registration: ' . $e->getMessage()]);
        }
    }
}
