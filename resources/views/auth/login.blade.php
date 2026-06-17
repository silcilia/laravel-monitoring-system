<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Monitoring System</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e3a5f, #0f2b4f);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 24px;
            width: 420px;
            max-width: 100%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            background: linear-gradient(135deg, #1e3a5f, #0f2b4f);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .logo-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .logo-icon i {
            font-size: 35px;
            color: white;
        }

        .login-header h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .login-header p {
            font-size: 14px;
            opacity: 0.8;
        }

        .login-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }

        .form-group label i {
            margin-right: 8px;
            color: #1e3a5f;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #1e3a5f;
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1);
        }

        .input-wrapper input:hover {
            border-color: #cbd5e1;
        }

        /* Error styling */
        .input-error {
            border-color: #dc2626 !important;
        }
        .input-error:focus {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
        }
        .error-text {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #1e3a5f, #0f2b4f);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 58, 95, 0.3);
        }

        .btn-login:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            transform: none;
        }

        .error-message {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px 15px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #dc2626;
        }

        .error-message i {
            font-size: 16px;
        }

        .success-message {
            background: #d1fae5;
            color: #065f46;
            padding: 12px 15px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #10b981;
        }

        .login-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            margin-top: 10px;
        }

        .login-footer p {
            color: #64748b;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            .login-container {
                width: 95%;
            }
            
            .login-header {
                padding: 20px;
            }
            
            .login-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-header">
        <div class="logo-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <h2>Monitoring System</h2>
        <p>Login untuk mengakses dashboard</p>
    </div>

    <div class="login-body">
        <!-- Error Message -->
        @if ($errors->any())
            <div class="error-message" style="display: flex;">
                <i class="fas fa-exclamation-circle"></i>
                <span id="errorText">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </span>
            </div>
        @endif

        <!-- Success Message (logout) -->
        @if (session('status'))
            <div class="success-message" style="display: flex;">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label><i class="fas fa-user"></i> Username / Email</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        placeholder="Masukkan username" 
                        autocomplete="off" 
                        autofocus
                        value="{{ old('username') }}"
                        class="@error('username') input-error @enderror"
                    >
                </div>
                @error('username')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Masukkan password"
                        class="@error('password') input-error @enderror"
                    >
                </div>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login" id="loginBtn">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="login-footer">
            <p>&copy; {{ date('Y') }} Monitoring System. All rights reserved.</p>
        </div>
    </div>
</div>

<script>
    // ===============================
    // AUTO HIDE ERROR MESSAGE
    // ===============================
    document.addEventListener('DOMContentLoaded', function() {
        const errorMsg = document.querySelector('.error-message');
        if (errorMsg && errorMsg.style.display !== 'none') {
            setTimeout(() => {
                errorMsg.style.display = 'none';
            }, 5000);
        }

        const successMsg = document.querySelector('.success-message');
        if (successMsg && successMsg.style.display !== 'none') {
            setTimeout(() => {
                successMsg.style.display = 'none';
            }, 5000);
        }
    });

    // ===============================
    // CLEAR ERROR WHEN TYPING
    // ===============================
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    
    if (usernameInput) {
        usernameInput.addEventListener('input', function() {
            this.classList.remove('input-error');
            const errorMsg = document.querySelector('.error-message');
            if (errorMsg) errorMsg.style.display = 'none';
        });
    }
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            this.classList.remove('input-error');
            const errorMsg = document.querySelector('.error-message');
            if (errorMsg) errorMsg.style.display = 'none';
        });
    }

    // ===============================
    // DISABLE BUTTON ON SUBMIT (Anti Double Submit)
    // ===============================
    const loginForm = document.querySelector('form');
    if (loginForm) {
        loginForm.addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="loading-spinner"></span> Memproses...';
            }
        });
    }
</script>

</body>
</html>