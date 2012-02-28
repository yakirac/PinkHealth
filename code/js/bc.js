/*<!--Javascript for Breast Cancer-->*/

function submitRisk() {

	//alert("Submit risk!");

	var age = $("#agetext").val();
	var menAge = 999;
	if ($("#menarcheAge_0").attr("checked"))
	{
		menAge = 10;
	}
	else if ($("#menarcheAge_1").attr("checked"))
	{
		menAge = 13;
	}
	else if ($("#menarcheAge_2").attr("checked"))
	{
		menAge = 15;
	}
	else if ($("#menarcheAge_3").attr("checked"))
	{
		menAge = 99;
	}

	var birthAge = 999;
	if ($("#ageb1c_0").attr("checked"))
	{
		birthAge = 0;
	}
	else if ($("#ageb1c_1").attr("checked"))
	{
		birthAge = 15;
	}
	else if ($("#ageb1c_2").attr("checked"))
	{
		birthAge = 22;
	}
	else if ($("#ageb1c_3").attr("checked"))
	{
		birthAge = 27;
	}
	else if ($("#ageb1c_4").attr("checked"))
	{
		birthAge = 30;
	}
	else if ($("#ageb1c_5").attr("checked"))
	{
		birthAge = 99;
	}

	var firstRels = 999;
	if ($("#relwbc_0").attr("checked"))
	{
		firstRels = 0;
	}
	else if ($("#relwbc_1").attr("checked"))
	{
		firstRels = 1;
	}
	else if ($("#relwbc_2").attr("checked"))
	{
		firstRels = 2;
	}
	else if ($("#relwbc_3").attr("checked"))
	{
		firstRels = 99;
	}

	var hadBiopsy = 999;
	if ($("#bbiopsy_0").attr("checked"))
	{
		hadBiopsy = 1;
	}
	else if ($("#bbiopsy_1").attr("checked"))
	{
		hadBiopsy = 0;
	}
	else if ($("#bbiopsy_2").attr("checked"))
	{
		hadBiopsy = 99;
	}

	var numBiopsy = 999;
	if ($("#numbbiopsy_0").attr("checked"))
	{
		numBiopsy = 1;
	}
	else if ($("#numbbiopsy_1").attr("checked"))
	{
		numBiopsy = 2;
	}

	var hyperplasia = 999;
	if ($("#hyperplasia_0").attr("checked"))
	{
		hyperplasia = 1;
	}
	else if ($("#hyperplasia_1").attr("checked"))
	{
		hyperplasia = 0;
	}
	else if ($("#hyperplasia_2").attr("checked"))
	{
		hyperplasia = 99;
	}

	var race = 999;
	if ($("#raceTypes_0").attr("checked"))
	{
		race = 1;
	}
	else if ($("#raceTypes_1").attr("checked"))
	{
		race = 2;
	}
	else if ($("#raceTypes_2").attr("checked"))
	{
		race = 3;
	}
	else if ($("#raceTypes_3").attr("checked"))
	{
		race = 4;
	}
	else if ($("#raceTypes_4").attr("checked"))
	{
		race = 5;
	}
	else if ($("#raceTypes_5").attr("checked"))
	{
		race = 6;
	}

    checkEmpty();

	var url = "http://web.cip.gatech.edu/~preventbc/calcrisk.php?curAge= " + age +
		"&menAge=" + menAge +
		"&birthAge=" + birthAge +
		"&rel=" + firstRels +
		"&hadBiopsy=" + hadBiopsy +
		"&numBiopsy=" + numBiopsy +
		"&hyperPlasia=" + hyperplasia +
		"&race=" + race;

	//alert(url);
		
	$.getJSON(url, function(data) {

		$('#risk').hide();
		var results = document.getElementById( 'ratresults' );
		results.innerHTML = "";
		
		var rat = document.createElement( 'a' );
		rat.setAttribute('href', "javascript:$('#risk').show();");
		//rat.setAttribute("href", "#");
		rat.innerHTML = "Show risk assessment tool";

		results.appendChild( rat );

		var res = document.createElement( 'p' );
		res.innerHTML = "5 year risk:<br />" +
			"You (age " + age + ") = " + data.five[0] + "<br />" +
			"Average woman (age " + age + ") = " + data.five[1] + "<br /><br />" +
			"Lifetime risk:<br />" +
			"You (to age 90): " + data.lifetime[0] + "<br />" +
			"Average woman (to age 90): " + data.lifetime[1];

		results.appendChild( res );
		
		var restablediv = document.createElement( 'div' );
		restablediv.setAttribute('class', 'ui-widget-header-pink ui-corner-all');
		restablediv.setAttribute('style', 'float: left; width: 400px;');
		var restable = document.createElement( 'table' );
		restable.setAttribute('style', 'width: 400px;');
		
		var rescaption = document.createElement( 'caption' );
		rescaption.innerHTML = "Lifetime Risk Assessment Groupings";
		
		var tr1 = document.createElement( 'tr' );
		
		var td1a = document.createElement( 'td' );
		td1a.innerHTML = "High Risk:";
		
		var td1b = document.createElement( 'td' );
		td1b.innerHTML = "&gt;= 20%";
		
		tr1.appendChild( td1a );
		tr1.appendChild( td1b );
		
		var tr2 = document.createElement( 'tr' );
		
		var td2a = document.createElement( 'td' );
		td2a.innerHTML = "Medium Risk:";
		
		var td2b = document.createElement( 'td' );
		td2b.innerHTML = "&gt;= 10% and &lt; 20%";
		
		tr2.appendChild( td2a );
		tr2.appendChild( td2b );
		
		var tr3 = document.createElement( 'tr' );
		
		var td3a = document.createElement( 'td' );
		td3a.innerHTML = "Low Risk:";
		
		var td3b = document.createElement( 'td' );
		td3b.innerHTML = "&lt; 10%"
		
		tr3.appendChild( td3a );
		tr3.appendChild( td3b );
		
		//Highlight the resulting row
		if ( data.lifetime[0] < 10)
		{
			tr3.setAttribute("class", "ui-widget-header-purple ui-corner-all");
		}
		else if ( data.lifetime[0] >= 10 && data.lifetime[0] < 20)
		{
			tr2.setAttribute("class", "ui-widget-header-purple ui-corner-all");
		}
		else if ( data.lifetime[0] >= 20)
		{
			tr1.setAttribute("class", "ui-widget-header-purple ui-corner-all");
		}
		
		restable.appendChild( rescaption );
		restable.appendChild( tr1 );
		restable.appendChild( tr2 );
		restable.appendChild( tr3 );
		
		restablediv.appendChild( restable );
		
		results.appendChild( restablediv );
		
		
		var highinfo = document.createElement( 'p' );
		highinfo.innerHTML = "Your lifetime risk (" + data.lifetime[0] + ") is considered to be high. If you have not done so already, please consult with your primary care physician to get his or her recommendations for screening (mammogram, MRI, etc.). Please continue on to My Plan.";
		highinfo.setAttribute("class", "ui-widget-header ui-corner-all ui-state-active");
		highinfo.setAttribute("style", "float: left;");
		
		var mediuminfo = document.createElement( 'p' );
		mediuminfo.innerHTML = "Your lifetime risk (" + data.lifetime[0] + ") is considered to be medium. It is recommended that you share this information with your primary care physician at your next visit. Please continue on to My Plan.";
		mediuminfo.setAttribute("class", "ui-widget-header ui-corner-all ui-state-active");
		mediuminfo.setAttribute("style", "float: left;");
		
		var lowinfo = document.createElement( 'p' );
		lowinfo.innerHTML = "Your lifetime risk (" + data.lifetime[0] + ") is considered to be low. Seeking immediate counsel with your primary care physician is not recommended. Please continue on to My Plan.";
		lowinfo.setAttribute("class", "ui-widget-header ui-corner-all ui-state-active");
		lowinfo.setAttribute("style", "float: left;");
		
		//Add the appropriate information
		if ( data.lifetime[0] < 10)
		{
			results.appendChild( lowinfo );
		}
		else if ( data.lifetime[0] >= 10 && data.lifetime[0] < 20)
		{
			results.appendChild( mediuminfo );
		}
		else if ( data.lifetime[0] >= 20)
		{
			results.appendChild( highinfo );
		}
		
		var hiddendiv = document.createElement( 'div' );
		//hiddendiv.setAttribute("class", "hidden");
		hiddendiv.innerHTML = "&nbsp;";
		results.appendChild( hiddendiv );
		
		results.appendChild( document.createElement( 'br' ) );
		results.appendChild( document.createElement( 'br' ) );
		results.appendChild( document.createElement( 'br' ) );
		results.appendChild( document.createElement( 'br' ) );
		results.appendChild( document.createElement( 'br' ) );
		results.appendChild( document.createElement( 'br' ) );
		results.appendChild( document.createElement( 'br' ) );
		results.appendChild( document.createElement( 'br' ) );
		
		var citation = document.createElement( 'p' );
		var cite = document.createElement( 'i' );
		cite.innerHTML = "Saslow, D., et al. American Cancer Society Guidelines for Breast Screening with MRI as an Adjunct to Mammography. CA Cancer J Clin 2007;57:75–89.";

		citation.appendChild( cite );
		
		results.appendChild( citation );



		$('#ratresults').show();

		if (typeof(SMART) != "undefined")
		{
			var url2 = "http://web.cip.gatech.edu/~preventbc/rat.php?action=addrisk&id=" + SMART.record.id + "&age=" + age + "&menage=" + menAge + "&fb=" + birthAge + "&fr=" + firstRels + "&biopsy=" + hadBiopsy + "&numbiopsy=" + numBiopsy + "&h=" + hyperplasia + "&race=" + race + "&five=" + data.five[0] + "&fiveavg=" + data.five[1] + "&life=" + data.lifetime[0] + "&lifeavg=" + data.lifetime[1];

			//alert(url2);

			$.getJSON(url2, function(data2) {
			});//$.getJSON(url2)
		}

	});//$.getJSON(url)

}// submitRisk()

