<?php

class Genetic{
	private $poblacion;

	public function __construct($uea,$profesor,$profUEA){
		
	}
	function fitness (){

	}
	function seleccion($num){
		$pob_copy = this->toArray($poblacion);

		$best = 0;
		for ($i=0; $i < sizeof(pob_copy); $i++) { 
			$fit = this->fitness();
		}

	}
	
	public function cruza($gen1, $gen2){
		$gen1 = $this->toArray($gen1);
		$gen2 = $this->toArray($gen2);

		$pointcross = intval(sizeof($gen1)/2);
		echo $pointcross."<br>";

		$child1 = array_merge(array_slice($gen1,0,$pointcross),array_slice($gen2,$pointcross));
		$child2 = array_merge(array_slice($gen2,0,$pointcross),array_slice($gen1,$pointcross) );
		
		echo $this->toString($child1)."<br>".$this->toString($child2);
	}
	function mutacion($gen1){
		$gen1 = $this->toArray($gen1);

		for ($i=5; $i < 15 ; $i++) { 
			if ($gen1[$i] == 0) {
				$gen1[$i] = 1;
			}else{
				$gen1[$i] = 0;
			}
		}
	}
	function calcula(){

	}
	function generarPoblacion(){

	}
	function elitismo(){

	}

	public function toString($array){
		$out="";
		foreach ($array as $value) {
			$out .= $value." ";
		}
		return $out;
	}
	public function toArray($matrix){
			
		//$co = array_sum(array_map("count", $matrix));
		$M =sizeof($matrix);
		$N =sizeof($matrix[0]);
		$K =sizeof($matrix[0][0]);
		
		
		$array = array();//$M*$N*$K);

		for( $i=0; $i<$M; $i++){
			for( $j=0; $j<$N; $j++){
				for( $k=0; $k<$K; $k++){
					$array[ $i*($N*$M) + $j*$M + $k ]=$matrix[ $i ][ $j ][ $k ];
						//print $array[ $i*($N*$M) + $j*$M + $k ]." ";
				}
			}
		}
			
		//print_r($array);
		return $array;
	}

}

$genetic = new Genetic(1,1,1);
$gen1 = [[[1,2,3],[4,5,6],[7,8,9]],[[10,11,12],[13,14,15],[16,17,18]],[[19,20,21],[22,23,24],[25,26,27]]];
$gen2 = [[[28,29,30],[31,32,33],[34,35,36]],[[37,38,39],[40,41,42],[43,44,45]],[[46,47,48],[49,50,51],[52,53,54]]];

$genetic->cruza($gen1,$gen2);
?>