	<?php
		require_once "generic_init.php";
		require_once "globalfunctions.php";

		$pageaction = 0;
		if(isset($_POST['pageaction']))
			$pageaction = $_POST['pageaction'];

		// echo "Page action: " . $pageaction;
	?>
		<script>
			function selectDeselectAllCheckboxes(val)
			{
				var checkboxes = document.getElementsByName('selImages[]');
				//var values = [];
				for (var i = 0; i < checkboxes.length; i++) {
      				checkboxes[i].checked = val;
      				// values.push(checkboxes[i].value);
    			}
			}
		</script>

		<!-- Return to the page for handling an action -->
		<nav class="navbar sticky-top navbar-light bg-light p-0">
			<!-- ACTION Create folder -->
			<?php
				if(isset($_POST['foldername']) && ($pageaction == 1))
				{					
					echo '<div class="container justify-content-center mt-2" id="createfolderdiv">';
						echo '<div class="alert alert-success border border-dark">';
							echo "Folder <b>" . $_POST['foldername'] . "</b> will be created<br />";
							$dirname = $_POST['foldername'];
							
							if (strpbrk($dirname, "\\/?%*:|\"<>") === FALSE)
							{	
								if (!is_dir($dirname)) {
									echo "...creating folder <b>" . $_POST["foldername"] . "</b>... ";
									mkdir("Sorted/" . $dirname);
									if(is_dir("Sorted/" . $dirname))
									{
										echo "<font color=green><b>Ok</b></font><br />";
									}
									else
									{
										echo "<font color=red><b>Error</b></font><br />";
									}
								}
							}
						echo "</div>";
						//echo 'success';
					echo "</div>";
					echo "<script>";
						echo "const elem = document.getElementById('createfolderdiv');";
						echo "setTimeout(hideElement, 3000);";
						echo "function hideElement() { elem.style.display = 'none'; }";
					echo "</script>";
				}
			?>

			<!-- ACTION Move to folder -->
			<?php
				if(isset($_POST["selImages"]) && ($pageaction == 2))
				{
					echo '<div class="container justify-content-center mt-2" id="movetofolderdiv">';
						echo '<div class="alert alert-success border border-dark">';
							echo "<b>" . count($_POST["selImages"]) . "</b> file(s) will be copied/moved to <u>" . $_POST["selFolder"][0] . "</u><br />";
							foreach ($_POST['selImages'] as $sImage)
							{
								$initialPath = realpath($sImage);
								$finalPath = realpath($_POST["selFolder"][0]) . DIRECTORY_SEPARATOR . basename($sImage);
								echo "...moving <b>" . basename($sImage) . "</b> to <u>" . $_POST["selFolder"][0] . "</u>... ";
											
								if(rename($initialPath, $finalPath))
								{
									echo "<font color=green><b>Ok</b></font><br />";
									
									//!$comments = exif_read_data($finalPath, 'COMMENT', true);
									//!if($comments) { echo "Comments: <b>" . $comments["COMMENT"][0] . "</b>"; }
								}
								else
								{
									echo "<font color=red><b>Error</b></font><br />";
								}
							}
						echo "</div>";
					echo "</div>";
					echo "<script>";
						echo "const elem = document.getElementById('movetofolderdiv');";
						echo "setTimeout(hideElement, 3000);";
						echo "function hideElement() { elem.style.display = 'none'; }";
					echo "</script>";
				}
			?>
		</nav>

		<form action="index.php" class="form-horizontal" method="post" id="main">
			<input name='pageaction' id='pageaction' type='hidden' form='main' value='0'>
			<nav class="navbar sticky-top navbar-light bg-light p-1 m-0 shadow">
				<h6 class="ms-1 me-2 mt-1 mb-1 mr-auto text-primary">Move To Folder</h6>
				<?php
					$folders_dirname = "Sorted/*";
					$folders = glob($folders_dirname, GLOB_ONLYDIR);

					if(count($folders) > 0)
						foreach($folders as $folder)
						{
							$cntfiles = count(array_diff( scandir($folder), array(".", "..") ));
							echo '<button type="submit" class="btn btn-primary btn-sm m-1 shadow btn-grad text-white" name="selFolder[]" form="main" value="' . $folder . '" onclick=' . '"' . "document.getElementById('pageaction').value=2" . '"' . '>' . basename($folder) . '</b> (' . $cntfiles . ')</button>';
						}
					else
					{
						echo '<button type="submit" class="btn btn-outline-danger btn-sm m-1 shadow disabled btn-grad text-black" value="">No folders. Please create one first.</button>';
					}
				?>
				<div class="mx-auto"></div>
				<div class="ms-auto d-flex">
					<input type="text" class="m-1 small p-0" id="newfolder" name="foldername" value="" form="main" placeholder="Folder Name">
					<button type="submit" class="btn btn-success btn-sm m-1 shadow btn-grad text-white" id="createfolderbtn" form="main" name="selFolder[]" value="" onclick="if(document.getElementById('newfolder').value === '') { alert('Folder name should not be blank!'); return false; } else { document.getElementById('pageaction').value=1; }">+ Create</button>
				</div>
			</nav>
				
			<?php			
				$images_dirname = "ToSort/*";
				$images = glob($images_dirname . "*.{jpg,gif,png,jpeg}", GLOB_BRACE);
			?>

			<h6 class="ms-2 me-2 mt-1 mb-1 mr-auto text-primary d-flex mt-3">
				<div class="ms-2 me-auto">Files to Sort: <b><?php echo count($images) . "</b> file(s)"; ?></div>
				<div class="ms-auto ms-2">
					<input type="checkbox" name="selectall" value="false" id="selectall" onclick="selectDeselectAllCheckboxes(document.getElementById('selectall').checked);">
					<label for="selectall" class="noselect">
						Select/Deselect All	
					</label>
				</div>
			</h6>
			<div class="container-fluid mt-3" id="card-container">
				<div class="row">
					<?php
						foreach($images as $image)
						{
							$info = pathinfo($image);
							$imagename = basename($image);
							$imageext = $info['extension'];
					?>			
							<div class="col-xxs-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xxl-2">
								<div class="card border border-dark">
									<div class="card-header ps-2 p-1">
										<input type="checkbox" name="selImages[]" form="main" value="<?php echo $image; ?>" id="<?php echo $imagename; ?>">
										<span class="ms-2 fs-6"><a nohref title="<?php echo "Filename: " . $imagename . "\n" . "Extension: " . $imageext . "\n" . "Filesize: " . human_filesize(filesize($image))  . "\n" . "Hash code: " . hash_file("md2", $image);?>"><?php echo mb_strimwidth(basename($image), 0, 20, "..."); ?></a></span>
										<!-- a href="#" class="me-auto" title="<?php echo "Filename: " . $imagename . "\n" . "Extension: " . $imageext . "\n" . "Filesize: " . human_filesize(filesize($image))  . "\n" . "Hash code: " . hash_file("md2", $image);?>"><span class="fas fa-info-circle"></span></a -->
									</div>
									<div class="card-body m-1 p-0">
										<div class="card-top text-center">
											<label for="<?php echo $imagename; ?>">
												<?php echo '<img src="' . $image . '"  width="100%" alt="' . $image . '" />'; ?>
											</label>
										</div>
										<!--div class="text-center">
											<div class="">
												<span class=""><?php echo $imageext; ?></span>
											</div>
											<div class="">
												<span class="fas fa-info-circle"></span>
											</div>
										</div-->
										<!--p class="text-center"><strong>Size</strong> <?php echo human_filesize(filesize($image)); ?></p-->
										<!--p class="text-center"><strong>Hash</strong> <?php echo hash_file("md2", $image); ?></p-->
									</div>
								</div>
							</div>
					<?php
						}
					?>
				</div>
			</div>
		</form>

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
	<?php
		require_once "generic_done.php";
	?>