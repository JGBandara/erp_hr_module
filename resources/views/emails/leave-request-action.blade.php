<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Covering Officer Notification</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4;">
<table align="center" width="100%" cellspacing="0" cellpadding="0"
       style="max-width: 600px; background: #ffffff; padding: 20px; border-radius: 8px;">
    <tr>
        <td>
            <h2 style="color: #333;">Leave Covering Officer Notification</h2>
            <p>Hello,</p>
            <p><strong>{{ $requestData['employee_name'] }}</strong> has assigned you as the covering officer during their leave.</p>

            <h3 style="color: #555;">Leave Details:</h3>
            <p><strong>Employee:</strong> {{ $requestData['employee_name'] }}</p>
            <p><strong>Leave Type:</strong> {{ $requestData['leave_type'] }}</p>
            <p><strong>Start Date:</strong> {{ $requestData['start_date'] }}</p>
            <p><strong>End Date:</strong> {{ $requestData['end_date'] }}</p>
            <p><strong>Message:</strong> {{ $requestData['message'] }}</p>

            <p style="text-align: center;">
                <a href="{{'http://localhost:3000/secured/leave-req/covering-officer/acknowledge/'.$requestData['covering_officer_id'] }}"
                   style="display: inline-block; padding: 12px 20px; font-size: 16px; color: #fff;
                          background-color: #007bff; text-decoration: none; border-radius: 5px;">
                    Acknowledge
                </a>

                <a href="{{'http://localhost:3000/secured/leave-req/covering-officer/reject/'.$requestData['covering_officer_id'] }}"
                   style="display: inline-block; padding: 12px 20px; font-size: 16px; color: #fff;
                          background-color: #dc3545; text-decoration: none; border-radius: 5px; margin-left: 10px;">
                    Reject
                </a>
            </p>

            <p>If you have any concerns, please contact HR.</p>

            <p>Thanks,<br>{{ config('app.name') }}</p>
        </td>
    </tr>
</table>
</body>
</html>
