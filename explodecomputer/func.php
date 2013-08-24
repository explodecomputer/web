<?

class enumerate_values
{
	public $values;
	public function __construct($table, $column)
	{
		$sql = "SHOW COLUMNS FROM $table LIKE '$column'";
		if ($result = mysql_query($sql))
		{
			$enum = mysql_fetch_object($result);
			preg_match_all("/'([\w ]*)'/", $enum->Type, $values);
			$this->values = $values[1];
		} else {
			die("Unable to fetch enum values: ".mysql_error());	
		}
	}
}

class encode_values
{
	public $showval;
	public function __construct($request, $values, $exclude)
	{
		if(isset($request))
		{
			$showval = preg_split('//', $request, -1, PREG_SPLIT_NO_EMPTY);
		} else {
			$showval = $values;
			for($i = 0; $i < count($showval); $i++)
			{
				$showval[$i] = 1;
				for($j = 0; $j < count($exclude); $j++)
				{
					if($exclude[$j] == $values[i])
					{
						$showval[$i] = 0;
					}
				}				
			}
		}
	}
}


?>