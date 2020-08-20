<?php
/* By Lukáš Plevač
under apache 2.0
https://www.apache.org/licenses/LICENSE-2.0
*/

class template {
	private $name;
	private $dir;

    
	function __construct($name, $dir = '.') {
    	$this->name = $name;
    	$this->dir = $dir;
	}
	
	public function create($data, $min = false){
		//Načtení html souboru
		$templatefile = file_get_contents("$this->dir/templates/$this->name.html");
		
		//Nalezení všech ##key## (Slouží pro zavedení jiného html)
		preg_match_all('/\##(.*?)\##/', $templatefile, $matches);
		//Odstranění duplikátů
		$matches = array_map('array_unique', $matches);

		//Nahrazení všech ##key## za html kód z souborů
		foreach( $matches[1] as $key ) {
			$htmlinclude = file_get_contents("$this->dir/templates/$key.html");
			$templatefile = str_replace("##$key##", $htmlinclude, $templatefile);
		}
		
		$data['year'] = date("Y");
		//Nahrazení %%key%% za hodnoty z php
		foreach ($data as $key => $value) {
			$templatefile = str_replace("%%$key%%", $value, $templatefile);
		}
		
		//Porovnávení věci musí být již očištěny od možného špatného kódu!!!
		//podpara if v HTML kode
		//{% if %%test%% == %%test2%% %}
		//html if true
		//{% endif %}
		preg_match_all("'{% if (.*?) %}(.*?){% endif %}'si", $templatefile, $matches);
		
		//Odstranění duplikátů
		$matches = array_map('array_unique', $matches);
		
		//řazení v array 0 -> celý if block, 1 -> podmínka, 2 -> kód když je podmínka prvdivá
		foreach ($matches[0] as $key => $ifblock) {
			$result = "";
			
			eval('$true = ' . $matches[1][$key] . ';');
			if ($true){
				$result = $matches[2][$key];
			}
			
			$templatefile = str_replace($ifblock, $result, $templatefile);
		}
		
		//Minimalizace kódu na jeden řádek
		if ($min) {
			$templatefile = preg_replace("/\s+|\n+|\r/", ' ', $templatefile);
		}
		
		echo $templatefile;
	}

}

?>