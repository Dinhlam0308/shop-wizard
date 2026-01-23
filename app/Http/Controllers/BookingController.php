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
            })->orderByDesc('created_at')->paginate(10);
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

            $user = $request->user();

            $validated = $request->validate([
                'user_id' => 'nullable|exists:users,id',

                'name'  => 'required|string|max:100',
                'phone' => 'required|string|max:20',

                // guest mới bắt buộc email
                'email' => $user ? 'nullable|email|max:255' : 'required|email|max:255',

                'type' => ['required', Rule::in(['table', 'potion_class', 'tarot', 'event_table'])],
                'booking_date' => 'required',
                'booking_time' => 'required',
                'people_count' => 'required|integer|min:1',
                'note' => 'nullable|string',
            ]);

            // user_id: ưu tiên auth, không tin hidden input từ client
            $validated['user_id'] = $user?->id;

            // email: auth thì lấy từ user, guest lấy từ form
            $validated['email'] = $user?->email ?? $validated['email'];

            // parse date/time (flatpickr của bạn đang d-m-Y và H:i)
            try {
                $validated['booking_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validated['booking_date'])
                    ->format('Y-m-d');
            } catch (\Exception $e) {
                // fallback nếu request gửi chuẩn Y-m-d
                $validated['booking_date'] = \Carbon\Carbon::parse($validated['booking_date'])->format('Y-m-d');
            }

            try {
                $validated['booking_time'] = \Carbon\Carbon::createFromFormat('H:i', $validated['booking_time'])
                    ->format('H:i:s');
            } catch (\Exception $e) {
                $validated['booking_time'] = \Carbon\Carbon::parse($validated['booking_time'])->format('H:i:s');
            }

            $booking = \App\Models\Booking::create($validated);

            DB::commit();

            dispatch(function () use ($validated, $booking) {
                \Mail::to($validated['email'])
                    ->cc(config('mail.from.address'))
                    ->send(new \App\Mail\BookingFormSubmitted([
                        ...$validated,
                        'booking_id' => $booking->id,
                    ]));
            })->afterResponse();
            return redirect()->back()->with('success', 'Đặt lịch thành công.');
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
                'name' => 'required|string|max:100',
                'phone' => 'required|string|max:20',

                'type' => ['required', Rule::in(['table', 'position_class', 'tarot', 'event_table'])],
                'booking_date' => 'required|date',
                'booking_time' => 'required',
                'people_count' => 'required|integer|min:1',
                'note' => 'nullable|string',
                'status' => ['required', Rule::in(['pending', 'confirmed', 'cancelled'])],
            ]);

            $booking->update($validated);

            dispatch(function () use ($request, $booking) {
                if ($request->input('status') === 'confirmed') {
                    \Mail::to($booking->user->email)->cc(config('mail.from.address'))
                        ->send(new \App\Mail\BookingConfirmed($booking));
                }

                if ($request->input('status') === 'cancelled') {
                    \Mail::to($booking->user->email)->cc(config('mail.from.address'))
                        ->send(new \App\Mail\BookingCancelled($booking));
                }
            })->afterResponse();

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
