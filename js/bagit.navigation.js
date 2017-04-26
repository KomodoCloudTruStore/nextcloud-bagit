(function() {

    var BagList = function() {

        this.init();

    };

    /**
     * @memberof OCA.BagIt
     */

    BagList.prototype = {

        id: 'bagit',
        appName: t('bagit', 'BagIt'),

        _bags: [],

        init: function() {

            var self = this;
            self.fetchBags();

        },
        drawLeftNav: function() {

            var _self = this;

            var list = $("<ul></ul>");
            list.attr('class', 'with-icon');

            $.each(_self._bags, function(index, value) {

                var url = OC.generateUrl('/apps/bagit/bags/' + value['id']);

                var link = $("<a></a>");
                link.attr('href', url);
                link.attr('class', 'nav-icon-bagit-black');
                link.text(value['name']);

                var item = $('<li></li>');

                item.append(link);

                list.append(item);

            });

            if (_self._bags.length = 0) {

                var url = OC.generateUrl('/apps/bagit');

                var link = $("<a></a>");
                link.attr('href', url);
                link.attr('class', 'nav-icon-bagit-black');
                link.text('There are no Bags here...');

                var item = $('<li></li>');

                item.append(link);

                list.append(item);


            }

            $("#app-navigation").append(list);

        },
        fetchBags: function() {

            var url = OC.generateUrl('/apps/bagit/bags'),
                _self = this;

            $.ajax({

                type: 'GET',
                url: url,
                dataType: 'json',
                async: true,
                success: function(data) {

                    _self._bags = data;
                    _self.drawLeftNav();

                }

            });

        }

    };

    OCA.BagIt = OCA.BagIt || {};

    OCA.BagIt.BagList = BagList;

})();

$(document).ready(function () {

    var list = new OCA.BagIt.BagList();

});
