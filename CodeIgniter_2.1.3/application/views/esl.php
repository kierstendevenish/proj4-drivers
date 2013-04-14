<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title>Flower Shop - Set ESL</title>
 </head>
 <body>
   <h1>Set your Event Signal URL:</h1>
   <?php echo validation_errors(); ?>
   <?php echo form_open('home/setEsl'); ?>
     <label for="esl">ESL:</label>
     <input type="text" size="20" id="esl" name="esl" value="<?php echo $esl ?>"/>
     <br/>
     <input type="submit" value="Set"/>
   </form>
 </body>
</html>