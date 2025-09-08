


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid Verification Link</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-2xl p-10 max-w-lg text-center">
        <svg class="w-20 h-20 text-red-500 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M12 9v2m0 4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z"/>
        </svg>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Invalid or Expired Link</h1>
        <p class="text-gray-600 mb-6">
            Oops! The verification link is not valid or has already been used.
            Please request a new verification email.
        </p>
        <a href="https://your-frontend-app.com/resend-verification" 
           class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg shadow-md">
            Resend Verification Email
        </a>
    </div>
</body>
</html>
