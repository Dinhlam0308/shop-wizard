<x-mail::message>
# ❌ Hủy Đăng Ký Workshop

Xin chào **{{ $registration->name }}**,  
Chúng tôi rất tiếc phải thông báo rằng đăng ký của bạn cho **{{ $registration->workshop->title }}** đã bị **hủy**.

Nếu đây là sự nhầm lẫn hoặc bạn muốn đăng ký lại, vui lòng liên hệ với chúng tôi để được hỗ trợ.

<x-mail::button :url="url('/')">
Truy Cập Always Café
</x-mail::button>

Cảm ơn bạn đã thông cảm và đồng hành cùng chúng tôi,  
**Đội Ngũ Workshop Always Café**
</x-mail::message>
