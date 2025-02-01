@component('mail::message')
# Package Confirmation Invoice

Thank you for booking with us!

**Package Name    :**  {{ $data['package_name'] }}  
**Price Per Person:** ${{ number_format($data['price_per_person'], 2) }}  
**Number of Guests:**  {{ $data['guests'] }}  
**Total Amount    :** ${{ number_format($data['total_amount'], 2) }}  


We look forward to serving you soon!

Thanks,  
{{ config('app.name') }}
@endcomponent