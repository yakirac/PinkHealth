<?php

class RiskCalculator
{

	private $NumCovPattInGailModel = 216;
	private $t;
	private $rmu2;
	private $rlan2;
	private $bet2;
	private $rf2;

	function RiskCalculator()
	{
		$this->initialize();
	}

	function initialize()
	{
		//echo "Riskcalc test!";

		/* age categories boundaries */
        $this->t[0] = 20.0;
        $this->t[1] = 25.0;
        $this->t[2] = 30.0;
        $this->t[3] = 35.0;
        $this->t[4] = 40.0;
        $this->t[5] = 45.0;
        $this->t[6] = 50.0;
        $this->t[7] = 55.0;
        $this->t[8] = 60.0;
        $this->t[9] = 65.0;
        $this->t[10] = 70.0;
        $this->t[11] = 75.0;
        $this->t[12] = 80.0;
        $this->t[13] = 85.0;
        $this->t[14] = 90.0;

		/*            
        age specific competing hazards (h2) - BCPT model or STAR model
        SEER mortality 1985:87, excluding death from breast cancer - white, African American/Black)
        US   mortality 1990:96, excluding death from breast cancer -     hispanic)
        ages [20:25), [25:30), [30:35) .... [70:74), [75:80), [80:85), [85:90)
        */
        $this->rmu2[0][0] = 49.3 * 0.00001;        // [20:25) race=white,other  1/12
        $this->rmu2[1][0] = 53.1 * 0.00001;        // [25:30) race=white,other  BCPT
        $this->rmu2[2][0] = 62.5 * 0.00001;        // [30:35) race=white,other
        $this->rmu2[3][0] = 82.5 * 0.00001;        // [35:40) race=white,other
        $this->rmu2[4][0] = 130.7 * 0.00001;        // [40:45) race=white,other
        $this->rmu2[5][0] = 218.1 * 0.00001;        // [45:50) race=white,other
        $this->rmu2[6][0] = 365.5 * 0.00001;        // [50:55) race=white,other
        $this->rmu2[7][0] = 585.2 * 0.00001;        // [55:60) race=white,other
        $this->rmu2[8][0] = 943.9 * 0.00001;        // [60:65) race=white,other
        $this->rmu2[9][0] = 1502.8 * 0.00001;        // [65:70) race=white,other
        $this->rmu2[10][0] = 2383.9 * 0.00001;        // [70:75) race=white,other
        $this->rmu2[11][0] = 3883.2 * 0.00001;        // [75:80) race=white,other
        $this->rmu2[12][0] = 6682.8 * 0.00001;        // [80:85) race=white,other
        $this->rmu2[13][0] = 14490.8 * 0.00001;        // [85:90) race=white,other

		/* 11/29/2007 SRamaiah - updated age specific competing hazards (h2)
        with new values from NCHS 1996-00 data for African American Women	 	
	 	
        Updated array  rmu2[*, 1] with following new values for African American Women 	
            */

        $this->rmu2[0][1] = 0.00074354;   // [20,25) race=African American/Black    11/28/2007 
        $this->rmu2[1][1] = 0.00101698;   // [24,30) race=African American/Black
        $this->rmu2[2][1] = 0.00145937;   // [30,35) race=African American/Black
        $this->rmu2[3][1] = 0.00215933;   // [34,40) race=African American/Black
        $this->rmu2[4][1] = 0.00315077;   // [40,45) race=African American/Black
        $this->rmu2[5][1] = 0.00448779;   // [44,50) race=African American/Black
        $this->rmu2[6][1] = 0.00632281;   // [50,55) race=African American/Black
        $this->rmu2[7][1] = 0.00963037;   // [54,60) race=African American/Black
        $this->rmu2[8][1] = 0.01471818;   // [60,65) race=African American/Black
        $this->rmu2[9][1] = 0.02116304;   // [64,70) race=African American/Black
        $this->rmu2[10][1] = 0.03266035;  // [70,75) race=African American/Black
        $this->rmu2[11][1] = 0.04564087;  // [74,80) race=African American/Black
        $this->rmu2[12][1] = 0.06835185;  // [80,84) race=African American/Black
        $this->rmu2[13][1] = 0.13271262;  // [84,90) race=African American/Black


        $this->rmu2[0][2] = 43.7 * 0.00001;        // [20:25) race=hispanic  5/12/00
        $this->rmu2[1][2] = 53.3 * 0.00001;        // [25:30) race=hispanic     STAR
        $this->rmu2[2][2] = 70.0 * 0.00001;        // [30:35) race=hispanic
        $this->rmu2[3][2] = 89.7 * 0.00001;        // [35:40) race=hispanic
        $this->rmu2[4][2] = 116.3 * 0.00001;        // [40:45) race=hispanic
        $this->xrmu2[5][2] = 170.2 * 0.00001;        // [45:50) race=hispanic
        $this->rmu2[6][2] = 264.6 * 0.00001;        // [50:55) race=hispanic
        $this->rmu2[7][2] = 421.6 * 0.00001;        // [55:60) race=hispanic
        $this->rmu2[8][2] = 696.0 * 0.00001;        // [60:65) race=hispanic
        $this->rmu2[9][2] = 1086.7 * 0.00001;        // [65:70) race=hispanic
        $this->rmu2[10][2] = 1685.8 * 0.00001;        // [70:75) race=hispanic
        $this->rmu2[11][2] = 2515.6 * 0.00001;        // [75:80) race=hispanic
        $this->rmu2[12][2] = 4186.6 * 0.00001;        // [80:85) race=hispanic
        $this->rmu2[13][2] = 8947.6 * 0.00001;        // [85:90) race=hispanic

        /* 
            age specific competing hazards (h2) for "average woman"
            (NCHS mortality 1992:95, excluding death from breast cancer - white, African American/Black)
            (US   mortality 1990:95, excluding death from breast cancer -     hispanic)
            ages [20:25), [25:30), [30:35) .... [70:74), [75:80), [80:85), [85:90)
        */

        $this->rmu2[0][3] = 44.12 * 0.00001;         // [20,25) race=white,other 11/21
        $this->rmu2[1][3] = 52.54 * 0.00001;         // [24,30) race=white,other
        $this->rmu2[2][3] = 67.46 * 0.00001;         // [30,35) race=white,other
        $this->rmu2[3][3] = 90.92 * 0.00001;         // [34,40) race=white,other
        $this->rmu2[4][3] = 125.34 * 0.00001;         // [40,45) race=white,other
        $this->rmu2[5][3] = 195.70 * 0.00001;         // [44,50) race=white,other
        $this->rmu2[6][3] = 329.84 * 0.00001;         // [50,55) race=white,other
        $this->rmu2[7][3] = 546.22 * 0.00001;         // [54,60) race=white,other
        $this->rmu2[8][3] = 910.35 * 0.00001;         // [60,65) race=white,other
        $this->rmu2[9][3] = 1418.54 * 0.00001;         // [64,70) race=white,other
        $this->rmu2[10][3] = 2259.35 * 0.00001;         // [70,75) race=white,other
        $this->rmu2[11][3] = 3611.46 * 0.00001;         // [74,80) race=white,other
        $this->rmu2[12][3] = 6136.26 * 0.00001;         // [80,84) race=white,other
        $this->rmu2[13][3] = 14206.63 * 0.00001;         // [84,90) race=white,other


        /* 11/29/2007 SRamaiah - updated age specific competing hazards (h2)
                with new values from NCHS 1996-00 data for African American Women	 	
            	 	
                Updated array rmu2[*, 4] with following new values for African American Women 	
        */
        $this->rmu2[0][4] = 0.00074354;   // [20,25) race=African American/Black    11/28/07
        $this->rmu2[1][4] = 0.00101698;   // [24,30) race=African American/Black
        $this->rmu2[2][4] = 0.00145937;   // [30,35) race=African American/Black
        $this->rmu2[3][4] = 0.00215933;   // [34,40) race=African American/Black
        $this->rmu2[4][4] = 0.00315077;   // [40,45) race=African American/Black
        $this->rmu2[5][4] = 0.00448779;   // [44,50) race=African American/Black
        $this->rmu2[6][4] = 0.00632281;   // [50,55) race=African American/Black
        $this->rmu2[7][4] = 0.00963037;   // [54,60) race=African American/Black
        $this->rmu2[8][4] = 0.01471818;   // [60,65) race=African American/Black
        $this->rmu2[9][4] = 0.02116304;   // [64,70) race=African American/Black
        $this->rmu2[10][4] = 0.03266035;  // [70,75) race=African American/Black
        $this->rmu2[11][4] = 0.04564087;  // [74,80) race=African American/Black
        $this->rmu2[12][4] = 0.06835185;  // [80,84) race=African American/Black
        $this->rmu2[13][4] = 0.13271262;  // [84,90) race=African American/Black            


        $this->rmu2[0][5] = 43.7 * 0.00001;        // [20:25) race=hispanic  5/12/00
        $this->rmu2[1][5] = 53.3 * 0.00001;        // [25:30) race=hispanic
        $this->rmu2[2][5] = 70.0 * 0.00001;        // [30:35) race=hispanic
        $this->rmu2[3][5] = 89.7 * 0.00001;        // [35:40) race=hispanic
        $this->rmu2[4][5] = 116.3 * 0.00001;        // [40:45) race=hispanic
        $this->rmu2[5][5] = 170.2 * 0.00001;        // [45:50) race=hispanic
        $this->rmu2[6][5] = 264.6 * 0.00001;        // [50:55) race=hispanic
        $this->rmu2[7][5] = 421.6 * 0.00001;        // [55:60) race=hispanic
        $this->rmu2[8][5] = 696.0 * 0.00001;        // [60:65) race=hispanic
        $this->rmu2[9][5] = 1086.7 * 0.00001;        // [65:70) race=hispanic
        $this->rmu2[10][5] = 1685.8 * 0.00001;        // [70:75) race=hispanic
        $this->rmu2[11][5] = 2515.6 * 0.00001;        // [75:80) race=hispanic
        $this->rmu2[12][5] = 4186.6 * 0.00001;        // [80:85) race=hispanic
        $this->rmu2[13][5] = 8947.6 * 0.00001;        // [85:90) race=hispanic

        /*
        age specific breast cancer composite incidence (h1*)
        (SEER incidence 1983:87 - white)                                      BCPT
        (SEER incidence 1994-98 - African American/Black)                                      SEER11
        (SEER incidence 1990:96 -     hispanic)                               STAR
        ages [20:25), [25:30), [30:35) .... [70:74), [75:80), [80:85), [85:90)
        */

        $this->rlan2[0][0] = 1.0 * 0.00001;        // [20:25) race=white,other  1/12
        $this->rlan2[1][0] = 7.6 * 0.00001;        // [25:30) race=white,other  BCPT
        $this->rlan2[2][0] = 26.6 * 0.00001;        // [30:35) race=white,other
        $this->rlan2[3][0] = 66.1 * 0.00001;        // [35:40) race=white,other
        $this->rlan2[4][0] = 126.5 * 0.00001;        // [40:45) race=white,other
        $this->rlan2[5][0] = 186.6 * 0.00001;        // [45:50) race=white,other
        $this->rlan2[6][0] = 221.1 * 0.00001;        // [50:55) race=white,other
        $this->rlan2[7][0] = 272.1 * 0.00001;        // [55:60) race=white,other
        $this->rlan2[8][0] = 334.8 * 0.00001;        // [60:65) race=white,other
        $this->rlan2[9][0] = 392.3 * 0.00001;        // [65:70) race=white,other
        $this->rlan2[10][0] = 417.8 * 0.00001;        // [70:75) race=white,other
        $this->rlan2[11][0] = 443.9 * 0.00001;        // [75:80) race=white,other
        $this->rlan2[12][0] = 442.1 * 0.00001;        // [80:85) race=white,other
        $this->rlan2[13][0] = 410.9 * 0.00001;        // [85:90) race=white,other

        /* 11/29/2007 SRamaiah - updated age specific breast cancer composite incidence (h1*)
           with new values from 1994-98SEER11 data for African American Women	 	
             
           Updated array rlan2[*, 1] with following new values for African American Women 	
        */

        $this->rlan2[0][1] = 0.00002696;     // [20:25) race=African American/Black    11/29/2007
        $this->rlan2[1][1] = 0.00011295;     // [25:30) race=African American/Black
        $this->rlan2[2][1] = 0.00031094;      // [30:35) race=African American/Black
        $this->rlan2[3][1] = 0.00067639;      // [35:40) race=African American/Black
        $this->rlan2[4][1] = 0.00119444;      // [40:45) race=African American/Black
        $this->rlan2[5][1] = 0.00187394;       // [45:50) race=African American/Black
        $this->rlan2[6][1] = 0.00241504;       // [50:55) race=African American/Black
        $this->rlan2[7][1] = 0.00291112;       // [55:60) race=African American/Black
        $this->rlan2[8][1] = 0.00310127;       // [60:65) race=African American/Black
        $this->rlan2[9][1] = 0.00366560;       // [65:70) race=African American/Black
        $this->rlan2[10][1] = 0.00393132;       // [70:75) race=African American/Black
        $this->rlan2[11][1] = 0.00408951;       // [75:80) race=African American/Black
        $this->rlan2[12][1] = 0.00396793;       // [80:85) race=African American/Black
        $this->rlan2[13][1] = 0.00363712;       // [85:90) race=African American/Black


        $this->rlan2[0][2] = 2.00 * 0.00001;       // [20:25) race=hispanic  5/12/00
        $this->rlan2[1][2] = 7.10 * 0.00001;       // [25:30) race=hispanic     STAR
        $this->rlan2[2][2] = 19.70 * 0.00001;       // [30:35) race=hispanic
        $this->rlan2[3][2] = 43.80 * 0.00001;       // [35:40) race=hispanic
        $this->rlan2[4][2] = 81.10 * 0.00001;       // [40:45) race=hispanic
        $this->rlan2[5][2] = 130.70 * 0.00001;       // [45:50) race=hispanic
        $this->rlan2[6][2] = 157.40 * 0.00001;       // [50:55) race=hispanic
        $this->rlan2[7][2] = 185.70 * 0.00001;       // [55:60) race=hispanic
        $this->rlan2[8][2] = 215.10 * 0.00001;       // [60:65) race=hispanic
        $this->rlan2[9][2] = 251.20 * 0.00001;       // [65:70) race=hispanic
        $this->rlan2[10][2] = 284.60 * 0.00001;       // [70:75) race=hispanic
        $this->rlan2[11][2] = 275.70 * 0.00001;       // [75:80) race=hispanic
        $this->rlan2[12][2] = 252.30 * 0.00001;       // [80:85) race=hispanic
        $this->rlan2[13][2] = 203.90 * 0.00001;       // [85:90) race=hispanic

        /*
          age specific breast cancer composite incidence (h1*)-"average woman"
          (SEER incidence 1992:96 - white, African American/Black)
          (SEER incidence 1990:96 -     hispanic)
          ages [20:25), [25:30), [30:35) .... [70:74), [75:80), [80:85), [85:90)
        */
        $this->rlan2[0][3] = 1.22 * 0.00001;       // [20:25) race=white,other 11/21
        $this->rlan2[1][3] = 7.41 * 0.00001;       // [25:30) race=white,other
        $this->rlan2[2][3] = 22.97 * 0.00001;       // [30:35) race=white,other
        $this->rlan2[3][3] = 56.49 * 0.00001;       // [35:40) race=white,other
        $this->rlan2[4][3] = 116.45 * 0.00001;       // [40:45) race=white,other
        $this->rlan2[5][3] = 195.25 * 0.00001;       // [45:50) race=white,other
        $this->rlan2[6][3] = 261.54 * 0.00001;       // [50:55) race=white,other
        $this->rlan2[7][3] = 302.79 * 0.00001;       // [55:60) race=white,other
        $this->rlan2[8][3] = 367.57 * 0.00001;       // [60:65) race=white,other
        $this->rlan2[9][3] = 420.29 * 0.00001;       // [65:70) race=white,other
        $this->rlan2[10][3] = 473.08 * 0.00001;       // [70:75) race=white,other
        $this->rlan2[11][3] = 494.25 * 0.00001;       // [75:80) race=white,other
        $this->rlan2[12][3] = 479.76 * 0.00001;       // [80:85) race=white,other
        $this->rlan2[13][3] = 401.06 * 0.00001;       // [85:90) race=white,other

        /* 11/29/2007 SRamaiah - updated age specific breast cancer composite incidence (h1*)
            with new values from 1994-98SEER11 data for African American Women	 	
             
            Updated array rlan2[*, 4] with following new values for African American Women 	
        */
        $this->rlan2[0][4] = 0.00002696;     // [20:25) race=African American/Black    11/29/2007
        $this->rlan2[1][4] = 0.00011295;     // [25:30) race=African American/Black
        $this->rlan2[2][4] = 0.00031094;      // [30:35) race=African American/Black
        $this->rlan2[3][4] = 0.00067639;      // [35:40) race=African American/Black
        $this->rlan2[4][4] = 0.00119444;      // [40:45) race=African American/Black
        $this->rlan2[5][4] = 0.00187394;       // [45:50) race=African American/Black
        $this->rlan2[6][4] = 0.00241504;       // [50:55) race=African American/Black
        $this->rlan2[7][4] = 0.00291112;       // [55:60) race=African American/Black
        $this->rlan2[8][4] = 0.00310127;       // [60:65) race=African American/Black
        $this->rlan2[9][4] = 0.00366560;       // [65:70) race=African American/Black
        $this->rlan2[10][4] = 0.00393132;       // [70:75) race=African American/Black
        $this->rlan2[11][4] = 0.00408951;       // [75:80) race=African American/Black
        $this->rlan2[12][4] = 0.00396793;       // [80:85) race=African American/Black
        $this->rlan2[13][4] = 0.00363712;       // [85:90) race=African American/Black


        $this->rlan2[0][5] = 2.00 * 0.00001;       // [20:25) race=hispanic  5/12/00
        $this->rlan2[1][5] = 7.10 * 0.00001;       // [25:30) race=hispanic
        $this->rlan2[2][5] = 19.70 * 0.00001;       // [30:35) race=hispanic
        $this->rlan2[3][5] = 43.80 * 0.00001;       // [35:40) race=hispanic
        $this->rlan2[4][5] = 81.10 * 0.00001;       // [40:45) race=hispanic
        $this->rlan2[5][5] = 130.70 * 0.00001;       // [45:50) race=hispanic
        $this->rlan2[6][5] = 157.40 * 0.00001;       // [50:55) race=hispanic
        $this->rlan2[7][5] = 185.70 * 0.00001;       // [55:60) race=hispanic
        $this->rlan2[8][5] = 215.10 * 0.00001;       // [60:65) race=hispanic
        $this->rlan2[9][5] = 251.20 * 0.00001;       // [65:70) race=hispanic
        $this->rlan2[10][5] = 284.60 * 0.00001;       // [70:75) race=hispanic
        $this->rlan2[11][5] = 275.70 * 0.00001;       // [75:80) race=hispanic
        $this->rlan2[12][5] = 252.30 * 0.00001;       // [80:85) race=hispanic
        $this->rlan2[13][5] = 203.90 * 0.00001;       // [85:90) race=hispanic

        //11/29/2007 replaced with two dimensional array to update for African American women

        // White & Other women logistic regression coefficients - GAIL model (BCDDP)

        $this->bet2[0][0] = -0.7494824600;     // intercept            1/12/99 & 11/13/07
        $this->bet2[1][0] = 0.0108080720;     // age >= 50 indicator

        $this->bet2[2][0] = 0.0940103059;     // age menarchy
        $this->bet2[3][0] = 0.5292641686;     // # of breast biopsy
        $this->bet2[4][0] = 0.2186262218;     // age 1st live birth
        $this->bet2[5][0] = 0.9583027845;     // # 1st degree relatives with breast ca

        $this->bet2[6][0] = -0.2880424830;     // # breast biopsy * age >=50 indicator
        $this->bet2[7][0] = -0.1908113865;     // age 1st live birth * # 1st degree rel

        // African American/Black women  logistic regression coefficients - CARE model

        $this->bet2[0][1] = -0.3457169653;     // intercept                      11/13/07
        $this->bet2[1][1] = 0.0334703319;     // age >= 50 indicator set á to 0 in PGM

        $this->bet2[2][1] = 0.2672530336;     // age menarchy
        $this->bet2[3][1] = 0.1822121131;     // # of breast biopsy
        $this->bet2[4][1] = 0.0000000000;     // age 1st live birth
        $this->bet2[5][1] = 0.4757242578;     // # 1st degree relatives with breast ca

        $this->bet2[6][1] = -0.1119411682;     // # breast biopsy * age >=50 indicator
        $this->bet2[7][1] = 0.0000000000;     // age 1st live birth * # 1st degree rel

        // Hispanic women   logistic regression coefficients - GAIL model (BCDDP)

        $this->bet2[0][2] = -0.7494824600;     // intercept            1/12/99 & 11/13/07
        $this->bet2[1][2] = 0.0108080720;     // age >= 50 indicator

        $this->bet2[2][2] = 0.0940103059;     // age menarchy
        $this->bet2[3][2] = 0.5292641686;     // # of breast biopsy
        $this->bet2[4][2] = 0.2186262218;     // age 1st live birth
        $this->bet2[5][2] = 0.9583027845;     // # 1st degree relatives with breast ca

        $this->bet2[6][2] = -0.2880424830;     // # breast biopsy * age >=50 indicator
        $this->bet2[7][2] = -0.1908113865;     // age 1st live birth * # 1st degree rel

        /* age 1st live birth * # 1st degree rel */

        // conversion factors (1-attributable risk) used in BCPT model

        $this->rf2[0][0] = 0.5788413;         // age < 50, race=white,other        1/12/99
        $this->rf2[1][0] = 0.5788413;         // age >=50, race=white,other


        /* 11/27/2007 SRamaiah.
         * Based on Journal(JNCI djm223 LM) published on Dec 05, 2007 by Gail and other scientists,
         * The new values are being used for african american woman
         * as there were differences between CARE model and GAIL Model
        */

        $this->rf2[0][1] = 0.72949880;         // age < 50, race=African American/Black     12/19/2007 based on journal value
        $this->rf2[1][1] = 0.74397137;         // age >=50, race=African American/Black

        $this->rf2[0][2] = 0.5788413;         // age < 50, race=hispanic   5/12/2000
        $this->rf2[1][2] = 0.5788413;         // age >=50, race=hispanic

        // conversion factors (1-attributable risk) used for "average woman"

        $this->rf2[0][3] = 1.0;                // age < 50, race=white avg woman      11/21
        $this->rf2[1][3] = 1.0;                // age >=50, race=white avg woman

        $this->rf2[0][4] = 1.0;                // age < 50, race=African American/Black avg woman      11/21
        $this->rf2[1][4] = 1.0;                // age >=50, race=African American/Black avg woman

        $this->rf2[0][5] = 1.0;                // age < 50, race=hispanic avg woman    5/12
        $this->rf2[1][5] = 1.0;                // age >=50, race=hispanic avg woman

	}

