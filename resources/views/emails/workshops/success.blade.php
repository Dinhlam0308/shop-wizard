<x-mail::message>
# 🎉 Đăng Ký Workshop Thành Công!

Xin chào **{{ $registration->name }}**,  
Cảm ơn bạn đã đăng ký tham gia **{{ $registration->workshop->title }}**.

---

### 🗓 Thông Tin Workshop
- **Ngày:** {{ \Carbon\Carbon::parse($registration->workshop->date)->format('d/m/Y') }}
- **Thời gian:** {{ $registration->workshop->time ?? 'Sẽ được thông báo sau' }}
- **Địa điểm:** {{ $registration->workshop->location ?? 'Sẽ được thông báo sau' }}

@if($registration->note)
> **Ghi chú của bạn:** {{ $registration->note }}
@endif

---

<x-mail::button :url="url('/')">
Truy Cập Website Always Café
</x-mail::button>

Chúng tôi sẽ liên hệ lại với bạn khi việc đăng ký được xác nhận.  
Cảm ơn bạn và hẹn gặp lại tại **Always Café**! ☕✨

Trân trọng,  
**Đội Ngũ Workshop Always Café**
</x-mail::message>
