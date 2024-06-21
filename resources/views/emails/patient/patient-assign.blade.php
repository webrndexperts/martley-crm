<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Clinician assigned to patient</title>
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
                                            <h2>Dear {{ $data['patient']->first_name }} {{ $data['patient']->last_name }},</h2>
                                            <p>I hope this message finds you well.</p>
                                            <p>We would like to inform you that a new clinician has been assigned to oversee your <b>{{ config('app.name') }}</b>. Below are the details of your new clinician:</p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left" valign="top">
                                            <table border="0" cellpadding="0" cellspacing="0" width="700" id="">
                                                <tbody>
                                                    <tr>
                                                        <td valign="top" id="" style="background-color:#fff">
                                                            <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top" style="padding:30px 30px 0px">
                                                                            <div id="" style="color:#636363;font-size:14px;line-height:150%">
                                                                                <div>
                                                                                    <table cellspacing="0" cellpadding="6" border="1" style="color:#636363;border:1px solid #e5e5e5;width:100%; width:100%;font-size: 14px">
                                                                                        <tfoot style="color:#636363;text-align: left !important;font-size: 14px">
                                                                                            <tr>
                                                                                                <th scope="row" colspan="2" style="border:1px solid #e5e5e5;padding:12px">
                                                                                                    Clinician Name:
                                                                                                </th>
                                                                                                <td style="border:1px solid #e5e5e5;padding:12px">
                                                                                                    {{ $data['clinitian']->first_name }} {{ $data['clinitian']->last_name }}
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
                                        <td style="text-align: left; padding: 30px 30px 40px;">
                                            <p style="text-align: left;">{{ ucfirst($data['clinitian']->first_name) }} {{ ucfirst($data['clinitian']->last_name) }} will be reaching out to you soon to schedule your next appointment. If you have any immediate questions or concerns, please feel free to contact here <a style="color: #bc9c23; text-decoration: none;" href="mailto:hello@becomingmethod.com">hello@becomingmethod.com</a>.</p>


                                            <p style="text-align: left;line-height: 24px;">We appreciate your understanding and cooperation during this transition. Our priority is to ensure you receive the highest level of care.</p>

                                            <p style="text-align: left;">Thank you for your dedication and support. We are excited to have you on board and look forward to serving you. <a href="{{ $url }}" style="color: #bc9c23; text-decoration: none;">Visit our site</a></p>
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