<?php
	require_once "generic_init.php";
?>

		<div class="m-4">
			<div class="container-fluid">
				<!-- Card sizing using grid markup -->
				<div id="div_progress" class="row mb-3">
					<div class="col-sm-12">
						<div class="card" id="result">
							<div class="card-body">
								<div class="progress" id="progress_bar" style="height:50px;">
									<div class="progress-bar border border-dark" id="progress_bar_process" role="progressbar" style="width:0%; height:50px;">0%

									</div>
								</div>
								<div id="action_result_notification" class="row justify-content-center"></div>
								<button id="close_button" type="button" class="row mt-3 btn btn-primary border border-dark justify-content-center mx-auto" onclick="closeDivProgress();">Close notification</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 mb-3">
						<div class="card" style="height: 100%; background-color: #63a4ff; background-image: linear-gradient(315deg, #63a4ff 0%, #83eaf1 74%);">
							<div class="card-body">
								<p class="card-text" class="small">Upload png, gif, jpg</p>
								<label class="btn btn-primary btn-sm btn-block border border-dark" for="my-file-selector">
									<input id="my-file-selector" type="file" style="display:none" accept="image/x-png,image/gif,image/jpeg" form="main" multiple />
									Browse...
								</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6 mb-3">
						<div class="card" style="height:100%; background-color: #fad0c4; background-image: linear-gradient(315deg, #fad0c4 0%, #f1a7f1 74%);">
							<div class="card-body">
								<div id="drag_drop" class="small">Drag file(s) here</div>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
		
		<style>
			#drag_drop {
				background-color : #f9f9f9;
				border : #ccc 4px dashed;
				line-height : 50px;
				padding : 12px;
				font-size : 16px;
				text-align : center;
				width: 100%;
			}
			
			.file_font {
				color: Red;
			}
			
			.success {
				background-color: #abe9cd;
				background-image: linear-gradient(315deg, #abe9cd 0%, #3eadcf 74%);
			}
			
			.error {
				background-color: #f9c1b1;
				background-image: linear-gradient(315deg, #f9c1b1 0%, #fb8085 74%);
			}
			
			.title {
				background-color: darkgreen;
				background-image: linear-gradient(to right, darkgreen , green);
			}
		</style>

		<script>
			function _(element)
			{
				return document.getElementById(element);
			}
			
			_('div_progress').style.display = 'none';
			_('close_button').style.display = 'none';
			_('action_result_notification').innerHTML = '';

			var idInterval;
			var intervalStart;
			var intervalRemaining;
			var intervalDecrease;
			intervalStart = 4000; //miliseconds
			intervalDecrease = 1000;

			function uploadFiles(event, drop_files)
			{
				event.preventDefault();

				var form_data  = new FormData();
				var image_number = 1;
				var error = '';

				_('div_progress').style.display = 'block';

				for(var count = 0; count < drop_files.length; count++)
				{
					if(!['image/jpeg','image/jpg', 'image/png', 'image/gif'].includes(drop_files[count].type))
					{
						error += '<div class="row justify-content-center mx-auto clearfix" style="align:center;"><b><u><font color=Blue>' +  drop_files[count].name + '</font></u></b>&nbsp;is not an accepted type</div>';
					}
					else
					{
						form_data.append("images[]", drop_files[count]);
					}

					image_number++;
				}

				if(error != '')
				{
					_('progress_bar_process').style.backgroundColor = "red";
					_('progress_bar_process').style.width = '100%';
					_('progress_bar_process').innerHTML = 'Errors';
					_('close_button').style.display = 'block';

					_('action_result_notification').innerHTML = error;
					_('drag_drop').style.borderColor = '#ccc';
				}
				else
				{
					_('progress_bar_process').style.backgroundColor = "green";
					_('progress_bar_process').style.width = '0%';
					_('progress_bar_process').innerHTML = '';
					_('progress_bar').style.display = 'block';

					var ajax_request = new XMLHttpRequest();
					ajax_request.open("post", "upload_drag.php");
					ajax_request.upload.addEventListener('progress', function(event)
					{
						var percent_completed = Math.round((event.loaded / event.total) * 100);
						_('progress_bar_process').style.width = percent_completed + '%';
						_('progress_bar_process').innerHTML = percent_completed + '% completed';
					});

					ajax_request.addEventListener('load', function(event)
					{
						intervalRemaining = intervalStart;
						_('action_result_notification').innerHTML = 'Success! Closes automatically in ' + Math.round(intervalRemaining/intervalDecrease, 0) + 's';
						_('drag_drop').style.borderColor = '#ccc';
						
						idInterval = setInterval(closeDivProgress, intervalDecrease);
					});
					ajax_request.send(form_data);
				}
			}
		
			function closeDivProgress()
			{
				if(intervalRemaining > 0)
				{
					_('action_result_notification').innerHTML = 'Success! Closes automatically in ' + Math.round(intervalRemaining/intervalDecrease, 0) + 's';
					intervalRemaining -= intervalDecrease;
				}
				else
				{
					_('div_progress').style.display = 'none';
					intervalRemaining = 0;
					_('action_result_notification').innerHTML = '';
					clearInterval(idInterval);
				}
			}
		
			_('drag_drop').ondragover = function(event)
			{
				this.style.borderColor = '#333';
				return false;
			}

			_('drag_drop').ondragleave = function(event)
			{
				this.style.borderColor = '#ccc';
				return false;
			}


			_('drag_drop').ondrop = function(event)
			{
				uploadFiles(event, event.dataTransfer.files);
				return false;
			}

			_('my-file-selector').onchange = function(event)
			{
				uploadFiles(event, this.files);
				return false;
			}
		</script>

<?php
	require_once "generic_done.php";
?>