function disableBiopsy()
{
	$("#numbbiopsy").addClass( "ui-state-disabled" );
	$("#hyperplasia").addClass( "ui-state-disabled" );
}

function enableBiopsy()
{
	$("#numbbiopsy").removeClass( "ui-state-disabled" );
	$("#hyperplasia").removeClass( "ui-state-disabled" );
}

function checkHistory( e ) {
	
	var val = e.checked;

	if(val)
	{
		//alert("This tool cannot calculate breast cancer risk accurately for women with a medical history of any breast cancer or of DCIS or LCIS.");
		$("#histdialog").dialog("open");
		return false;
	}
} 

function checkEmpty(){
    var age = $("#agetext").val();
	var menAge = 999;
	if ($("#menarcheAge_0").attr("checked"))
	{
		menAge = 10;
	}
	else if ($("#menarcheAge_1").attr("checked"))
	{
		menAge = 13;
	}
	else if ($("#menarcheAge_2").attr("checked"))
	{
		menAge = 15;
	}
	else if ($("#menarcheAge_3").attr("checked"))
	{
		menAge = 99;
	}
	var birthAge = $("#ageb1c").val();
	var firstRels = $("#relwbc").val();
	var hadBiopsy = $("#bbiopsy").val();
	var numBiopsy = $("#numbbiopsy").val();
	var hyperplasia = $("#hyperplasia").val();
	var race = $("#raceTypes").val();

    if(age == null){
	alert("Please enter your age in question 2");
    }
    if(menAge == "999"){
	alert("Please select age of first menstrual period in question 3");
    }
    if(birthAge == "999"){
	alert("Please select age of birth of first child in question 4");
    }
    if(firstRels == "999"){
	alert("Please select how many of your relatives have had breast cancer in question 5");
    }
    if(hadBiopsy == "999"){
	alert("Please select if you have or have not had a biopsy in question 6");
    }
    if(numBiopsy == "999"){
	alert("Please select the number of biopsies you have had in question 6");
    }
    if(hyperplasia == "999"){
	alert("Please selects the number of breast biopsies with atypical biopsy in question 6");
    }
    if(race == "999"){
	alert("Please select your race/ethnicity in question 7");
    }
}

