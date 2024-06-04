<?php
function highlight_array($array, $name = 'var')
{
	highlight_string("<?php\n\$$name =\n" . var_export($array, true) . ";\n?>");
}

function xrange($start, $limit = null, $step = null)
{
	if ($limit === null) {
		$limit = $start;
		$start = 0;
	}
	$step = $step ?? 1;
	if ($start <= $limit) {
		for ($i = $start; $i < $limit; $i += $step)
			yield $i;
	} else
        if ($step < 0)
		for ($i = $start; $i > $limit; $i += $step)
			yield $i;
}
function flatten(array $array) {
    $return = array();
    array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
    return $return;
}
var_dump($_POST);
?>
<h1>Markov Chain generator</h1>
<?php

$TEXT = "the raven and the fox and the turtle and the ass and the kick and the shit and the soup";
// $TEXT = $_POST['text'] ?? 
// "Markov chains, named after Andrey Markov, are mathematical systems that hop from one state (a situation or set of values) to another. For example, if you made a Markov chain model of a baby's behavior, you might include 'playing,' 'eating', 'sleeping,' and 'crying' as states, which together with other behaviors could form a 'state space': a list of all possible states. In addition, on top of the state space, a Markov chain tells you the probabilitiy of hopping, or transitioning, from one state to any other state---e.g., the chance that a baby currently playing will fall asleep in the next five minutes without crying first.";
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
$SPLIT_NUMBER = 3;
$step = $SPLIT_NUMBER - 1;
$split = $pieces = explode(" ", $TEXT);

$dev_prep = [];
$dev_model = [];
highlight_array($split, "split</br>");
for ($i = 0; $i < count($split) - 1; $i++) {
	$dev_prep[$i] = [$split[$i], $split[$i + 1]];
	$dev_model[$split[$i]] = [];
}

$prep = [];
$model = array_flip(array_unique($split));
foreach ($model as $key => $item) {
	$model[$key] = [];
}
foreach (xrange(0, count($split), $step) as $i) {
	for ($j = 0; $j < $SPLIT_NUMBER; $j++) {
		if ($i + $j >= count($split)) {
			break;
		}
		$prep[$i][] = $split[$i + $j];
	}
}

foreach ($prep as $key => $item) {

	$item = array_reverse($item);
	$curr_item = array_pop($item);
	$item = array_reverse($item);

	if (!array_key_exists($item[0], $model[$curr_item])) {
		$model[$curr_item][] = $item;
	}

}
function get_starter($model): string
{
	return array_rand($model);
}
$sentence = [['the']];
$MIN_LENGTH = 4;

$i = 0;
while (true) {
	if ($model[$curr_word] != '') {
		$sentence[] = $model[$curr_word][$key];
		if (count($sentence) > $MIN_LENGTH) {
			break;
		}
	}
	$i++;
}

echo join(" ", flatten($sentence));

?>
</br>
<form action="" method="post">
	<label for="text">Enter text for Markov chain generation ( if left empty will use default text ) </label>
	</br>
	<textarea name="text" rows="20" cols="50"><?php echo $_POST['text'] ?? ''; ?></textarea>
	<br>
	<button type="submit">Generate</button>
</form>