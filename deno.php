<?php
			$total_inc = 0;
			$data=[];
			?>
			$amount_may = number_format($_SESSION['amount_may']);
			$amount_june = number_format($_SESSION['amount_june']);
			$amount_july = number_format($_SESSION['amount_july']);
			$amount_aug = number_format($_SESSION['amount_august']);
			$amount_sep = number_format($_SESSION['amount_september']);
			$amount_oct = number_format($_SESSION['amount_october']);
			$amount_nov= number_format($_SESSION['amount_november']);
			$amount_dec = number_format($_SESSION['amount_dec']);
			$amount_total = number_format($_SESSION['total_inc']);
			foreach($_SESSION['query_total'] as $totals)
					{
						if($totals['cust_id'] == $row['id'])
						{
							$c_total = number_format($totals['total']);
			
							
						}
						else
						{}
					}
			  
			<? while(($row_revenue = mysqli_fetch_array($query_revenues, MYSQLI_ASSOC))):
				{
				array_push($data,$row_revenue);
				}
				?>
				<? endwhile; ?>


				
				
				
				
				<? foreach(mysqli_fetch_array($query_revenues, MYSQLI_ASSOC) AS $row_revenue):?>
				
				
					

				 
				 
				<tr>
				<td><? $row_revenue['cust_name'] ?>
				</td>
				
				<td><? $row_revenue['cust_email'] ?>
				</td>
				<td><? if($row_revenue['sav_month']=='January'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><? endif; ?></td>
				 <td><? if($row_revenue['sav_month']=='February'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 <td><? if($row_revenue['sav_month']=='March'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 <td><? if($row_revenue['sav_month']=='April'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 <td><? if($row_revenue['sav_month']=='May'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 <td><? if($row_revenue['sav_month']=='June'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 <td><? if($row_revenue['sav_month']=='July'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 <td><? if($row_revenue['sav_month']=='August'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 <td><? if($row_revenue['sav_month']=='September'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 <td><? if($row_revenue['sav_month']=='October'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 <td><? if($row_revenue['sav_month']=='November'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 <td><? if($row_revenue['sav_month']=='December'):
				    {
						echo $row_revenue['sav_amount'];
					}
				?><?endif;?></td>
				 </tr><tr>
				
			      <? endforeach; ?>
				  </tr>
				 
				
				
				
			
		
		
			
			

			
			
			
			</table>
			<?php
	