function hideall()
{
	//$('#risk').hide();
	//$('#ratresults').hide();

}

function showrat()
{
	if (typeof(SMART) != "undefined")
	{
		var url = "http://web.cip.gatech.edu/~preventbc/rat.php?action=exists&id=" + SMART.record.id;

		//Autopopulate from EMR
		if (typeof(SMART) != "undefined")
		{
			//Age
			SMART.DEMOGRAPHICS_get(function(rdf) {
				var dob;
				var person = rdf.where("?d <http://smartplatforms.org/terms#birthday> ?dob");
				person.each(function(i, info){
					dob = info.dob;
				});
	
				var d=new Date();

				dob = dob.value.substring(0, 4);
				var age = d.getFullYear() - parseInt(dob);

				$("#agetext").val(age);
			});
		}

		$.getJSON(url, function(data) {

			if (data.exists == 1)
			{
				$('#risk').hide();
				var results = document.getElementById( 'ratresults' );
				results.innerHTML = "";
		
				var rat = document.createElement( 'a' );
				//rat.setAttribute('href', "javascript:showrat_link();");
				rat.setAttribute("href", "#");
				rat.setAttribute("onclick", "showrat_link()");
				rat.innerHTML = "Show risk assessment tool";

				results.appendChild( rat );

				var res = document.createElement( 'p' );
				res.innerHTML = "5 year risk:<br />" +
					"You (age " + data.age + ") = " + data.fiverisk + "<br />" +
					"Average woman (age " + data.age + ") = " + data.fiveavg + "<br /><br />" +
					"Lifetime risk:<br />" +
					"You (to age 90): " + data.lifetimerisk + "<br />" +
					"Average woman (to age 90): " + data.lifeavg;

				results.appendChild( res );

				
				
				var restablediv = document.createElement( 'div' );
				restablediv.setAttribute('class', 'ui-widget-header-pink ui-corner-all');
				restablediv.setAttribute('style', 'float: left; width: 400px;');
				var restable = document.createElement( 'table' );
				restable.setAttribute('style', 'width: 400px;');
				
				var rescaption = document.createElement( 'caption' );
				rescaption.innerHTML = "Lifetime Risk Assessment Groupings";
				
				var tr1 = document.createElement( 'tr' );
				
				var td1a = document.createElement( 'td' );
				td1a.innerHTML = "High Risk:";
				
				var td1b = document.createElement( 'td' );
				td1b.innerHTML = "&gt;= 20%";
				
				tr1.appendChild( td1a );
				tr1.appendChild( td1b );
				
				var tr2 = document.createElement( 'tr' );
				
				var td2a = document.createElement( 'td' );
				td2a.innerHTML = "Medium Risk:";
				
				var td2b = document.createElement( 'td' );
				td2b.innerHTML = "&gt;= 10% and &lt; 20%";
				
				tr2.appendChild( td2a );
				tr2.appendChild( td2b );
				
				var tr3 = document.createElement( 'tr' );
				
				var td3a = document.createElement( 'td' );
				td3a.innerHTML = "Low Risk:";
				
				var td3b = document.createElement( 'td' );
				td3b.innerHTML = "&lt; 10%"
				
				tr3.appendChild( td3a );
				tr3.appendChild( td3b );	

				//Highlight the resulting row
				if ( data.lifetimerisk < 10)
				{
					tr3.setAttribute("class", "ui-widget-header-purple ui-corner-all");
				}
				else if ( data.lifetimerisk >= 10 && data.lifetimerisk < 20)
				{
					tr2.setAttribute("class", "ui-widget-header-purple ui-corner-all");
				}
				else if ( data.lifetimerisk >= 20)
				{
					tr1.setAttribute("class", "ui-widget-header-purple ui-corner-all");
				}
				
				restable.appendChild( rescaption );
				restable.appendChild( tr1 );
				restable.appendChild( tr2 );
				restable.appendChild( tr3 );
				
				restablediv.appendChild( restable );
				
				results.appendChild( restablediv );
				
				var highinfo = document.createElement( 'p' );
				highinfo.innerHTML = "Your lifetime risk (" + data.lifetimerisk + ") is considered to be high. If you have not done so already, please consult with your primary care physician to get his or her recommendations for screening (mammogram, MRI, etc.). Please continue on to My Plan.";
				highinfo.setAttribute("class", "ui-widget-header ui-corner-all ui-state-active");
				highinfo.setAttribute("style", "float: left;");
				
				var mediuminfo = document.createElement( 'p' );
				mediuminfo.innerHTML = "Your lifetime risk (" + data.lifetimerisk + ") is considered to be medium. It is recommended that you share this information with your primary care physician at your next visit. Please continue on to My Plan.";
				mediuminfo.setAttribute("class", "ui-widget-header ui-corner-all ui-state-active");
				mediuminfo.setAttribute("style", "float: left;");
				
				var lowinfo = document.createElement( 'p' );
				lowinfo.innerHTML = "Your lifetime risk (" + data.lifetimerisk + ") is considered to be low. Seeking immediate counsel with your primary care physician is not recommended. Please continue on to My Plan.";
				lowinfo.setAttribute("class", "ui-widget-header ui-corner-all ui-state-active");
				lowinfo.setAttribute("style", "float: left;");
				
				//Add the appropriate information
				if ( data.lifetimerisk < 10)
				{
					results.appendChild( lowinfo );
				}
				else if ( data.lifetimerisk >= 10 && data.lifetimerisk < 20)
				{
					results.appendChild( mediuminfo );
				}
				else if ( data.lifetimerisk >= 20)
				{
					results.appendChild( highinfo );
				}
				
				var hiddendiv = document.createElement( 'div' );
				//hiddendiv.setAttribute("class", "hidden");
				hiddendiv.innerHTML = "&nbsp;";
				results.appendChild( hiddendiv );
				
				results.appendChild( document.createElement( 'br' ) );
				results.appendChild( document.createElement( 'br' ) );
				results.appendChild( document.createElement( 'br' ) );
				results.appendChild( document.createElement( 'br' ) );
				results.appendChild( document.createElement( 'br' ) );
				results.appendChild( document.createElement( 'br' ) );
				results.appendChild( document.createElement( 'br' ) );
				results.appendChild( document.createElement( 'br' ) );
				
				
				var citation = document.createElement( 'p' );
				var cite = document.createElement( 'i' );
				cite.innerHTML = "Saslow, D., et al. American Cancer Society Guidelines for Breast Screening with MRI as an Adjunct to Mammography. CA Cancer J Clin 2007;57:75–89.";

				citation.appendChild( cite );
				
				results.appendChild( citation );
				
				$('#ratresults').show();
			}

		}); //$.getJSON()
	}

} //showrat()

