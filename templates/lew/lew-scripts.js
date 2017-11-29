$('html,body').css('background-color', 'white');
$('label').css('display', 'inline');
$('#dataOutput').hide();
$('#projStartDate,#projEndDate').datepicker();
$('[id*=Lat],[id*=Long]').click(function () {
        this.select();
    }
);
$('[id*=Lat],[id*=Long],[for*=Lat],[for*=Long]').mousedown(function () {
        checkRadioButton('faciMethod', '0');
        var latLongMethod = $(this).parent().parent().find('[name=LatLong]').val();
        checkRadioButton('LatLong', latLongMethod);
        clearAddress();
    }
);
var submitForm = 0 + submitForm;
if (submitForm == 1) {
    $('obj, #processing').hide();
    var validLocation = 0 + validLocation;
    if (validLocation == 1) {
        var setDate = [document.getElementById('startDate').innerHTML + '', document.getElementById('endDate').innerHTML + ''];
        var setMonth = [Number(setDate[0].substring(0, setDate[0].indexOf('/'))) - 1, Number(setDate[1].substring(0, setDate[1].indexOf('/'))) - 1];
        var setDay = [Number(setDate[0].substring(setDate[0].indexOf('/') + 1, setDate[0].lastIndexOf('/'))), Number(setDate[1].substring(setDate[1].indexOf('/') + 1, setDate[1].lastIndexOf('/')))];
        var setYear = [Number(setDate[0].substring(setDate[0].lastIndexOf('/') + 1)), Number(setDate[1].substring(setDate[1].lastIndexOf('/') + 1))];
        var monthDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        var dayIndex = setDay;
        for (b = 0; b < setMonth.length; b ++) {
            for (c = 0; c < setMonth[b]; c ++) {
                dayIndex[b] = dayIndex[b] + monthDays[c];
            }
        }

        var climateData = document.getElementsByTagName('calc')[1].firstChild.nodeValue;
        // console.warn('...','climateData',climateData);
        var dailyEIIndex = 0;
        var dailyEIData = [];
        for (i = 0; i < climateData.length; i ++) {
            if (climateData.charCodeAt(i) == 10 | climateData.charCodeAt(i) == 32) {
                dailyEIIndex ++;
                var dailyCapture = false;
                for (j = 1; j < climateData.length - i; j ++) {
                    if (climateData.charCodeAt(i + j) > 44 && climateData.charCodeAt(i + j) < 58 && dailyCapture == false || climateData.charCodeAt(i + j) == 101 && dailyCapture == false) {
                        if (j == 1) {
                            dailyEIData[dailyEIIndex] = climateData.charAt(i + j);
                        }
                        else {
                            dailyEIData[dailyEIIndex] = dailyEIData[dailyEIIndex] + climateData.charAt(i + j);
                        }
                    }
                    else {
                        dailyCapture = true;
                    }
                }
            }
        }

        var rFactor = 0;
        if (setYear[1] > setYear[0]) {
            dayIndex[1] = dayIndex[1] + 365 * (setYear[1] - setYear[0]);
        }
        for (p = dayIndex[0]; p < dayIndex[1] + 1; p ++) {
            if (p % 365 == 0) {
                rFactor = rFactor + Number(dailyEIData[365]);
            }
            else {
                rFactor = rFactor + Number(dailyEIData[p - 365 * Math.floor(p / 365)]);
            }
        }

        if (rFactor < 10) {
            rFactor = rFactor.toPrecision(3);
        }
        else if (rFactor >= 10 && rFactor < 99) {
            rFactor = rFactor.toPrecision(4);
        }
        else {
            rFactor = Math.round(rFactor);
        }
        $('#startDate,#endDate,#climateData').hide();
        $('#dataOutput').show();

        var geoCodeMethod = 0 + getCodeMethod;
        // console.warn('.........','InnerHTML',0);
        if (geoCodeMethod == 1) {
            // console.warn('.........','InnerHTML',1);
            document.getElementById('results').innerHTML = '<h2>Facility Information</h2><ul><li>Start Date: ' + document.getElementById('startDate').innerHTML + '</li><li>End Date: ' + document.getElementById('endDate').innerHTML + '</li><li>Address: ' + setAddress + '</li><li>Latitude: ' + faciLat4 + '</li><li>Longitude: ' + faciLng4 + '</li></ul><h2>Erosivity Index Calculator Results</h2><p>An erosivity index value Of <strong style="color:#FF0000">' + rFactor + '</strong> has been determined for the construction period of <strong>' + setDate[0] + '</strong> - <strong>' + setDate[1] + '</strong>.</p>';
        } else {
            // console.warn('.........','InnerHTML',2);
            document.getElementById('results').innerHTML = '<h2>Facility Information</h2><ul><li>Start Date: ' + document.getElementById('startDate').innerHTML + '</li><li>End Date: ' + document.getElementById('endDate').innerHTML + '</li><li>Latitude: ' + faciLat + '</li><li>Longitude: ' + faciLng + '</li></ul><h2>Erosivity Index Calculator Results</h2><p>An erosivity index value Of <span class="warning"><strong>' + rFactor + '</strong></span> has been determined for the construction period of <strong>' + setDate[0] + '</strong> - <strong>' + setDate[1] + '</strong>.</p>';
        }

        // console.warn('.........','InnerHTML',3)
        if (rFactor < 5) {
            // console.warn('.........','InnerHTML',4)
            document.getElementById('results').innerHTML = document.getElementById('results').innerHTML + '<p>A rainfall erosivity factor of less than 5.0 has been calculated for your site and period of construction. Contact your permitting authority to determine if you are eligible for a waiver from NPDES permitting requirements. If you are covered under EPA&apos;s <a href="http://www.epa.gov/npdes/stormwater-discharges-construction-activities#cgp">construction general permit</a> then you can use eNOI to submit your low erosivity waiver certification.<br/><br/>If your construction activity extends past the project completion date you specified above, you must recalculate the R factor using the original start date and a new project completion date. If the recalculated R factor is still less than 5.0, a new waiver certification form must be submitted before the end of the original construction period. If the new R factor is 5.0 or greater, the operator must submit a Notice of Intent to be covered by the Construction General Permit before the original project completion date.</p>';
        } else {
            // console.warn('.........','InnerHTML',5)
            document.getElementById('results').innerHTML = document.getElementById('results').innerHTML + '<p>A rainfall erosivity factor of 5.0 or greater has been calculated for your site and period of construction. <strong>You do NOT qualify for a waiver from NPDES permitting requirements</strong>.</p>';
        }
    } else {
        // console.warn('.........','InnerHTML',6)
        $('#dataOutput').show();
        $('#startDate,#endDate,#climateData').hide();
        document.getElementById('results').innerHTML = '<p><strong>The Low Erosivity Waiver calculator could not calculate an R factor value for your location. You can use the <a href="http://www.epa.gov/sites/production/files/2015-10/documents/fact3-1.pdf">Construction Rainfall Erosivity Waiver fact sheet</a> to try to calculate an R factor for your location.</strong></p>';
    }
    $('#LEWform').hide();
    document.getElementById('results').innerHTML = document.getElementById('results').innerHTML + '<br /><button id="reset">Start Over</button>';
}

