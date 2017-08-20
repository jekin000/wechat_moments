<?php
require_once('heartstone.php');
	//test_split();
	//test_heartstone_create();

	$tt = new test();

	$tt->testObj();

class test
{
	public function testObj()
	{
		$ht = new HeartStone();
		echo $ht->createDeck('hello');
	}
}

function test_heartstone_create()
{
	$heartstone= new HeartStone();
	echo $heartstone->createDeck('hello');
}
function test_split()
{
	$str = '101';
	print_r(split(" ",$str));

	$str = '101 001';
	$cmd = split(" ",$str);
	echo $cmd[0]."\n";
	

}

?>