function showrat_link()
{
	$('#risk').show();
}

function showplan()
{
	//alert("Show plan!");

	if (typeof(SMART) != "undefined")
	{
		var url = "http://web.cip.gatech.edu/~preventbc/plan.php?action=exists&id=" + SMART.record.id;

		//alert(url);

		$.getJSON(url, function(data) {

			if (data.exists == 1)
			{
				//will probably have to fix this later if NULL is given

				var height = data.height;
				var weight = data.weight;
				var thepill = data.thepill;
				var strenuous = data.strenuous;
				var moderate = data.moderate;
				var mild = data.mild;
				var godin = data.godin;
				var sevenday = data.sevenday;
				var alcohol1 = data.alc1;
				var alcohol2 = data.alc2;
				var alcohol3 = data.alc3;
				var smoke = data.smoke;

				var lweight = 18.5 * height * height;
				lweight /= 0.45359237;
				lweight = Math.round(lweight);
				var hweight = 24.9 * height * height;
				hweight /= 0.45359237;
				hweight = Math.round(hweight);

				//Convert back to ft and inches
				height *= 39.3700787;
				var height_ft = Math.floor(height / 12);
				var height_in = Math.round(height % 12);

				//Convert to pounds
				weight *= 2.20462262;
				weight = Math.round(weight);

				var bmi = data.bmi;
				var thepill = data.thepill;

				//alert("height = " + height_ft + "'" + height_in + "'' \nweight = " + weight + "\nbmi = " + bmi + "\npill = " + thepill);

				$("#weighttext").val(weight);
				$("#heighttext_ft").val(height_ft);
				$("#heighttext_in").val(height_in);

				var bmiele = document.getElementById( "bmi" );
				bmiele.innerHTML = bmi + "<br /> For your height, you ideally want to weigh between <strong>" + lweight + "</strong> and <strong>" + hweight + "</strong> pounds to be in a healthy weight range.";

				if( bmi < 18.5 )
				{
					//$("#bmi0").addClass("highlight");
					$("#bmi0").addClass("ui-widget-header ui-corner-all");
				}
				else if ( bmi >= 18.5 && bmi < 25)
				{
					//$("#bmi1").addClass("highlight");
					$("#bmi1").addClass("ui-widget-header ui-corner-all");
				}
				else if ( bmi >= 25 && bmi < 30)
				{
					//$("#bmi2").addClass("highlight");
					$("#bmi2").addClass("ui-widget-header ui-corner-all");
				}
				else if ( bmi >= 30 )
				{
					//$("#bmi3").addClass("highlight");
					$("#bmi3").addClass("ui-widget-header ui-corner-all");
				}

				//The Pill
				if (thepill == 1)
				{
					$("#birthcontrol_q_0").attr("checked", true);
				}
				else
				{
					$("#birthcontrol_q_1").attr("checked", true);
				}
				$("#birthcontrol_q").buttonset("refresh");

				//My Exercise
				$("#strenuousex").val(strenuous);
				$("#moderateex").val(moderate);
				$("#mildex").val(mild);

				if (sevenday == 1)
				{
					$("#ex_q2_0").attr("checked", "true");
				}
				else if (sevenday == 2)
				{
					$("#ex_q2_1").attr("checked", "true");
				}
				else if (sevenday == 3)
				{
					$("#ex_q2_2").attr("checked", "true");
				}
				$("#ex_q2").buttonset("refresh");

				var godinelement = document.getElementById( "godinscore" );
				godinelement.innerHTML = godin + " arbitrary units (higher is better)";

				//My Alcohol
				if (alcohol1 == 0)
				{
					$("#alc_a1_0").attr("checked", "true");
				}
				else if (alcohol1 == 1)
				{
					$("#alc_a1_1").attr("checked", "true");
				}
				else if (alcohol1 == 2)
				{
					$("#alc_a1_2").attr("checked", "true");
				}
				else if (alcohol1 == 3)
				{
					$("#alc_a1_3").attr("checked", "true");
				}
				else if (alcohol1 == 4)
				{
					$("#alc_a1_4").attr("checked", "true");
				}

				if (alcohol2 == 0)
				{
					$("#alc_a2_0").attr("checked", "true");
				}
				else if (alcohol2 == 1)
				{
					$("#alc_a2_1").attr("checked", "true");
				}
				else if (alcohol2 == 2)
				{
					$("#alc_a2_2").attr("checked", "true");
				}
				else if (alcohol2 == 3)
				{
					$("#alc_a2_3").attr("checked", "true");
				}
				else if (alcohol2 == 4)
				{
					$("#alc_a2_4").attr("checked", "true");
				}

				if (alcohol3 == 0)
				{
					$("#alc_a3_0").attr("checked", "true");
				}
				else if (alcohol3 == 1)
				{
					$("#alc_a3_1").attr("checked", "true");
				}
				else if (alcohol3 == 2)
				{
					$("#alc_a3_2").attr("checked", "true");
				}
				else if (alcohol3 == 3)
				{
					$("#alc_a3_3").attr("checked", "true");
				}
				else if (alcohol3 == 4)
				{
					$("#alc_a3_4").attr("checked", "true");
				}
				$("#alc_a1").buttonset("refresh");
				$("#alc_a2").buttonset("refresh");
				$("#alc_a3").buttonset("refresh");

				//My Tobacco
				if (smoke == 1)
				{
					$("#smk_a1_0").attr("checked", "true");
				}
				else if (smoke == 2)
				{
					$("#smk_a1_1").attr("checked", "true");
				}
				$("#smk_q1").buttonset("refresh");
			}
			else
			{
				//alert("Patient added to db!");
			}

		}); //$.getJSON()

	}
	
} //showplan()

