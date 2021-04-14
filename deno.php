<?php
			$total_inc = 0;
			$data=[];
			?>
			
			  
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
	