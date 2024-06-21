<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to {{ config('app.name') }}</title>
    </head>
    <body>
        <div id="" dir="ltr" style="background-color:#f9f9f9;margin:0;padding:70px 0;width:100%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif">
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tbody>
                    <tr>
                        <td align="center" valign="top">
                            <div id=""></div>
                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="container"
                            style="background-color:#fff;border:1px solid #e0e0e0;border-radius:3px">
                                <tbody>
                                    <tr>
                                        <td align="center" valign="top">
                                            <p style="margin-top: 50px;margin-bottom: 0;">
                                                <img src="{{ url('public/new/img/logo.png') }}" alt="logo" style="border: 1px solid #bc9c23;" />
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="
                                            text-align: center;
                                            padding: 30px 30px 0;
                                        ">
                                            <h3>Hello {{ ucfirst($data['first_name']) }} {{ ucfirst($data['last_name']) }},</h3>
                                            <p>We are pleased to inform you that your account has been successfully created on <b>{{ config('app.name') }}</b>. Below are your account details:</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="">
                                                <tbody>
                                                    <tr>
                                                        <td valign="top" id="" style="background-color:#fff">
                                                            <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top" style="padding:30px 30px 0px">
                                                                            <div id="" style="color:#636363;font-size:14px;line-height:150%">
                                                                                <div>
                                                                                    <table cellspacing="0" cellpadding="6"
                                                                                    border="1"
                                                                                    style="color:#636363;border:1px solid #e5e5e5;width:100%; width:100%;font-size: 14px">
                                                                                        <tfoot style="color:#636363;text-align: left !important;font-size: 14px">
                                                                                            <tr>
                                                                                                <th scope="row" colspan="2"
                                                                                                    style="border:1px solid #e5e5e5;padding:12px"
                                                                                                >
                                                                                                    Email:
                                                                                                </th>
                                                                                                <td
                                                                                                style="border:1px solid #e5e5e5;padding:12px">
                                                                                                    <span><a href="mailto:webmaster@example.com" style="
                                                                                                        color: #bc9c23;
                                                                                                        text-decoration: none;
                                                                                                    ">{{ $data['email'] }}</a></span>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <th scope="row" colspan="2" style="border:1px solid #e5e5e5;padding:12px">
                                                                                                    Password:
                                                                                                </th>
                                                                                                <td style="border:1px solid #e5e5e5;padding:12px">
                                                                                                    {{ $data['password'] }}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tfoot>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="
                                            text-align: center;
                                            padding: 30px 30px 40px;
                                        ">
                                            <p style="text-align: left; color: #bc9c23; font-size: 12px;">
                                                <i>**Steps to Change Your Password:**</i>
                                            </p>

                                            <ul style="list-style: auto; margin-top: 0;">
                                                <li style="text-align: left;">Log in to your account using the temporary password.</li>
                                                <li style="text-align: left;">Go to the profile section from top right.</li>
                                                <li style="text-align: left;">There you can change your password and other things.</li>
                                            </ul>

                                            <p style="text-align: left;">If you encounter any issues or have any questions, please do not hesitate to contact us at <a style="color: #bc9c23; text-decoration: none;" href="mailto:hello@becomingmethod.com">hello@becomingmethod.com</a>.
                                            </p>
                                            <p style="text-align: left;">We are excited to have you on board and look forward to serving you. <a href="{{ $url }}" style="color: #bc9c23; text-decoration: none;">Visit our site</a></p>
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