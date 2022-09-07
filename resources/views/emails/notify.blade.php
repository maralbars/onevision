<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Feedback</title>
    <style>
        .content {
            max-width: 700px;
            margin: 50px auto;
        }
    </style>
</head>

<body>
    <div class="content">
        <table>
            <tr>
                <td><strong>Subject:</strong></td>
                <td>{{ $feedback->subject }}</td>
            </tr>
            <tr>
                <td><strong>Description:</strong></td>
                <td>{{ $feedback->description }}</td>
            </tr>
            <tr>
                <td><strong>Author:</strong></td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td><strong>Author's email:</strong></td>
                <td>{{ $user->email }}</td>
            </tr>
            @if ($feedback->attachment_original_name)
            <tr>
                <td><strong>Attached file:</strong></td>
                <td><a href="{{ route('feedback.download', $feedback->id) }}">{{ $feedback->attachment_original_name }}</a></td>
            </tr>
            @endif
        </table>
        <a href="{{ route('feedback.index') }}">See all new feedbacks</a>
    </div>
</body>

</html>