<x-mail::message>
# Strategy Call Lead Request

A new strategy call request has been submitted through the Mapsily Social Media Engagement Calculator!

**Lead Details:**
- **Name:** {{ $data['name'] ?? 'N/A' }}
- **Email:** {{ $data['email'] ?? 'N/A' }}
- **Phone:** {{ $data['phone'] ?? 'N/A' }}
- **Company:** {{ $data['company'] ?? 'N/A' }}

**Message:**
<x-mail::panel>
{{ $data['message'] ?? 'No message provided.' }}
</x-mail::panel>

You can reply directly to this email to contact the lead.

Best,<br>
Mapsily System
</x-mail::message>
