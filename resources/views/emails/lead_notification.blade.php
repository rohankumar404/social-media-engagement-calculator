<x-mail::message>
# New Lead Captured

A new potential customer has interacted with the Social Media Engagement Calculator.

**Lead Details:**
- **Email:** {{ $leadData['email'] }}
- **Source:** {{ $leadData['source'] ?? 'PDF Download Popup' }}
- **Intent Level:** {{ $leadData['intent_level'] ?? 'High' }}

You can view more details in the admin panel.

<x-mail::button :url="config('app.url') . '/admin/leads'">
View All Leads
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
