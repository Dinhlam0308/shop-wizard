<x-mail::message>
# ✅ Your Workshop Registration Is Confirmed

Hi **{{ $registration->name }}**,  
Thanks for signing up — your seat for **{{ $registration->workshop->title }}** is now **confirmed**.

---

### 🗓 Workshop Details
- **Date:** {{ \Carbon\Carbon::parse($registration->workshop->date)->format('d/m/Y') }}
- **Time:** {{ $registration->workshop->time ?? 'To be updated' }}
- **Location:** {{ $registration->workshop->location ?? 'To be updated' }}

---

### 👤 Your Registration Info
- **Workshop ID:** {{ $registration->workshop_id }}
- **Name:** {{ $registration->name }}
- **Email:** {{ $registration->email }}
- **Phone:** {{ $registration->phone }}
- **Note:** {{ $registration->note ?? '—' }}

<x-mail::button :url="url('/workshops/' . $registration->workshop_id)">
View Workshop Details
</x-mail::button>

If you need to update your information, simply reply to this email and we’ll help you.

— **Always Café Workshop Team** ☕✨
</x-mail::message>
