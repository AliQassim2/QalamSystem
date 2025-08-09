<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        a {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.9em;
        }

        button {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            width: 100%;
            margin-top: 15px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        small {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Login</h2>

        @if(session('error'))
        <div style="color: red; text-align:center;">{{ session('error') }}</div>
        @endif
        @if(session('success'))
        <div style="color: green; text-align:center;">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            {{-- Login field --}}
            <label for="login">Email / Username / Phone</label>
            <input type="text" name="login" id="login" value="{{ old('login') }}" required>
            @error('login') <small>{{ $message }}</small> @enderror

            {{-- Password field --}}
            <div id="passwordField">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                @error('password') <small>{{ $message }}</small> @enderror
            </div>

            {{-- Code field --}}
            <div id="codeField" style="display:none;">
                <label for="code">Login Code</label>
                <input type="text" name="code" id="code">
                <a href="#" id="sendCodeLink">Send code to email</a>
                @error('code') <small>{{ $message }}</small> @enderror
            </div>

            {{-- Toggle button --}}
            <div style="margin-top: 10px;">
                <button type="button" id="toggleMethod" style="background: #6c757d;">Use Code Instead</button>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        const passwordField = document.getElementById('passwordField');
        const codeField = document.getElementById('codeField');
        const toggleBtn = document.getElementById('toggleMethod');
        const sendCodeLink = document.getElementById('sendCodeLink');
        const loginInput = document.getElementById('login');

        let useCode = false;

        toggleBtn.addEventListener('click', function() {
            useCode = !useCode;

            if (useCode) {
                passwordField.style.display = 'none';
                codeField.style.display = 'block';
                toggleBtn.textContent = 'Use Password Instead';
            } else {
                passwordField.style.display = 'block';
                codeField.style.display = 'none';
                toggleBtn.textContent = 'Use Code Instead';
            }
        });

        sendCodeLink.addEventListener('click', function(e) {
            e.preventDefault();
            const loginValue = loginInput.value.trim();

            if (!loginValue) {
                alert('Please enter your email, username, or phone first.');
                return;
            }

            window.location.href = `/send-login-code?login=${encodeURIComponent(loginValue)}`;
        });
    </script>

</body>

</html>
