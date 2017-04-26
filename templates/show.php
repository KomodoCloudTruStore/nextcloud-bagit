<?php style('bagit', 'style'); ?>
<?php style('files', 'files'); ?>
<?php style('files', 'detailsView'); ?>

    <div id="app">
        <div id="app-navigation"></div>

        <div id="app-content">

            <div id="app-content-bagit" class="viewcontainer hide-hidden-files has-favorites has-comments" style="min-height: initial;">

                <table id="filestable" data-allow-public-upload="yes" data-preview-x="32" data-preview-y="32" class="has-controls">

                    <thead style="width: 648px;">
                    <tr>
                        <th id="headerName" class="column-name">
                            <div id="headerName-container">
                                <input type="checkbox" id="select_all_files" class="select-all checkbox">
                                <label for="select_all_files">
                                    <span class="hidden-visually">Select all</span>
                                </label>
                                <a class="name sort columntitle" data-sort="name"><span>Name</span><span class="sort-indicator hidden icon-triangle-s"></span></a>
                                <span id="selectedActionsList" class="selectedActions hidden">
						<a href="" class="download" data-original-title="" title="">
							<span class="icon icon-download"></span>
							<span>Download</span>
						</a>
					</span>
                            </div>
                        </th>
                        <th id="headerSize" class="column-size">
                            <a class="size sort columntitle" data-sort="size"><span>Size</span><span class="sort-indicator icon-triangle-n"></span></a>
                        </th>
                        <th id="headerDate" class="column-mtime">
                            <a id="modified" class="columntitle" data-sort="mtime"><span>Modified</span><span class="sort-indicator hidden icon-triangle-s"></span></a>
                            <span class="selectedActions hidden"><a href="" class="delete-selected" data-original-title="" title="">
						<span>Delete</span>
						<span class="icon icon-delete"></span>
					</a></span>
                        </th>
                    </tr>
                    </thead>

                    <tbody id="fileList">

                        <?php foreach($_['items'] as $item){ ?>

                            <tr>

                                <td>

                                    <div class="thumbnail" style="background-image:url(/apps/bagit/img/bagit-white.svg); background-size: 32px;"></div>
                                    <b>
                                        <a class="name"
                                           href="apps/files?fileid=<?php p($item['id']); ?>#editor"><?php p($item['name']); ?></a></b>

                                </td>

                                <td class="filesize" style="color:rgb(160,160,160)"><?php p($item['size']); ?></td>

                                <td class="date"><span class="modified live-relative-timestamp" style="color:rgb(3,3,3)""><?php p($item['time']); ?></span></td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

<?php script('bagit', array('bagit.navigation')); ?>
