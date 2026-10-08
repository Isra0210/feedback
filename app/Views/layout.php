<?php

use App\Auth;
use App\View;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= View::e($title) ?> - Sistema de Feedback</title>
    <style>
        :root {
            --bg: #eef1f6;
            --surface: #ffffff;
            --ink: #1f2933;
            --muted: #6b7280;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --border: #e5e7eb;
            --radius: 12px;
            --shadow: 0 1px 3px rgba(16, 24, 40, .08), 0 1px 2px rgba(16, 24, 40, .04);
            --shadow-lg: 0 10px 25px rgba(16, 24, 40, .12);

            --st-received-bg: #f1f5f9;
            --st-received-tx: #475569;
            --st-analysis-bg: #fef3c7;
            --st-analysis-tx: #b45309;
            --st-development-bg: #dbeafe;
            --st-development-tx: #1d4ed8;
            --st-finished-bg: #dcfce7;
            --st-finished-tx: #15803d;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 24px;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        header .brand {
            font-weight: 700;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        header .brand .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--primary);
        }

        header nav a {
            color: var(--muted);
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
            font-weight: 500;
            transition: color .15s;
        }

        header nav a:hover {
            color: var(--ink);
        }

        header nav a.nav-logout {
            color: #dc2626;
            font-weight: 700;
        }

        header nav a.nav-logout:hover {
            color: #b91c1c;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            width: 40px;
            height: 40px;
            padding: 8px;
            background: transparent;
            border: 0;
            cursor: pointer;
        }

        .hamburger span {
            display: block;
            height: 2px;
            width: 100%;
            background: var(--ink);
            border-radius: 2px;
            transition: transform .2s ease, opacity .2s ease;
        }

        main {
            max-width: 1080px;
            margin: 32px auto;
            padding: 0 24px;
        }

        main.wide {
            max-width: 1280px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px;
            box-shadow: var(--shadow);
        }

        .card.narrow {
            max-width: 460px;
            margin: 40px auto;
        }

        h1 {
            margin: 0 0 4px;
            font-size: 24px;
        }

        h2 {
            font-size: 18px;
            margin: 0 0 12px;
        }

        .subtitle {
            color: var(--muted);
            margin: 0 0 24px;
            font-size: 14px;
        }

        label {
            display: block;
            margin: 16px 0 6px;
            font-weight: 600;
            font-size: 14px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #fff;
            color: var(--ink);
            transition: border-color .15s, box-shadow .15s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, .15);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .btn,
        button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: var(--primary);
            color: #fff;
            border: 0;
            padding: 11px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            transition: background .15s, transform .05s;
        }

        .btn:hover,
        button:hover {
            background: var(--primary-hover);
        }

        .btn:active,
        button:active {
            transform: translateY(1px);
        }

        .btn-ghost {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover {
            background: #f8fafc;
            color: var(--ink);
        }

        .mt {
            margin-top: 20px;
        }

        a {
            color: var(--primary);
        }

        .link-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .link-back:hover {
            color: var(--ink);
        }

        .msg {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .msg-ok {
            background: var(--st-finished-bg);
            color: var(--st-finished-tx);
        }

        .msg-error {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            background: #eef1f4;
            color: var(--muted);
        }

        .status-received {
            background: var(--st-received-bg);
            color: var(--st-received-tx);
        }

        .status-analysis {
            background: var(--st-analysis-bg);
            color: var(--st-analysis-tx);
        }

        .status-development {
            background: var(--st-development-bg);
            color: var(--st-development-tx);
        }

        .status-finished {
            background: var(--st-finished-bg);
            color: var(--st-finished-tx);
        }

        .table-wrap {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            text-align: left;
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }

        .table th {
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .table tbody tr:last-child td {
            border-bottom: 0;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .table a {
            font-weight: 600;
            text-decoration: none;
        }

        .table a:hover {
            text-decoration: underline;
        }

        @media (max-width: 560px) {
            header {
                padding: 0 16px;
            }

            header .brand {
                font-size: 15px;
            }

            .hamburger {
                display: inline-flex;
            }

            header nav {
                display: none;
                position: absolute;
                top: 100%;
                right: 12px;
                min-width: 190px;
                background: var(--surface);
                border: 1px solid var(--border);
                border-radius: 10px;
                box-shadow: var(--shadow-lg);
                flex-direction: column;
                align-items: stretch;
                padding: 6px;
                margin-top: 6px;
            }

            header.nav-open nav {
                display: flex;
            }

            header nav a {
                margin: 0;
                padding: 11px 14px;
                font-size: 15px;
                border-radius: 6px;
            }

            header nav a:hover {
                background: #f1f5f9;
            }

            header.nav-open .hamburger span:nth-child(1) {
                transform: translateY(7px) rotate(45deg);
            }

            header.nav-open .hamburger span:nth-child(2) {
                opacity: 0;
            }

            header.nav-open .hamburger span:nth-child(3) {
                transform: translateY(-7px) rotate(-45deg);
            }

            main {
                margin: 20px auto;
                padding: 0 16px;
            }

            .card {
                padding: 20px;
            }

            .card.narrow {
                margin: 24px auto;
            }

            h1 {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>
    <header id="site-header">
        <div class="brand"><span class="dot"></span> <span class="brand-txt">Sistema de Feedback</span></div>
        <button class="hamburger" id="hamburger" type="button"
            aria-label="Abrir menu" aria-expanded="false" aria-controls="menu-nav">
            <span></span><span></span><span></span>
        </button>
        <nav id="menu-nav">
            <a href="/">Novo feedback</a>
            <?php if (Auth::check()): ?>
                <a href="/feedbacks">Feedbacks</a>
                <a href="/logout" class="nav-logout">Sair</a>
            <?php else: ?>
                <a href="/login">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="<?= ($widePage ?? false) ? 'wide' : '' ?>">
        <?= $content ?>
    </main>

    <script>
        (function() {
            var button = document.getElementById('hamburger');
            var header = document.getElementById('site-header');
            if (!button || !header) return;

            function setOpen(open) {
                header.classList.toggle('nav-open', open);
                button.setAttribute('aria-expanded', open ? 'true' : 'false');
                button.setAttribute('aria-label', open ? 'Fechar menu' : 'Abrir menu');
            }

            button.addEventListener('click', function(e) {
                e.stopPropagation();
                setOpen(!header.classList.contains('nav-open'));
            });

            document.addEventListener('click', function(e) {
                if (!header.contains(e.target)) setOpen(false);
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') setOpen(false);
            });
        })();
    </script>
    <?php if (Auth::check()): ?>
        <script>
            window.addEventListener('pageshow', function(e) {
                if (e.persisted) {
                    window.location.reload();
                }
            });
        </script>
    <?php endif; ?>
</body>

</html>