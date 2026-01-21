<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $bookings = \App\Models\Booking::when($search, function ($query, $search) {
                return $query->where('id', $search);
            })->paginate(10);
            return view("admin.booking.index", compact("bookings"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load bookings: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            return view("admin.booking.create");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load booking form: ' . $e->getMessage()]);
        }
    }

    public function booking()
    {
        try {
            return view("user.booking.booking");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load booking form: ' . $e->getMessage()]);
        }
    }

    public function createTarot()
    {
        try {
            return view("user.booking.tarot");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load tarot booking form: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'type' => ['required', Rule::in(['table', 'position_class', 'tarot', "event_table"])],
                'booking_date' => 'required|date',
                'booking_time' => 'required',
                'people_count' => 'required|integer|min:1',
                'note' => 'nullable|string'
            ]);

            if (\Carbon\Carbon::createFromFormat('d-m-Y', $validated['booking_date'])) {
                $validated['booking_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validated['booking_date'])->format('Y-m-d');
            }

            if (\Carbon\Carbon::createFromFormat('H:i', $validated['booking_time'])) {
                $validated['booking_time'] = \Carbon\Carbon::createFromFormat('H:i', $validated['booking_time'])->format('H:i:s');
            }

            \App\Models\Booking::create($validated);

            $validated['email'] = $request->user()->email;
            $validated['name']  = $request->user()->name;

            \Mail::to($request->user()->email)->send(new \App\Mail\BookingFormSubmitted($validated));
            DB::commit();

            return redirect()->back()
                ->with('success', 'Đặt lịch thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create booking: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $booking = \App\Models\Booking::query()
                ->join('users', 'users.id', '=', 'bookings.user_id')
                ->select('bookings.*', 'users.email')
                ->where('bookings.id', $id)
                ->firstOrFail();
            return view("admin.booking.show", compact("booking"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load booking details: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $match = \App\Models\Booking::findOrFail($id);
            return view("admin.booking.edit", compact("match"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load booking for editing: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $booking = \App\Models\Booking::findOrFail($id);

            $validated = $request->validate([
                'type' => ['required', Rule::in(['table', 'potion_class', 'tarot', "event_table"])],
                'booking_date' => 'required|date',
                'booking_time' => 'required',
                'people_count' => 'required|integer|min:1',
                'note' => 'nullable|string',
                'status' => ['required', Rule::in(['pending', 'confirmed', 'cancelled'])],
            ]);

            $booking->update($validated);

            if ($request->has('status') && $request->input('status') === 'confirmed') {
                \Mail::to($booking->user->email)->send(new \App\Mail\BookingConfirmed($booking));
            }

            if ($request->has('status') && $request->input('status') === 'cancelled') {
                \Mail::to($booking->user->email)->send(new \App\Mail\BookingCancelled($booking));
            }

            return redirect()->route('admin.booking.index')
                ->with('success', 'Booking updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update booking: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $booking = \App\Models\Booking::findOrFail($id);
            $booking->delete();

            return redirect()->route('admin.booking.index')
                ->with('success', 'Booking deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete booking: ' . $e->getMessage()]);
        }
    }
}
