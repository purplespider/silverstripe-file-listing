<% require css("purplespider/file-listing: client/dist/css/files.css") %>
<% require javascript("purplespider/file-listing: client/dist/js/fontawesome-all.min.js") %>

<% include SideBar %>

<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
	</article>

	<div class="filelistings" id="filelisting">
		<% if $BackLink %>
			<h2>$CurrentFolder.Title</h2>
			<p class="item back">
				<a href="$Top.Link{$BackLink}"><strong>
					<i class="fas fa-level-up-alt fa-2x"></i>
					Back to $CurrentFolder.Parent.Title
				</strong></a>
			</p>
		<% else %>
			<% if $FilesHeading %><h2>$FilesHeading</h2><% end_if %>
		<% end_if %>
		
		<% if $Listing %>
			<% loop $Listing %>	
				<p class="item">
					<a href="<% if $ClassName == "SilverStripe\\Assets\\Folder" %>$Top.getFolderLink($ID)<% else %>$Link<% end_if %>" title="$Title" ><strong>
						<% if $ClassName == "SilverStripe\\Assets\\Folder" %>
							<i class="fas fa-folder-open fa-2x"></i>
						<% else_if $AppCategory == "image" %>
							<i class="fas fa-image fa-2x"></i>
						<% else_if $AppCategory == "archive" %>
							<i class="fas fa-file-archive fa-2x"></i>
						<% else_if $AppCategory == "document" %>
							<i class="fas fa-file-alt fa-2x"></i>
						<% else %>
							<i class="fas fa-file fa-2x"></i>
						<% end_if %>
						$Title
					</strong></a>

					<span><em>Added $Created.Ago</em></span>
					<br />

					<% if $AppCategory == "image" %>
						$Pad(100,100)
					<% end_if %>
				</p>
			<% end_loop %>
		<% else %>
			<p>Sorry, this folder is empty.</p>
		<% end_if %>		
	</div>

	$Form
	$PageComments
</div>