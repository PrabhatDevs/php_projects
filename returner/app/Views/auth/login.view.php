<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Package Returner </title>
     <link rel="stylesheet"
        href="<?= base_url('public/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') ?>" />
    <link rel="stylesheet"
        href="<?= base_url('public/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') ?>" />
    <!-- <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
    
       
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
             font-family: sans-serif, serif;
        }

        body {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .container {
            display: flex;
            max-width: 900px;
            width: 100%;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .image-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f4ff;
           
        }

        .image-section img {
            max-width: 100%;
            height: auto;
        }

        .form-section {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-section h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .form-section p {
            color: #666;
            margin-bottom: 20px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group label {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #999;
            font-size: 14px;
            transition: 0.3s;
        }

        .input-group input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
        }

        .input-group input:focus + label,
        .input-group input:valid + label {
            top: 0px;
            background-color: white;
            font-size: 12px;
            color: #4e1a3d;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .remember-forgot a {
            color: #4e1a3d;
            text-decoration: none;
        }

        .btn {
            background: #4e1a3d;
            color: #fff;
            border: none;
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background:#4e1a3d
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .image-section {
                display: none;
            }

            .form-section {
                width: 100%;
                padding: 30px;
            }
        }
    </style>
        <link rel="stylesheet" href="<?= base_url('public/assets/vendor/libs/sweetalert2/sweetalert2.css') ?>" />

</head>
<body>

    <div class="container">
        <div class="image-section">
            <img src="<?= base_url('assets/images/login.png'); ?>" alt="Login Image">
        </div>

        <div class="form-section">
            <h2>Welcome to Package Returner 👋</h2>
            <p>Please sign in to your account</p>

            <form action="<?= base_url('/login'); ?>" method="POST">
                <div class="input-group">
                    <input type="email" name="email" id="email" required>
                    <label for="email">Email</label>
                </div>

                <div class="input-group">
                    <input type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>

                <div class="remember-forgot">
                   
                    <a href="javascript:void(0)" onclick="showForgotPasswordAlert()" class="float-end mb-1 mt-2">
                  <span>Forgot Password?</span> </a>
                </div>

                <button type="submit" class="btn">Sign In</button>
            </form>
        </div>
    </div>
     <script src="<?= base_url('assets/js/sweetalert/sweetalert.js') ?>"></script>
    <?php if (isset($_SESSION['status'])): ?>
        <script>
            Swal.fire({
                title: '<?= addslashes($_SESSION['status']) ?>',
                text: '<?= addslashes($_SESSION['message']) ?>',
                icon: '<?= addslashes($_SESSION['status']) ?>',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        </script>
        <?php unset($_SESSION['status'], $_SESSION['message']); ?>
    <?php endif; ?>
<script>
     function showForgotPasswordAlert() {
        Swal.fire({
          title: 'Oops!',
          text: 'Please request your admin to change your password',
          icon: 'info',
          confirmButtonText: 'OK',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
</script>

</body>
</html>
