		<ul class="nav fixed-bottom navbar-light title justify-content-center">
			<li class="nav-item text-white small">
				@<?php echo date("Y"); ?> costincca.ro &ndash; All Right Reserved
			</li>
		</ul>	
		
		<!-- https://www.osano.com/cookieconsent/download/ -->
		<script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>
		<script src="Logic/JavaScript/cookieconsent.js"></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		
		<!-- https://www.osano.com/cookieconsent/download/ -->
		<script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>
		<script>
			var p;
			window.cookieconsent.initialise({
				"palette": {
					"popup": {
					  "background": "#ffffff"
					},
					"button": {
					  "background": "#006400"
					}
				},
				type: "info",
				revokable:false,
				onStatusChange: function(status) {
					console.log(this.hasConsented() ? 'enable cookies' : 'disable cookies');
				},
				"content": {
					"policy": "Privacy Policy",
					"message": "This site is governed as described in the  Privacy Policy.",
					"dismiss": "Ok",
					"link": "Find out more.",
					"href": "privacypolicy.htm"
				},
					function (popup) {
						p = popup;
					},
					function (err) {
						console.error(err);
					}
			});
		</script>

		<script>
            // Enable tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
			
			var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
			var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
				return new bootstrap.Popover(popoverTriggerEl, {trigger: 'click hover focus'});
			});
			
			var collapseElementList = [].slice.call(document.querySelectorAll('.collapse'));
			var collapseList = collapseElementList.map(function (collapseEl) {
				return new bootstrap.Collapse(collapseEl);
			});
			
			var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
			var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
				return new bootstrap.Dropdown(dropdownToggleEl);
			});

			var triggerTabList = [].slice.call(document.querySelectorAll('#nav-tab button'))
			triggerTabList.forEach(function (triggerEl) {
			  var tabTrigger = new bootstrap.Tab(triggerEl);

			  triggerEl.addEventListener('click', function (event) {
				event.preventDefault();
				tabTrigger.show();
			  })
			});
		
			//var toastElList = [].slice.call(document.querySelectorAll('.toast'));
			//var toastList = toastElList.map(function (toastEl) {
			//  return new bootstrap.Toast(toastEl);
			//});
		</script>
		
		<!-- Default Statcounter code for Global Micro Tasking
		https://www.globalmicrotasking.com/elements.php -->
		<script type="text/javascript">
		var sc_project=12753544; 
		var sc_invisible=1; 
		var sc_security="2513cf2f"; 
		</script>
		<script type="text/javascript"
		src="https://www.statcounter.com/counter/counter.js"
		async></script>
		<noscript><div class="statcounter"><a title="Web Analytics
		Made Easy - Statcounter" href="https://statcounter.com/"
		target="_blank"><img class="statcounter"
		src="https://c.statcounter.com/12753544/0/2513cf2f/1/"
		alt="Web Analytics Made Easy - Statcounter"
		referrerPolicy="no-referrer-when-downgrade"></a></div></noscript>
		<!-- End of Statcounter Code -->

	</body>
</html>