$('#reset').click(function () {
        $('#LEWform').show();
        $('#dataOutput').hide();
        $('#startDate,#endDate,#results').empty();
    }
);

function validate_form () {

    var errorMsg = "";
    var temp = "";
    var startDtValid = true;
    var endDtValid = true;
    var isValid = true;
    var method = - 1;
    /*
     // to validate the facility name
     var projName = trim(document.getElementById("projName").value);
     if(projName.length<1)
     {
     errorMsg += "Please enter the name of you facility! \n";
     }
     */

    // to validate the project start date
    var startDt = trim(document.getElementById("projStartDate").value);
    //alert("Start Date:" + startDt);
    if (startDt.length < 1) {
        startDtValid = false;
        errorMsg += "Please enter the start date of the construction! \n";
    }
    else {
        temp = isValidDate(startDt, "Start Date");
        if (temp != "") {
            startDtValid = false;
            errorMsg += temp;
        }
    }
    // to validate the project end date
    var endDt = trim(document.getElementById("projEndDate").value);
    //alert("End Date:" + endDt);
    if (endDt.length < 1) {
        endDtValid = false;
        errorMsg += "Please enter the end date of the construction! \n";
    }
    else {
        temp = isValidDate(endDt, "End Date");
        if (temp != "") {
            endDtValid = false;
            errorMsg += temp;
        }
    }

    if (startDtValid && endDtValid) {
        if (! compareTwoDates(startDt, endDt)) {
            isValid = false;
            errorMsg += "The Start Date should NOT be later than the End Date! \n";
        }
    }
    else {
        isValid = false;
    }


    for (var i = 0; i < document.lewform.faciMethod.length; i ++) {
        if (document.lewform.faciMethod[i].checked) {
            method = document.lewform.faciMethod[i].value;
            break;
        }
    }
    if (method == - 1) {
        errorMsg += "Please select whether you have the Latitude/Longitude information or not! \n";
        isValid = false;
    }
    else if (method == 0) {
        var latLngMethod = - 1;
        for (var j = 0; j < document.lewform.LatLong.length; j ++) {
            if (document.lewform.LatLong[j].checked) {
                latLngMethod = document.lewform.LatLong[j].value;
                break;
            }
        }

        if (latLngMethod == - 1) {
            errorMsg += "Please select a format of the latitude and longtitude! \n";
            isValid = false;
        }
        else if (latLngMethod == 0) {
            var latA = trim(document.lewform.LatitudeA.value);
            var latB = trim(document.lewform.LatitudeB.value);
            var latC = trim(document.lewform.LatitudeC.value);
            var lngA = trim(document.lewform.LongitudeA.value);
            var lngB = trim(document.lewform.LongitudeB.value);
            var lngC = trim(document.lewform.LongitudeC.value);

            // latitude degree validation
            if (latA == "") {
                errorMsg += "The degree of the latitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(latA)) {
                errorMsg += "The format of the latitude degree is incorrect! \n";
                isValid = false;
            }

            // latitude minute validation
            if (latB == "") {
                errorMsg += "The minute of the latitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(latB)) {
                errorMsg += "The format of the latitude minute is incorrect! \n";
                isValid = false;
            }
            else if (parseInt(latB) < 0 || parseInt(latB) > 59) {
                errorMsg += "The minute of the latitude should be between 0 and 59! \n";
                isValid = false;
            }

            // latitude second validation
            if (latC == "") {
                errorMsg += "The second of the latitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(latC)) {
                errorMsg += "The format of the latitude second is incorrect! \n";
                isValid = false;
            }
            else if (parseInt(latC) < 0 || parseInt(latC) > 59) {
                errorMsg += "The second the of the latitude should be between 0 and 59! \n";
                isValid = false;
            }

            // longitude degree validation
            if (lngA == "") {
                errorMsg += "The degree of the longitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(lngA)) {
                errorMsg += "The format of the longitude degree is incorrect! \n";
                isValid = false;
            }

            // longitude minute validation
            if (lngB == "") {
                errorMsg += "The minute of the longitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(lngB)) {
                errorMsg += "The format of the longitude minute is incorrect! \n";
                isValid = false;
            }
            else if (parseInt(lngB) < 0 || parseInt(lngB) > 59) {
                errorMsg += "The minute of the longitude should be between 0 and 59! \n";
                isValid = false;
            }

            // longitude second validation
            if (lngC == "") {
                errorMsg += "The second of the longitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(lngC)) {
                errorMsg += "The format of the longitude second is incorrect! \n";
                isValid = false;
            }
            else if (parseInt(lngC) < 0 || parseInt(lngC) > 59) {
                errorMsg += "The second the of the longitude should be between 0 and 59! \n";
                isValid = false;
            }
        }
        else if (latLngMethod == 1) {
            var latE = trim(document.lewform.LatitudeE.value);
            var latF = trim(document.lewform.LatitudeF.value);
            var latG = trim(document.lewform.LatitudeG.value);
            var lngE = trim(document.lewform.LongitudeE.value);
            var lngF = trim(document.lewform.LongitudeF.value);

            var lngG = trim(document.lewform.LongitudeG.value);

            // latitude degree validation
            if (latE == "") {
                errorMsg += "The degree of the latitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(latE)) {
                errorMsg += "The format of the latitude degree is incorrect! \n";
                isValid = false;
            }

            // latitude minute validation
            if (latF == "") {
                errorMsg += "The minute of the latitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(latF)) {
                errorMsg += "The format of the latitude minute is incorrect! \n";
                isValid = false;
            }
            else if (parseInt(latF) < 0 || parseInt(latF) > 59) {
                errorMsg += "The minute of the latitude should be between 0 and 59! \n";
                isValid = false;
            }

            // latitude decimal minute validation
            if (latG == "") {
                errorMsg += "The decimal minute of the latitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(latG)) {
                errorMsg += "The format of the latitude decimal minute is incorrect! \n";
                isValid = false;
            }
            else if (parseInt(latG) < 0 || parseInt(latG) > 99) {
                errorMsg += "The decimal minute the of the latitude should be between 0 and 99! \n";
                isValid = false;
            }

            // longitude degree validation
            if (lngE == "") {
                errorMsg += "The degree of the longitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(lngE)) {
                errorMsg += "The format of the longitude degree is incorrect! \n";
                isValid = false;
            }

            // longitude minute validation
            if (lngF == "") {
                errorMsg += "The minute of the longitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(lngF)) {
                errorMsg += "The format of the longitude minute is incorrect! \n";
                isValid = false;
            }
            else if (parseInt(lngF) < 0 || parseInt(lngF) > 59) {
                errorMsg += "The minute of the longitude should be between 0 and 59! \n";
                isValid = false;
            }

            // longitude second validation
            if (lngG == "") {
                errorMsg += "The decimal minute of the longitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(lngG)) {
                errorMsg += "The format of the longitude decimal minute is incorrect! \n";
                isValid = false;
            }
            else if (parseInt(lngG) < 0 || parseInt(lngG) > 99) {
                errorMsg += "The decimal minute the of the longitude should be between 0 and 99! \n";
                isValid = false;
            }
        }
        else if (latLngMethod == 2) {
            var decLatA = trim(document.lewform.decimalLatA.value);
            var decLatB = trim(document.lewform.decimalLatB.value);
            var decLngC = trim(document.lewform.decimalLongC.value);
            var decLngD = trim(document.lewform.decimalLongD.value);

            // latitude degree validation
            if (decLatA == "") {
                errorMsg += "The degree of the latitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(decLatA)) {
                errorMsg += "The format of the latitude degree is incorrect! \n";
                isValid = false;
            }

            // latitude decimal validation
            if (decLatB == "") {
                errorMsg += "The latitude decimal is required! \n";
                isValid = false;
            }
            else if (! isInteger(decLatB)) {
                errorMsg += "The format of the latitude decimal is incorrect! \n";
                isValid = false;
            }
            else if (parseInt(decLatB) < 0 || parseInt(decLatB) > 9999) {
                errorMsg += "The latitude decimal should be between 0 and 9999! \n";
                isValid = false;
            }

            // longitude degree validation
            if (decLngC == "") {
                errorMsg += "The degree of the longitude is required! \n";
                isValid = false;
            }
            else if (! isInteger(decLngC)) {
                errorMsg += "The format of the longitude degree is incorrect! \n";
                isValid = false;
            }

            // latitude decimal validation
            if (decLngD == "") {
                errorMsg += "The longitude decimal is required! \n";
                isValid = false;
            }
            else if (! isInteger(decLngD)) {
                errorMsg += "The format of the longitude decimal is incorrect! \n";
                isValid = false;
            }
            else if (parseInt(decLngD) < 0 || parseInt(decLngD) > 9999) {
                errorMsg += "The longitude decimal should be between 0 and 9999! \n";
                isValid = false;
            }
        }
    }
    else if (method == 1) {
        var address1 = trim(document.getElementById("address").value);

        if (address1 == "") {
            errorMsg += "Please enter the address of the facility! \n";
            isValid = false;
        }

    }


    if (! isValid) {
        alert(errorMsg);
    }
    return isValid;


}

