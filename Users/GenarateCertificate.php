<?php
include_once("ProfileHeader.php");
include_once("../DB_Files/db.php");

$category = $_SESSION["exam_name"];
$stu_email = $_SESSION['stu_email'];

$sql = "SELECT * FROM students WHERE stu_email='$stu_email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $stuName = $row["stu_name"];
}

if (isset($_REQUEST["generate"])) {
    $font = "geometric.otf";
    $image = imagecreatefromjpeg("../Images/Certificate/Certificate.jpg");

    // Add these variable declarations
    $color = imagecolorallocate($image, 0, 134, 249);
    $color1 = imagecolorallocate($image, 64, 46, 14);
    $blueColor = imagecolorallocate($image, 0, 0, 255);

    $title = "Destiny online learning education academy";
    $message1 = "is hereby awarded this certificate for successful completion of";
    $message2 = "by Destiny online learning education center";
    $date = date("Y-m-d");
    $logo = imagecreatefrompng("../Images/logo.png");
    $signatureText = "President of Destiny academy";

    // ... (your certificate generation code)

    // Get image dimensions
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);

    // Get text dimensions
    $titleDims = imagettfbbox(50, 0, $font, $title);
    $stuNameDims = imagettfbbox(55, 0, $font, $stuName);
    $message1Dims = imagettfbbox(25, 0, $font, $message1);
    $categoryDims = imagettfbbox(25, 0, $font, $category . " certification exam");
    $message2Dims = imagettfbbox(25, 0, $font, $message2);

    // Calculate text positions
    $logoX = ($imageWidth - imagesx($logo)) / 2;
    $logoY = 0;  // Top of the image
    
    $titleX = ($imageWidth - ($titleDims[4] - $titleDims[0])) / 2;
    $titleY = $logoY + imagesy($logo) + 20;  // Adjusted for spacing
    
    $stuNameX = ($imageWidth - ($stuNameDims[4] - $stuNameDims[0])) / 2;
    $stuNameY = $imageHeight * 0.37;
    
    $message1X = ($imageWidth - ($message1Dims[4] - $message1Dims[0])) / 2;
    $message1Y = $imageHeight * 0.4;
    
    $categoryX = ($imageWidth - ($categoryDims[4] - $categoryDims[0])) / 2;
    $categoryY = $imageHeight * 0.45;
    
    $message2X = ($imageWidth - ($message2Dims[4] - $message2Dims[0])) / 2;
    $message2Y = $categoryY + 50;  // Adjusted for spacing
    
    $signatureTextX = ($imageWidth - imagettfbbox(20, 0, $font, $signatureText)[4]) / 2;
    $signatureTextY = $imageHeight * 0.8;
    
    // Add logo image
    imagecopy($image, $logo, $logoX, $logoY, 0, 0, imagesx($logo), imagesy($logo));

    // Adjusted positions for better visibility
    imagettftext($image, 50, 0, $titleX, $titleY, $color, $font, $title);
    imagettftext($image, 60, 0, $stuNameX, $stuNameY, $color, $font, $stuName);
    imagettftext($image, 25, 0, $message1X, $message1Y, $color1, $font, $message1);
    imagettftext($image, 25, 0, $categoryX, $categoryY, $blueColor, $font, $category . " certification exam");
    imagettftext($image, 25, 0, $message2X, $message2Y, $color1, $font, $message2);
    imagettftext($image, 25, 0, 50, $imageHeight - 50, $color1, $font, "Date: " . $date);
    imagettftext($image, 20, 0, $signatureTextX, $signatureTextY, $color1, $font, $signatureText);

    $img = "Certificates/" . $stuName . "-" . $category . ".jpg";
    $img_pdf = "Certificates/" . $stuName . "-" . $category . ".pdf";

    $_SESSION["pdf_path"] = $img_pdf;

    imagejpeg($image, $img);
    imagedestroy($image);

    require('fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage("L");
    $pdf->Image($img, 10, 10, 280, 190);
    $pdf->Output($img_pdf, "F");
}

$img_pdf = isset($_SESSION['pdf_path']) ? $_SESSION['pdf_path'] : '';
?>

<!-- The rest of your HTML and CSS remains unchanged -->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 4rem;
        }
        .btn-generate {
            background-color: #d9534f;
            color: #fff;
            font-weight: bold;
        }
        .certificate-img {
            max-width: 100%;
            margin-top: 2rem; /* Adjust margin-top for better spacing */
        }
        .download-link {
            color: #d9534f;
            font-weight: bold;
        }
        .form-control {
            width: 50%;
        }
    </style>
</head>
<body>

<div class="col-sm-6 mt-4 ms-5">
    <div class="container">
        <div class="col-md-12">
            <form action="" method="POST">
                <button type="submit" name="generate" class="btn btn-generate">Generate</button>
            </form>

            <?php if (!empty($img_pdf)) { ?>
                <br><br><br>
                <img class="certificate-img" src="<?php echo $img; ?>" alt="Certificate Image">
                <br><br><br>
                <?php echo isset($passmsg) ? $passmsg : ''; ?>
                <br><br>
                <p>Download your certificate:
                    <a href="<?php echo $img_pdf; ?>" class="download-link" download>Download Certificate</a>
                </p>
            <?php } ?>

            
    </div>
</div>

</body>
</html>
