<link rel="stylesheet" href="CSS/login.css">

<script src="/ethiolearn/js/jquery-3.3.1.min.js"></script>
<script language="javascript" type="text/javascript">
    window.history.forward();
</script>
<style>
    .goog-logo-link,.goog-te-gadget span {
        display:none !important;
    }

    .goog-te-gadget {
        color:transparent!important;
        font-size :0;
    }

    .goog-te-banner-frame {
        display:none !important;
    }

    .goog-te-gadget img {
        display:none !important;
    }

    body > .skiptranslate {
        display: none;
    }

    body {
        top: 0px !important;
    }
</style>

<div class="wrapper">
    <div class="container">
        <!-- Sign In -->
        <div class="container__form container--signin">
            <form action="signinDb.php" method="POST" class="form" id="login">
                <h2 class="form__title">Sign In</h2>
                <!-- login body -->
                <?php
                if (!empty($errors)) {
                    foreach ($errors as $key => $value) {
                        ?>
                        <div class="alert"><?php echo $value; ?></div>
                <?php
                    }
                }
                ?>
                <div class="form__group field">
                    <input type="email" name="email2" placeholder="Email Address" class="form__field" autocomplete="off" value=""/>
                    <label for="email2" class="form__label">Email</label>
                </div>
                <?php
                if (isset($error_msg['Email2'])) {
                    echo "<div class='validationError'>" . $error_msg['Email2'] . "</div>";
                }
                ?>
                <div class="form__group field">
                    <input type="password" name="password2" placeholder="Password" class="form__field" autocomplete="off" value=""/>
                    <label for="password2" class="form__label">Password</label>
                </div>
                <?php
                if (isset($error_msg['Password2'])) {
                    echo "<div class='validationError'>" . $error_msg['Password2'] . "</div>";
                }
                ?>
                <br>
                <label class="checkbox">
                    <div class="page__section page__custom-settings">
                        <div class="page__toggle">
                            <label class="toggle">
                                <input class="toggle__input" type="checkbox" checked>
                                <span class="toggle__label">
                                    <span class="toggle__text">Remember Me</span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <a href="forgot_password.php" class="link">Forgot your password?</a>
                    <div id='google_translate_element'></div>
                    <script src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit' async></script>
                    <script>
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                autoDisplay: 'true',
                                includedLanguages:'am,en,om',
                                layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
                            }, 'google_translate_element');
                        }
                    </script>
                    <br><br>
                    <button name="login" class="cta">
                        <span>Sign In</span>
                        <svg width="13px" height="10px" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
            </form>
        </div>
        <div class="container__overlay">
            <div class="overlay">
                <button class="cta cssbtn" id="signIn">
                    <span>Sign In</span>
                    <svg width="13px" height="10px" viewBox="0 0 13 10">
                        <path d="M1,5 L11,5"></path>
                        <polyline points="8 1 12 5 8 9"></polyline>
                    </svg>
                </button>
                <button class="cta cssbtn1" id="signUp">
                    <span>Sign Up</span>
                    <svg width="13px" height="10px" viewBox="0 0 13 10">
                        <path d="M1,5 L11,5"></path>
                        <polyline points="8 1 12 5 8 9"></polyline>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
<script src="js/Custom.js"></script>
<script>
    const signInBtn = document.getElementById("signIn");
    const signUpBtn = document.getElementById("signUp");
    const container = document.querySelector(".container");

    signInBtn.addEventListener("click", () => {
        container.classList.remove("right-panel-active");
    });

    signUpBtn.addEventListener("click", () => {
        window.location.href = 'signup.php';
    });
</script>
