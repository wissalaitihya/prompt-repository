<?php
session_start();
require_once '../config/db.php';
$error_message = isset($_GET['error']) ? $_GET['error'] : "";
$success_message = isset($_GET['success']) ? $_GET['success'] : "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PromptHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Couleurs */
            --color-primary: #4f46e5;
            --color-primary-dark: #4338ca;
            --color-primary-light: #6366f1;
            --color-secondary: #10b981;
            --color-danger: #ef4444;
            --color-background: #eef0f4;
            --color-dark: #0b1120;
            --color-gray-light: #f8fafc;
            --color-gray-border: #e2e8f0;
            --color-gray-text: #666666;
            
            /* Border Radius */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 18px;
            --radius-2xl: 24px;
            
            /* Shadows */
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.15);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--color-background);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
            animation: float 20s infinite ease-in-out;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -100px;
            right: -100px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(11, 17, 32, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
            animation: float-reverse 25s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(30px, -30px); }
        }

        @keyframes float-reverse {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-30px, 30px); }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes glow {
            0%, 100% {
                box-shadow: var(--shadow-lg) 0 0 20px rgba(79, 70, 229, 0.3);
            }
            50% {
                box-shadow: var(--shadow-xl) 0 0 40px rgba(79, 70, 229, 0.5);
            }
        }

        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.95; }
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 1200px;
            gap: 60px;
            align-items: center;
            animation: slideInUp 0.7s ease-out;
            z-index: 1;
        }

        .login-brand {
            flex: 1;
            display: none;
        }

        .brand-content {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .brand-logo {
            font-size: 48px;
            font-weight: 900;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
        }

        .brand-text {
            font-size: 18px;
            color: #666;
            font-weight: 500;
            line-height: 1.6;
        }

        .login-container {
            flex: 1;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: var(--radius-2xl);
            padding: 50px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--color-gray-border);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.15) 0%, transparent 100%);
            border-radius: 50%;
            transition: all 0.6s ease;
            z-index: 0;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: rgba(79, 70, 229, 0.2);
            animation: glow 2s ease-in-out;
        }

        .card:hover::before {
            top: -20px;
            right: -20px;
            width: 250px;
            height: 250px;
        }

        .card-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
            animation: slideInDown 0.6s ease-out 0.1s backwards;
        }

        .card-header h1 {
            font-size: 38px;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 12px;
            text-shadow: var(--shadow-xs);
        }

        .card-header p {
            color: #999;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
            animation: slideInUp 0.6s ease-out backwards;
        }

        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.3s; }
        .form-group:nth-child(3) { animation-delay: 0.4s; }

        label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #2a2a2a;
            font-weight: 700;
            margin-bottom: 12px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        label i {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid var(--color-gray-border);
            background: var(--color-gray-light);
            color: #1a1a1a;
            border-radius: var(--radius-lg);
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 500;
        }

        input::placeholder {
            color: #ccc;
            font-weight: 400;
        }

        input:focus {
            outline: none;
            border-color: var(--color-primary);
            background: white;
            box-shadow: var(--shadow-md), inset 0 1px 3px rgba(79, 70, 229, 0.1);
            transform: translateY(-2px);
        }

        input:hover:not(:focus) {
            border-color: rgba(79, 70, 229, 0.3);
            box-shadow: var(--shadow-sm);
        }

        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 15px;
            position: relative;
            z-index: 1;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            animation: slideInUp 0.6s ease-out 0.5s backwards;
        }

        button i {
            font-size: 17px;
            transition: transform 0.3s ease;
        }

        button:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            background: linear-gradient(135deg, var(--color-primary-light) 0%, var(--color-primary) 100%);
        }

        button:hover i {
            transform: translateX(5px);
        }

        button:active {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .error-message {
            background: linear-gradient(135deg, #fef5f5 0%, #ffe6e6 100%);
            color: #d63031;
            padding: 16px 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 5px solid #d63031;
            font-size: 14px;
            position: relative;
            z-index: 1;
            animation: slideInUp 0.4s ease-out;
            box-shadow: 0 4px 15px rgba(214, 48, 49, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .error-message i {
            font-size: 18px;
            flex-shrink: 0;
        }

        .success-message {
            background: linear-gradient(135deg, #f5fef5 0%, #e6ffe6 100%);
            color: #27ae60;
            padding: 16px 18px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 5px solid #27ae60;
            font-size: 14px;
            position: relative;
            z-index: 1;
            animation: slideInUp 0.4s ease-out;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .success-message i {
            font-size: 18px;
            flex-shrink: 0;
        }

        .signup-link {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 14px;
            position: relative;
            z-index: 1;
            animation: slideInUp 0.6s ease-out 0.6s backwards;
        }

        .signup-link a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            display: inline-block;
        }

        .signup-link a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .signup-link a:hover {
            color: var(--color-primary-dark);
        }

        .signup-link a:hover::after {
            width: 100%;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                gap: 40px;
            }

            .login-brand {
                display: block;
                width: 100%;
            }

            .card {
                padding: 40px 30px;
            }

            .card-header h1 {
                font-size: 32px;
            }

            input, button {
                font-size: 14px;
                padding: 13px 16px;
            }

            button {
                margin-top: 12px;
            }
        }

        @media (max-width: 480px) {
            .card {
                padding: 30px 20px;
                border-radius: 20px;
            }

            .card-header h1 {
                font-size: 28px;
            }

            .card-header p {
                font-size: 13px;
            }

            input, button {
                font-size: 13px;
                padding: 12px 14px;
            }

            label {
                font-size: 12px;
            }

            .signup-link {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-brand">
            <div class="brand-content">
                <div class="brand-logo">PromptHub</div>
                <div class="brand-text">
                    <strong>Manage your prompts efficiently.</strong> Create, organize, and share your best ideas with ease.
                </div>
                <div style="margin-top: 30px; padding-top: 30px; border-top: 2px solid rgba(255, 107, 157, 0.1);">
                    <p style="color: #999; font-size: 13px; margin-bottom: 15px;">✨ Features:</p>
                    <ul style="list-style: none; color: #777; font-size: 13px; line-height: 1.8;">
                        <li>🚀 Quick prompt creation</li>
                        <li>📊 Track analytics</li>
                        <li>⭐ Save favorites</li>
                        <li>🔒 Secure & private</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="login-container">
            <div class="card">
                <div class="card-header">
                    <h1>Welcome Back</h1>
                    <p>Sign in to your account</p>
                </div>

                <?php if (!empty($error_message)) : ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> 
                        <span><?php echo htmlspecialchars($error_message); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success_message)) : ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> 
                        <span><?php echo htmlspecialchars($success_message); ?></span>
                    </div>
                <?php endif; ?>

                <form action="../controllers/authController.php" method="POST">
                    <input type="hidden" name="login" value="1">
                    
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                        <input type="email" id="email" name="email" placeholder="you@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </button>
                </form>

                <div class="signup-link">
                    Don't have an account? <a href="register.php">Create one now</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>




