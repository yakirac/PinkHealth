<?php

include 'RiskCalculator.php';

class Helper
{
	/*private $riskIndex;
	private $curAge;
	private $menAge;
	private $firstBirth;
	private $everBiopsy;
	private $numBiopsy;
	private $hyperplasia;
	private $firstdegrel;
	private $race;*/

	function Helper()
	{
		/*$this->riskIndex = $riskIndex;
		$this->curAge = $curAge;
		$this->menAge = $menAge;
		$this->firstBirth = $firstBirth;
		$this->everBiopsy = $everBiopsy;
		$this->numBiopsy = $numBiopsy;
		$this->hyperplasia = $hyperplasia;
		$this->firstdegrel = $firstdegrel;
		$this->race = $race;*/
	}

	function riskCalc($riskIndex, $curAge, $projAge, $menAge, $firstBirth, $firstdegrel, $everBiopsy, $numBiopsy, $hyperplasia, $rHyperPlasia, $race)
	{
		if($curAge < 50)
			$ageInd = 0;
		elseif($curAge >= 50)
			$ageInd = 1;

		$RiskCalc = new RiskCalculator();

		//echo "riskCalc";
		$rval[0] = $RiskCalc->CalculateAbsoluteRisk($curAge, $projAge, $ageInd, $numBiopsy, $menAge, $firstBirth, $firstdegrel, $everBiopsy, $hyperplasia, $rHyperPlasia, $race);
		$rval[1] = $RiskCalc->CalculateAverageRisk($curAge, $projAge, $ageInd, $numBiopsy, $menAge, $firstBirth, $firstdegrel, $everBiopsy, $hyperplasia, $rHyperPlasia, $race);
		return $rval;
	}

	function calcPercentage($absRisk, $avgRisk)
	{
		$absRisk = round($absRisk, 6);
		$avgRisk = round($avgRisk, 6);
		$ret[0] = round($absRisk * 100, 1);
		$ret[1] = round($avgRisk * 100, 1);
		return $ret;
	}

}

?>
