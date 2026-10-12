
<?php
session_start();

// 데모용 계정: 실제 서비스에서는 데이터베이스를 사용하세요.
$demoUser = 'admin';
$demoPasswordHash = password_hash('Elephant123!', PASSWORD_DEFAULT);

$error = '';

if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (
        hash_equals($demoUser, $username) &&
        password_verify($password, $demoPasswordHash)
    ) {
        session_regenerate_id(true);
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        header('Location: login.php');
        exit;
    }

    $error = '아이디 또는 비밀번호가 올바르지 않습니다.';
}

$loggedIn = !empty($_SESSION['logged_in']);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>PHP 로그인</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: Arial, "Malgun Gothic", sans-serif;
            background: linear-gradient(135deg, #edf4ff, #f8faff);
            color: #202b3c;
        }

        .card {
            width: 100%;
            max-width: 410px;
            padding: 38px;
            background: white;
            border-radius: 22px;
            box-shadow: 0 18px 55px #23447718;
        }

        .logo {
            text-align: center;
            font-size: 54px;
            margin-bottom: 10px;
        }

        h1 {
            text-align: center;
            font-size: 28px;
            margin: 0 0 10px;
        }

        .subtitle {
            color: #7b8799;
            text-align: center;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        label {
            display: block;
            margin: 16px 0 8px;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #dbe3ef;
            border-radius: 10px;
            font-size: 16px;
            outline: none;
        }

        input:focus {
            border-color: #3478f6;
            box-shadow: 0 0 0 3px #3478f622;
        }

        button, .logout {
            display: block;
            width: 100%;
            margin-top: 24px;
            padding: 14px;
            border: 0;
            border-radius: 10px;
            background: #3478f6;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        button:hover, .logout:hover {
            background: #2463d5;
        }

        .error {
            padding: 12px;
            border-radius: 8px;
            background: #fff0f0;
            color: #c62828;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .success {
            padding: 16px;
            border-radius: 10px;
            background: #edfff4;
            color: #167344;
            text-align: center;
            line-height: 1.8;
        }

        footer {
            margin-top: 25px;
            text-align: center;
            color: #8793a5;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            body {
                padding: 16px;
            }

            .card {
                padding: 26px 22px;
            }
        }
    </style>
</head>

<body>
    <main class="card">
        <div class="logo" aria-hidden="true">🐘</div>

        <?php if ($loggedIn): ?>
            <h1>로그인 성공!</h1>

            <p class="subtitle">
                PHP 로그인 시스템에 오신 것을 환영합니다.
            </p>

            <div class="success">
                안녕하세요,
                <strong><?= htmlspecialchars(
                    $_SESSION['username'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?></strong>님!<br>
                로그인 상태가 유지되고 있습니다.
            </div>

            <a class="logout" href="?logout=1">
                로그아웃
            </a>

        <?php else: ?>
            <h1>PHP 로그인</h1>

            <p class="subtitle">
                아이디와 비밀번호를 입력하세요.
            </p>

            <?php if ($error !== ''): ?>
                <div class="error" role="alert">
                    <?= htmlspecialchars(
                        $error,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="login.php">
                <label for="username">아이디</label>
                <input
                    id="username"
                    name="username"
                    type="text"
                    placeholder="아이디를 입력하세요"
                    autocomplete="username"
                    maxlength="100"
                    required
                >

                <label for="password">비밀번호</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="비밀번호를 입력하세요"
                    autocomplete="current-password"
                    required
                >

                <button type="submit">로그인</button>
            </form>
        <?php endif; ?>

        <footer>
            Powered by PHP 🐘
        </footer>
    </main>
</body>
</html>
