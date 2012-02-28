<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'Helper.php';

$currentAge = $_GET['curAge'];
$menarcheAge = $_GET['menAge'];
$firstLiveBirthAge = $_GET['birthAge'];
$firstDegreeRel = $_GET['rel'];
$hadBiopsy = $_GET['hadBiopsy'];
$numBiopsy = $_GET['numBiopsy'];
$hyperPlasia = $_GET['hyperPlasia'];
$race = $_GET['race'];

function GetRace($race)
{
	$rval = 0;
	
	switch ($race)
	{
		case 1: //White
			$rval = 1;
			break;
		case 2: //African American
			$rval = 2;
			break;
		case 3: //Hispanic
			$rval = 3;
			break;
		case 4: //Asian or Pacific Islander
			$rval = 1; //Code as White for now
			break;
		case 5: //American Indian or Alaskan Native
			$rval = 1; //Code as White for now
			break;
		case 6: //Unknown
			$rval = 1; //Code as White for now
			break;
		default:
			$rval = 1;
	}

	return $rval;
}

function MenarchAge($age)
{
	$rval = 0;

	if ($age >= 7 && $age < 12)
		$rval = 2;
	elseif ($age >= 12 && $age < 14)
		$rval = 1;
	elseif ($age >= 14 && $age <= 39 || $age == 99)
		$rval = 0;
	return $rval;
}

function GetFirstLiveBirthAge($age)
{
	$rval = 0;

	switch ($age)
	{
		case 0: //No births
			$rval = 0;
			break;
		case 1: //< 20
			$rval = 15;
			break;
		case 2: //20 to 24
			$rval = 22;
			break;
		case 3: //25 to 30
			$rval = 27;
			break;
		case 4: //> 30
			$rval = 31;
			break;
	}
	return $rval;
}

function FirstLiveBirth($age)
{
	$rval = 0;

	if ($age == 0)
	{
		// no live birth
		$rval = 2;
	}
	elseif ($age > 0)
	{
		if ($age < 20 || $age == 99)
		{
			$rval = 0;
		}
		elseif ($age >= 20 && $age < 25)
		{
			$rval = 1;
		}
		elseif ($age >= 25 && $age < 30)
		{
			$rval = 2;
		}
		elseif ($age >= 30 && $age <= 55)
		{
			$rval = 3;
		}
	}
	
	return $rval;
}

function FirstDegRel($rels)
{
	$rval = $rels;

	if ($rval == 99)
	{
		$rval = 0;
	}
	return $rval;
}

function RHyperplasia($hyper)
{
	$rval = 0;
	
	switch ($hyper)
	{
		case 1: //hyperplasia = yes
			$rval = 1.82;
			break;
		case 2: //hyperplasia = no
			$rval = 0.93;
			break;	
	}
	return $rval;
}

function HaveBiopsy($ans)
{
	$rval = $ans;

	if ($rval == 99)
		$rval = 0;

	return $rval;
}

function Hyperplasia($ans)
{
	$rval = $ans;

	if ($rval == 99)
		$rval = 0;

	return $rval;
}

/* Menarche age
>=7 and <12 => 10
>=12 and <14 => 13
>=14 and <=39 => 15
Unknown = 99*/


$menarcheAge = MenarchAge($menarcheAge);
//$firstLiveBirthAge = GetFirstLiveBirthAge($firstLiveBirthAge);
//$currentAge = GetAge($currentAge);
$rHyperPlasia = RHyperplasia($hyperPlasia);
$firstLiveBirthAge = FirstLiveBirth($firstLiveBirthAge);
$firstDegreeRel = FirstDegRel($firstDegreeRel);
$hadBiopsy = HaveBiopsy($hadBiopsy);
$hyperPlasia = Hyperplasia($hyperPlasia);
$race = GetRace($race);

//echo $menarcheAge . "<br />";
//echo $firstLiveBirthAge . "<br />";
//echo $hyperPlasia . "<br />";

$helper = new Helper();

// Calculate 5 year risk.
$val = $helper->riskCalc(0, $currentAge, $currentAge + 5, $menarcheAge, $firstLiveBirthAge, $firstDegreeRel, $hadBiopsy, $numBiopsy, $hyperPlasia, $rHyperPlasia, $race);
$r = $helper->calcPercentage($val[0], $val[1]);
/*echo "5 Year Risk:<br />";
echo "This woman (age " . $currentAge . ") " . $r[0] . "<br />";
echo "Average woman (age " . $currentAge . ") " . $r[1] . "<br />";*/
$json['five'] = $r;

// Calculate lifetime risk.
$val = $helper->riskCalc(0, $currentAge, 90, $menarcheAge, $firstLiveBirthAge, $firstDegreeRel, $hadBiopsy, $numBiopsy, $hyperPlasia, $rHyperPlasia, $race);
$r = $helper->calcPercentage($val[0], $val[1]);
/*echo "Lifetime Risk:<br />";
echo "This woman (to age 90) " . $r[0] . "<br />";
echo "Average woman (to age 90) " . $r[1] . "<br />";*/
$json['lifetime'] = $r;

echo json_encode($json);

?>
