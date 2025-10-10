<?php
session_start();

require_once __DIR__ . '/koneksi.php';

if (isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}

$errorMessage = '';
$enteredUsername = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredUsername = trim($_POST['username'] ?? '');
    $enteredPassword = $_POST['password'] ?? '';

    if ($enteredUsername === '' || $enteredPassword === '') {
        $errorMessage = 'Username dan password wajib diisi.';
    } else {
        $query = 'SELECT id_user, username, password, role FROM users WHERE username = ? LIMIT 1';
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $enteredUsername);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) === 1) {
                mysqli_stmt_bind_result($stmt, $idUser, $dbUsername, $passwordHash, $role);
                mysqli_stmt_fetch($stmt);

                if (password_verify($enteredPassword, $passwordHash)) {
                    $_SESSION['id_user'] = $idUser;
                    $_SESSION['username'] = $dbUsername;
                    $_SESSION['role'] = $role;

                    mysqli_stmt_close($stmt);
                    header('Location: index.php');
                    exit;
                }
            }

            mysqli_stmt_close($stmt);
            $errorMessage = 'Username atau password salah.';
        } else {
            $errorMessage = 'Terjadi kesalahan pada server. Silakan coba lagi.';
        }
    }
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Monitoring Proyek</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                                <p class="mb-4">Masuk untuk mengelola monitoring proyek.</p>
                            </div>

                            <?php if ($errorMessage !== '') : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            <?php endif; ?>

                            <form class="user" method="post" action="">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="username" placeholder="Username" value="<?php echo htmlspecialchars($enteredUsername, ENT_QUOTES, 'UTF-8'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Masuk
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>

</body>

</html>