function showprogress()
{
	if (typeof(SMART) != "undefined")
	{
		var url = "http://web.cip.gatech.edu/~preventbc/progress.php?action=start&id=" + SMART.record.id;
		
		//alert(url);
		
		
		
		$.getJSON(url, function(data) {
			if(data.exists == 0)
			{
				//Patient doesn't exist yet
				$("#height_missing").removeClass("hidden");
				$("#weight_missing").removeClass("hidden");
			}
			else if(data.exists == 1)
			{
				//Patient exists, check height and weight
				if (data.weight == 0 || data.height == 0)
				{
					//Tell patient to go back and enter weight in My Plan
					$("#height_missing").removeClass("hidden");
					$("#weight_missing").removeClass("hidden");
				}
				else
				{
					var weight = data.weight;
					var height = data.height;
					
					//Dump height in heightholder
					document.getElementById( 'heightholder' ).innerHTML = height;
					
					var hweight = 24.9 * height * height;
					hweight *= 2.20462262;
					hweight = Math.round(hweight);
					
					//Convert back to ft and inches
					height *= 39.3700787;
					var height_ft = Math.floor(height / 12);
					var height_in = Math.round(height % 12);
					var bmi = data.bmi;

					//Convert to pounds
					weight *= 2.20462262;
					weight = Math.round(weight);
					
					var startheight = document.getElementById( 'start_height' );
					var startweight = document.getElementById( 'start_weight' );
					var startbmi = document.getElementById( 'start_bmi' );
					var goalweight = document.getElementById( 'info_weight_goal' );
					var startclass = document.getElementById( 'start_classification' );
				
					startheight.innerHTML += height_ft + "' " + height_in + '"';
					startweight.innerHTML += weight + " lbs";
					startbmi.innerHTML += bmi;
					goalweight.innerHTML = hweight + " lbs";
					
					if (bmi < 18.5)
					{
						startclass.innerHTML = "underweight";
					}
					else if (bmi >= 18.15 && bmi < 25)
					{
						startclass.innerHTML = "healthy";
					}
					else if (bmi >= 25 && bmi < 30)
					{
						startclass.innerHTML = "overweight";
					}
					else if (bmi >= 30)
					{
						startclass.innerHTML = "obese";
					}
				
					$("#height_missing").addClass("hidden");
					$("#weight_missing").addClass("hidden");
					$("#baseinfo").removeClass("hidden");
					
					graphtodayweight();
					getweighttoday();
					graphtodaybmi();
					graphtodaycalconsumed();
					getcalconsumedtoday();
					graphtodayalcohol();
					getalcoholtoday();
					graphtodayexminutes();
					getexminutestoday();
					graphtodaycalburned();
					getcalburnedtoday();
					
					getgodin();
					getalcohol();
					//showalccal();
					
				} //patient exists!
				
				
			} //data exists!
		
		}); //getJSON()
	} //if SMART exists
} //showprogress()

