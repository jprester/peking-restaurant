<?php include('admin/init.php');?>

<?php $visit1="";?>
<?php $visit2="";?>
<?php $visit3="pressed";?>
<?php $visit4="";?>
<?php $page_id= $_REQUEST["fname"];?>

<?php include('inc/header.php');?>


		<div id="title">
			<h1><img src="img/title3.png" width="63" height="61" border="0" alt="" /></h1>
		</div>
				
				</div>					
          </div>
		<div class="clearer"></div>


              <div class="clear"></div>
        
        
        
		</div>	  
	 

      
	  </div>
	  <div class="clear"></div>
	  
		<div id ="page_down">
		
			 <div class="container_12">
				  
					<div class ="grid_6">
				
						<div class="meni-list">

				
						
						<ul>	
						<?php include('inc/jelovnik_list.php');?>
							</ul>
						
						</div>
					
						<div class="text-c"><div class="mobile-meninav"><a href="#">Izbor jela <span class ="darrow"><img src="img/darrow.png" alt="" width="13" height="11" border="0" /></span> </a></div></div>
						
						<div class="text-c">

							<div class="mobile-menilist">							
							
								<ul><?php include('inc/jelovnik_list.php');?></ul>
							
							</div>	

						</div>
						<br />
					</div>
					
					
					 <div class ="grid_6">				   
				
		
					  <div id="jelovnik" >
					  
						<div id="jelovnik_top"></div>
						<div id="jelovnik_content">
						<table class="meni-table">
						<tr>
			         	  <th colspan="3" class="table_naslov">

			         	  <?php							  
			         	  $meni = new Meni();
						 echo $meni->chooseMeni($page_id);
							?></th>
						</tr>
			           <tr>
						          
			           <tr>
							<?php	
							$jelo = new Jelo();				
					       $array_jelo= $jelo->getJela($page_id);	
					       foreach ($array_jelo as $row) {
					       		 echo("<tr>". 
				 	"<td class ='td-broj'>".$row['broj']."</td>".
				 	"<td class ='td-jelo'>"."<strong>".$row['naziv']."</strong>"."<br />"."<h4>".$row['naziv_en']."<h4>"."</td>".
				 	"<td class ='td-cijena'>".$row['cijena']."</td>".	
																							
				 "</tr>");
					       					
					       				}				
							?>

							<tr class ="t_bottom"><td colspan = "3" class ="t_bottom"></td></tr>
						
						</table>

						</div>
						<div id="jelovnik_bottom"></div>
						
						<br /><p class="text-c txt2 italic">Sve cijene su izražene u kunama</p><br /><br />
						
					  </div>				

						
					</div>
				
			   <div class="clearer"></div>
			 
			
		 </div>
			
			
        </div> 

<br/><br/>	
<?php include('inc/footer.php');	?>