<div id="loginBox">
	<div class="spacer">
	   <?php echo validation_errors(); ?>
	   <?php echo form_open('verifylogin'); ?>
	     <input type="text" size="20" placeholder="username" id="username" name="username"/>
	     <input type="password" size="20" placeholder="password" id="passowrd" name="password"/>
	     <input type="submit" value="Login"/>
	   </form>
	</div>
</div>