function getweighttoday()
{
	//See if there's data to make graph!
	var turl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getweighttoday&id=" + SMART.record.id;
	
	//alert(turl);
		
	$.getJSON(turl, function(data) {
		if (data.exists == 1)
		{
			
			var height = data.height;
			var hweight = 24.9 * height * height;
			hweight *= 2.20462262;
			hweight = Math.round(hweight);
			
			var gweight = data.details[0].weight;
			
			//Convert to pounds
			gweight *= 2.20462262;
			gweight = Math.round(gweight*10)/10;
			
			var bmi = data.details[0].bmi;
			
			document.getElementById( 'tweight' ).innerHTML = gweight + " lbs";
			document.getElementById( 'tbmi' ).innerHTML = " " + bmi + " BMI";
			$("#tweight_div").removeClass("hidden");

		}
	}); //getJSON()
} //getweighttoday()

function graphtodayweight()
{
	//See if there's data to make graph!
	var graphurl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getweight&id=" + SMART.record.id;
	
	//alert(graphurl);
		
	$.getJSON(graphurl, function(data) {
		if (data.exists == 1)
		{
			var graphdata = new google.visualization.DataTable();
			
			graphdata.addColumn('string', 'Date');
			graphdata.addColumn('number', 'Weight (lbs)');
			graphdata.addColumn('number', 'Goal Weight');
			graphdata.addRows(data.details.length);
			
			var height = data.height;
			var hweight = 24.9 * height * height;
			hweight *= 2.20462262;
			hweight = Math.round(hweight);
			
			var index = 0;
			for(var obj in data.details)
			{
				var detail = data.details[obj];
				
				//alert("obj = " + obj);
				//alert("detail = " + detail);
				
				var gweight = detail.weight;
				
				//Convert to pounds
				gweight *= 2.20462262;
				gweight = Math.round(gweight*10)/10;
				
				
				graphdata.setValue(index, 0, detail.date);
				graphdata.setValue(index, 1, gweight);
				graphdata.setValue(index, 2, hweight);
				
				index++;
			}
		
			weightchart( graphdata );
			
			
		}
	}); //getJSON()
} //graphtodayweight()

function graphtodaybmi()
{
	//See if there's data to make graph!
	var graphurl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getbmi&id=" + SMART.record.id;
	
	//alert(graphurl);
		
	$.getJSON(graphurl, function(data) {
		if (data.exists == 1)
		{
			var graphdata = new google.visualization.DataTable();
			
			graphdata.addColumn('string', 'Date');
			graphdata.addColumn('number', 'BMI');
			graphdata.addColumn('number', 'Goal BMI');
			graphdata.addRows(data.details.length);
			
			var index = 0;
			for(var obj in data.details)
			{
				var detail = data.details[obj];
				
				var bmi = parseFloat(detail.bmi);
				var goalbmi = 24.9;
				
				graphdata.setValue(index, 0, detail.date);
				graphdata.setValue(index, 1, bmi);
				graphdata.setValue(index, 2, goalbmi);
				
				index++;
			}
		
			bmichart( graphdata );
			
			
		}
	}); //getJSON()
} //graphtodaybmi()

function graphtodaycalconsumed()
{
	//See if there's data to make graph!
	var graphurl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getcalconsumed&id=" + SMART.record.id;
	
	//alert(graphurl);
		
	$.getJSON(graphurl, function(data) {
		if (data.exists == 1)
		{
			var graphdata = new google.visualization.DataTable();
			
			graphdata.addColumn('string', 'Date');
			graphdata.addColumn('number', 'Calories consumed');
			//graphdata.addColumn('number', 'Goal calories');
			graphdata.addRows(data.details.length);
			
			var index = 0;
			for(var obj in data.details)
			{
				var detail = data.details[obj];
				
				//alert("obj = " + obj);
				//alert("detail = " + detail);
				
				var cal = parseInt(detail.calories);
				
				graphdata.setValue(index, 0, detail.date);
				graphdata.setValue(index, 1, cal);
				//graphdata.setValue(index, 2, goalcal);
				
				index++;
			}
		
			calconsumedchart( graphdata );
			
			
		}
	}); //getJSON()

} //graphtodaycalconsumed()

