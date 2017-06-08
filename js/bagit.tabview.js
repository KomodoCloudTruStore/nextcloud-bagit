(function () {

    var BagItTabView = OCA.Files.DetailTabView.extend({

        id: 'bagItTabView',

        className: 'tab bagItTabView',

        hashTypes: ['md5', 'sha256'],

        /**
         * Returns the tab label
         *
         * @return {String} label
         */
        getLabel: function () {
            return t('bagit', 'BagIt');
        },

        /**
         * Renders this details view
         *
         * @abstract
         */
        render: function () {
            this.$el.html('<div class="bagit-details-menu">' +
                '<div class="bagit-details-controls" style="margin-bottom: 5px;">' +
                '</div>' +
                '<div class="bagit-details-message"></div>' +
                '</div>'
            );

            if (this.canDisplay(this.getFileInfo())) {

            	this.show(this.getFileInfo())

			}

        },

        /**
         * Returns whether the current tab is able to display
         * the given file info, for example based on mime type.
         *
         * @param {OCA.Files.FileInfoModel} fileInfo file info model
         * @return {bool} whether to display this tab
         */
        canDisplay: function (fileInfo) {

			if (fileInfo !== null) {
				if (fileInfo.isDirectory()) {
					return true;
				}
			}

			return false;
        },

        /**
         * ajax callback for generating md5 hash
         */
        show: function (fileInfo) {
            // skip call if fileInfo is null
            if (null === fileInfo) {
                _self.updateDisplay({
                    response: 'error',
                    msg: t('bagit', 'No Bags Found.')
                }, fileInfo);
                return;
            }

            var url = OC.generateUrl('/apps/bagit/bags?fileId=' + fileInfo['id']),
                _self = this;

            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                async: true,
                success: function (data) {
                    _self.updateDisplay({
                        response: 'success',
                        msg: data

                    }, fileInfo);
                }
            });
        },

        /**
         * display message from ajax callback
         */
        updateDisplay: function (data, fileInfo) {


        	var _self = this;

            var fileId = fileInfo['id'];

            if ('success' === data.response) {

                var buttonContainer = $('<div></div>');
                buttonContainer.css('display', 'flex');
                buttonContainer.css('align-items', 'center');
                buttonContainer.css('justify-content', 'space-between');
                buttonContainer.css('margin-top', '25px');

                if (data.msg.length < 1) {

					var createBtnMD5 = $('<button></button>');
					createBtnMD5.css('flex-grow', 1);

					createBtnMD5.text('Create with MD5');
					createBtnMD5.click(function() {

						var url = OC.generateUrl('/apps/bagit/bags?fileId=' + fileId + '&hash=md5');

						var __self = this;

						buttonContainer.empty();

						buttonContainer.attr('class', 'icon-loading');
						buttonContainer.css('background-position', 'center');
						buttonContainer.css('background-repeat', 'no-repeat');

						$.ajax({

							type: 'POST',
							url: url,
							dataType: 'json',
							async: true,
							success: function(data) {

								$(__self).removeClass('icon-loading');
								$(__self).attr('class', 'icon-checkmark');

								setTimeout(function() {

									_self.show(fileInfo);

								}, 2000);

							}

						});

					});

					var createBtnSHA256 = $('<button></button>');
					createBtnSHA256.css('flex-grow', 1);

					createBtnSHA256.text('Create with SHA256');
					createBtnSHA256.click(function() {

						var url = OC.generateUrl('/apps/bagit/bags?fileId=' + fileId + '&hash=sha256');

						var __self = this;

						buttonContainer.empty();

						buttonContainer.attr('class', 'icon-loading');
						buttonContainer.css('background-position', 'center');
						buttonContainer.css('background-repeat', 'no-repeat');

						$.ajax({

							type: 'POST',
							url: url,
							dataType: 'json',
							async: true,
							success: function(data) {

								$(__self).removeClass('icon-loading');
								$(__self).attr('class', 'icon-checkmark');

								setTimeout(function() {

									_self.show(fileInfo);

								}, 2000);

							}

						});

					});

					buttonContainer.append(createBtnMD5);
					buttonContainer.append(createBtnSHA256);

                } else {

					var validateBtn = $('<button></button>');
					validateBtn.css('background-color', 'rgb(56, 195, 56)');
					validateBtn.css('color', 'rgb(250,250,250)');
					validateBtn.css('flex-grow', 1);
					validateBtn.text('Validate');

                	var updateBtn = $('<button></button>');
					updateBtn.css('flex-grow', 1);

                    updateBtn.text('Update');
					updateBtn.click(function() {

						var url = OC.generateUrl('/apps/bagit/bags?fileId=' + fileId);

						$(this).css('opacity', 0.0);
						validateBtn.css('opacity', 0.0);

						buttonContainer.attr('class', 'icon-loading');
						buttonContainer.css('background-position', 'center');
						buttonContainer.css('background-repeat', 'no-repeat');

						$.ajax({

							type: 'PATCH',
							url: url,
							dataType: 'json',
							async: true,
							success: function(data) {

								buttonContainer.removeClass('icon-loading');
								buttonContainer.attr('class', 'icon-checkmark');

								setTimeout(function() {

									_self.show(fileInfo);

								}, 2000);

							}

						});

					});

					validateBtn.click(function() {

						var url = OC.generateUrl('/apps/bagit/bags?fileId=' + fileId + '&validate=true');

						$(this).css('opacity', 0.0);
						updateBtn.css('opacity', 0.0);

						buttonContainer.attr('class', 'icon-loading');
						buttonContainer.css('background-position', 'center');
						buttonContainer.css('background-repeat', 'no-repeat');

						$.ajax({

							type: 'PATCH',
							url: url,
							dataType: 'json',
							async: true,
							success: function(data) {

								buttonContainer.removeClass('icon-loading');
								buttonContainer.attr('class', 'icon-checkmark');

								setTimeout(function() {

									_self.show(fileInfo);

								}, 2000);

							}

						});

					});

					buttonContainer.append(updateBtn);
					buttonContainer.append(validateBtn);

                }

				var menu = $(".bagit-details-menu");
                menu.empty();
				menu.append(buttonContainer);

            }

            if ('error' == data.response) {
                msg = data.msg;
            }


        },

        _onReloadEvent: function (ev) {
            ev.preventDefault();
        }

    });


    OCA.BagIt = OCA.BagIt || {};

    OCA.BagIt.BagItTabView = BagItTabView;


})();