<form>
 <input type="text" style="width:50px;"placeholder="g1" name="g1"/><input type="text" style="width:50px;"placeholder="g2" name="g2"/><input type="text" style="width:50px;"placeholder="m1" name="m1" /><input type="text" style="width:50px;"placeholder="m2" name="m2" />
 <br /><input type="submit" /><br />
 </form>
 <?php 
 $g1 = $_GET['g1'];
 $g2 = $_GET['g2'];
 $m1 = $_GET['m1'];
 $m2 = $_GET['m2'];
 $m = $m2 / $m1;
 $answer = $m * 1/2;
 echo $answer;
 ?>
 
 