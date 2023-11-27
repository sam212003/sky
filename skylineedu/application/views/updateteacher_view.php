<html>
<head>
<title>Update Teacher</title>
<style>
<?php include 'skylinestyles.css';?>
</style>
</head>

    <body bgcolor = "#EBF5FB">
<?php include 'skyheader.html';?> 
<div class = "maincontainer">
<form  method="post" action="<?php echo base_url('index.php/teacherController/updateteacherdetails'); ?>">

<center><h2>Teacher Registration Form</h2>
</center><br>

<?php echo isset($message) ? $message : ''; ?>
€
<br><br>
<div class="container">
    <div class="section">
    <input type="hidden"  name= "teacherid" value="<?php echo $teacher->teacherid; ?>"  >
<label id="teachername">Teacher Name:</label><input type="text"  name= "teachername" value="<?php echo $teacher->teachername; ?>" required ><br><br>
<label id="dob">DOB:</label><input type="text"  name= "dob" value="<?php echo $teacher->dob; ?>" required><br><br>
<label id="address">Address:</label><input type="text" name="address" value="<?php echo $teacher->address; ?>" required><br><br></div>

 
  <div class="section">
  <label id="phno">Phone No:</label><input type="text"  name= "phno" value="<?php echo $teacher->phno; ?>" required><br><br>
  <label id="speciality">Speciality:</label><input type="text"  name= "speciality" value="<?php echo $teacher->speciality; ?>" required><br><br>
  <label id="qualification">Qualification:</label><input type="text"  name= "qualification" value="<?php echo $teacher->qualification; ?>" required><br><br>
  <label id="status">Status:</label><input type="text"  name= "status" value="<?php echo $teacher->status; ?>" required><br><br>

</div>
</div>
<center> 
<input type="submit" onclick="fun1()" value="UPDATE">
</center>
</form>
</body>
 </html>