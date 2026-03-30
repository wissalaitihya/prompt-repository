<?php

require_once '../config/db.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PromptHub</title>
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
            --color-danger-dark: #dc2626;
            --color-background: #eef0f4;
            --color-dark: #0b1120;
            --color-sidebar-dark: #1a1a2e;
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(255, 107, 169, 0.3);
            }
            50% {
                box-shadow: 0 0 30px rgba(255, 107, 169, 0.6);
            }
        }

        body {
            display: flex;
            font-family: 'Outfit', 'Segoe UI', Tahoma, sans-serif;
            background: var(--color-background);
            min-height: 100vh;
        }

        /* Left Sidebar Styling */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            animation: slideIn 0.5s ease-out;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 70px;
            font-size: 26px;
            font-weight: bold;
            color: white;
            text-decoration: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .logo:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            text-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
        }

        /* Navigation Menu */
        nav {
            margin-top: 0;
            padding: 15px 10px;
            flex-grow: 1;
            overflow-y: auto;
        }

        nav ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        nav li {
            margin: 0;
            animation: slideIn 0.6s ease-out backwards;
        }

        nav li:nth-child(1) { animation-delay: 0.1s; }
        nav li:nth-child(2) { animation-delay: 0.2s; }
        nav li:nth-child(3) { animation-delay: 0.3s; }
        nav li:nth-child(4) { animation-delay: 0.4s; }
        nav li:nth-child(5) { animation-delay: 0.5s; }

        nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: var(--radius-md);
            background-color: rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
            font-weight: 500;
            border-left: 4px solid transparent;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: left 0.3s ease;
            z-index: -1;
        }

        nav a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            transform: translateX(8px);
            border-left-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        nav a:active {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateX(5px);
        }

        /* Black Icons Class */
        .icon-black {
            color: rgba(255, 255, 255, 0.95);
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        nav a:hover .icon-black {
            transform: scale(1.15);
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        /* Font Awesome Icon Styling */
        nav i {
            font-size: 16px;
        }

        /* Sidebar Footer - Logout Button */
        .sidebar-footer {
            padding: 15px 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            flex-shrink: 0;
            backdrop-filter: blur(10px);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px 18px;
            background: linear-gradient(135deg, var(--color-danger-dark) 0%, var(--color-danger) 100%);
            color: white;
            text-decoration: none;
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.3s, height 0.3s;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, var(--color-danger) 0%, var(--color-danger-dark) 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .logout-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .logout-btn:active {
            transform: translateY(-1px);
        }

        .logout-btn i {
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover i {
            transform: scale(1.2);
        }

        /* Footer Styling */
        footer {
            position: fixed;
            bottom: 0;
            left: 280px;
            right: 0;
            background: linear-gradient(135deg, var(--color-primary-dark) 0%, #1a1a2e 100%);
            border-top: 2px solid rgba(255, 255, 255, 0.1);
            padding: 16px 40px;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            font-size: 13px;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        footer p {
            margin: 0;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        /* Content adjustment for sidebar */
        body > main {
            margin-left: 280px;
            width: calc(100% - 280px);
            padding: 40px;
            padding-bottom: 90px;
            animation: fadeIn 0.6s ease-out;
        }

        /* Media query for responsive design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            body > main {
                margin-left: 200px;
                width: calc(100% - 200px);
                padding: 20px;
                padding-bottom: 100px;
            }

            footer {
                left: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#" class="logo">PromptHub</a>
        <nav>
            <ul>
               <?php //if(isset($_SESSION['user_id'] )): ?>
                <li><a href="../developer/dashboard.php"><i class="fas fa-chart-line icon-black"></i> Dashboard</a></li>
                <li><a href="../developer/create_prompt.php"><i class="fas fa-plus icon-black"></i> Add Prompt</a></li>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="../admin/add_category.php"><i class="fas fa-cog icon-black"></i> Manage Categories</a></li>
                <?php endif; ?>

                <?php //else: ?>
                <li><a href="../auth/login.php"><i class="fas fa-lock icon-black"></i> Login</a></li>
                <li><a href="../auth/register.php"><i class="fas fa-user-plus icon-black"></i> Register</a></li>
                <?php //endif; ?>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="../auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</body>
</html>