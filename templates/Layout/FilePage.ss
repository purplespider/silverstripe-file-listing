<h1>$Title</h1>

$Content

<div class="filelistings">
				
			<% if BackLink %>
				<h2>$CurrentFolder.Title</h2>
				<p class="item back"><a href="$Top.Link{$BackLink}"><strong><img src="file-listing/images/dots.png" class="icon" width="16" height="16" />Back to $CurrentFolder.Parent.Title</strong></a></p>
			<% else %>
				<% if FilesHeading %><h2>$FilesHeading</h2><% end_if %>
			<% end_if %>
			
			<% if Listing %>
				
					<% loop Listing %>	
						<% if ClassName = Folder %>
							<p class="item"><a class="mainlink" href="$Top.Link?fid=$ID"><img class="icon" src="file-listing/images/folder.png"/><strong>$Title</strong></a></p>
							
						<% else_if ClassName = Image %>
							<p class="item"><a class="mainlink" href="$setWidth(850).Link" class="lightbox" rel="gallery1" title="$Title" >
								<img class="icon" src="file-listing/images/photo.png"/>$Title</a> <a href="$Link" class="orig">(Download Original)</a><span> - Added $Created.Ago</span><br />
								<a href="$setWidth(850).Link" class="lightbox" rel="gallery2" title="$Title" ><img class="thumb" src="$setWidth(200).URL" width="$setWidth(200).Width" height="$setWidth(200).Height" /></a>
								</p>
								
						<% else_if Extension=="zip" || Extension=="ZIP" || Extension=="doc" || Extension=="DOC" || Extension=="DOCX" || Extension=="docx" || Extension=="xls" || Extension=="XLS" || Extension=="xlsx" || Extension=="XLSX" || Extension=="pdf" || Extension=="PDF" %>
							<p class="item"><a class="mainlink" href="$Link">$Title ($Extension)</a><span> - Added $Created.Ago</span></p>
							
						<% else %>
							<p class="item"><img class="icon" src="file-listing/images/page_white.png"/><a class="mainlink" href="$Link">$Title ($Extension)</a><span> - Added $Created.Ago</span></p>
						<% end_if %>
					
					<% end_loop %>
				
				
			<% else %>
				<p>Sorry, this folder is empty.</p>
		<% end_if %>
						
</div>

$Form
$PageComments
