(function () {

    var BagItTabView = OCA.Files.DetailTabView.extend({

        id: 'bagItTabView',

        className: 'tab bagItTabView',

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

            this.show(this.getFileInfo());

        },

        /**
         * Returns whether the current tab is able to display
         * the given file info, for example based on mime type.
         *
         * @param {OCA.Files.FileInfoModel} fileInfo file info model
         * @return {bool} whether to display this tab
         */
        canDisplay: function (fileInfo) {

            return true;
        },

        /**
         * ajax callback for generating md5 hash
         */
        show: function (fileInfo) {
            // skip call if fileInfo is null
            if (null == fileInfo) {
                _self.updateDisplay({
                    response: 'error',
                    msg: t('bagit', 'No Bags Found.')
                });
                return;
            }

            var url = OC.generateUrl('/apps/bagit/bags/' + fileInfo['id']),
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
                    });
                }
            });
        },

        /**
         * display message from ajax callback
         */
        updateDisplay: function (data) {

            if ('success' == data.response) {

                var list = $('<ul></ul>');
                list.attr('class', 'activities');

                var empty = $('<li></li>');
                empty.text('There are no bags for this resource.');

                if (data.msg.length < 1) {

                    empty.attr('class', 'activity box');

                } else {

                    empty.attr('class', 'empty hidden');

                }

                list.append(empty);

                var baseUrl = window.location.protocol + '//' + window.location.hostname;

                if (window.location.port !== '') {

                    baseUrl = baseUrl + ":" + window.location.port

                }

                for (var i = 0; i < data.msg.length; i++) {

                    var item = $('<li></li>');
                    item.attr('class', 'activity box');

                    var iconContainer = $('<div></div>');
                    iconContainer.attr('class', 'activity-icon');

                    var icon = $("<img>");

                    var subj = $('<div></div>');
                    subj.attr('class', 'activitysubject');
                    subj.css('width', 'initial');

                    if (i === (data.msg.length - 1)) {

                        icon.attr('src', baseUrl + '/apps/bagit/img/bagit-black.svg');
                        subj.text('Bag Created');

                    } else {

                        icon.attr('src', baseUrl + '/apps/files/img/add-color.svg');
                        subj.text('Bag Updated');

                    }

                    date = new Date(data.msg[i]['timestamp']);

                    var timestamp = $('<span></span>');
                    timestamp.attr('class', 'activitytime has-tooltip live-relative-timestamp');
                    timestamp.attr('data-timestamp', date.getTime() - (date.getTimezoneOffset() * 60000));
                    timestamp.text('calculating...');

                    var activityMessage = $('<div></div>');
                    activityMessage.attr('class', 'activitymessage');

                    iconContainer.append(icon);

                    item.append(iconContainer);
                    item.append(subj);
                    item.append(timestamp);
                    item.append(activityMessage);

                    list.append(item);

                }

                $(".bagit-details-menu").append(list);

                var buttonContainer = $('<div></div>');
                buttonContainer.css('display', 'flex');
                buttonContainer.css('align-items', 'center');
                buttonContainer.css('justify-content', 'space-between');
                buttonContainer.css('margin-top', '25px');

                var updateBtn = $('<button></button>');
                updateBtn.text('Update');
                updateBtn.css('flex-grow', 1);

                var validateBtn = $('<button></button>');
                validateBtn.css('background-color', 'rgb(56, 195, 56)');
                validateBtn.css('color', 'rgb(250,250,250)');
                validateBtn.css('flex-grow', 1);
                validateBtn.text('Validate');

                var DeleteBtn = $('<button></button>');
                DeleteBtn.css('background-color', 'rgb(241, 51, 51)');
                DeleteBtn.css('color', 'rgb(250,250,250)');
                DeleteBtn.css('flex-grow', 1);
                DeleteBtn.text('Delete');

                buttonContainer.append(updateBtn);
                buttonContainer.append(validateBtn);
                buttonContainer.append(DeleteBtn);

                $(".bagit-details-menu").append(buttonContainer);

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