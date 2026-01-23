<x-mail::message>
# Registration Canceled

Hi **{{ $registration->name }}**,  
We’re sorry to inform you that your registration for **{{ $registration->workshop->title }}** has been **canceled**.

---

### 🗓 Workshop Details
- **Date:** {{ \Carbon\Carbon::parse($registration->workshop->date)->format('d/m/Y') }}
- **Time:** {{ $registration->workshop->time ?? 'To be updated' }}
- **Location:** {{ $registration->workshop->location ?? 'To be updated' }}

---

If you believe this was a mistake or you’d like to register again, simply reply to this email and our team will assist you.

<x-mail::button :url="url('/workshops/' . $registration->workshop_id)">
View Workshop Info
</x-mail::button>

Thank you for your understanding,  
— **Always Café Workshop Team**
</x-mail::message>
