<?php
/*
 *********************************************************************************************************
 * daloRADIUS - RADIUS Web Platform
 * Copyright (C) 2007 - Liran Tal <liran@enginx.com> All Rights Reserved.
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 *********************************************************************************************************
 *
 * Authors:	Liran Tal <liran@enginx.com>
 *
 *********************************************************************************************************
 */
 
    include ("library/checklogin.php");
    $operator = $_SESSION['operator_user'];

	include('library/check_operator_perm.php');

	include 'library/opendb.php';

        isset($_POST['planNameOld']) ? $planNameOld = $_POST['planNameOld'] : $planNameOld = "";
        isset($_REQUEST['planName']) ? $planName = $_REQUEST['planName'] : $planName = "";
        isset($_POST['planId']) ? $planId = $_POST['planId'] : $planId = "";
        isset($_POST['planType']) ? $planType = $_POST['planType'] : $planType = "";
        isset($_POST['planTimeType']) ? $planTimeType = $_POST['planTimeType'] : $planTimeType = "";
        isset($_POST['planTimeBank']) ? $planTimeBank = $_POST['planTimeBank'] : $planTimeBank = "";
        isset($_POST['planBandwidthUp']) ? $planBandwidthUp = $_POST['planBandwidthUp'] : $planBandwidthUp = "";
        isset($_POST['planBandwidthDown']) ? $planBandwidthDown = $_POST['planBandwidthDown'] : $planBandwidthDown = "";
        isset($_POST['planTrafficTotal']) ? $planTrafficTotal = $_POST['planTrafficTotal'] : $planTrafficTotal = "";
        isset($_POST['planTrafficDown']) ? $planTrafficDown = $_POST['planTrafficDown'] : $planTrafficDown = "";
        isset($_POST['planTrafficUp']) ? $planTrafficUp = $_POST['planTrafficUp'] : $planTrafficUp = "";
        isset($_POST['planRecurring']) ? $planRecurring = $_POST['planRecurring'] : $planRecurring = "";
        isset($_POST['planRecurringPeriod']) ? $planRecurringPeriod = $_POST['planRecurringPeriod'] : $planRecurringPeriod = "";
        isset($_POST['planCost']) ? $planCost = $_POST['planCost'] : $planCost = "";
        isset($_POST['planSetupCost']) ? $planSetupCost = $_POST['planSetupCost'] : $planSetupCost = "";
        isset($_POST['planTax']) ? $planTax = $_POST['planTax'] : $planTax = "";
        isset($_POST['planCurrency']) ? $planCurrency = $_POST['planCurrency'] : $planCurrency = "";
        isset($_POST['planGroup']) ? $planGroup = $_POST['planGroup'] : $planGroup = "";

	$edit_planname = $planName; //feed the sidebar variables	

	$logAction = "";
	$logDebugSQL = "";

	if (isset($_POST['submit'])) {

		if (trim($planName) != "") {

			$currDate = date('Y-m-d H:i:s');
			$currBy = $_SESSION['operator_user'];

			$sql = "UPDATE ".$configValues['CONFIG_DB_TBL_DALOBILLINGPLANS']." SET ".
			" planName='".$dbSocket->escapeSimple($planName)."', ".
			" planId='".$dbSocket->escapeSimple($planId)."', ".
			" planType='".$dbSocket->escapeSimple($planType)."', ".
			" planTimeType='".$dbSocket->escapeSimple($planTimeType)."', ".
			" planTimeBank='".$dbSocket->escapeSimple($planTimeBank)."', ".
			" planBandwidthUp='".$dbSocket->escapeSimple($planBandwidthUp)."', ".
			" planBandwidthDown='".$dbSocket->escapeSimple($planBandwidthDown)."', ".
			" planTrafficTotal='".$dbSocket->escapeSimple($planTrafficTotal)."', ".
			" planTrafficDown='".$dbSocket->escapeSimple($planTrafficDown)."', ".
			" planTrafficUp='".$dbSocket->escapeSimple($planTrafficUp)."', ".
			" planRecurring='".$dbSocket->escapeSimple($planRecurring)."', ".
			" planRecurringPeriod='".$dbSocket->escapeSimple($planRecurringPeriod)."', ".
			" planCost='".$dbSocket->escapeSimple($planCost)."', ".
			" planSetupCost='".$dbSocket->escapeSimple($planSetupCost)."', ".
			" planTax='".$dbSocket->escapeSimple($planTax)."', ".
			" planCurrency='".$dbSocket->escapeSimple($planCurrency)."', ".
			" planGroup='".$dbSocket->escapeSimple($planGroup)."', ".
			" updatedate='$currDate', updateby='$currBy' ".
			" WHERE planName='".$dbSocket->escapeSimple($planNameOld)."'";
			$res = $dbSocket->query($sql);
			$logDebugSQL = "";
			$logDebugSQL .= $sql . "\n";
			
			$successMsg = "Updated billing plan settings for: <b> $planName </b>";
			$logAction .= "Successfully updated billing plan settings for hotspot [$planName] on page: ";
			
		} else {
			$failureMsg = "no billing plan name was entered, please specify a billing plan name to edit";
			$logAction .= "Failed updating billing plan settings for plan [$planName] on page: ";
		}
		
	}
	

	// fill-in username and password in the textboxes
	$sql = "SELECT * FROM ".$configValues['CONFIG_DB_TBL_DALOBILLINGPLANS']." WHERE planName='".$dbSocket->escapeSimple($planName)."'";
	$res = $dbSocket->query($sql);
	$logDebugSQL .= $sql . "\n";

	$row = $res->fetchRow(DB_FETCHMODE_ASSOC);
	$planName = $row['planName'];
	$planId = $row['planId'];
	$planType = $row['planType'];
	$planTimeType = $row['planTimeType'];
	$planTimeBank = $row['planTimeBank'];
	$planBandwidthUp = $row['planBandwidthUp'];
	$planBandwidthDown = $row['planBandwidthDown'];
	$planTrafficTotal = $row['planTrafficTotal'];
	$planTrafficDown = $row['planTrafficDown'];
	$planTrafficUp = $row['planTrafficUp'];
	$planRecurring = $row['planRecurring'];
	$planRecurringPeriod = $row['planRecurringPeriod'];
	$planCost = $row['planCost'];
	$planSetupCost = $row['planSetupCost'];
	$planTax = $row['planTax'];
	$planCurrency = $row['planCurrency'];
	$planGroup = $row['planGroup'];
	$creationdate = $row['creationdate'];
	$creationby = $row['creationby'];
	$updatedate = $row['updatedate'];
	$updateby = $row['updateby'];

	include 'library/closedb.php';

	if (trim($planName) == "") {
		$failureMsg = "no billing plan name was entered, please specify a billing plan name to edit</b>";
	}

	include_once('library/config_read.php');
	$log = "visited page: ";

	
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>daloRADIUS</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/1.css" type="text/css" media="screen,projection" />
</head>
<script src="library/javascript/pages_common.js" type="text/javascript"></script>
<?php
	include_once ("library/tabber/tab-layout.php");
