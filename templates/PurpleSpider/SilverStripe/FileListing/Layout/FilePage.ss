<% require css("purplespider/file-listing: client/dist/css/files.css") %>
<% require javascript("purplespider/file-listing: client/dist/js/fontawesome-all.min.js") %>

<% include SideBar %>

<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
	</article>

	<div class="filelistings">
		<% if $BackLink %>
			<h2>$CurrentFolder.Title</h2>
			<p class="item back"><a href="$Top.Link{$BackLink}"><strong><img src="file-listing/images/dots.png" class="icon" width="16" height="16" />Back to $CurrentFolder.Parent.Title</strong></a></p>
		<% else %>
			<% if $FilesHeading %><h2>$FilesHeading</h2><% end_if %>
		<% end_if %>
		
		<% if $Listing %>
			<% loop $Listing %>	
				<% if $ClassName == "SilverStripe\\Assets\\Folder" %>
					<p class="item">
						<a class="mainlink" href="$Top.Link?fid=$ID">
							<i class="fas fa-folder-open"></i>
							<strong>$Title</strong>
						</a>
					</p>
				<% else_if $AppCategory == "image" %>
					<p class="item">
						<a class="mainlink" href="$ScaleWidth(850).Link" class="lightbox" rel="gallery1" title="$Title" >
							<i class="fas fa-image"></i>
							$Title
						</a>
						<a href="$Link" class="orig">
							(Download Original)
						</a>
						<span> - Added $Created.Ago</span>
						<br />
						<a href="$setWidth(850).Link" class="lightbox" rel="gallery2" title="$Title" >
							<img class="thumb" src="$ScaleWidth(200).URL" />
						</a>
					</p>
				<% else_if $AppCategory == "archive" %>
					<p class="item">
						<a class="mainlink" href="$Link">
							<i class="fas fa-file-archive"></i>
							$Title ($Extension)
						</a>
						<span> - Added $Created.Ago</span>
					</p>
				<% else_if $AppCategory == "document" %>
					<p class="item">
						<a class="mainlink" href="$Link">
							<i class="fas fa-file-alt"></i>
							$Title ($Extension)
						</a>
						<span> - Added $Created.Ago</span>
					</p>
				<% else %>
					<p class="item">
						<a class="mainlink" href="$Link">$Title ($Extension)</a>
						<span> - Added $Created.Ago</span>
					</p>
				<% end_if %>
			<% end_loop %>
		<% else %>
			<p>Sorry, this folder is empty.</p>
		<% end_if %>		
	</div>

	$Form
	$PageComments
</div>