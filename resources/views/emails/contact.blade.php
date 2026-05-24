@component('mail::message')
# New Contact Form Submission

You have a new message from your website contact form:

- **Name:** {{ $data['name'] }}
- **Email:** {{ $data['email'] }}
- **Phone:** {{ $data['phone'] }}

---

**Message:**

{{ $data['message'] }}

@endcomponent