function submit_form () {

    if (validate_form()) {
        var method = - 1;
        for (var i = 0; i < document.lewform.faciMethod.length; i ++) {
            if (document.lewform.faciMethod[i].checked) {
                method = document.lewform.faciMethod[i].value;
                break;
            }
        }
        if (method == 0) {
            document.lewform.submit();
        }
        else if (method == 1) {
            var address = trim(document.getElementById("address").value);
            document.getElementById("setAddress").value = address;
            getLatLong(address);
        }

        // if user enter address, the google api will be called to retrieve the lat/long
    }
}

// DHTML date validation script
// Declaring valid date character, minimum year and maximum year
var dtCh = "/";
var minYear = 1900;
var maxYear = 3100;
var latVal = 0;
var lngVal = 0;
var geocoder = new google.maps.Geocoder();


function getLatLong (address) {
    //alert('test');
    //map = new google.maps.Map();
    //var address = document.getElementById('address').value;
    geocoder.geocode({'address': address}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            //alert(results[0].geometry.location.lat() + ", " + results[0].geometry.location.lng());
            document.getElementById("lat").value = results[0].geometry.location.lat();
            document.getElementById("lng").value = results[0].geometry.location.lng();
            document.lewform.submit();
        } else {
            alert("Your address can't be mapped! \nPlease enter the closest actual address or enter the latitude and longitude!");
        }
    });

}

