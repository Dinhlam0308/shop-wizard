<x-mail::message>
# 🎉 Đăng Ký Workshop Của Bạn Đã Được Xác Nhận!

Xin chào **{{ $registration->name }}**,  
Chỗ tham gia của bạn cho **{{ $registration->workshop->title }}** đã được **xác nhận thành công**.

### 📍 Thông Tin Workshop
- **Ngày:** {{ \Carbon\Carbon::parse($registration->workshop->date)->format('d/m/Y') }}
- **Thời gian:** {{ $registration->workshop->time ?? 'Sẽ được cập nhật sau' }}
- **Địa điểm:** {{ $registration->workshop->location ?? 'Sẽ được cập nhật sau' }}

<x-mail::button :url="url('/')">
Xem Chi Tiết Workshop
</x-mail::button>

Chúng tôi rất mong được chào đón bạn tại buổi workshop sắp tới! ☕✨  
**Đội Ngũ Workshop Always Café**
</x-mail::message>
