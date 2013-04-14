<table style="width:250px;">
       <tr>
           <td>
         		 <div style="border:solid 1px grey;width:50px;background-color:black;margin:auto;margin-top:5px;margin-bottom:5px;">
                      <img src="<?php echo $char->getUrlPicture('face',0,true); ?>" style="'.$style.'" alt="" />
                 </div>
           </td>
           <td>
           		<table style="width: 175px;text-align:center;">
           			<tr>
           				<td style="font-size: 20px">
           					<?php echo $char->getName(); ?>
           				</td>
           			</tr>
           			<tr>
           				<td>
           					niveau <?php echo $char->getLevel(); ?>
           				</td>
           			</tr>
					<tr><td style="width:100%;border-bottom:solid 1px grey;"></td></tr>
           			<tr>
           				<td>
           					Honneur : <?php echo $char->getHonnor(); ?>
           				</td>
           			</tr>
           			<tr>
           				<td>
           					Rang : <?php if($char->getRank() != "") { echo $char->getRank(); } else { echo "Aucun"; }; ?>
           				</td>								
				
           		</table>
           </td>
       </tr>
</table>
