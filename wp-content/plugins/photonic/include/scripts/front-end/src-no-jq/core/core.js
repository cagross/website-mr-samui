	var deep = location.hash, lastDeep, supportsSVG = !! document.createElementNS && !! document.createElementNS( 'http://www.w3.org/2000/svg', 'svg').createSVGRect;
	var photonicLightbox;
	var photonicLightboxList = {};
	var photonicPrompterList = {};

	window.photonicShowLoading = function() {
		var loading = document.getElementsByClassName('photonic-loading');
		if (loading.length > 0) {
			loading = loading[0];
		}
		else {
			loading = document.createElement('div');
			loading.className = 'photonic-loading';
		}
		loading.style.display = 'block';
		document.body.appendChild(loading);
	};

	window.photonicHideLoading = function() {
		var loading = document.getElementsByClassName('photonic-loading');
		if (loading.length > 0) {
			loading = loading[0];
			loading.style.display = 'none';
		}
	};

	window.photonicInitializePasswordPrompter = function(selector) {
		var selectorNoHash = selector.replace(/^#+/g, '');
		var prompter = new Modalise(selectorNoHash).attach();
		photonicPrompterList[selector] = prompter;
		prompter.show();
	};

	window.photonicDisplayLevel2 = function(provider, type, args) {
		var identifier = args['panel_id'].substr(('photonic-' + provider + '-' + type + '-thumb-').length);
		var panel = '#photonic-' + provider + '-panel-' + identifier;

		var existing = document.getElementById('photonic-' + provider + '-panel-' + identifier);

		if (existing.length === 0) {
			existing = document.getElementById(args['panel_id']);
			if (photonicUtils.hasClass(existing, 'photonic-' + provider + '-passworded')) {
				var prompter = '#photonic-' + provider + '-' + type + '-prompter-' + identifier;
				photonicInitializePasswordPrompter(prompter);
			}
			else {
				photonicShowLoading();
				photonicProcessRequest(provider, type, identifier, args);
			}
		}
		else {
			photonicShowLoading();
			photonicRedisplayPopupContents(provider, identifier, panel, args);
		}
	};

	window.photonicProcessRequest = function(provider, type, identifier, args) {
		args['action'] = 'photonic_display_level_2_contents';
		photonicUtils.post(Photonic_JS.ajaxurl, args, function(data) {
			if (data.substr(0, Photonic_JS.password_failed.length) === Photonic_JS.password_failed) {
				photonicHideLoading();
				var prompter = '#photonic-' + provider + '-' + type + '-prompter-' + identifier;
				var prompterDialog = photonicPrompterList[prompter];
				if (prompterDialog !== undefined && prompterDialog !== null) {
					prompterDialog.show();
				}
			}
			else {
				if ('show' === args['popup']) {
					photonicDisplayPopup(data, provider, type, identifier);
				}
				else {
					if (data !== '') {
						photonicBypassPopup(data);
					}
					else {
						photonicHideLoading();
					}
				}
			}
		});
	};

	window.photonicProcessL3Request = function(clicked, container, args) {
		args['action'] = 'photonic_display_level_3_contents';
		photonicShowLoading();
		photonicUtils.post(Photonic_JS.ajaxurl, args, function(data){
			var insert = photonicUtils.getElement(data);

			if (container) {
				container.insertAdjacentHTML('afterend', data);
			}

			var layout = insert.querySelector('.photonic-level-2-container');

			if (photonicUtils.hasClass(layout, 'photonic-random-layout')) {
				photonicJustifiedGridLayout(false);
			}
			else if (photonicUtils.hasClass(layout, 'photonic-mosaic-layout')) {
				photonicMosaicLayout(false);
			}
			else if (photonicUtils.hasClass(layout, 'photonic-masonry-layout')) {
				photonicMasonryLayout(false);
			}

			var level2 = insert.querySelectorAll('.photonic-level-2');
			Array.prototype.forEach.call(level2, function(item) {
				item.style.display = 'inline-block';
			});

			if (!($ && $.fn && $.fn.tooltip)) {
				photonicTooltip('[data-photonic-tooltip]', '.photonic-tooltip-container');
			}
			photonicHideLoading();

			photonicUtils.removeClass(clicked, 'photonic-level-3-expand-plus');
			photonicUtils.addClass(clicked, 'photonic-level-3-expand-up');
			clicked.setAttribute('title', Photonic_JS.minimize_panel === undefined ? 'Hide' : Photonic_JS.minimize_panel);
		});
	};

	window.photonicMoveHTML5External = function() {
		var videos = document.getElementById('photonic-html5-external-videos');
		if (!videos) {
			videos = document.createElement('div');
			videos.id = 'photonic-html5-external-videos';
			videos.style.display = 'none';
			document.body.appendChild(videos);
		}

		var current = document.querySelectorAll('.photonic-html5-external');
		if (current) {
			var cLen = current.length;
			for (var c = 0; c < cLen; c++) {
				photonicUtils.removeClass(current[c], 'photonic-html5-external');
				videos.appendChild(current[c]);
			}
		}
	};
	photonicMoveHTML5External();

