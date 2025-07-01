@extends('email.layout-email.app', [
    'title' => $property->name,
])
@section('content')
  <tr>
    <td class="sm-px-24" style="mso-line-height-rule: exactly; border-radius: 4px; background-color: #ffffff; padding: 48px; text-align: left; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 16px; line-height: 24px; color: #626262;">
      <p class="sm-leading-32" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-bottom: 24px; font-size: 24px; font-weight: 600; color: #263238;">
        MONTHLY REPORT {{ $property->name }} | {{ \Carbon\Carbon::createFromFormat('Y-m-d', $report->report_date)->translatedFormat('F Y') }}
      </p>
      {{-- <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 24px; font-weight: 700; color: #ff5850;">John Doe!</p> --}}
      <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-top: 24px; margin-bottom: 24px;">
        {!! $report->introduction_text !!}
      </p>
      <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
          <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; padding-top: 32px; padding-bottom: 32px;">
            <div style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; height: 1px; background-color: #eceff1; line-height: 1px;">&zwnj;</div>
          </td>
        </tr>
      </table>
      <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-bottom: 16px;">Best regards, <br>Bali Lyfe Ventures</p>
    </td>
  </tr>
@endsection
