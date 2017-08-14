








<?php


$getPid=mysqli_query("SELECT id FROM patients WHERE name='{$pName}'",$con);
	$pIdd=mysqli_fetch_array($getPid);
	$pId=$pIdd[0];
	
	$getDetails=mysqli_query("SELECT * FROM tempprescri WHERE customer_id='{$c_id}'",$con);
			$file=fopen("recipts/docs/".$c_id.".txt","a+");
				while($itemm=mysqli_fetch_array($getDetails))
				{			
				$id=mysqli_query("SELECT * FROM services WHERE name='{$itemm['service']}' ",$con);
				$idd=mysqli_fetch_array($id);
				fwrite($file, $itemm['service'].";".$itemm['priority'].";".$itemm['cost']."\n");
											
					$count[] = $itemm['cost'];
				}
				$total=array_sum($count);
				fwrite($file, "TOTAL;;".$total."\n");
				 fclose($file);
	$enterInv=mysqli_query("INSERT INTO invoices(invoiceNo, patient, amount, servedBy, status) VALUES('{$invoice}', '{$pId}', '{$total}', '{$who}', 'PENDING')",$con);
	
	$enterDetails=mysqli_query("SELECT * FROM tempinv WHERE inv='{$invoice}'",$con);
			
				while($itemmm=mysqli_fetch_array($enterDetails))
				{			
				$servid=mysqli_query("SELECT * FROM services WHERE name='{$itemmm['service']}' ",$con);
				$idServ=mysqli_fetch_array($servid);
				$insDet=mysqli_query("INSERT INTO invoicedetails(invoice, service) VALUES('{$invoice}', '{$idServ[0]}')",$con);
							
				
				}
				$delet=mysqli_query("DELETE FROM tempscri WHERE inv='{$invoice}'",$con);	