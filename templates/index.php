<?php style('bagit', 'style'); ?>
<?php style('files', 'files'); ?>

<div id="app">
	<div id="app-navigation">

        <ul class="with-icon">

            <li>

                <a class="nav-icon-bagit-black" href="#">

                    All Bags

                </a>

            </li>

            <li>

                <a class="nav-icon-favorites svg" href="#">

                    Favorites

                </a>

            </li>

            <li>

                <a class="nav-icon-recent svg" href="#">

                    Recent

                </a>

            </li>

            <li>

                <a class="nav-icon-upload" href="#">

                    Transfers

                </a>

            </li>

        </ul>

    </div>

	<div id="app-content">

        <div id="app-content-files" class="viewcontainer hide-hidden-files has-favorites has-comments" style="min-height: initial;">

            <div id="controls" style="width: 580px; min-width: 580px;">

                <div class="breadcrumb">

                    <div class="crumb svg last" data-dir="/">

                        <a href="/index.php/apps/bagit/">

                            <img class="svg" src="/core/img/places/home.svg" alt="Home">

                        </a>

                        <span style="display: none;"></span>

                    </div>

                </div>

            </div>

            <table id="filestable" data-allow-public-upload="yes" data-preview-x="32" data-preview-y="32" class="has-controls">
                <thead style="width: 574px;">
                <tr>
                    <th id="headerName" class="column-name">
                        <div id="headerName-container">
                            <input type="checkbox" id="select_all_files" class="select-all checkbox">
                            <label for="select_all_files">
                                <span class="hidden-visually">Select all</span>
                            </label>
                            <a class="name sort columntitle" data-sort="name"><span>Name</span><span class="sort-indicator icon-triangle-n"></span></a>
                            <span id="selectedActionsList" class="selectedActions hidden">
						        <a href="" class="download" data-original-title="" title="">
							        <span class="icon icon-download"></span>
							        <span>Download</span>
						        </a>
					        </span>
                        </div>
                    </th>
                    <th id="headerSize" class="column-size">
                        <a class="size sort columntitle" data-sort="size"><span>Replication Status (D)</span><span class="sort-indicator hidden icon-triangle-s"></span></a>
                    </th>
                    <th id="headerSize" class="column-size">
                        <a class="size sort columntitle" data-sort="size"><span>Replication Status (SC)</span><span class="sort-indicator hidden icon-triangle-s"></span></a>
                    </th>
                    <th id="headerSize" class="column-size">
                        <a class="size sort columntitle" data-sort="size"><span>Size</span><span class="sort-indicator hidden icon-triangle-s"></span></a>
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
                    <tr data-id="26" data-type="dir" data-size="34" data-file=".bagit" data-mime="httpd/unix-directory" data-mtime="1493203424000" data-etag="590079e0d0155" data-permissions="31" data-has-preview="false" data-path="/" data-share-permissions="31" class="ui-droppable hidden-file">
                        <td class="filename ui-draggable">
                            <a href="#" class="action action-favorite " data-original-title="" title="">
                                <span class="icon icon-star"></span>
                                <span class="hidden-visually">Favorite</span>
                            </a>
                            <input id="select-files-26" type="checkbox" class="selectCheckBox checkbox">
                            <label for="select-files-26">
                                <div class="thumbnail" style="background-image:url(/index.php/apps/theming/img/core/filetypes/folder.svg?v=0); background-size: 32px;"></div>
                                <span class="hidden-visually">Select</span>
                            </label>
                            <a class="name" href="/index.php/apps/files?dir=//.bagit">
                                <span class="nametext">
                                    <span class="innernametext"></span>
                                    <span class="extension">.bagit</span>
                                </span>
                                <span class="uploadtext" currentuploads="0"></span>
                                <span class="fileactions">
                                    <a class="action action-share permanent" href="#" data-action="Share" data-original-title="" title="">
                                        <span class="icon icon-share"></span>
                                        <span class="hidden-visually">Share</span></a>
                                    <a class="action action-menu permanent" href="#" data-action="menu" data-original-title="" title="">
                                        <span class="icon icon-more"></span><span class="hidden-visually">Actions</span>
                                    </a>
                                </span>
                            </a>
                        </td>
                        <td class="filesize" style="color:rgb(160,160,160)">&lt; 1 KB</td>
                        <td class="date">
                            <span class="modified live-relative-timestamp" title="" data-timestamp="1493203424000" style="color:rgb(5,5,5)" data-original-title="April 26, 2017 5:43 AM">a day ago</span>
                        </td>
                    </tr>
                    <tr data-id="3" data-type="dir" data-size="78496" data-file="Documents" data-mime="httpd/unix-directory" data-mtime="1493201860000" data-etag="590073c431579" data-permissions="31" data-has-preview="false" data-path="/" data-share-permissions="31" class="ui-droppable">
                        <td class="filename ui-draggable">
                            <a href="#" class="action action-favorite " data-original-title="" title="">
                                <span class="icon icon-star"></span>
                                <span class="hidden-visually">Favorite</span>
                            </a>
                            <input id="select-files-3" type="checkbox" class="selectCheckBox checkbox">
                            <label for="select-files-3">
                                <div class="thumbnail" style="background-image:url(/index.php/apps/theming/img/core/filetypes/folder.svg?v=0); background-size: 32px;">

                                </div>
                                <span class="hidden-visually">Select</span>
                            </label>
                            <a class="name" href="#">
                                <span class="nametext">
                                    <span class="innernametext">collection01.tar.gz</span>
                                </span>
                                <span class="uploadtext" currentuploads="0"></span>
                            </a>
                        </td>
                        <td style="color:rgb(110,160,78)">

                            <span class="nametext">100%</span>

                        </td>
                        <td style="color:rgb(110,160,78)">

                            <span class="nametext">100%</span>

                        </td>
                        <td class="filesize" style="color:rgb(160,160,160)">124.3 TB</td>
                        <td class="date">
                            <span class="modified live-relative-timestamp" title="" data-timestamp="1493201860000" style="color:rgb(5,5,5)" data-original-title="April 26, 2017 5:17 AM">a day ago</span>
                        </td>
                    </tr>
                    <tr data-id="3" data-type="dir" data-size="78496" data-file="Documents" data-mime="httpd/unix-directory" data-mtime="1493201860000" data-etag="590073c431579" data-permissions="31" data-has-preview="false" data-path="/" data-share-permissions="31" class="ui-droppable">
                        <td class="filename ui-draggable">
                            <a href="#" class="action action-favorite " data-original-title="" title="">
                                <span class="icon icon-star"></span>
                                <span class="hidden-visually">Favorite</span>
                            </a>
                            <input id="select-files-3" type="checkbox" class="selectCheckBox checkbox">
                            <label for="select-files-3">
                                <div class="thumbnail" style="background-image:url(/index.php/apps/theming/img/core/filetypes/folder.svg?v=0); background-size: 32px;">

                                </div>
                                <span class="hidden-visually">Select</span>
                            </label>
                            <a class="name" href="#">
                                <span class="nametext">
                                    <span class="innernametext">collection02.tar.gz</span>
                                </span>
                                <span class="uploadtext" currentuploads="0"></span>
                            </a>
                        </td>
                        <td style="color:rgb(110,160,78)">

                            <span class="nametext">100%</span>

                        </td>
                        <td style="color:rgb(226,202,34)">

                            <span class="nametext">34%</span>

                        </td>
                        <td class="filesize" style="color:rgb(160,160,160)">20.2 GB</td>
                        <td class="date">
                            <span class="modified live-relative-timestamp" style="color:rgb(5,5,5)">a second ago</span>
                        </td>
                    </tr>
                    <tr data-id="3" data-type="dir" data-size="78496" data-file="Documents" data-mime="httpd/unix-directory" data-mtime="1493201860000" data-etag="590073c431579" data-permissions="31" data-has-preview="false" data-path="/" data-share-permissions="31" class="ui-droppable">
                        <td class="filename ui-draggable">
                            <a href="#" class="action action-favorite " data-original-title="" title="">
                                <span class="icon icon-star"></span>
                                <span class="hidden-visually">Favorite</span>
                            </a>
                            <input id="select-files-3" type="checkbox" class="selectCheckBox checkbox">
                            <label for="select-files-3">
                                <div class="thumbnail" style="background-image:url(/index.php/apps/theming/img/core/filetypes/folder.svg?v=0); background-size: 32px;">

                                </div>
                                <span class="hidden-visually">Select</span>
                            </label>
                            <a class="name" href="#">
                                <span class="nametext">
                                    <span class="innernametext">skunkworks-collection.tar.gz</span>
                                </span>
                                <span class="uploadtext" currentuploads="0"></span>
                            </a>
                        </td>
                        <td style="color:rgb(160,34,10)">

                            <span class="nametext">Network Error</span>

                        </td>
                        <td style="color:rgb(110,160,78)">

                            <span class="nametext">100%</span>

                        </td>
                        <td class="filesize" style="color:rgb(160,160,160)">555.2 TB</td>
                        <td class="date">
                            <span class="modified live-relative-timestamp" style="color:rgb(5,5,5)">a second ago</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

