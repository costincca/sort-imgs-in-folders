	<?php
		require_once "generic_init.php";
		require_once "globalfunctions.php";
	?>

		<!-- Return to the page for handling an action -->
		<!-- ACTION Move to folder -->
		<div id="div_progress" class="m-4">
			<div class="container-fluid">
				<div class="row mb-3">
					<div class="col-sm-12">
						<div class="card" id="result">
							<div class="card-body">
								<div id="action_result_notification" class="row justify-content-center"></div>
								<button id="close_button" type="button" class="row mt-3 btn btn-primary border border-dark justify-content-center mx-auto" onclick="closeDivProgress();">Close notification</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<form action="index.php" class="form-horizontal" method="post" id="main"></form>
			<nav class="navbar sticky-top navbar-light bg-light">
				<div class="container">
					<?php
						if(isset($_POST["selImages"]))
						{
							echo '<div class="alert alert-success border border-dark">';
								echo "<b>" . count($_POST["selImages"]) . "</b> files will be copied/moved to <u>" . $_POST["selFolder"][0] . "</u><br />";
								foreach ($_POST['selImages'] as $sImage)
								{
									$initialPath = realpath($sImage);
									$finalPath = realpath($_POST["selFolder"][0]) . DIRECTORY_SEPARATOR . basename($sImage);
									echo "<b>" . basename($sImage) . "</b> will be moved to <u>" . $_POST["selFolder"][0] . "</u>... ";
												
									if(rename($initialPath, $finalPath))
									{
										echo "<font color=green><b>Ok</b></font><br />";
										
										$comments = exif_read_data($finalPath, 'COMMENT', true);
										if($comments) echo "<b>" . $comments["COMMENT"][0] . "</b>";
									}
									else
									{
										echo "<font color=red><b>Error</b></font><br />";
									}
								}
							echo "</div>";
						}
					?>
				</div>
			</nav>

			<nav class="navbar sticky-top navbar-light bg-light">
				<h6 class="mt-3 mb-3 text-primary"><b>Move or Copy To Folder</b></h6>
				<?php
					$folders_dirname = "Sorted/*";
					$folders = glob($folders_dirname, GLOB_ONLYDIR);

					foreach($folders as $folder)
					{
						$cntfiles = count(array_diff( scandir($folder), array(".", "..") ));
						echo '<button type="submit" class="btn btn-primary btn-sm m-2 shadow btn-grad" name="selFolder[]" form="main" value="' . $folder . '">' . basename($folder) . '</b> (' . $cntfiles . ')</button>';
					}
				?>
				<span style="float:right;">
					<input type="text" class="m-2 shadow" id="newfolder" name="foldername" value="" form="main" placeholder="Folder Name">
					<button type="submit" class="btn btn-success btn-sm m-2 shadow" id="createfolderbtn" form="main" name="selFolder[]" value="">Create Folder</button>
				</span>
			</nav>
			
			<br />
				
			<?php			
				$images_dirname = "ToSort/*";
				$images = glob($images_dirname . "*.{jpg,gif,png,jpeg}", GLOB_BRACE);
			?>

			<hr size=1>

			<h6 class="mt-3 mb-3 text-primary"><b>Files in Current Folder to Sort: <?php echo count($images) . " file(s)"; ?></b></h6>
			<div class="container-fluid" id="card-container">
				<div class="row">
					<?php
						foreach($images as $image)
						{
							$info = pathinfo($image);
							$ext = $info['extension'];
					?>			
							<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
								<div class="card border border-dark">
									<div class="card-header">
										<span><input type="checkbox" name="selImages[]" form="main" value="<?php echo $image; ?>"></span>
										<span><?php echo mb_strimwidth(basename($image), 0, 15, "..."); ?></span>
										
										<div class="mt-1" style="float:right; font-size: 14px; color: green;">
											<a href=# title="<?php echo basename($image); ?>"><span class="fas fa-info-circle" style="float:right; color: green;"></span></a>
										</div>
									</div>
									<div class="card-body m-2 p-0">
										<div class="card-top">
											<?php echo '<img src="' . $image . '" width="100%" alt="' . $image . '" />'; ?>
										</div>
										<div class="text-center">
											<div class="">
												<span class=""><?php echo $ext; ?></span>
											</div>
											<div class="">
												<span class="fas fa-info-circle"></span>
											</div>
										</div>
										<p class="text-center"><strong>Size</strong> <?php echo human_filesize(filesize($image)); ?></p>
										<p class="text-center"><strong>Hash</strong> <?php echo hash_file("md2",$image); ?></p>
									</div>
								</div>
							</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>

		<script>
			$(document).ready(function()
			{
				// Card Multi Select
				$('input[type=checkbox]').click(function()
				{
					if ($(this).parent().parent().hasClass('active'))
					{
						$(this).parent().parent().removeClass('active');
					}
					else
					{
						$(this).parent().parent().addClass('active');
					}
				});
			});
			// allow users to select multiple cards with shift key
			$('#card-container').on('click', '.card-pf-view-checkbox>input', function(event)
			{
				var $cardsContainer = $('.container-cards-pf');
				var prevIndex = $cardsContainer.data('prevIndex');
				var $cards = $cardsContainer.find('.card-pf');
				var $currentCard = $(this).closest('.card-pf');
				if(event.shiftKey && prevIndex > -1 && this.checked)
				{
					var currentIndex = $cards.index($currentCard);
					var $selectScope = currentIndex - prevIndex > 0
					? $currentCard.parent().prevAll().not($cards.eq(prevIndex).parent().prevAll().addBack())
					: $cards.eq(prevIndex).parent().prevAll().not($currentCard.parent().prevAll().addBack());
					$selectScope.children().addClass('active').find('.card-pf-view-checkbox').children('input').prop('checked', true);
				}
				$cardsContainer.data('prevIndex', this.checked ? $cards.index($currentCard) : -1);
			});

		</script>

		<script>
			function _(element)
			{
				return document.getElementById(element);
			}

			_('div_progress').style.display = 'none';
			//_('close_button').style.display = 'none';
			_('action_result_notification').innerHTML = '';

			var idInterval;
			var intervalStart;
			var intervalRemaining;
			var intervalDecrease;
			intervalStart = 4000; //miliseconds
			intervalDecrease = 1000;

			_('newfolder').onkeypress = function(event)
			{
				_('createfolderbtn').value = this.value;
				return true;
			}

			_('createfolderbtn').onclick = function(event)
			{
				event.preventDefault();

				_('div_progress').style.display = 'block';
				
				var form_data  = new FormData();
				var error = '';

				form_data.append("foldername", _('newfolder').value);

				var ajax_request = new XMLHttpRequest();
				ajax_request.open("post", "mkdir.php", true);
				ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				ajax_request.addEventListener('load', function(event)
				{
					intervalRemaining = intervalStart;
					_('action_result_notification').innerHTML = 'Success! Closes automatically in ' + Math.round(intervalRemaining/intervalDecrease, 0) + 's';
					
					idInterval = setInterval(closeDivProgress, intervalDecrease);
				});
				ajax_request.send(form_data);
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
		</script>
	<?php
		require_once "generic_done.php";
	?>