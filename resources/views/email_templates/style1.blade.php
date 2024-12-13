<!DOCTYPE html>
<html>
<head>
    <title>Simple Template</title>
</head>
<body>
    <h1>Unrelated Content</h1>
    <p>This content is outside the template and should not be affected.</p>

    <!-- Template Container -->
    <div id="simple-template">
        <!-- Header Section -->
        <div data-section="header" class="editable-section header">
            <h1 data-editable="title">Welcome to My Simple Page</h1>
        </div>

        <!-- Body Section -->
        <div data-section="body" class="editable-section body">
            <p data-editable="content">This is a short paragraph that provides some description.</p>
        </div>

        <!-- Footer Section -->
        <div data-section="footer" class="editable-section footer">
            <p data-editable="signature">Thank you for visiting!<br>Your Name or Company</p>
        </div>
    </div>

    <!-- Inline CSS -->
    <style>
        /* Scoped styles for the template */
        #simple-template {
            background-color: #add8e6; /* Light blue background */
            color: #333;
            font-family: Arial, sans-serif;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 600px;
        }

        #simple-template .header,
        #simple-template .body,
        #simple-template .footer {
            margin-bottom: 20px;
        }

        #simple-template .header h1,
        #simple-template .footer p {
            text-align: center;
        }

        #simple-template .body p {
            line-height: 1.6;
            text-align: justify;
        }

        #simple-template .footer {
            border-top: 1px solid #ccc;
            padding-top: 15px;
            font-size: 0.9rem;
            color: #555;
            text-align: center;
        }

        #simple-template .editable-section {
            position: relative;
            transition: background-color 0.3s ease;
        }

        #simple-template .editable-section:hover {
            background-color: rgba(0, 123, 255, 0.1);
            cursor: pointer;
        }
    </style>
</body>
</html>