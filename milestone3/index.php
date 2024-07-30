<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
        integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    <!-- Viewport meta tag -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <i class="fas fa-graduation-cap" style="font-size: 60px;"></i>
        </div>
        <div class="text-center mt-4 name">
            CASPS
        </div>
        
        <!-- Error Section -->
        <?php
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo '<div class="alert alert-danger text-center" role="alert">
                        Invalid login credentials. Please try again.
                      </div>';
            }
        ?>
        
        <form class="p-3 mt-3" action="login.php" method="post">
            <div class="form-field d-flex align-items-center">
                <select name="userType">
                    <option value="Admin">Admin</option>
                    <option value="Parent">Parent</option>
                </select>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-phone"></span>
                <input type="tel" name="phoneNumber" id="phoneNumber" placeholder="Phone Number" required>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="pwd" placeholder="Password" required>
            </div>
            <button type="submit" class="btn mt-3" name="login">Login</button>
        </form>
        <div class="bg">
            <img src="assets/images/schoolbg.jpg" class="bg">
        </div>
        <div class="text-center fs-6">
            <a href="#">Forget password?</a>
        </div>
    </div>
</body>

</html>
