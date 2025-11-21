<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="WP2" />
    <meta name="author" content="Naurah Sallsabila" />
    <meta name="description" content="SIMA stok - Sistem Informasi Management Stok" />
    <meta name="robots" content="noindex,nofollow" />
    <title>Login - SIMA stok</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/image/sima.png') }}" />

    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background: #1e3a8a;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
      }

      .login-wrapper {
        display: flex;
        width: 100%;
        height: 100vh;
        position: relative;
      }

      /* Left Side - Logo */
      .left-side {
        flex: 0 0 45%;
        background: #e8edf5;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
      }

      .diagonal-shape {
        position: absolute;
        right: -150px;
        top: 0;
        bottom: 0;
        width: 300px;
        background: #e8edf5;
        transform: skewX(-10deg);
        z-index: 1;
      }

      .logo-container {
        position: relative;
        z-index: 2;
      }

      .logo-circle {
        width: 320px;
        height: 320px;
        border: 5px solid #2563eb;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: white;
      }

      .logo-icon {
        width: 120px;
        height: 120px;
        margin-bottom: 20px;
      }

      .logo-icon svg {
        width: 100%;
        height: 100%;
      }

      .logo-text {
        font-size: 52px;
        font-weight: 700;
        color: #2563eb;
        line-height: 1;
        letter-spacing: -1px;
      }

      .logo-subtext {
        font-size: 28px;
        font-weight: 600;
        color: #2563eb;
        letter-spacing: 1px;
      }

      /* Right Side - Form */
      .right-side {
        flex: 0 0 55%;
        background: linear-gradient(135deg, #3b5998 0%, #2d4373 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px;
      }

      .login-form-container {
        width: 100%;
        max-width: 460px;
        color: white;
      }

      .login-title {
        font-size: 72px;
        font-weight: 700;
        letter-spacing: 8px;
        margin-bottom: 60px;
        color: white;
      }

      .form-group {
        margin-bottom: 32px;
      }

      .form-label {
        display: block;
        font-size: 16px;
        font-weight: 400;
        margin-bottom: 12px;
        color: white;
      }

      .input-field {
        width: 100%;
        padding: 16px 24px;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        background: white;
        color: #333;
        outline: none;
      }

      .input-field::placeholder {
        color: #999;
      }

      .password-wrapper {
        position: relative;
      }

      .password-toggle {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        width: 24px;
        height: 24px;
      }

      .password-toggle svg {
        width: 24px;
        height: 24px;
        color: #666;
      }

      .login-button {
        width: 100%;
        max-width: 240px;
        padding: 16px 0;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 20px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 40px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        transition: transform 0.2s;
      }

      .login-button:hover {
        transform: translateY(-2px);
      }

      .signup-link {
        text-align: center;
        margin-top: 24px;
      }

      .signup-link a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        font-weight: 500;
      }

      .alert {
        padding: 14px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: white;
      }

      .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: white;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .lds-ripple {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
      }

      .lds-pos {
        position: absolute;
        border: 4px solid #2563eb;
        opacity: 1;
        border-radius: 50%;
        animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
      }

      .lds-pos:nth-child(2) {
        animation-delay: -0.5s;
      }

      @keyframes lds-ripple {
        0% {
          top: 36px;
          left: 36px;
          width: 0;
          height: 0;
          opacity: 1;
        }
        100% {
          top: 0px;
          left: 0px;
          width: 72px;
          height: 72px;
          opacity: 0;
        }
      }

      @media (max-width: 968px) {
        .login-wrapper {
          flex-direction: column;
        }

        .left-side {
          flex: 0 0 40%;
        }

        .diagonal-shape {
          display: none;
        }

        .logo-circle {
          width: 240px;
          height: 240px;
        }

        .logo-icon {
          width: 90px;
          height: 90px;
        }

        .logo-text {
          font-size: 42px;
        }

        .logo-subtext {
          font-size: 22px;
        }

        .right-side {
          flex: 0 0 60%;
          padding: 40px 30px;
        }

        .login-title {
          font-size: 48px;
          letter-spacing: 4px;
          margin-bottom: 40px;
        }
      }
    </style>
  </head>

  <body>
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>

    <div class="login-wrapper">
      <!-- Left Side -->
      <div class="left-side">
        <div class="diagonal-shape"></div>
        <div class="logo-container">
          <div class="logo-circle">
            <div class="logo-icon">
              <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Box/Package Icon -->
                <rect x="30" y="45" width="60" height="45" fill="#2563eb" opacity="0.3"/>
                <path d="M60 30 L90 45 L90 75 L60 90 L30 75 L30 45 Z" fill="#2563eb" opacity="0.5"/>
                <path d="M60 30 L60 60 L90 75" stroke="#2563eb" stroke-width="3" fill="none"/>
                <path d="M60 60 L30 75" stroke="#2563eb" stroke-width="3" fill="none"/>
                <!-- Arrow Up -->
                <path d="M75 15 L90 30 L82 30 L82 42 L68 42 L68 30 L60 30 Z" fill="#2563eb"/>
              </svg>
            </div>
            <div class="logo-text">SIMA</div>
            <div class="logo-subtext">stok</div>
          </div>
        </div>
      </div>

      <!-- Right Side -->
      <div class="right-side">
        <div class="login-form-container">
          <h1 class="login-title">LOGIN</h1>

          @if(session()->has('error'))
          <div class="alert">
            <strong>{{ session('error') }}</strong>
          </div>
          @endif

          <form action="{{ route('backend.login') }}" method="POST">
            @csrf

            <div class="form-group">
              <label class="form-label">Username / email</label>
              <input
                type="text"
                name="email"
                class="input-field"
                placeholder="Masukkan Email"
                required
              />
            </div>

            <div class="form-group">
              <label class="form-label">Password</label>
              <div class="password-wrapper">
                <input
                  type="password"
                  name="password"
                  id="password"
                  class="input-field"
                  placeholder="Masukkan Password"
                  required
                />
                <button type="button" class="password-toggle" onclick="togglePassword()">
                  <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>
            </div>

            <button type="submit" class="login-button">Login</button>

            <div class="signup-link">
              <a href="#">Sign Up</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      window.addEventListener('load', function() {
        document.querySelector('.preloader').style.display = 'none';
      });

      function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
        } else {
          passwordInput.type = 'password';
          eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
      }
    </script>
  </body>
</html>