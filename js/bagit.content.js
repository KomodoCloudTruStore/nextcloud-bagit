(function() {

    var BagItems = function(id) {

        this.init(id);

    };

    /**
     * @memberof OCA.BagIt
     */

    BagItems.prototype = {

        id: 'bagit',
        appName: t('bagit', 'BagIt'),

        _items: [],

        init: function(id) {

            var self = this;
            self.fetchItems(id);

        },
        fetchItems: function(id) {

            var url = OC.generateUrl('/apps/bagit/bags/' + id),
                _self = this;

            $.ajax({

                type: 'GET',
                url: url,
                async: true,
                success: function(data) {

                    var data = data;

                }

            });

        }

    };

    OCA.BagIt = OCA.BagIt || {};

    OCA.BagIt.BagItems = BagItems;

})();

$(document).ready(function () {

    var items = new OCA.BagIt.BagItems();

});
