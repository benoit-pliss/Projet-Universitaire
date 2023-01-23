<!--  E.Porcq	util_chap9.php 20/09/2010 -->
<?php 
	function verifierText($n)
	{  
		if (!empty($_POST[$n]))
		{
		  $var = $_POST[$n];
          $var = preg_replace("/\"/u", "&quot;", $var);
		  if ($var <> "")
			echo $var; 
		}
		else 
		  echo ""; 
	}

function verifierTextGET($n)
{
    if (!empty($_GET[$n]))
    {
        $var = $_GET[$n];
        $var = preg_replace("/\"/u", "&quot;", $var);
        if ($var <> "")
            echo $var;
    }
    else
        echo "";
}

	function cocherRadio($civ,$n)
	{
		if (isset($_POST[$civ]))
		{
		  if ( $_POST[$civ] == $n) 
			  echo "checked";
		}
	}
	function VerifierSelect ($pa,$n)
	{
		if (isset($_POST[$pa]))
		{
		  if ( $_POST[$pa] == $n) 
			  echo "selected=true";
		}
	}
function VerifierSelectGET($pa,$n)
{
    if (isset($_GET[$pa]))
    {
        if ( $_GET[$pa] == $n)
            echo "selected=true";
    }
}
	function cocherCase ($pref,$n)
	{
		if (isset($_POST[$pref]))
			foreach($_POST[$pref] as $val)
			{
			  if ($n == $val)
			  {
				  echo "checked";
			  }
			}
	}  
?>
