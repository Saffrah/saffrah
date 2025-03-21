@component('mail::message')
# Package Confirmation Pill

Thank you for booking with us!

@component('mail::table')
| Description              | Details                                                                         |
|--------------------------|---------------------------------------------------------------------------------|
| **Package**              | {{ $data['package_name'] }}                                                     |
| **Number of Guests**     | {{ $data['guests'] }}                                                           |
| **Trip Starting Date**   | {{ $data['start_date'] }}                                                       |
| **Package Fees**         | ${{ number_format($data['total_amount'], 2) }}                                  |
| **Next Trip Percentage** | 15 %                                                                             |
| **Total Amount**         | ${{ number_format(($data['total_amount'] * 0.15) + $data['total_amount'], 2) }} |
@endcomponent

We look forward to See you again !

Thanks,  
{{ config('app.name') }}
@endcomponent