function clearAddress () {
    document.getElementById("address").value = "";

}

function clearLatLng () {
    for (var i = 0; i < document.lewform.LatLong.length; i ++) {
        document.lewform.LatLong[i].checked = false;
    }
    document.lewform.LatitudeA.value = "";
    document.lewform.LatitudeB.value = "";
    document.lewform.LatitudeC.value = "";
    document.lewform.LongitudeA.value = "";
    document.lewform.LongitudeB.value = "";
    document.lewform.LongitudeC.value = "";
    document.lewform.LatitudeE.value = "";
    document.lewform.LatitudeF.value = "";
    document.lewform.LatitudeG.value = "";
    document.lewform.LongitudeE.value = "";
    document.lewform.LongitudeF.value = "";
    document.lewform.LongitudeG.value = "";
    document.lewform.decimalLatA.value = "";
    document.lewform.decimalLatB.value = "";
    document.lewform.decimalLongC.value = "";
    document.lewform.decimalLongD.value = "";
}

function checkRadioButton (rName, rValue, iName) {
    var obj = document.getElementsByName(rName);
    for (var i = 0; i < obj.length; i ++) {
        if (obj[i].value == rValue)
            obj[i].checked = true;
    }

    window.setTimeout(function () {
        document.getElementById(iName).focus();
    }, 0);

}
// to trim a string
function trim (TRIM_VALUE) {
    if (TRIM_VALUE.length < 1)
        return "";

    TRIM_VALUE = RTrim(TRIM_VALUE);
    TRIM_VALUE = LTrim(TRIM_VALUE);

    if (TRIM_VALUE == "")
        return "";
    else
        return TRIM_VALUE;
}

