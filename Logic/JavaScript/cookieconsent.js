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
					"policy": "Politica de confidențialitate",
					"message": "Acest site poate fi vizitat complet anonim și nu salvează niciun fel de date. Totuși, pentru o experiență mai bună, te poți conecta cu Facebook, caz în care site-ul salvează momentul conectării și exclusiv date oferite de Facebook din profilul tău public, fără niciun acces suplimentar.",
					"dismiss": "Am înțeles",
					"link": "Află mai multe.",
					"href": "pp.htm"
				},
					function (popup) {
						p = popup;
					},
					function (err) {
						console.error(err);
					}
			});