<?php
	$me = $member->getUsrInfo($_SESSION['ID']);
	$wall = new wall;
	$sys = new sys;
	
?>

			<div id="pro_usr_stream_write">
            	<img src="/images/user/<?php echo $me['image']; ?>" class="pro_pic_tumb" />
                <div class="pro_stream_box">
                    <textarea></textarea> 
                    <span id="pro_usr_stream_write_send" class="btn">Send</span>
                </div>
            </div>
            <div id="pro_usr_wall">
            <input type="hidden" ID="Mee" value='<?php echo json_encode(array("ID"=> $me['ID'], "usr" => $me['username'], "img"=>$me['image'])); ?>'>
            <?php
			
				$TheWall = $wall->getWall($ID);
				while($row = mysql_fetch_array($TheWall))
				{
					$by = $member->getUsrInfo($row['by']);
					echo '<div class="pro_usr_stream_log">';
					echo '<a href="/user/'.$by['username'].'"><img src="/images/user/'.$by['image'].'" class="pro_pic_tumb" /></a>';
					echo '<div class="pro_stream_box" sID="'.$row['ID'].'">';
					echo '<b><a href="/user/'.$by['username'].'">'.$by['username'].'</a> '.(($row['to'] != $row['by'])? " &raquo; <a href=\"/user/".$member->getUsrInfo($row['to'])['username']."\">". $member->getUsrInfo($row['to'])['username']."</a>" : "") . '</b> <i>'.$sys->timeDiff($row['date']).'</i>';
					echo '<span class="pro_stream_s"><img src="/images/s.png" /></span>';
					echo '<p>'. $row['txt'];
					echo '<span class="pro_stream_l">'.$wall->getLikesCount($row['like']).' people(s) liked this</span><img src="/images/like.png" title="Like" class="stream_like_ico"></p>';
					
					
					$TheWallA = $wall->getWallA($row['ID']);
					
					while($row2 = mysql_fetch_array($TheWallA))
					{
						$by2 = $member->getUsrInfo($row2['by']);
						echo '<hr>
						<div class="pro_stream_log_a">
							<a href="/user/'.$by2['username'].'"><img src="/images/user/'.$by2['image'].'" class="pro_pic_tumb_a" /></a>
							<b><a href="/user/'.$by2['username'].'">'.$by2['username'].'</a></b> <i>'.$sys->timeDiff($row2['date']).'</i>
							<span class="pro_stream_s"><img src="/images/s.png" /></span>
							<p>
								'.$row2['txt'].'
							<span class="pro_stream_l">'.$wall->getLikesCount($row['like']).' person(s) liked this</span><img src="/images/like.png" title="Like" class="stream_like_ico">
							</p>
						</div>';
					
					}
					echo '<textarea></textarea> 
                        <span id="pro_usr_stream_write_send" class="btn">Send</span>';
					
					echo '</div><br /><br />';
					
					
					
					
					echo '</div>';
				}
				
					
			
			?>
            	
            </div>
            
            
            
            
            
            
            
           