?>
 
<?php
	include ("menu-bill-plans.php");
?>		
	<div id="contentnorightbar">
		
		<h2 id="Intro" onclick="javascript:toggleShowDiv('helpPage')"><?php echo $l['Intro']['billplansedit.php'] ?>
		:: <?php if (isset($planName)) { echo $planName; } ?><h144>+</h144></a></h2>

		<div id="helpPage" style="display:none;visibility:visible" >
			<?php echo $l['helpPage']['billplansedit'] ?>
			<br/>
		</div>
		<?php
			include_once('include/management/actionMessages.php');
		?>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="tabber">

	<div class="tabbertab" title="<?php echo $l['title']['PlanInfo']; ?>">


	<fieldset>

		<h302> <?php echo $l['title']['PlanInfo']; ?> </h302>
		<br/>

		<ul>

                <li class='fieldset'>
                <label for='name' class='form'><?php echo $l['all']['PlanName'] ?></label>
                <input name='planName' type='text' id='planName' value='<?php echo $planName ?>' tabindex=100 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planNameTooltip')" />

                <div id='planNameTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planNameTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planId' class='form'><?php echo $l['all']['PlanId'] ?></label>
                <input name='planId' type='text' id='planId' value='<?php echo $planId ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planIdTooltip')" />

                <div id='planIdTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planIdTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planType' class='form'><?php echo $l['all']['PlanType'] ?></label>
                <select class='form' tabindex=102 name='planType' >
			<option value='<?php echo $planType ?>'><?php echo $planType ?></option>
			<option value=''></option>
                        <option value='PayPal'>PayPal</option>
                        <option value='Prepaid'>Prepaid</option>
                        <option value='Postpaid'>Postpaid</option>
                </select>
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planTypeTooltip')" />

                <div id='planTypeTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planTypeTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planRecurring' class='form'><?php echo $l['all']['PlanRecurring'] ?></label>
                <input name='planRecurring' type='text' id='planRecurring' value='<?php echo $planRecurring ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planRecurringTooltip')" />

                <div id='planRecurringTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planRecurringTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planRecurringPeriod' class='form'><?php echo $l['all']['PlanRecurringPeriod'] ?></label>
                <input name='planRecurringPeriod' type='text' id='planRecurringPeriod' value='<?php echo $planRecurringPeriod ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planRecurringPeriodTooltip')" />

                <div id='planRecurringPeriodTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planRecurringPeriodTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planCost' class='form'><?php echo $l['all']['PlanCost'] ?></label>
                <input name='planCost' type='text' id='planCost' value='<?php echo $planCost ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planCostTooltip')" />

                <div id='planCostTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planCostTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planSetupCost' class='form'><?php echo $l['all']['PlanSetupCost'] ?></label>
                <input name='planSetupCost' type='text' id='planSetupCost' value='<?php echo $planSetupCost ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planSetupCostTooltip')" />

                <div id='planSetupCostTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planSetupCostTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planTax' class='form'><?php echo $l['all']['PlanTax'] ?></label>
                <input name='planTax' type='text' id='planTax' value='<?php echo $planTax ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planTaxTooltip')" />

                <div id='planTaxTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planTaxTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planCurrency' class='form'><?php echo $l['all']['PlanCurrency'] ?></label>
                <select class='form' tabindex=102 name='planCurrency' >
                        <option value='<?php echo $planCurrency ?>'><?php echo $planCurrency ?></option>
                        <option value=''></option>
                        <option value='USD'>USD</option>
                        <option value='EUR'>EUR</option>
                        <option value='GBP'>GBP</option>
                        <option value='CAD'>CAD</option>
                        <option value='JPY'>JPY</option>
                        <option value='AUD'>AUD</option>
                        <option value='NZD'>NZD</option>
                        <option value='CHF'>CHF</option>
                        <option value='HKD'>HKD</option>
                        <option value='SGD'>SGD</option>
                        <option value='SEK'>SEK</option>
                        <option value='DKK'>DKK</option>
                        <option value='PLN'>PLN</option>
                        <option value='NOK'>NOK</option>
                        <option value='HUF'>HUF</option>
                        <option value='CZK'>CZK</option>
                        <option value='ILS'>ILS</option>
                        <option value='MXN'>MXN</option>
                </select>
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planCurrencyTooltip')" />

                <div id='planCurrencyTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planCurrencyTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planGroup' class='form'><?php echo $l['all']['PlanGroup'] ?></label>
                <input name='planGroup' type='text' id='planGroup' value='<?php echo $planGroup ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planGroupTooltip')" />

                <div id='planGroupTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planGroupTooltip'] ?>
                </div>
                </li>



			<li class='fieldset'>
			<br/>
			<hr><br/>
			<input type='submit' name='submit' value='<?php echo $l['buttons']['apply'] ?>' tabindex=10000
				class='button' />
			</li>

		</ul>

	</fieldset>
	</div>

        <div class="tabbertab" title="<?php echo $l['title']['TimeSettings']; ?>">
        <fieldset>

                <h302> <?php echo $l['title']['PlanInfo']; ?> </h302>
                <br/>

                <ul>

                <li class='fieldset'>
                <label for='planTimeType' class='form'><?php echo $l['all']['PlanTimeType'] ?></label>
                <select class='form' tabindex=102 name='planTimeType' >
			<option value='<?php echo $planTimeType ?>'><?php echo $planTimeType ?></option>
			<option value=''></option>
                        <option value='Accumulative'>Accumulative</option>
                        <option value='Time-To-Finish'>Time-To-Finish</option>
                </select>
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planTimeTypeTooltip')" />

                <div id='planTimeTypeTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planTimeTypeTooltip'] ?>
                </div>
                </li>


                <li class='fieldset'>
                <label for='planTimeBank' class='form'><?php echo $l['all']['PlanTimeBank'] ?></label>
                <input name='planTimeBank' type='text' id='planTimeBank' value='<?php echo $planTimeBank ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planTimeBankTooltip')" />

                <div id='planTimeBankTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planTimeBankTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <br/>
                <hr><br/>
                <input type='submit' name='submit' value='<?php echo $l['buttons']['apply'] ?>' tabindex=10000 class='button' />
                </li>

                </ul>

        </fieldset>
        </div>


        <div class="tabbertab" title="<?php echo $l['title']['BandwidthSettings']; ?>">
        <fieldset>

                <h302> <?php echo $l['title']['PlanInfo']; ?> </h302>
                <br/>

                <ul>

                <li class='fieldset'>
                <label for='planBandwidthUp' class='form'><?php echo $l['all']['PlanBandwidthUp'] ?></label>
                <input name='planBandwidthUp' type='text' id='planBandwidthUp' value='<?php echo $planBandwidthUp ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planBandwidthUpTooltip')" />

                <div id='planBandwidthUpTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planBandwidthUpTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planBandwidthDown' class='form'><?php echo $l['all']['PlanBandwidthDown'] ?></label>
                <input name='planBandwidthDown' type='text' id='planBandwidthDown' value='<?php echo $planBandwidthDown ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planBandwidthDownTooltip')" />

                <div id='planBandwidthDownTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planBandwidthDownTooltip'] ?>
                </div>
                </li>



                <li class='fieldset'>
                <label for='planTrafficTotal' class='form'><?php echo $l['all']['PlanTrafficTotal'] ?></label>
                <input name='planTrafficTotal' type='text' id='planTrafficTotal' value='<?php echo $planTrafficTotal ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planTrafficTotalTooltip')" />

                <div id='planTrafficTotalTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planTrafficTotalTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <label for='planTrafficDown' class='form'><?php echo $l['all']['PlanTrafficDown'] ?></label>
                <input name='planTrafficDown' type='text' id='planTrafficDown' value='<?php echo $planTrafficDown ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planTrafficDownTooltip')" />

                <div id='planTrafficDownTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planTrafficDownTooltip'] ?>
                </div>
                </li>



                <li class='fieldset'>
                <label for='planTrafficUp' class='form'><?php echo $l['all']['PlanTrafficUp'] ?></label>
                <input name='planTrafficUp' type='text' id='planTrafficUp' value='<?php echo $planTrafficUp ?>' tabindex=101 />
                <img src='images/icons/comment.png' alt='Tip' border='0' onClick="javascript:toggleShowDiv('planTrafficUpTooltip')" />

                <div id='planTrafficUpTooltip'  style='display:none;visibility:visible' class='ToolTip'>
                        <img src='images/icons/comment.png' alt='Tip' border='0' />
                        <?php echo $l['Tooltip']['planTrafficUpTooltip'] ?>
                </div>
                </li>

                <li class='fieldset'>
                <br/>
                <hr><br/>
                <input type='submit' name='submit' value='<?php echo $l['buttons']['apply'] ?>' tabindex=10000 class='button' />
                </li>

                </ul>

        </fieldset>
        </div>

	<input type=hidden value="<?php echo $planName ?>" name="planNameOld"/>

</div>

		</form>

<?php
	include('include/config/logging.php');
?>

		</div>

		<div id="footer">

<?php
	include 'page-footer.php';
?>


		</div>

</div>
</div>


</body>
</html>
