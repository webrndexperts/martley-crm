<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>New assessment has been assigned</title>
    </head>
    <body>
        <div id="" dir="ltr" style="background-color:#f9f9f9;margin:0;padding:70px 0;width:100%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif">
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tbody>
                    <tr>
                        <td align="center" valign="top">
                            <div id=""></div>
                            <table border="0" cellpadding="0" cellspacing="0" width="900" id="container" style="background-color:#fff;border:1px solid #e0e0e0;border-radius:3px">
                                <tbody>
                                    <tr>
                                        <td align="center" valign="top">
                                            <p style="margin-top: 50px;margin-bottom: 0;">
                                                <img src="{{ url('public/new/img/logo.png') }}" alt="" style="border: 1px solid #bc9c23;">
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 30px 30px 0;">
                                            <b>Dear  {{ $data['patient']->first_name }} {{ $data['patient']->last_name }},</b>
                                            <p>I hope this message finds you well.</p>

                                            <p>Your clinician, {{ Auth::user()->name }}, has assigned a new assessment <a style="color: #bc9c23;" href="{{ route('assessment-list') }}" target="_blank"><b>{{ $data['assessment']->title }}</b></a> for you to complete. This assessment is an important part of your ongoing care and will help us better understand and manage your health and its due date is till <b>{{ $data['assessment']->due_date }}</b>.</p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="text-align: left; padding: 30px 30px 40px;">
                                           <p style="text-align: left;line-height: 24px;">Please complete the assessment by the due date. If you have any questions or need assistance with the form, please do not hesitate to contact us at <a style="color: #bc9c23; text-decoration: none;" href="mailto:hello@becomingmethod.com">hello@becomingmethod.com</a>. <a href="{{ url('/') }}" style="color: #bc9c23; text-decoration: none;">Visit our site</a></p>

                                           <p>Your cooperation is greatly appreciated.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>