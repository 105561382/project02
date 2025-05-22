<!DOCTYPE html>
<html lang="en">
<head>
  <?php
        include 'header.inc';
        ?>
  <link rel="stylesheet" href="styles/styles.css">
  <title>JOB APPLICATION</title>
</head>
<body>
<?php
        include 'nav.inc';
        ?>
		<hr>
  <hr>
  <h1>JOB APPLICATION</h1>
  <h2>FILL THE REQUIRED FIELDS FOR JOB APPLICATION</h2>

  <form action="process_eoi.php" method="post" novalidate="novalidate">

    <label for="jobreference">JOB REFERENCE</label>
    <select name="number" id="jobreference" required>
      <option value="">select</option>
      <option value="Network Administrator 101">Network Administrator-101</option>
      <option value="Cybersecurity Specialist 102">Cybersecurity Specialist-102</option>
    </select>

    <fieldset>
      <legend>Personal Details</legend>

      <p><label for="Firstname">First name</label>
        <input type="text" name="Firstname" id="Firstname" maxlength="20" required></p>

      <p><label for="Lastname">Last name</label>
        <input type="text" name="Lastname" id="Lastname" maxlength="20" required></p>

      <p><label for="dob">Date of birth</label>
        <input type="date" name="dob" id="dob" required></p>
      <fieldset>
        <legend>Gender</legend>
        <label><input type="radio" name="gender" value="Male" required> Male</label>
        <label><input type="radio" name="gender" value="Female"> Female</label>
        <label><input type="radio" name="gender" value="Other"> Other</label>
      </fieldset>

      <p><label for="streetaddress">Street Address</label><br>
        <input type="text" name="streetaddress" id="streetaddress" maxlength="40" required></p>

      <p><label for="suburb">Suburb/town</label>
        <input type="text" name="suburb" id="suburb" maxlength="40" required></p>

      <p><label for="state">State:</label> <!--dropdown for state-->
        <select name="state" id="state" required>
          <option value="">--Select--</option>
          <option value="ACT">ACT</option>
          <option value="NSW">NSW</option>
          <option value="NT">NT</option>
          <option value="QLD">QLD</option>
          <option value="SA">SA</option>
          <option value="TAS">TAS</option>
          <option value="VIC">VIC</option>
          <option value="WA">WA</option>
        </select>
      </p>
      <!--validaton of postcode without javascript--><!--pattern generated using chatgpt-->
      <p>
        <label for="postcode">Postcode</label>
        <input type="text" name="postcode" id="postcode" required
            pattern="\d{4}"
            title="Postcode must be exactly 4 digits">
      </p>
    
      

      <p><label for="email">Email Address</label>
        <input type="email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required></p> <!--pattern from uni provided cheatsheet-->

      <p><label for="phonenumber">Phone number</label>
        <input type="tel" name="phonenumber" id="phonenumber" pattern="[0-9]{8-12}" placeholder="eg-9496102189" required></p> <!--pattern from uni provided cheatsheet-->
    </fieldset><br>

    <h2>REQUIRED SKILLS</h2> <!--input for skills-->
<fieldset><legend>SKILLS</legend>
  <p><label><input type="checkbox" name="NetworkingProtocols" checked> Networking Protocols</label></p>
  <p><label><input type="checkbox" name="HardwareKnowledge"> Hardware Knowledge</label></p>
  <p><label><input type="checkbox" name="OperatingSystems"> Operating Systems</label></p>
  <p><label><input type="checkbox" name="NetworkConfiguration&Troubleshooting"> Network Configuration & Troubleshooting</label></p>
  <p><label><input type="checkbox" name="CloudNetworking" checked> Cloud Networking</label></p>
  <p><label><input type="checkbox" name="SecurityFundamentals"> Security Fundamentals</label></p>

  <p><label for="description">Other Skills</label><br>
    <textarea name="description" id="description" rows="4" cols="40" placeholder="Other Skills"></textarea>
  </p></fieldset>
    
    

    <p>
      <aside><button  type="submit">Apply</button>
        <button type="reset">Reset</button></aside>
  
      
    </p>
  </form>


 