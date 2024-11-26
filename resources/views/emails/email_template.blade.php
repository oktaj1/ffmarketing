<!-- resources/views/emails/email_template.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template->name }}</title>
</head>
<body>
    <h1>{{ $template->name }}</h1>

    <!-- Displaying the uploaded image if it exists -->
    @if($template->image_path)
        <img src="{{ Storage::url($template->image_path) }}" alt="Template Image" style="max-width: 100%; height: auto;">
    @endif

    <!-- Displaying the email body text -->
    <div>
        {!! nl2br(e($template->body)) !!}
    </div>
</body>
</html>