function getcalconsumedtoday()
{
	//See if there's data to make graph!
	var turl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getcalconsumedtoday&id=" + SMART.record.id;
	
	//alert(turl);
		
	$.getJSON(turl, function(data) {
		if (data.exists == 1)
		{
			var calories = parseInt(data.details[0].calories);
				
			document.getElementById( 'tcalconsumed' ).innerHTML =  calories + " calories";
			$("#tcalconsumed_div").removeClass("hidden");
		}
	}); //getJSON()

} //getcalconsumedtoday()

function graphtodayalcohol()
{
	//See if there's data to make graph!
	var graphurl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getalcohol&id=" + SMART.record.id;
	
	//alert(graphurl);
		
	$.getJSON(graphurl, function(data) {
		if (data.exists == 1)
		{
			var graphdata = new google.visualization.DataTable();
			
			graphdata.addColumn('string', 'Date');
			graphdata.addColumn('number', 'Drinks consumed');
			//graphdata.addColumn('number', 'Goal drinks');
			graphdata.addRows(data.details.length);
			
			var index = 0;
			for(var obj in data.details)
			{
				var detail = data.details[obj];
				
				//alert("obj = " + obj);
				//alert("detail = " + detail);
				
				var drinks = parseInt(detail.drinks);
				
				graphdata.setValue(index, 0, detail.date);
				graphdata.setValue(index, 1, drinks);
				//graphdata.setValue(index, 2, goaldrinks);
				
				index++;
			}
		
			drinkschart( graphdata );
			
			
		}
	}); //getJSON()

} //graphtodayalcohol()

function getalcoholtoday()
{
	//See if today has been added yet
	var turl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getalcoholtoday&id=" + SMART.record.id;
	
	//alert(turl);
		
	$.getJSON(turl, function(data) {
	
		//alert(data.exists);
		
		if (data.exists == 1)
		{			
			var drinks = data.details[0].drinks;
			
			document.getElementById( 'talcohol' ).innerHTML = drinks + " drinks";
			$("#talcohol_div").removeClass("hidden");
			
		}
	}); //getJSON()

} //getalcoholtoday()

function graphtodayexminutes()
{
	//See if there's data to make graph!
	var graphurl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getexmin&id=" + SMART.record.id;
	
	//alert(graphurl);
		
	$.getJSON(graphurl, function(data) {
		if (data.exists == 1)
		{
			var graphdata = new google.visualization.DataTable();
			
			graphdata.addColumn('string', 'Date');
			graphdata.addColumn('number', 'Minutes exercised');
			//graphdata.addColumn('number', 'Goal minutes');
			graphdata.addRows(data.details.length);
			
			var index = 0;
			for(var obj in data.details)
			{
				var detail = data.details[obj];
				
				//alert("obj = " + obj);
				//alert("detail = " + detail);
				
				var minutes = parseInt(detail.minutes);
				
				graphdata.setValue(index, 0, detail.date);
				graphdata.setValue(index, 1, minutes);
				//graphdata.setValue(index, 2, goalminutes);
				
				index++;
			}
		
			exminchart( graphdata );
			
			
		}
	}); //getJSON()

} //graphtodayexminutes()

function getexminutestoday()
{
	//See if today has been added yet
	var turl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getexmintoday&id=" + SMART.record.id;
	
	//alert(turl);
		
	$.getJSON(turl, function(data) {
	
		//alert(data.exists);
		
		if (data.exists == 1)
		{			
			var minutes = data.details[0].minutes;
			var intensity = data.details[0].intensity;
			
			if (intensity == 0)
			{
				intensity = "mild";
			}
			else if (intensity == 1)
			{
				intensity = "moderate";
			}
			else if (intensity == 2)
			{
				intensity = "strenuous";
			}
			
			document.getElementById( 'tminutes' ).innerHTML = minutes + " minutes at " + intensity + " intensity";
			$("#tminutes_div").removeClass("hidden");
			
		}
	}); //getJSON()

} //getexminutestoday()

function graphtodaycalburned()
{
	//See if there's data to make graph!
	var graphurl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getcalburned&id=" + SMART.record.id;
	
	//alert(graphurl);
		
	$.getJSON(graphurl, function(data) {
		if (data.exists == 1)
		{
			var graphdata = new google.visualization.DataTable();
			
			graphdata.addColumn('string', 'Date');
			graphdata.addColumn('number', 'Calories burned');
			//graphdata.addColumn('number', 'Goal calories');
			graphdata.addRows(data.details.length);
			
			var index = 0;
			for(var obj in data.details)
			{
				var detail = data.details[obj];
				
				var calories = parseInt(detail.calories);
				
				graphdata.setValue(index, 0, detail.date);
				graphdata.setValue(index, 1, calories);
				//graphdata.setValue(index, 2, goalcalories);
				
				index++;
			}
		
			calburnedchart( graphdata );
			
			
		}
	}); //getJSON()

} //graphtodaycalburned()

function getcalburnedtoday()
{
	//See if today has been added yet
	var turl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getcalburnedtoday&id=" + SMART.record.id;
	
	//alert(turl);
		
	$.getJSON(turl, function(data) {
	
		//alert(data.exists);
		
		if (data.exists == 1)
		{			
			var calories = data.details[0].calories;
			
			document.getElementById( 'tcalburned' ).innerHTML = calories + " calories";
			$("#tcalburned_div").removeClass("hidden");
			
		}
	}); //getJSON()

} //getcalburnedtoday()

