<?php  

//init
$totalMastery = array();
$minimalMastery = array();
$isMastered = true;
$isTotallyMastered = true;
$advice1 = '';
$advice2 = '';
$levels = array(
	0 => 2,
	1 => 5,
	2 => 10,
	3 => 1,
	4 => 4,
	5 => 3,
	6 => 0,
	7 => 6,
	8 => 8,
	9 => 9,
	10 => 7
);
$maxColumn = 0;

//find level on which to provide advice
	//check if a time table is not mastered
		//init
$analysedColumn = 0;
		//find
while ($analysedColumn != 11) {
	
	if ($minimalMastery[$analysedColumn] == false) {
		$advice1 = $levels[$analysedColumn];
		$isMastered = false;
		$isTotallyMastered = false;
		break;
	}

	$analysedColumn++;

}

$maxColumn = $analysedColumn;
	//check if a timetable is not totally mastered
if ($maxColumn != 0) {
		//init
	$analysedColumn = 0;
		//find
	while ($analysedColumn != $maxColumn) {

		if ($totalMastery[$analysedColumn] == false) {

			($advice2 != '')? $advice2 += ', ' : $isTotallyMastered = false;
			$advice2 += $levels[$analysedColumn];

		}

		$analysedColumn++;

	}
}


?>