<?php 
session_start();
error_reporting(1);
include('../database/connect.php'); 
include('../database/connect2.php'); 

//set time
date_default_timezone_set('Africa/Accra');
$current_date = date('Y-m-d H:i:s');

// Define the current month and year
$current_month = date('m');
$current_year = date('Y');

$app_name = 'Drug Recommender System';
$app_logo = 'uploadImage/Logo/logo.png';
$app_email = 'support@drug-recommender.com';


//fetch user data
$user_id = $_SESSION["user_id"];
$stmt = $dbh->query("SELECT * FROM users where id='$user_id'");
$row_user = $stmt->fetch();
$role = $row_user['role'];

//no of patients
$stmt = $dbh->query("SELECT COUNT(*) as total_patient FROM patients");
$total_patients = $stmt->fetch();

//no of admin
$stmt = $dbh->query("SELECT COUNT(*) as total_admin FROM users where role='Admin'");
$total_admins = $stmt->fetch();

//no of doctor
$stmt = $dbh->query("SELECT COUNT(*) as total_doctor FROM users where role='Doctor'");
$total_doctors = $stmt->fetch();

//no of pharmacist
$stmt = $dbh->query("SELECT COUNT(*) as total_pharmacist FROM users where role='Pharmacist'");
$total_pharmacists = $stmt->fetch();

//no of diagnosis
$stmt = $dbh->query("SELECT COUNT(*) as total_diagnosis FROM recommendations");
$total_diagnosis = $stmt->fetch();
?>