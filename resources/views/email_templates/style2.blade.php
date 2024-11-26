<!DOCTYPE html>
<html>
<head>
    <title>Style 2</title>
</head>
<body>
    <h1>Style 2 Template</h1>
    <p>This is the preview for Style 2.</p>

    <!-- Email Template Sections -->
    <div class="email-template">
        <!-- Header Section -->
        <div data-section="header" class="editable-section header">
            <h1 data-editable="title">Your Email Title Here</h1>
        </div>

        <!-- Body Section -->
        <div data-section="body" class="editable-section body">
            <p data-editable="content">Email body content goes here. This section can be customized with the actual content for your email template.</p>
        </div>

        <!-- Footer Section -->
        <div data-section="footer" class="editable-section footer">
            <p data-editable="signature">Best regards,<br>Your Company Name</p>
        </div>
    </div>

    <!-- Inline CSS -->
    <style>
        .email-template {
            background-color: lightgreen;
            color: darkgreen;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .email-template .header, .email-template .body, .email-template .footer {
            margin-bottom: 20px;
        }
        .email-template .header h1, .email-template .footer p {
            text-align: center;
        }
        .email-template .body p {
            line-height: 1.6;
        }
        .email-template .footer {
            border-top: 1px solid #ddd;
            padding-top: 15px;
            font-style: italic;
            color: #555;
        }
        .editable-section {
            position: relative;
            transition: background-color 0.3s ease;
        }
        .editable-section:hover {
            background-color: rgba(255, 255, 0, 0.3);
            cursor: pointer;
        }
    </style>
</body>
</html>
