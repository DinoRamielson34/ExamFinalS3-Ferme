<?php
$base_url = Flight::get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="<?php echo $base_url ?>/public/assets/css/log.css">

    <title>Responsive login and registration form - Bedimcode</title>
</head>

<body>
    <!--=============== LOGIN IMAGE ===============-->
    <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
        <mask id="mask0" mask-type="alpha">
            <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" />
        </mask>

        <g mask="url(#mask0)">
            <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" />
            <!-- Insert your image (recommended size: 1000 x 1200) -->
            <image class="login__img" href="<?= $base_url ?>/public/assets/images/bg-img.jpg" />
        </g>
    </svg>

    <!--=============== LOGIN ===============-->
    <div class="login container grid" id="loginAccessRegister">
        <!--===== LOGIN ACCESS =====-->
        <div class="login__access">
            <h1 class="login__title">Log in to your account.</h1>

            <div class="login__area">
                <form action="<?php echo $base_url; ?>/log" method="POST" class="login__form">
                    <div class="login__content grid">
                        <div class="login__box">
                            <input type="email" name="email" id="loginEmail" required placeholder=" "
                                class="login__input">
                            <label for="loginEmail" class="login__label">Email</label>
                            <i class="ri-mail-fill login__icon"></i>
                        </div>

                        <div class="login__box">
                            <input type="password" name="password" id="loginPassword" required placeholder=" "
                                class="login__input">
                            <label for="loginPassword" class="login__label">Password</label>
                            <i class="ri-eye-off-fill login__icon login__password" id="loginPasswordToggle"></i>
                        </div>
                    </div>

                    <a href="#" class="login__forgot">Forgot your password?</a>
                    <button type="submit" class="login__button">Login</button>
                </form>

                <div class="login__social">
                    <p class="login__social-title">Or login with</p>
                    <div class="login__social-links">
                        <a href="#" class="login__social-link">
                            <img src="<?php echo $base_url ?>/public/assets/images/icon-google.svg" alt="image"
                                class="login__social-img">
                        </a>
                        <a href="#" class="login__social-link">
                            <img src="<?php echo $base_url ?>/public/assets/images/icon-facebook.svg" alt="image"
                                class="login__social-img">
                        </a>
                        <a href="#" class="login__social-link">
                            <img src="<?php echo $base_url ?>/public/assets/images/icon-apple.svg" alt="image"
                                class="login__social-img">
                        </a>
                    </div>
                </div>

                <p class="login__switch">
                    Don't have an account?
                    <button type="button" id="loginButtonRegister">Create Account</button>
                </p>
            </div>
        </div>

        <!--===== LOGIN REGISTER =====-->
        <div class="login__register">
            <h1 class="login__title">Create new account.</h1>

            <div class="login__area">
                <form action="<?php echo $base_url; ?>/register" class="login__form" method="POST">
                    <div class="login__content grid">
                        <div class="login__group grid">
                            <div class="login__box">
                                <input type="text" name="names" id="registerNames" required placeholder=" "
                                    class="login__input">
                                <label for="registerNames" class="login__label">Names</label>
                                <i class="ri-id-card-fill login__icon"></i>
                            </div>

                            <div class="login__box">
                                <input type="tel" name="phone" id="registerSurnames" required placeholder=" "
                                    class="login__input">
                                <label for="registerSurnames" class="login__label">Phone</label>
                                <i class="ri-phone-fill login__icon"></i>
                            </div>
                        </div>

                        <div class="login__box">
                            <input type="email" name="email" id="registerEmail" required placeholder=" "
                                class="login__input">
                            <label for="registerEmail" class="login__label">Email</label>
                            <i class="ri-mail-fill login__icon"></i>
                        </div>

                        <div class="login__box">
                            <input type="password" name="password" id="registerPassword" required placeholder=" "
                                class="login__input">
                            <label for="registerPassword" class="login__label">Password</label>
                            <i class="ri-eye-off-fill login__icon login__password" id="registerPasswordToggle"></i>
                        </div>
                        <div class="login__box">
                            <input type="checkbox" name="is_admin" id="isAdmin" value="1">
                            <label for="isAdmin" class="login__label">Register as Admin</label>
                        </div>
                    </div>

                    <button type="submit" class="login__button">Create account</button>
                </form>

                <p class="login__switch">
                    Already have an account?
                    <button type="button" id="loginButtonAccess">Log In</button>
                </p>
            </div>
        </div>
    </div>

    <!--=============== MAIN JS ===============-->
    <script>
        /*=============== SHOW HIDE PASSWORD LOGIN ===============*/
        const passwordAccess = (loginPass, loginEye) => {
            const input = document.getElementById(loginPass),
                iconEye = document.getElementById(loginEye);

            iconEye.addEventListener('click', () => {
                input.type = input.type === 'password' ? 'text' : 'password';
                iconEye.classList.toggle('ri-eye-fill');
                iconEye.classList.toggle('ri-eye-off-fill');
            });
        }
        passwordAccess('loginPassword', 'loginPasswordToggle');

        /*=============== SHOW HIDE PASSWORD CREATE ACCOUNT ===============*/
        const passwordRegister = (loginPass, loginEye) => {
            const input = document.getElementById(loginPass),
                iconEye = document.getElementById(loginEye);

            iconEye.addEventListener('click', () => {
                input.type = input.type === 'password' ? 'text' : 'password';
                iconEye.classList.toggle('ri-eye-fill');
                iconEye.classList.toggle('ri-eye-off-fill');
            });
        }
        passwordRegister('registerPassword', 'registerPasswordToggle');

        /*=============== SHOW HIDE LOGIN & CREATE ACCOUNT ===============*/
        const loginAcessRegister = document.getElementById('loginAccessRegister'),
            buttonRegister = document.getElementById('loginButtonRegister'),
            buttonAccess = document.getElementById('loginButtonAccess');

        buttonRegister.addEventListener('click', () => {
            loginAcessRegister.classList.add('active');
        });

        buttonAccess.addEventListener('click', () => {
            loginAcessRegister.classList.remove('active');
        });
    </script>
</body>

</html>