<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
	
	<link rel="stylesheet" type="text/css" href="_css/form.css" media="all" />
	<script src="_js/jquery-ui.js"></script>
	<script src="_js/jquery.min.js"></script>
	<script src="_js/jquery-form.js"></script>
	<script src="_js/jquery-inputfocus.js"></script>
</head>
<body>
	
	<div id="container">
		<header id="fheader-1"><h1>SIGN UP FOR A FREE <span>Congregation Link</span> ACCOUNT</h1>
		</header>
		<form action="#" method="post">
			<!-- #first_step -->
			<div id="first_step">

				<div class="form">
					<div>
						<h4>Silver</h4>
						<input type="hidden" name="silver_term" id="silver_term" value="silver" />
						<input class="term-submit" type="submit" name="submit_first" id="submit_silver" value=" " />
					</div>
					<div>
						<h4>Gold</h4>
						<input type="hidden" name="gold_term" id="gold_term" value="gold" />
						<input class="term-submit" type="submit" name="submit_first" id="submit_gold" value=" " />
					</div>
					<div>
						<h4>Platinum</h4><input type="hidden" name="platinum_term" id="platinum_term" value="platinum" />
						<input class="term-submit" type="submit" name="submit_first" id="submit_platinum" value=" " />
					</div>
				</div> 
			</div>      


			<!-- clearfix --><div class="clear"></div><!-- /clearfix -->



			<!-- #second_step -->
			<div id="second_step">
				<h1>SIGN UP FOR A FREE <span>Congregation Link</span> ACCOUNT</h1>

				<div class="form">
					<input type="text" name="firstname" id="firstname" placeholder="first name" />
					<label for="firstname">Your First Name. </label>
					<input type="text" name="middlename" id="middlename" placeholder="middle name" />
					<label for="middlename">Your Middle Name. </label>                    
					<input type="text" name="lastname" id="lastname" placeholder="last name" />
					<label for="lastname">Your Last Name. </label>
				</div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->
				<input class="submit" type="submit" name="submit_second" id="submit_second" value="" />
			</div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->


			<!-- #third_step -->
			<div id="third_step">
				<h1>SIGN UP FOR A FREE <span>Congregation Link</span> ACCOUNT</h1>

				<div class="form">
					<input type="text" name="birthday" id="birthday" placeholder="date of birth" />
					<label for="email">Your Birthday. </label>   <!-- clearfix --><div class="clear"></div><!-- /clearfix -->

					<select id="gender" name="gender">
						<option>Male</option>
						<option>Female</option>
					</select>
					<label for="gender">Your Gender. </label> <!-- clearfix --><div class="clear"></div><!-- /clearfix -->

					<input type="text" name="email" id="email" placeholder="email address" />
					<label for="email">Your email address. We send important administration notices to this address. </label>   <!-- clearfix --><div class="clear"></div><!-- /clearfix -->
				</div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->
				<input class="submit" type="submit" name="submit_third" id="submit_third" value="" />

			</div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->


			<!-- #fourth_step -->
			<div id="fourth_step">
				<h1>SIGN UP FOR A FREE <span>Congregation Link</span> ACCOUNT</h1>

				<div class="form">
					<h2>Summary</h2>

					<table>
						<tr><td>Username</td><td></td></tr>
						<tr><td>Password</td><td></td></tr>
						<tr><td>Email</td><td></td></tr>
						<tr><td>Name</td><td></td></tr>
						<tr><td>Age</td><td></td></tr>
						<tr><td>Gender</td><td></td></tr>
					</table>
				</div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->
				<input class="send submit" type="submit" name="submit_fourth" id="submit_fourth" value=" " />            
			</div>

		</form>
	</div>
	<div id="progress_bar">
		<div id="progress"></div>
		<div id="progress_text">0% Complete</div>
	</div>
	
</body>
</html>