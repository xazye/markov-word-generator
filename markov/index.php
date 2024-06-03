<?php 
function highlight_array($array, $name = 'var') {
    highlight_string("<?php\n\$$name =\n" . var_export($array, true) . ";\n?>");
}
?>
<h1>Markov Chain generator</h1>
<?php

$TEXT = "the raven and the fox like my furry friend xdd";
$TEXT = "Markov chains, named after Andrey Markov, are mathematical systems that hop from one state (a situation or set of values) to another. For example, if you made a Markov chain model of a baby's behavior, you might include 'playing,' 'eating', 'sleeping,' and 'crying' as states, which together with other behaviors could form a 'state space': a list of all possible states. In addition, on top of the state space, a Markov chain tells you the probabilitiy of hopping, or transitioning, from one state to any other state---e.g., the chance that a baby currently playing will fall asleep in the next five minutes without crying first.";
// $TEXT = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime mollitia,
// molestiae quas vel sint commodi repudiandae consequuntur voluptatum laborum
// numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga praesentium
// optio, eaque rerum! Provident similique accusantium nemo autem. Veritatis
// obcaecati tenetur iure eius earum ut molestias architecto voluptate aliquam
// nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat, odit,
// tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
// quia. Quo neque error repudiandae fuga? Ipsa laudantium molestias eos 
// sapiente officiis modi at sunt excepturi expedita sint? Sed quibusdam
// recusandae alias error harum maxime adipisci amet laborum.";
$SPLIT_NUMBER = 2;
$split = $pieces = explode(" ", $TEXT);

$prep = [];
$model =[];

for($i=0;$i<count($split)-1;$i++){
	$prep[$i]=[ $split[$i], $split[$i+1]];
	$model[$split[$i]]=[];
}

foreach ($prep as $key=>$item){
	if(!array_key_exists($item[1],$model[$item[0]])){
		$model[$item[0]][$item[1]] = 1;
	}
	else{
		$model[$item[0]][$item[1]]++;
	}
}
function get_starter($model) : string {
	return array_rand($model);
}
$sentence = ['the'];
$MIN_LENGTH = 4;

$i=0;
while (true){
	var_dump($sentence[$i],'sentence </br>');
	highlight_array($model[$sentence[$i]],"option</br>");
	if(!array_key_exists($sentence[$i],$model)){
		var_dump('true');
		$sentence[$i] = get_starter($model);
		continue;
	}
	$sentence[]=array_rand($model[$sentence[$i]]) ;
	if (count($sentence) > $MIN_LENGTH){
		break;
	}
	$i++;
}
echo join(", ",$sentence);

die();
?>
<!--  -->
	