function getgodin()
{
	var turl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getgodin&id=" + SMART.record.id;
	
	$.getJSON(turl, function(data) {
	
		//alert(turl);
	
		if (data.exists == 1)
		{
			var strenuous = data.details[0].strenuous;
			var moderate = data.details[0].moderate;
			var mild = data.details[0].mild;
			var godin = data.details[0].godin;
			var sevenday = data.details[0].sevenday;
			
			document.getElementById( 'start_strenuous' ).innerHTML = strenuous + " times a week";
			document.getElementById( 'start_moderate' ).innerHTML = moderate + " times a week";
			document.getElementById( 'start_mild' ).innerHTML = mild + " times a week";
			document.getElementById( 'start_godin' ).innerHTML = godin;
			
			if (data.current == 1)
			{
				var cur_stren = 0;
				var cur_mod = 0;
				var cur_mild = 0;
				var cur_godin = 0;
				
				for (var i = 0; i < data.intensity.length; i++)
				{
					if (data.intensity[i].intensity == 0 )
					{
						cur_mild++;
					}
					else if (data.intensity[i].intensity == 1)
					{
						cur_mod++;
					}
					else if (data.intensity[i].intensity == 2)
					{
						cur_stren++;
					}
				}
			
				cur_godin = cur_stren * 9 + cur_mod * 5 + cur_mild * 3;
			
				document.getElementById( 'current_strenuous' ).innerHTML = cur_stren + " times a week";
				document.getElementById( 'current_moderate' ).innerHTML = cur_mod + " times a week";
				document.getElementById( 'current_mild' ).innerHTML = cur_mild + " times a week";
				document.getElementById( 'current_godin' ).innerHTML = cur_godin;
			}
		}
		
	}); //$.getJSON
} //getgodin()

function getalcohol()
{
	var turl = "http://web.cip.gatech.edu/~preventbc/progress.php?action=getalc&id=" + SMART.record.id;
	
	//alert(turl);
	
	$.getJSON(turl, function(data) {
		if (data.exists == 1)
		{
		
			var alc1 = data.details[0].alc1;
			var alc2 = data.details[0].alc2;
			var alc3 = data.details[0].alc3;
		
			var a1 = document.getElementById( 'start_often_drink' );
			//a1.innerHTML = alc1;
			
			if (alc1 == 0)
			{
				a1.innerHTML = "Never";
			}
			else if (alc1 == 1)
			{
				a1.innerHTML = "Monthly or less";
			}
			else if (alc1 == 2)
			{
				a1.innerHTML = "2 to 4 times a month";
			}
			else if (alc1 == 3)
			{
				a1.innerHTML = "2 to 3 times a week";
			}
			else if (alc1 == 4)
			{
				a1.innerHTML = "4 or more times a week";
			}
			
			var a2 = document.getElementById( 'start_day_drink' );
			//a2.innerHTML = alc2;
			
			if (alc2 == 0)
			{
				a2.innerHTML = "1 or 2";
			}
			else if (alc2 == 1)
			{
				a2.innerHTML = "3 or 4";
			}
			else if (alc2 == 2)
			{
				a2.innerHTML = "5 or 6";
			}
			else if (alc2 == 3)
			{
				a2.innerHTML = "7 to 9";
			}
			else if (alc2 == 4)
			{
				a2.innerHTML = "10 or more";
			}
			
			var a3 = document.getElementById( 'start_five_drink' );
			//a3.innerHTML = alc3;
			
			if (alc3 == 0)
			{
				a3.innerHTML = "Never";
			}
			else if (alc3 == 1)
			{
				a3.innerHTML = "Less than monthly";
			}
			else if (alc3 == 2)
			{
				a3.innerHTML = "Monthly";
			}
			else if (alc3 == 3)
			{
				a3.innerHTML = "Weekly";
			}
			else if (alc3 == 4)
			{
				a3.innerHTML = "Daily or almost daily";
			}
		}
	});

} //getalcohol

function showcommunity()
{
	//hideall();
}

function showadhi()
{
	//hideall();
	/*var $dialog = $("<div></div>")
		.html("This dialog will show every time!")
		.dialog({
			autoOpen: false,
			title: "Basic Dialog"
	});

	$("#opener").click(function() {
		$dialog.dialog("open");
		// prevent the default action, e.g., following a link
		return false;
	});*/
}

function showstart()
{
	//hideall();
}

//On load
$(function(){

	//If connected to the SMART platform, check if this user has used the app before, if not, add them to our database
	if (typeof(SMART) != "undefined")
	{
		var url = "http://web.cip.gatech.edu/~preventbc/patient.php?action=start&name=" + SMART.record.full_name + "&id=" + SMART.record.id;

		//alert(url);

		$.getJSON(url, function(data) {
			if (data.start == 1)
			{
				//alert("In db!");
			}
			else if (data.start == 0)
			{
				//alert("Added to db!");
			}
			else
			{
				alert("Error adding to db!");
			}
		});//$.getJSON()
	}

});//On load 

function getTdata(tid){
    var url = "http://api.twitter.com/1/statuses/user_timeline.json?user_id=" + tid;
    $.getJSON(url, function(data) {
	//$("#twitt").html(data[0].text);
	document.getElementBtId("twitt").innerHTML = data[0].text;
    });
}//Get twitter timeline for user 