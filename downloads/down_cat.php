<?Php

session_start();
if(!isset($_SESSION['email']))
{
	die(include('../user/error.html'));
	
}
require('../pdf/fpdf.php');
function connectDB()
{
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'lms';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

function getAdminData()
{
    $conn = connectDB();
    $stmt = $conn->prepare("select name,email,mobile from admins where email='$_SESSION[email]'");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function getCatData()
{
    $conn = connectDB();
    $stmt = $conn->prepare("select  * from category");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

$pdf = new FPDF();
$pdf->AddPage();
// $pdf->Image('../images/pdf_logo.png', 0, -1, 90);
// $pdf->Ln(5);
// Set line width
$pdf->SetLineWidth(0.5);

// Draw a line
$pdf->Line(10, 10, 100, 10);
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetFillColor(4, 216, 209); // Set background color
$pdf->Cell(0, 10, 'Library Management System', 1, 1, 'C', true); // Add 'true' parameter to fill the background
$pdf->Ln(3);


$userList = getAdminData();
$pdf->Ln(6);

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(129,219,153); // Set background color
$pdf->Cell(0, 10, 'Your Profile', 1, 1, 'C', true); // Add 'true' parameter to fill the background
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, 'Name: ', 1, 0, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(95, 10, $userList[0]['name'], 1, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, 'Email ID: ', 1, 0, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(95, 10, $userList[0]['email'], 1, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, 'Mobile NO: ', 1, 0, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(95, 10, $userList[0]['mobile'], 1, 1, 'C');


$pdf->SetLineWidth(0.5);

// Draw a line
$pdf->Line(10, 10, 100, 10);
$pdf->Ln(10);

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14); // Set font to bold and increase font size
$pdf->SetFillColor(200, 200, 200); // Set background color for title
$pdf->Cell(0, 10, 'Available Categories', 1, 1, 'C', true); // Add 'true' parameter to fill the background
$pdf->SetFont('Arial', '', 12); // Reset font to regular
$pdf->Ln(3);
$pdf->AliasNbPages();

$pdf->SetFont('Arial', '', 12);

$catList = getcatData();
$pdf->SetFillColor(236, 229,14);
$pdf->Cell(50, 10, 'Category ID', 1,0,'C',true); 
$pdf->Cell(90, 10, 'Category Name.', 1,0,'C',true); 
$pdf->SetFillColor(236, 229,14);
$pdf->Ln();

foreach ($catList as $cat) {

    $pdf->Cell(50, 10, $cat['cat_id'], 1);
    $pdf->Cell(90, 10, $cat['cat_name'], 1);
    $pdf->Ln();
}
$pdf->Output('books Categories.pdf', 'I');
?>
