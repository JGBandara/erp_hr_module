<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request for Approval</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4;">
<table align="center" width="100%" cellspacing="0" cellpadding="0"
       style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px;">
    <tr>
        <td>
            <h2 style="color: #333;">Request for Covering officer</h2>
            <p>Hello,</p>
            <p>You have a new request from <strong>{{ $requestData['sender_name'] }}</strong>.</p>

            <h3 style="color: #555;">Request Details:</h3>
            <p><strong>Subject:</strong> {{ $requestData['subject'] }}</p>
            <p><strong>Message:</strong> {{ $requestData['message'] }}</p>

            <p style="text-align: center;">
                <a href="{{'http://localhost:3000/secured/covering-officer/request/accept/'.$requestData['emp_id'] }}"
                   style="display: inline-block; padding: 12px 20px; font-size: 16px; color: #fff;
                              background-color: #28a745; text-decoration: none; border-radius: 5px;">
                    Accept
                </a>

                <a href="{{'http://localhost:3000/secured/covering-officer/request/reject/'.$requestData['emp_id'] }}"
                   style="display: inline-block; padding: 12px 20px; font-size: 16px; color: #fff;
                              background-color: #dc3545; text-decoration: none; border-radius: 5px; margin-left: 10px;">
                    Reject
                </a>
            </p>

            <p>Thanks,<br>{{ config('app.name') }}</p>
        </td>
    </tr>
</table>
</body>
</html>
