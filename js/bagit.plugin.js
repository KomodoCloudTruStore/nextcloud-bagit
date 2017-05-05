(function() {

    OCA.BagIt = OCA.BagIt || {};

    /**
     * @namespace
     */

    OCA.BagIt.FileList = {

        /**
         * Initialize the BagIt plugin.
         *
         * @param {OCA.Files.FileList} fileList
         */

        attach: function (fileList) {

            fileList.fileActions.registerAction({

                name: "BagIt",
                displayName: t('bagit', 'BagIt'),
                order: -20,
                mime: 'all',
                permissions: OC.PERMISSION_READ,
                iconClass: 'icon-bagit',
                actionHandler: function (filename, context) {

                    var fileId = context.fileInfoModel.attributes.id;

                    var url = OC.generateUrl('/apps/bagit/bags/' + fileId),
                        _self = this;

                    $.ajax({

                        type: 'POST',
                        url: url,
                        dataType: 'json',
                        async: true,
                        success: function(data) {

                            window.location.href = OC.generateUrl('/apps/bagit/');

                        }

                    });

                }
            });
            fileList.registerTabView(new OCA.BagIt.BagItTabView('bagiItTabView', {}));

        }
    };

})();

OC.Plugins.register('OCA.Files.FileList', OCA.BagIt.FileList);