<!-- Contains Modals, tokens, footer -->
<?php
	$token = null;
?>
<!-- Forms -->
				<div id="login-modal"class="modal fade">
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				        <h4 class="modal-title">Login</h4>
				      </div>
				      <div class="modal-body">
				        <input type="text"class="form-control"placeholder="Username..."/>
				        <br>
				        <input type="password"class="form-control"placeholder="Password..."/>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary">Login</button>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<!--  -->
				<div id="register-modal"class="modal fade">
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				        <h4 class="modal-title">Register</h4>
				      </div>
				      <div class="modal-body">
				        <input type="text"class="form-control"placeholder="Username..."/>
				        <br>
				        <input type="text"class="form-control"placeholder="Password..."/>
				        <br>
				        <input type="text"class="form-control"placeholder="Confirm Password..."/>
				        <br>
				        <input type="text"class="form-control"placeholder="Email..."/>
				        <br>
				        <input type="checkbox"/> I accept the <a href="">Terms and Agreements</a>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary">Register</button>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<!--  -->
				<div id="recover-modal"class="modal fade">
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				        <h4 class="modal-title">Recover</h4>
				      </div>
				      <div class="modal-body">
				        <input type="text"class="form-control"placeholder="Username or Email..."/>
				        <br>
				        <p>An email will be sent to your associated email. Follow the directions within.</p>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary">Recover</button>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<!--  -->
				<div id="contact-modal"class="modal fade">
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
					<br>
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				        <h4 class="modal-title">Contact Us</h4>
				      </div>
				      <div class="modal-body">
				      	I am contacting Infinity for:
				        <span class="dropdown">
							  <span class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
							    <span>Questions</span>
							    <i class="fa fa-caret-down"></i>
							  </span>
							  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
							    <li role="presentation"><a role="menuitem" tabindex="-1">Comments</a></li>
							    <li role="presentation"><a role="menuitem" tabindex="-1">Security</a></li>
							    <li role="presentation"><a role="menuitem" tabindex="-1">Support</a></li>
							  </ul>
						</span>
						<br>
						<input type="text"class="form-control"placeholder="Subject..."/>
						<br>
						<textarea class="form-control"name="" id="" cols="30" rows="10"></textarea>
						<br>
						<p>
							Please be as specific as possible. We do actually read this stuff, so if you feel like trolling we'll feel like banning.
						</p>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary">Send</button>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<!-- Tokens -->
				<input type="hidden"id="csrfToken"value=
				<?php
					echo '"'+$token+'"';
				?>
				>
		<!-- <div id="bottom">
			&copy; <a href="index.html">Infinity-Forum.org</a> - All rights reserved
		</div> -->
		<!-- Libs -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.2/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script src="js/base.js"></script>