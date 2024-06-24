<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>New Form Assigned</title>
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
                                                <img src="{{ url('/public/new/img/logo.png') }}" alt="ScolioLife™" style="border: 1px solid #bc9c23;">
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 30px 30px 0;">
                                            <b>Dear {{ $data['patient']->first_name }} {{ $data['patient']->last_name }},</b>
                                            <p>I hope this message finds you well.</p>
                                            <p>As part of <b>{{ config('app.name') }}</b>, we kindly ask you to complete the attached <b>{{ $data['form']->name }}</b> form. Your prompt attention to this matter will help us ensure we have the most accurate and up-to-date information to provide you with the best possible care.</p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="text-align: left; padding: 30px 30px 40px;">
                                           <p style="text-align: left;line-height: 24px;">If you have any questions or need assistance with the form, please do not hesitate to contact us at <a style="color: #bc9c23; text-decoration: none;" href="mailto:hello@becomingmethod.com">hello@becomingmethod.com</a>. <a href="{{ url('/') }}" style="color: #bc9c23; text-decoration: none;">Visit our site</a></p>
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