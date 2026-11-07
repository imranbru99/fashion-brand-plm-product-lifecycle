@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Fashion Brand PLM</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-black">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">About Fashion Brand PLM</h1>

        <p>Fashion Brand PLM is a comprehensive platform designed to streamline the fashion business lifecycle from design to production. Our mission is to provide a one-stop solution for all your fashion management needs.</p>

        <div class="mb-4">
            <h2 class="text-xl font-bold">Our Vision</h2>
            <p>We envision a world where every fashion brand can manage their products, collections, and supply chain efficiently. Our platform is built to empower you with the tools you need to succeed in the competitive fashion industry.</p>
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-bold">Our Team</h2>
            <p>Fashion Brand PLM is developed by a team of experienced professionals who are passionate about helping fashion brands achieve their goals. Our team includes designers, developers, and business experts who work together to create a platform that meets the needs of our customers.</p>
        </div>

        @if (Auth::check())
            <div class="mb-4">
                <h2 class="text-xl font-bold">Your Account</h2>
                <p>Welcome back, {{ Auth::user()->name }}! You can access your account and manage your products, collections, and supply chain here.</p>
            </div>
        @else
            <div class="mb-4">
                <h2 class="text-xl font-bold">Sign Up</h2>
                <p>Join our community today and start managing your fashion business with Fashion Brand PLM. Sign up for a free trial or request a demo to see how we can help you succeed.</p>
            </div>
        @endif

        <div class="mb-4">
            <h2 class="text-xl font-bold">Contact Us</h2>
            <p>For any questions or concerns, please contact us at <a href="mailto:info@fashionbrandplm.com">info@fashionbrandplm.com</a>.</p>
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-bold">Privacy Policy</h2>
            <p>By using Fashion Brand PLM, you agree to our <a href="/privacy-policy">Privacy Policy</a>.</p>
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-bold">Terms and Conditions</h2>
            <p>By using Fashion Brand PLM, you agree to our <a href="/terms-and-conditions">Terms and Conditions</a>.</p>
        </div>
    </div>

    @vite(['resources/js/app.js'])
</body>
</html>
