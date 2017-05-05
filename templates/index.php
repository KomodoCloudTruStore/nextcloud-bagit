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
        <div id="app-settings">
            <div id="app-settings-header">
                <button class="settings-button" data-apps-slide-toggle="#app-settings-content">
                    Settings			</button>
            </div>
            <div id="app-settings-content">
                <div id="files-setting-showhidden">
                    <input class="checkbox" id="showhiddenfilesToggle" checked="checked" type="checkbox">
                    <label for="showhiddenfilesToggle">Enable FITS Services</label>
                </div>
            </div>
        </div>
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
                <tbody id="bagList">


                </tbody>
            </table>
        </div>

    </div>
</div>

<?php script('bagit', 'bagit.content'); ?>

