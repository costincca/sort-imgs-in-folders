	<?php
		require_once "generic_init.php";
		require_once "globalfunctions.php";
	?>
		<!-- Return to the page for handling an action -->
		<nav class="navbar sticky-top navbar-light bg-light p-0 m-0">
			<!-- ACTION Move to folder -->
			<div class="container justify-content-center">
				<?php
					if(isset($_POST["selImages"]))
					{
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
									
									$comments = exif_read_data($finalPath, 'COMMENT', true);
									if($comments) echo "Comments: <b>" . $comments["COMMENT"][0] . "</b>";
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

			<!-- ACTION Create folder -->
			<div class="container justify-content-center">
				<?php
					if(isset($_POST['foldername']))
					{
						echo '<div class="alert alert-success border border-dark">';
							echo "Folder <b>" . $_POST['foldername'] . "</b> will be created<br />";
							$dirname = $_POST['foldername'];
							
							if (strpbrk($dirname, "\\/?%*:|\"<>") === FALSE)
							{	
								if (!is_dir($dirname)) {
									echo "...creating <b>" . $_POST["foldername"] . "</b>... ";
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
					}
				?>
			</div>
		</nav>

		<form action="index.php" class="form-horizontal" method="post" id="main">
			<nav class="navbar sticky-top navbar-light bg-light p-0 m-0">
				<h6 class="ms-2 me-2 mt-1 mb-1 mr-auto text-primary">Move or Copy To Folder</h6>
				<?php
					$folders_dirname = "Sorted/*";
					$folders = glob($folders_dirname, GLOB_ONLYDIR);

					foreach($folders as $folder)
					{
						$cntfiles = count(array_diff( scandir($folder), array(".", "..") ));
						echo '<button type="submit" class="btn btn-primary btn-sm m-1 shadow btn-grad me-2" name="selFolder[]" form="main" value="' . $folder . '">' . basename($folder) . '</b> (' . $cntfiles . ')</button>';
					}
				?>
				<input type="text" class="m-2 ms-auto" id="newfolder" name="foldername" value="" form="main" placeholder="Folder Name">
				<button type="submit" class="btn btn-success btn-sm m-2 shadow btn-grad" id="createfolderbtn" form="main" name="selFolder[]" value="">Create Folder</button>
			</nav>
				
			<?php			
				$images_dirname = "ToSort/*";
				$images = glob($images_dirname . "*.{jpg,gif,png,jpeg}", GLOB_BRACE);
			?>

			<h6 class="ms-2 me-2 mt-1 mb-1 mr-auto text-primary">Files in Current Folder to Sort: <b><?php echo count($images) . "</b> file(s)"; ?></h6>
			<div class="container-fluid mt-3" id="card-container">
				<div class="row">
					<?php
						foreach($images as $image)
						{
							$info = pathinfo($image);
							$ext = $info['extension'];
					?>			
							<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">
								<div class="card border border-dark">
									<div class="card-header ps-3 p-1">
										<input type="checkbox" name="selImages[]" form="main" value="<?php echo $image; ?>">
										<span class="ms-2 fs-6"><?php echo mb_strimwidth(basename($image), 0, 15, "..."); ?></span>
										<a href="#" class="me-auto" title="<?php echo "Filename: " . basename($image) . "\n" . "Extension: " . $ext . "\n" . "Filesize: " . human_filesize(filesize($image))  . "\n" . "Hash code: " . hash_file("md2", $image);?>"><span class="fas fa-info-circle"></span></a>
									</div>
									<div class="card-body m-1 p-0">
										<div class="card-top">
											<?php echo '<img src="' . $image . '" width="100%" alt="' . $image . '" />'; ?>
										</div>
										<!--div class="text-center">
											<div class="">
												<span class=""><?php echo $ext; ?></span>
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