	function CalculateAbsoluteRisk($curAge, $projAge, $ageInd, $numBiopsy, $menAge, $firstBirth, $firstDegRel, $hadBiopsy, $ihyp, $rhyp, $irace)
	{
		//echo "<br />Current age = " . $curAge . "<br />";

		return $this->CalculateRisk(1, $curAge, $projAge, $ageInd, $numBiopsy, $menAge, $firstBirth, $hadBiopsy, $firstDegRel, $ihyp, $rhyp, $irace);

	}

	function CalculateAverageRisk($curAge, $projAge, $ageInd, $numBiopsy, $menAge, $firstBirth, $firstDegRel, $hadBiopsy, $ihyp, $rhyp, $irace)
	{

		return $this->CalculateRisk(2, $curAge, $projAge, $ageInd, $numBiopsy, $menAge, $firstBirth, $hadBiopsy, $firstDegRel, $ihyp, $rhyp, $irace);

	}

	function CalculateRisk($riskindex, $curAge, $projAge, $ageInd, $numBiopsy, $menAge, $firstBirth, $firstDegRel, $hadBiopsy, $ihyp, $rhyp, $irace)
	{

		$n = 216;
		$r = 0;
		$ni = 0;
		$ti = $curAge;
		$ts = $projAge;
		$incr = 0;

		//echo "<br />Risk index = " . $riskindex . "<br />";
		//echo "<br />Current age = " . $curAge . "<br />";

		/*11/29/2007 SR: setting BETA to race specific lnRR*/
        for ($i = 0; $i < 8; $i++)
        {
        	$bet[$i] = $this->bet2[$i][$irace - 1];   //index starts from 0 hence irace-1 
        }
	
		/*11/29/2007 SR: recode agemen for African American/Black women*/
        if ($irace == 2)                 // for African American/Black women
        {
        	if ($menAge == 2)
            {
            	$menAge = 1;        // recode agemen=2 (age<12) to agmen=1 [12,13]
                $firstBirth = 0;  // set age 1st live birth to 0
             }
        }


        for ($i = 1; $i <= 15; ++$i)
        {
        	/* i-1=14 ==> current age=85, max for curre */
            if ($ti < $this->t[$i - 1])
            {
        	    //TODO CHECK THE INDEX
                $ni = $i - 1;	/* ni holds the index for current */

				//echo "<br />i = " . $i . " and ti = " . $ti . " and t[i-1] = " . $this->t[$i-1] . "<br />";
				//echo "<br />ni = " . $ni . "<br />";

                break; //goto L70;
            }
        }
        for ($i = 1; $i <= 15; ++$i)
        {
        	if ($ts <= $this->t[$i - 1])
            {
            	//!!!TODO CHECK THE INDEX
                $ns = $i - 1;	/* ns holds the index for risk as */
                break;	//goto L80;
            }
        }
        $incr = 0;
        if ($riskindex == 2)
        {
        	$incr = 3;
        }

		/* for race specific "avg women" */
        /* otherwise use cols 1,2,3 depen */
        /* on users race                5 */
        /* use cols 4,5,6 from rmu, rla */

        /* select race specific */
        $cindx = 0;  //column index
        $cindx = $incr + $irace - 1;

        for ($i = 0; $i < 14; ++$i)
        {
        	$rmu[$i] = $this->rmu2[$i][$cindx];	/* competeing baseline h */
            $rlan[$i] = $this->rlan2[$i][$cindx];	/* br ca composite incid */
        }

        $rf[0] = $this->rf2[0][$incr + $irace - 1];/* selecting correct fac */
        $rf[1] = $this->rf2[1][$incr + $irace - 1];/* based on race */
        if ($riskindex >= 2)
        {
        	/* set risk factors to */
            $menAge = 0;	    // baseline age menarchy 
            $numBiopsy = 0;	    // # of previous biop 
            $firstBirth = 0;	// age 1st live birth 
            $firstDegRel = 0;	// # 1st degree relat 
            $rhyp = 1.0;	            // set hyperplasia to 1.0 
        }

        $ilev = $ageInd * 108 + $menAge * 36 + $numBiopsy * 12 + $firstBirth * 3 + $firstDegRel + 1;	/* matrix of */
		/*echo "<br />ageInd = " . $ageInd . "<br />";
		echo "<br />menAge = " . $menAge . "<br />";
		echo "<br />numBiopsy = " . $numBiopsy . "<br />";
		echo "<br />firstBirth = " . $firstBirth . "<br />";
		echo "<br />firstDegRel = " . $firstDegRel . "<br />";
		echo "<br />ilev = " . $ilev . "<br />";*/

		/* covariate */
        /* range of 1 */
        /* AgeIndicator: age ge 50 ind  0=[20, 50) */
        /*                    1=[50, 85) */
        /* MenarcheAge: age menarchy   0=[14, 39] U 99 (unknown) */
        /*                    1=[12, 14) */
        /*                    2=[ 7, 12) */
        /* NumberOfBiopsy: # biopsy       0=0 or (99 and ever had biopsy=99 */
        /*                    1=1 or (99 and ever had biopsy=1 y */
        /*                    2=[ 2, 30] */
        /* FirstLiveBirthAge: age 1st live   0=<20, 99 (unknown) */
        /*                    1=[20, 25) */
        /*                    2=[25, 30) U 0 */
        /*                    3=[30, 55] */
        /* FirstDegRelatives: 1st degree rel 0=0, 99 (unknown) */
        /*                    1=1 */
        /*                    2=[2, 31] */
        /* **  Correspondence between exposure level and covariate factors X */
        /* **  in the logistic model */
        /* **  i-to-X correspondence */
        /* index in r8i */
		$r8iTox2;
        for ($k = 0; $k < 216; ++$k)
        {
        	/* col1: intercept o */
            $r8iTox2[$k][0] = 1.0;
        }

		for ($k = 0; $k < 108; ++$k)
        {
        	/* col2: indicator for age */
            $r8iTox2[$k][1] = 0.0;
            $r8iTox2[108 + $k][1] = 1.0;
        }
        for ($j = 1; $j <= 2; ++$j)
        {
        	/* col3: age menarchy cate */
            for ($k = 1; $k <= 36; ++$k)
            {
            	$r8iTox2[($j - 1) * 108 + $k - 1][2] = 0.0;
                $r8iTox2[($j - 1) * 108 + 36 + $k - 1][2] = 1.0;
                $r8iTox2[($j - 1) * 108 + 72 + $k - 1][2] = 2.0;
            }
        }
        for ($j = 1; $j <= 6; ++$j)
        {
        	/* col4: # biopsy cate */
            for ($k = 1; $k <= 12; ++$k)
            {
            	$r8iTox2[($j - 1) * 36 + $k - 1][3] = 0.0;
                $r8iTox2[($j - 1) * 36 + 12 + $k - 1][3] = 1.0;
                $r8iTox2[($j - 1) * 36 + 24 + $k - 1][3] = 2.0;
            }
        }
        for ($j = 1; $j <= 18; ++$j)
        {
        	/* col5: age 1st live birt */
            for ($k = 1; $k <= 3; ++$k)
            {
            	$r8iTox2[($j - 1) * 12 + $k - 1][4] = 0.0;
                $r8iTox2[($j - 1) * 12 + 3 + $k - 1][4] = 1.0;
                $r8iTox2[($j - 1) * 12 + 6 + $k - 1][4] = 2.0;
                $r8iTox2[($j - 1) * 12 + 9 + $k - 1][4] = 3.0;
            }
        }
        for ($j = 1; $j <= 72; ++$j)
        {
        	/* col6: # 1st degree re */
            $r8iTox2[($j - 1) * 3 + 1 - 1][5] = 0.0;
            $r8iTox2[($j - 1) * 3 + 2 - 1][5] = 1.0;
            $r8iTox2[($j - 1) * 3 + 3 - 1][5] = 2.0;
        }
        for ($i = 0; $i < 216; ++$i)
        {
        	/* col8: age 1st live*# r */
            /* col7: age*#biop intera */
            $r8iTox2[$i][6] = $r8iTox2[$i][1] * $r8iTox2[$i][3];
            $r8iTox2[$i][7] = $r8iTox2[$i][4] * $r8iTox2[$i][5];
        }
        for ($i = 0; $i < 216; ++$i)
        {
        	$r8iTox2[$i][8] = 1.0;
        }

		/* **  Computation of breast cancer risk */
        /* **  sum(bi*Xi) for all covariate patterns */
		$sumb;
        for ($i = 0; $i < 216; ++$i)
        {
        	/* ln relative risk from BCDDP */
            $sumb[$i] = 0.0;
            for ($j = 0; $j < 8; ++$j)
            {
            	$sumb[$i] += $bet[$j] * $r8iTox2[$i][$j];
            }
        }
        for ($i = 1; $i <= 108; ++$i)
        {
        	/* eliminate int */
            $sumbb[$i - 1] = $sumb[$i - 1] - $bet[0];
        }
        for ($i = 109; $i <= 216; ++$i)
        {
        	/* eliminate intercept */
            $sumbb[$i - 1] = $sumb[$i - 1] - $bet[0] - $bet[1];
        }
        for ($j = 1; $j <= 6; ++$j)
        {
        	/* age specific baseline hazard */
            $rlan[$j - 1] *= $rf[0];
        }
        for ($j = 7; $j <= 14; ++$j)
        {
        	/* age specific baseline hazard a */
            $rlan[$j - 1] *= $rf[1];
        }
        $i = $ilev;	/* index ilev of range 1- */
        /* setting i to covariate p */

		/*echo $i . "<br />";
		echo count($sumbb) . "<br />";*/
             
        $sumbb[$i - 1] += log($rhyp);
        if ($i <= 108)
        {
        	$sumbb[$i + 107] += log($rhyp);
        }

		/*echo "<br />i = " . $i . "<br />";
		echo "<br />ni = " . $ni . "<br />";
		echo "<br />ts = " . $ts . "<br />";
		echo "<br />ti = " . $ti . "<br />";*/

		$abs;
		if ($ts <= $this->t[$ni])
        {
        	/* same 5 year age risk in */
            /* age & projection age wi */
            $abs[$i - 1] = 1.0 - exp(-($rlan[$ni - 1] * exp($sumbb[
                    $i - 1]) + $rmu[$ni - 1]) * ($ts - $ti));
            $abs[$i - 1] = $abs[$i - 1] * $rlan[$ni - 1] * exp(
                    $sumbb[$i - 1]) / ($rlan[$ni - 1] * exp($sumbb[
                    $i - 1]) + $rmu[$ni - 1]);	/* breast cance */
        }
        else
        {
        	/* 5 year age risk interval */
        	/* calculate risk from */
            /* 1st age interval */
            /* age & projection age not i */
            $abs[$i - 1] = 1.0 - exp(-($rlan[$ni - 1] * exp($sumbb[
                    $i - 1]) + $rmu[$ni - 1]) * ($this->t[$ni] - $ti));
            $abs[$i - 1] = $abs[$i - 1] * $rlan[$ni - 1] * exp(
                    $sumbb[$i - 1]) / ($rlan[$ni - 1] * exp($sumbb[
                    $i - 1]) + $rmu[$ni - 1]);	/* age in */
            /* risk f */
            if ($ns - $ni > 0)
            {
            	if ($projAge > 50.0 && $curAge < 50.0)
                {
                	/* a */
                    /* s */
                    /* a */
                    /* calculate ris */
                    /* last age inte */

                    $r = 1.0 - exp(-($rlan[$ns - 1] * exp($sumbb[$i + 107]) + $rmu[$ns - 1]) * ($ts - $this->t[$ns - 1]));
                    $r = $r * $rlan[$ns - 1] * exp($sumbb[$i + 107]) / ($rlan[$ns - 1] * exp($sumbb[$i + 107]) + $rmu[$ns - 1]);
                    $r *= exp(-($rlan[$ni - 1] * exp($sumbb[$i - 1]) + $rmu[$ni - 1]) * ($this->t[$ni] - $ti));
                    if ($ns - $ni > 1)
                    {
                    	$menAge = $ns - 1;
                        for ($j = $ni + 1; $j <= $menAge; ++$j)
                        {
                        	if ($this->t[$j - 1] >= 50.0)
                            {
                            	$r *= exp(-($rlan[$j - 1] * exp($sumbb[
                                        $i + 107]) + $rmu[$j - 1]) * ($this->t[$j] - $this->t[$j - 1]));
                            }
                            else
                            {
                            	$r *= exp(-($rlan[$j - 1] * exp($sumbb[
                                        $i - 1]) + $rmu[$j - 1]) * ($this->t[$j] - $this->t[$j - 1]));
                            }
                        }
                    }
                        $abs[$i - 1] += $r;
                }
                else
                {
                	/* calculate risk from */
                	/* last age interval */
                    /* ages do not stradle */
                    $r = 1.0 - exp(-($rlan[$ns - 1] * exp($sumbb[$i - 1])
                            + $rmu[$ns - 1]) * ($ts - $this->t[$ns - 1]));
                    $r = $r * $rlan[$ns - 1] * exp($sumbb[$i - 1]) / (
                            $rlan[$ns - 1] * exp($sumbb[$i - 1]) +
                            $rmu[$ns - 1]);
                    $r *= exp(-($rlan[$ni - 1] * exp($sumbb[$i - 1]) +
                            $rmu[$ni - 1]) * ($this->t[$ni] - $ti));
                    if ($ns - $ni > 1)
                    {
                    	$menAge = $ns - 1;
                        for ($j = $ni + 1; $j <= $menAge; ++$j)
                        {
                        	$r *= exp(-($rlan[$j - 1] * exp($sumbb[$i -
                                    1]) + $rmu[$j - 1]) * ($this->t[$j] - $this->t[$j - 1]));
                        }
                    }
                    $abs[$i - 1] += $r;
                }
            }
            if ($ns - $ni > 1)
            {
            	if ($projAge > 50.0 && $curAge < 50.0)
                {
                	/* calculate risk from */
                    /* intervening age int */
                    $menAge = $ns - 1;
                    for ($k = $ni + 1; $k <= $menAge; ++$k)
                    {
                    	if ($this->t[$k - 1] >= 50.0)
                        {
                        	$r = 1.0 - exp(-($rlan[$k - 1] * exp($sumbb[
                                    $i + 107]) + $rmu[$k - 1]) * ($this->t[$k] -
                                    $this->t[$k - 1]));
                            $r = $r * $rlan[$k - 1] * exp($sumbb[$i +
                                    107]) / ($rlan[$k - 1] * exp($sumbb[
                                    $i + 107]) + $rmu[$k - 1]);
                        }
                        else
                        {
                        	$r = 1.0 - exp(-($rlan[$k - 1] * exp($sumbb[
                                    $i - 1]) + $rmu[$k - 1]) * ($this->t[$k] -
                                    $this->t[$k - 1]));
                            $r = $r * $rlan[$k - 1] * exp($sumbb[$i - 1]
                                    ) / ($rlan[$k - 1] * exp($sumbb[$i -
                                    1]) + $rmu[$k - 1]);
                        }
                        $r *= exp(-($rlan[$ni - 1] * exp($sumbb[$i - 1])
                                + $rmu[$ni - 1]) * ($this->t[$ni] - $ti));
                        $numBiopsy = $k - 1;
                        for ($j = $ni + 1; $j <= $numBiopsy; ++$j)
                        {
                            if ($this->t[$j - 1] >= 50.0)
                            {
                            	$r *= exp(-($rlan[$j - 1] * exp($sumbb[
                                        $i + 107]) + $rmu[$j - 1]) * ($this->t[$j] - $this->t[$j - 1]));
                            }
                            else
                            {
                            	$r *= exp(-($rlan[$j - 1] * exp($sumbb[
                                        $i - 1]) + $rmu[$j - 1]) * ($this->t[$j] - $this->t[$j - 1]));
                            }
                        }
                        $abs[$i - 1] += $r;
                    }
                }
                else
                {
                	/* calculate risk from */
                    /* intervening age int */
                    $menAge = $ns - 1;
                    for ($k = $ni + 1; $k <= $menAge; ++$k)
                    {
                    	$r = 1.0 - exp(-($rlan[$k - 1] * exp($sumbb[$i -
                                1]) + $rmu[$k - 1]) * ($this->t[$k] - $this->t[$k - 1]));
                        $r = $r * $rlan[$k - 1] * exp($sumbb[$i - 1]) /
                                ($rlan[$k - 1] * exp($sumbb[$i - 1]) +
                                $rmu[$k - 1]);
                        $r *= exp(-($rlan[$ni - 1] * exp($sumbb[$i - 1])
                                + $rmu[$ni - 1]) * ($this->t[$ni] - $ti));
                        $numBiopsy = $k - 1;
                        for ($j = $ni + 1; $j <= $numBiopsy; ++$j)
                        {
                        	$r *= exp(-($rlan[$j - 1] * exp($sumbb[$i -
                                    1]) + $rmu[$j - 1]) * ($this->t[$j] - $this->t[$j - 1]));
                        }
                        $abs[$i - 1] += $r;
                    }
                }
            }
        }

        $abss = $abs[$i - 1] * 1000.0;
            
        if ($abss - $abss >= 0.5)
        {
            //abss = d_int(abss) + 1.0 ;
            $abss = $abss + 1.0;
        }
        else
        {
            $abss = $abss;
        }
        $abss /= 10.0;	/* ** write the results to screen and output file */
        $retval = $abs[$i - 1];
        return $retval;



	}//CalculateRisk()

}

?>
