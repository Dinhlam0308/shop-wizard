<x-mail::message>
# 🎉 Workshop Registration Received

Hi **{{ $registration->name }}**,  
Thank you for registering for **{{ $registration->workshop->title }}**.  
Your registration has been successfully submitted and is now **pending confirmation**.

---

### 🗓 Workshop Details
- **Date:** {{ \Carbon\Carbon::parse($registration->workshop->date)->format('d/m/Y') }}
- **Time:** {{ $registration->workshop->time ?? 'To be updated' }}
- **Location:** {{ $registration->workshop->location ?? 'To be updated' }}

@if($registration->note)
> **Your Note:** {{ $registration->note }}
@endif

---

<x-mail::button :url="url('/workshops/' . $registration->workshop_id)">
View Workshop Information
</x-mail::button>

We’ll contact you as soon as your registration is confirmed.  
Thanks again — and we look forward to seeing you at **Always Café** ☕✨

Best regards,  
— **Always Café Workshop Team**
</x-mail::message>