// to trim all the white spaces ahead of a string
function RTrim (VALUE) {
    var w_space = String.fromCharCode(32);
    var v_length = VALUE.length;
    var strTemp = "";
    if (v_length < 0)
        return "";

    var iTemp = v_length - 1;

    while (iTemp > - 1) {
        if (VALUE.charAt(iTemp) != w_space) {
            strTemp = VALUE.substring(0, iTemp + 1);
            break;
        }
        iTemp = iTemp - 1;
    } //End While
    return strTemp;
} //End Function


// to trim all the white spaces right after a string
function LTrim (VALUE) {
    var w_space = String.fromCharCode(32);
    if (v_length < 1)
        return "";
    var v_length = VALUE.length;
    var strTemp = "";
    var iTemp = 0;
    while (iTemp < v_length) {
        if (VALUE.charAt(iTemp) != w_space) {
            strTemp = VALUE.substring(iTemp, v_length);
            break;
        }
        iTemp = iTemp + 1;
    } //End While
    return strTemp;
} //End Function


function isInteger (s) {
    var i;
    for (i = 0; i < s.length; i ++) {
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag (s, bag) {
    var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i ++) {
        var c = s.charAt(i);
        if (bag.indexOf(c) == - 1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year) {
    // February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (! (year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray (n) {
    for (var i = 1; i <= n; i ++) {
        this[i] = 31;
        if (i == 4 || i == 6 || i == 9 || i == 11) {
            this[i] = 30;
        }
        if (i == 2) {
            this[i] = 29;
        }
    }
    return this;
}

function isValidDate (dtStr, fieldName) {

    var errorMsg = "";
    var daysInMonth = DaysArray(12);
    var pos1 = dtStr.indexOf(dtCh);
    var pos2 = dtStr.indexOf(dtCh, pos1 + 1);
    var strMonth = dtStr.substring(0, pos1);
    var strDay = dtStr.substring(pos1 + 1, pos2);
    var strYear = dtStr.substring(pos2 + 1);
    strYr = strYear;
    if (strDay.charAt(0) == "0" && strDay.length > 1)
        strDay = strDay.substring(1);
    if (strMonth.charAt(0) == "0" && strMonth.length > 1)
        strMonth = strMonth.substring(1);
    for (var i = 1; i <= 3; i ++) {
        if (strYr.charAt(0) == "0" && strYr.length > 1)
            strYr = strYr.substring(1);
    }
    month = parseInt(strMonth);
    day = parseInt(strDay);
    year = parseInt(strYr);
    if (pos1 == - 1 || pos2 == - 1) {
        //alert("The date format should be : mm/dd/yyyy");
        errorMsg += "The format of the " + fieldName + " should be : mm/dd/yyyy! \n";
        //return errorMsg;
    }
    else {
        if (strMonth.length < 1 || month < 1 || month > 12) {
            //alert("Please enter a valid month");
            errorMsg += "Please enter a valid month for the " + fieldName + "! \n";
            //return errorMsg;
        }
        if (strDay.length < 1 || day < 1 || day > 31 || (month == 2 && day > daysInFebruary(year)) || day > daysInMonth[month]) {
            //alert("Please enter a valid day");
            errorMsg += "Please enter a valid day for the " + fieldName + "! \n";
            //return errorMsg;
        }
        if (strYear.length != 4 || year == 0 || year < minYear || year > maxYear) {
            //alert("Please enter a valid 4 digit year between " + minYear + " and " + maxYear);
            errorMsg += "Please enter a valid 4 digit year between " + minYear + " and " + maxYear + " for the " + fieldName + "! \n";
            //return errorMsg;
        }
        if (dtStr.indexOf(dtCh, pos2 + 1) != - 1 || isInteger(stripCharsInBag(dtStr, dtCh)) == false) {
            //alert("Please enter a valid date");
            errorMsg += "Please enter a valid " + fieldName + "! \n";
            //return errorMsg;
        }
    }
    return errorMsg;
}

// to check whether one date is earlier than the other
// if 'dtStr1' is earlier than 'dtStr2', return true; otherwise return false.
// the date format is mm/dd/yyyy
function compareTwoDates (dtStr1, dtStr2) {
    var pos1;
    var pos2;
    var result = true;

    // to get the day, month, year of the 1st date
    pos1 = dtStr1.indexOf(dtCh);
    pos2 = dtStr1.indexOf(dtCh, pos1 + 1);
    var strMonth1 = dtStr1.substring(0, pos1);
    var strDay1 = dtStr1.substring(pos1 + 1, pos2);
    var strYear1 = dtStr1.substring(pos2 + 1);
    if (strDay1.charAt(0) == "0" && strDay1.length > 1)
        strDay1 = strDay1.substring(1);
    if (strMonth1.charAt(0) == "0" && strMonth1.length > 1)
        strMonth1 = strMonth1.substring(1);
    for (var i = 1; i <= 3; i ++) {
        if (strYear1.charAt(0) == "0" && strYear1.length > 1)
            strYear1 = strYear1.substring(1);
    }
    month1 = parseInt(strMonth1);
    day1 = parseInt(strDay1);
    year1 = parseInt(strYear1);

    // to get the day, month, year of the 2nd date
    pos1 = dtStr2.indexOf(dtCh);
    pos2 = dtStr2.indexOf(dtCh, pos1 + 1);
    var strMonth2 = dtStr2.substring(0, pos1);
    var strDay2 = dtStr2.substring(pos1 + 1, pos2);
    var strYear2 = dtStr2.substring(pos2 + 1);
    if (strDay2.charAt(0) == "0" && strDay2.length > 1)
        strDay2 = strDay2.substring(1);
    if (strMonth2.charAt(0) == "0" && strMonth2.length > 1)
        strMonth2 = strMonth2.substring(1);
    for (var i = 1; i <= 3; i ++) {
        if (strYear2.charAt(0) == "0" && strYear2.length > 1)
            strYear2 = strYear2.substring(1);
    }
    month2 = parseInt(strMonth2);
    day2 = parseInt(strDay2);
    year2 = parseInt(strYear2);

    if (year1 > year2) {
        result = false;
    }
    else if (year1 == year2) {
        if (month1 > month2) {
            result = false;
        }
        else if (month1 == month2) {
            if (day1 > day2) {
                result = false;
            }
        }
    }
    return result;
}


// end of date validation
