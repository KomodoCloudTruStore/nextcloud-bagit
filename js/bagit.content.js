(function() {

    var BagItems = function () {

        this.init();

    };

    /**
     * @memberof OCA.BagIt
     */

    BagItems.prototype = {

        id: 'bagit',
        appName: t('bagit', 'BagIt'),

        init: function () {

            var self = this;
            self.fetchItems();

        },
        populateList: function (data) {

            var baseUrl = window.location.protocol + '//' + window.location.hostname;

            if (window.location.port !== '') {

                baseUrl = baseUrl + ":" + window.location.port

            }

            for (bag in data) {

                row = data[bag];

                var tr = $('<tr></tr>');
                tr.attr('class', 'ui-draggable');

                var filename = $('<td></td>');
                filename.attr('class', 'filename ui-draggable');

                var star = $('<a href="#" class="action action-favorite"></a>');
                star.css('display', 'block');
                star.css('float', 'left');
                star.css('width', '30px');
                star.css('line-height', '100%');
                star.css('text-align', 'center');
                star.css('padding', '17px', '8px');

                var innerStar = $('<span class="icon icon-star"></span><span class="hidden-visually"></span>');

                star.append(innerStar);

                var label = $('<label></label>');
                label.attr('for', 'bag-' + row['id']);
                label.css('background-position', '30px 30px');
                label.css('height', '50px');
                label.css('position', 'absolute');
                label.css('width', '50px');
                label.css('z-index', '5');

                //var iconUrl = '/apps/bagit/img/bagit-blue.svg';

                var iconUrl = OC.generateUrl('/apps/bagit/img/bagit-blue.svg');

                var thumbnail = $('<div></div>');
                thumbnail.attr('class', 'thumbnail');
                thumbnail.css('background-image', 'url(' + baseUrl + iconUrl + ')');
                thumbnail.css('background-size', '32px 32px');

                var hiddenSpan = $('<span></span>');
                hiddenSpan.attr('class', 'hidden-visually');
                hiddenSpan.text('Select');

                label.append(thumbnail);
                label.append(hiddenSpan);

                var nameLink = $('<a></a>');
                nameLink.attr('class', 'name');
                nameLink.attr('href', '#');
                nameLink.css('left', '50px');
                nameLink.css('margin-right', '50px');

                var nameText = $('<span></span>');
                nameText.attr('class', 'nametext');

                var innerNameText = $('<span></span>');
                innerNameText.attr('class', 'innernametext');
                innerNameText.text(row['name']);

                nameText.append(innerNameText);

                var bagActions = $('<span></span>');
                bagActions.attr('class', 'fileactions');
                bagActions.css('position', 'absolute');
                bagActions.css('right', '0');

                var details = $('<a></a>');
                details.attr('href', '#');
                details.attr('class', 'action action-share permanent');

                var detailSpan = $('<span class="icon icon-details"></span><span class="hidden-visually">Details</span>');

                details.append(detailSpan);

                var validate = $('<a></a>');
                validate.attr('href', '#');
                validate.attr('class', 'action action-share permanent');

                var validateSpan = $('<span class="icon icon-checkmark"></span><span class="hidden-visually">Validate</span>');

                validate.append(validateSpan);

                var deleteAction = $('<a></a>');
                deleteAction.attr('href', '#');
                deleteAction.attr('class', 'action action-share permanent');

                var deleteActionSpan = $('<span class="icon icon-delete"></span><span class="hidden-visually">Delete</span>');

                deleteAction.append(deleteActionSpan);

                bagActions.append(details);
                bagActions.append(validate);
                bagActions.append(deleteAction);

                nameLink.append(nameText);
                nameLink.append(bagActions);

                filename.append(star);
                filename.append(label);
                filename.append(nameLink);

                var replicaD = $('<td></td>');
                replicaD.attr('class', 'filesize');
                replicaD.css('color', 'rgb(145,145,145)');
                replicaD.text(row['replica_d'] + ' %');

                var replicaSm = $('<td></td>');
                replicaSm.attr('class', 'filesize');
                replicaSm.css('color', 'rgb(145,145,145)');
                replicaSm.text(row['replica_sm'] + ' %');

                var fileSize = $('<td></td>');
                fileSize.attr('class', 'filesize');
                fileSize.css('color', 'rgb(145,145,145)');
                fileSize.text(row['size'] + ' b');

                var modified = $('<td></td>');
                modified.attr('class', 'date');

                var date = new Date(row['timestamp']);

                var innerModified = $('<span></span>');
                innerModified.attr('class', 'modified live-relative-timestamp');
                innerModified.attr('data-timestamp', date.getTime() - (date.getTimezoneOffset() * 60000));
                innerModified.css('color', 'rgb(1,1,1)');
                innerModified.text('Calculating...');

                modified.append(innerModified);

                tr.append(filename);
                tr.append(replicaD);
                tr.append(replicaSm);
                tr.append(fileSize);
                tr.append(modified);

                $('#bagList').append(tr);

            }

        },
        fetchItems: function () {

            var url = OC.generateUrl('/apps/bagit/bags'),
                _self = this;

            $.ajax({

                type: 'GET',
                url: url,
                async: true,
                success: function(data) {

                    _self.populateList(data);

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
