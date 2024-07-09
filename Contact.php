<?php
include_once("Inc/Header.php");
include_once("DB_Files/db.php");
?>
<style>
    
.contact {
    padding: 150px 10px;
    background-color: #f9f9f9;
}

.contact__container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.contact__aside {
    flex: 1;
    max-width: 300px;
    text-align: center;
}

.contact__aside img {
    width: 100%;
    max-width: 200px;
    margin-bottom: 20px;
}

.contact__aside h2 {
    margin-bottom: 10px;
}

.contact__details {
    list-style: none;
    padding: 0;
}

.contact__details li {
    margin-bottom: 15px;
}

.contact__details h5 {
    margin: 0;
    font-weight: 500;
}

.contact__socials {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: center;
}

.contact__socials li {
    margin: 0 10px;
}

.contact__form {
    flex: 1;
    max-width: 600px;
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.contact__form input[type="text"],
.contact__form input[type="email"],
.contact__form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.contact__form textarea {
    resize: none;
}

.contact__form button {
    display: block;
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.contact__form button:hover {
    background-color: #0056b3;
}

.alert {
    margin-bottom: 15px;
}
    </style>
<section class="contact">
    <div class="container contact__container">
        <aside class="contact__aside">
            <div class="aside__image">
                <img src="Img/contact.svg" alt="Contact Image">
            </div>
            <h2>Contact Us</h2>
            <p>Suggestions and Feedbacks</p>
            <ul class="contact__details">
                <li>
                    <i class="uil uil-phone-alt"></i>
                    <h5>+251 977287978</h5>
                </li>
                <li>
                    <i class="uil uil-envelope-check"></i>
                    <h5>EthiolearnACadamy@gmail.com</h5>
                </li>
                <li>
                    <i class="uil uil-location-point"></i>
                    <h5>Sri Lanka</h5>
                </li>
            </ul>
            <ul class="contact__socials">
                <li><a href="#"><i class="uil uil-facebook-f"></i></a></li>
                <li><a href="#"><i class="uil uil-instagram"></i></a></li>
                <li><a href="#"><i class="uil uil-twitter-alt"></i></a></li>
                <li><a href="#"><i class="uil uil-linkedin-alt"></i></a></li>
            </ul>
        </aside>

        <form action="contact.php" method="POST" class="contact__form">
            <?php
            if (isset($successMessage)) {
                echo $successMessage;
            }
            if (isset($errorMessage)) {
                echo $errorMessage;
            }
            ?>
            <div class="form__name">
                <input type="text" name="First_Name" placeholder="First Name" required>
                <input type="text" name="Last_Name" placeholder="Last Name" required>
            </div>
            <input type="email" name="Email_Address" placeholder="Your Email Address" required>
            <textarea name="Message" placeholder="Message" rows="7" required></textarea>
            <button type="submit" class="button" name="sent">Send Message</button>
        </form>
    </div>
</section>
<?php
if (isset($_POST['sent'])) {
    $firstName = $_POST['First_Name'];
    $lastName = $_POST['Last_Name'];
    $email = $_POST['Email_Address'];
    $message = $_POST['Message'];

    // Insert into database
    $sql = "INSERT INTO contact (f_name, l_name, email, msg) VALUES ('$firstName', '$lastName', '$email', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        // Success message if needed
        $successMessage = '<div class="alert alert-success" role="alert">Message sent successfully!</div>';
    } else {
        // Error message if needed
        $errorMessage = '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
    }
}

include_once("Inc/Footer.php");
?>