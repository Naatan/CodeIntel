<?php $id = uniqid(); ?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: <?php echo $severity; ?></p>
<p>Message:  <?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>

<p><a href="javascript:show('bt_<?php echo $id ?>')">Show Backtrace</a></p>
<div id="bt_<?php echo $id ?>" style="display: none;">
	<pre><?php
	
		$a = array_reverse(debug_backtrace());
		$c = 1;
		$msg = '';
		foreach ($a AS $b) {
			if ($b['function']=='_exception_handler') break;
			$msg .= $c.'. ';
			if(isset($b['class']))
				$msg .= $b['class'].'->';
			$msg .= $b['function'].'() '.(isset($b['file']) ? $b['file'].':'.$b['line'] : '')."\n";
			$c++;
		}
		
		echo $msg;
	
	?>
	</pre>
</div>

</div>

<script type="text/javascript"><!--
function show(id) {
	document.getElementById(id).style.display='block';
}
//--></script>