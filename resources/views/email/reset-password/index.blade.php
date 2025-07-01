@extends('email.layout-email.app', [
    'title' => $title,
])
@section('content')
  <tr>
    <td class="sm-px-24" style="mso-line-height-rule: exactly; border-radius: 4px; background-color: #ffffff; padding: 48px; text-align: left; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 16px; line-height: 24px; color: #626262;">
      <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 20px; font-weight: 600;">Hi, {{ $user->name }}!</p>
      <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-top: 24px; margin-bottom: 24px;">
        You are receiving this email because we received a password reset request for your account.
      </p>
      <table cellpadding="0" cellspacing="0" role="presentation">
        <tr>
          <td style="mso-line-height-rule: exactly; mso-padding-alt: 16px 24px; border-radius: 4px; background-color: #14B4CA; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;">
            <a href="{{ $url }}" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; display: block; padding-left: 24px; padding-right: 24px; padding-top: 16px; padding-bottom: 16px; font-size: 16px; font-weight: 600; line-height: 100%; color: #ffffff; text-decoration: none;">Reset Password &rarr;</a>
          </td>
        </tr>
      </table>
      <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-top: 24px; margin-bottom: 24px;">
        <span style="font-weight: 600;">Note:</span> This link is valid for 1 hour from the time it was
        sent to you and can be used to change your password only once.
      </p>
      <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-top: 24px; margin-bottom: 12px;">If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: </p>
      <a href="{{ $url }}" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 24px; display: block; font-size: 16px; line-height: 100%; color: #14B4CA; text-decoration: none;">{{ $url }}</a>
      <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0;">
        If you did not request a password reset, no further action is required.
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
