<?php

// @start snippet
/* Define Menu */
$web = array();
$web['default'] = array('receptionist','status','schedule', 'hours', 'dispatch','general');
$web['location'] = array('receptionist','new','return');


/* Get the menu node, index, and url */
$node = $_REQUEST['node'];
$index = (int) $_REQUEST['Digits'];
$url = 'http://'.dirname($_SERVER["SERVER_NAME"].$_SERVER['PHP_SELF']).'/phonemenu.php';

/* Check to make sure index is valid */
if(isset($web[$node]) || count($web[$node]) >= $index && !is_null($_REQUEST['Digits']))
	$destination = $web[$node][$index];
else
	$destination = NULL;
// @end snippet

// @start snippet
/* Render TwiML */
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Response>\n";
switch($destination) {

	case 'hours': ?>
		<Say>Shea Service is located at five thirty two South four hundred West, in Downtown Salt Lake City. We are open Monday through Friday, from 10am to 5pm. We are closed on weekends.</Say>

		<?php break;

	case 'status': ?>
		<Say>Shea Service Order Status. Please leave your first and last name or the name of your business, and a phone number, and we will call you with the status of your order within 24 hours.</Say>
		<Dial>3859994057</Dial>

		<?php break;

	case 'schedule': ?>
		<Say>Shea Service Scheduling</Say>
		<Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=location'; ?>" numDigits="1">
			<Say>For new customers, press 1</Say>
			<Say>For returning customers, press 2</Say>
		</Gather>

		<?php break;
	case 'new': ?>
		<Say>New Customer Scheduling. The Shea Service level one maintenance package includes one hour of service, a baseline diagnostic, cleaning, adjustment and lube, which will tell us the nature of any repairs needed. If your machine needs more than one hour of service we will call you to discuss further estimates and repairs. Our level one maintenance package is eighty nine dollars. Our machine drop off hours are Monday through Friday from 10am to 4pm. We are located at five thirty two South four hundred West, in Downtown Salt Lake City. If you have questions about on-site repairs, please leave your first and last name or the name of your business and we will return your call within 24 hours.</Say>
		<Dial>3859994058</Dial>

		<?php break;
	case 'return': ?>
		<Say>Return Customer Scheduling. For a Level one diagnostic, which includes one hour of service, a baseline diagnostic, cleaning, adjustment and lube, which will tell us the nature of any repairs needed, or if you know your machine needs more than one hour of service with more advanced repairs, or if you have questions, please leave your first and last name or the name of your business and we will return your call within 12 hours.</Say>
		<Dial>3859994059</Dial>

		<?php break;
	case 'receptionist'; ?>
	<Say>We apologize. Our reception desk is currently unavailable. Main Menu.</Say>
	<Redirect><?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php' ?></Redirect>

		<?php break;
	case 'dispatch'; ?>
		<Say>Emergency Dispatch. To have a repair tech dispatched for an emergency, please leave your first and last name and name of business and your phone number and we will return your call within two hours. </Say>
		<Sms> Shea Service Status auto responder from DISPATCH mailbox 4066 </Sms>
		<Dial>3859994066</Dial>


		<?php break;
	case 'general'; ?>
		<Say>The Shea Service general mailbox. Please leave your first and last name, or name of your business, and your telephone number and message and we will return your call within 24 hours. </Say>
		<Sms> Shea Service Status auto responder from general mailbox 4060 </Sms>
		<Record> timeout=“10” transcribe=“false” </Record>

		<?php break;
	default: ?>
		<Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=default'; ?>" numDigits="1">
			<Say>Thanks for calling Shea Service, future home of FLUID Coffee and Beverage Goods.</Say>
			<Say>For the status of an order, press 1</Say>
			<Say>To schedule a repair, press 2</Say>
			<Say>For our hours and location, press 3</Say>
			<Say>For Emergency service dispatch, press 4</Say>
			<Say>To leave a message in the general mailbox, press 5</Say>
		</Gather>
		<?php
		break;
}
// @end snippet

// @start snippet
if($destination && $destination != 'receptionist') { ?>
	<Pause/>
	<Say>Main Menu</Say>
	<Redirect><?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php' ?></Redirect>
<?php }
// @end snippet

?>

</Response>
