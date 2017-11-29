<?php
/**
 * Template Name: LEW Calculator
 */
require __DIR__ . '/lew/lew-process.php';
$startDate = getPageVar('startDate');
$endDate = getPageVar('endDate');
$setAddress = getPageVar('setAddress');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rainfall Erosivity Factor Calculator for Small Construction Sites | NPDES | US EPA</title>
<link rel="stylesheet" href="https://www.epa.gov/sites/all/libraries/template/s.css" media="all"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <style>
        #lew-climate-data {
            display: none;
        }
    </style>
</head>
<body>
<section id="main-content" class="main-content clearfix" lang="en" role="main" tabindex="-1">
    <div class="pane-content">
        <?php echo $processing; ?>

        <!--<form id="LEWform" name="lewform" action="https://developer.epa.gov/lew-calculator/" method="post">-->
        <form id="LEWform" name="lewform" action="#" method="post">
            <input type="hidden" name="method" id="method">
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">
            <input type="hidden" name="setAddress" id="setAddress">

            <p><strong>Select a construction period</strong></p>
            <div class="row cols-2">
                <div class="col">
                    <ul style="list-style: none;">
                        <li><label for="projStartDate">Start Date: </label><span style="vertical-align:bottom"><input
                                        class="text" type="text" id="projStartDate" name="startDate" size="10"
                                        maxlength="10"><span></li>
                    </ul>
                    <span class="caption">&nbsp;&nbsp;&nbsp;(Format: mm/dd/yyyy)</span>
                </div>
                <div class="col">
                    <ul style="list-style: none;">
                        <li><label for="projEndDate">End Date: </label><input type="text" id="projEndDate"
                                                                              name="endDate" size="10" maxlength="10">
                        </li>
                    </ul>
                    <span class="caption">&nbsp;&nbsp;&nbsp;(Format: mm/dd/yyyy)</span>
                </div>
            </div>
            <br>
            <p>The start date is the date of initial earth disturbance. The end date is the date of final site
                stabilization.</p>
            <p class="caption"><strong>NOTE: If your construction project extends beyond the estimated end date, you
                    will need to either recalculate the R factor based on a new end date, or apply for NPDES permit
                    coverage.</strong></p>

            <br>

            <input type="radio" id="method1" name="faciMethod" value="0" onClick="javascript:clearAddress();">
            <label for="method1" style="display:inline"><strong>Please enter the Latitude/Longitude information of the
                    project/site.</strong></label>
            <p class="caption"><strong><span class="warning">(Do not enter negative numbers)</span></strong></p>

            <div class="row cols-2" style="margin:0px; margin-left:20px;">
                <div class="col">
                    <input type="radio" name="LatLong" value="0">&nbsp;&nbsp;<label for="LatitudeA">Latitude</label>
                    <input type="Text" name="LatitudeA" id="LatitudeA" size="2" maxlength="2">
                    <label for="LatitudeA">&deg;</label>
                    <input type="Text" name="LatitudeB" id="LatitudeB" size="2" maxlength="2">
                    <label for="LatitudeB">'</label>
                    <input type="Text" name="LatitudeC" id="LatitudeC" size="2" maxlength="2">
                    <label for="LatitudeC">"</label> N
                    <p class="caption">(Degrees/Minutes/Seconds)</p>
                </div>
                <div class="col">
                    <label for="LongitudeA">Longitude</label>:
                    <input type="Text" name="LongitudeA" id="LongitudeA" size="3" maxlength="3">
                    <label for="LongitudeA">&deg;</label>
                    <input type="Text" name="LongitudeB" id="LongitudeB" size="2" maxlength="2">
                    <label for="LongitudeB">'</label>
                    <input type="Text" name="LongitudeC" id="LongitudeC" size="2" maxlength="2">
                    <label for="LongitudeC">"</label> W
                    <p class="caption">(Degrees/Minutes/Seconds)</p>
                </div>
            </div>
            <div class="row cols-2" style="margin:0px; margin-left:20px;">
                <div class="col">
                    <input type="radio" name="LatLong" value="1">&nbsp;&nbsp;<label for="LatitudeE">Latitude</label>
                    <input type="Text" name="LatitudeE" id="LatitudeE" size="2" maxlength="2">
                    <label for="LatitudeE">&deg;</label>
                    <input type="Text" name="LatitudeF" id="LatitudeF" size="2" maxlength="2">
                    <label for="LatitudeF">.</label>
                    <input type="Text" name="LatitudeG" id="LatitudeG" size="2" maxlength="2">
                    <label for="LatitudeG">'</label> N
                    <p class="caption">(Degrees/Minutes.Decimal Minutes)</p>
                </div>
                <div class="col">
                    <label for="LongitudeE">Longitude</label>:
                    <input type="Text" name="LongitudeE" id="LongitudeE" size="3" maxlength="3">
                    <label for="LongitudeE">&deg;</label>
                    <input type="Text" name="LongitudeF" id="LongitudeF" size="2" maxlength="2">
                    <label for="LongitudeF">.</label>
                    <input type="Text" name="LongitudeG" id="LongitudeG" size="2" maxlength="2">
                    <label for="LongitudeG">'</label> W
                    <p class="caption">(Degrees/Minutes.Decimal Minutes)</p>
                </div>
            </div>
            <div class="row cols-2" style="margin:0px; margin-left:20px;">
                <div class="col">
                    <input type="radio" name="LatLong" id="LatLong" value="2">&nbsp;&nbsp;<label for="decimalLatA">Latitude</label>
                    <input type="Text" name="decimalLatA" id="decimalLatA" size="2" maxlength="2">
                    <label for="decimalLatA">.</label>
                    <input type="Text" name="decimalLatB" id="decimalLatB" size="4" maxlength="4">
                    <label for="decimalLatB">&deg;</label> N
                    <p class="caption">(Decimals)</p>
                </div>
                <div class="col">
                    <label for="decimalLongC">Longitude</label>:
                    <input type="Text" name="decimalLongC" id="decimalLongC" size="3" maxlength="3">
                    <label for="decimalLongC">.</label>
                    <input type="Text" name="decimalLongD" id="decimalLongD" size="4" maxlength="4">
                    <label for="decimalLongD">&deg;</label> W
                    <p class="caption">(Decimals)</p>
                </div>
            </div>

            <br>

            <input type="radio" id="method2" name="faciMethod" value="1" onClick="javascript:clearLatLng();">
            <label for="method2" style="display:inline"><strong>If you do NOT have the Latitude/Longitude information,
                    please enter the project/site address.</strong></label><br><br>
            <div class="row cols-2">
                <div class="col">
                    <ul style="list-style: none;">
                        <li><label for="address">Address:</label></li>
                    </ul>
                </div>
                <div class="col">
                    <ul style="list-style: none;">
                        <li><input type="text" name="address" id="address" size="40" maxlength="100"
                                   onClick="clearLatLng();javascript:checkRadioButton('faciMethod','1','address');">
                        </li>
                    </ul>
                </div>
                <div style="padding:1em;"><input type="button" value="Submit" onClick="javascript:submit_form();"></div>
            </div>
        </form>

        <div id="dataOutput">
            <div id="startDate"><?php echo safeOutput($startDate); ?></div>
            <div id="endDate"><?php echo safeOutput($endDate); ?></div>
            <div id="results"></div>
        </div>
    </div>
</section>

<script src="https://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyCfTaAcLEzUqr6tDWvze3yfURMn_XlnK28"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<div id="lew-climate-data">
    <?php echo $climateData; ?>
</div>

<script>
    var validLocation = <?php echo safeJsOutput($validLocation); ?>;
    var submitForm = <?php echo safeJsOutput($submitForm); ?>;
    var getCodeMethod = <?php echo safeJsOutput($geoCodeMethod); ?>;
    var faciLat = <?php echo safeJsOutput($faciLat); ?>;
    var faciLat4 = <?php echo safeJsOutput(number_format($faciLat,4)); ?>;
    var faciLng = <?php echo safeJsOutput($faciLng); ?>;
    var faciLng4 = <?php echo safeJsOutput(number_format($faciLng,4)); ?>;
    var setAddress = <?php echo safeJsOutput($setAddress); ?>;
</script>
<script src="/lew-calculator/wp-content/themes/benjamin/page-templates/lew/lew-scripts.js"></script>
</body>
</html>
