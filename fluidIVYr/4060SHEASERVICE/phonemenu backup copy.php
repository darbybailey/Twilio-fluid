<?php

// @start snippet
/* Define Menu */
$web = array();
$web['default'] = array('receptionist','status','schedule','hours','dispatch','general');
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
		<Play>sheaservice_hours.mp3</Play>

		<?php break;

	case 'status': ?>
		<Play>sheaservice_status.mp3</Play>
		<Dial>3859994057</Dial>

		<?php break;

	case 'schedule': ?>
		<Play>sheaservice_scheduling.mp3</Play>
		<Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=location'; ?>" numDigits="1">
			<Play>sheaservice_scheduling_new.mp3</Play>
			<Play>sheaservice_scheduling_returning.mp3</Play>
		</Gather>


		<?php break;
	case 'new': ?>
		<Play>sheaservice_scheduling_new_message.mp3</Play>
		<Dial>3859994058</Dial>

		<?php break;
	case 'return': ?>
		<Play>sheaservice_scheduling_returning_message.mp3</Play>
		<Dial>3859994059</Dial>

		<?php break;
	case 'receptionist'; ?>
	<Play>sheaservice_receptionist.mp3</Play>
	<Redirect><?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php' ?></Redirect>

		<?php break;
	case 'dispatch'; ?>
		<Play>sheaservice_emergency_dispatch.mp3 </Play>
		<Sms> Shea Service Status auto responder from EMERGENCY DISPATCH mailbox 4066 </Sms>
		<Dial>3859994066</Dial>


		<?php break;
	case 'general'; ?>
		<Play>sheaservice_generalmailbox.mp3</Play>
		<Sms> Shea Service Status auto responder from general mailbox 4060 </Sms>
		<Record> timeout=“10” transcribe=“true” </Record>


		<?php break;
	default: ?>
		<Gather action="<?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php?node=default'; ?>" numDigits="1">
			<Play>sheaservice_welcome.mp3</Play>
			<Play>sheaservice_menu_status1.mp3</Play>
			<Play>sheaservice_menu_repair2.mp3</Play>
			<Play>sheaservice_menu_hours3.mp3</Play>
			<Play>sheaservice_menu_dispatch4.mp3</Play>
			<Play>sheaservice_menu_general5.mp3</Play>
		</Gather>
		<?php
		break;
}
// @end snippet

// @start snippet
if($destination && $destination != 'receptionist') { ?>
	<Pause/>
	<Play>sheaservice_default_mainmenu.mp3</Play>
	<Redirect><?php echo 'http://' . dirname($_SERVER["SERVER_NAME"] .  $_SERVER['PHP_SELF']) . '/phonemenu.php' ?></Redirect>
<?php }
// @end snippet

?>

</Response>
