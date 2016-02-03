<?php

class FilePage extends Page
{
        
    public static $db = array(
        "FilesHeading" => "Text"
    );
    
    public static $has_one = array(
        "Folder" => "Folder"
    );
    
    public static $defaults = array(
        "FilesHeading" => "Downloads"
    );
    
    public static $description = "Lists files contained within a specific assets folder, for downloading/viewing.";
    public static $singular_name = "File Download Page";
    public static $plural_name = "File Download Pages";
    public static $icon = "file-listing/images/download";
    
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        if ($this->FolderID) {
            $filescount = File::get()->filter(array("ParentID"=>$this->FolderID))->count();
            $fields->addFieldToTab('Root.Main',
                new LiteralField("addnew", "<p><a href='/admin/assets/show/".$this->FolderID."' class='ss-ui-button ss-ui-action-constructive ui-button' style='font-size:130%' data-icon=add''>Manage Files (".$filescount.")</span></a></p>"), 'Title');
        }
        
        $fields->insertAfter(new TextField("FilesHeading", "Files Heading"), 'Content');
        
        $folders = class_exists('FileVersion') ? Folder::get()->exclude("Filename:PartialMatch", "_versions")->map("ID", "Title") : Folder::get()->map("ID", "Title");
        $dropdown = new DropdownField("FolderID", "Folder", $folders);
        $this->FolderID ? $dropdown->setEmptyString("Clear list") : $dropdown->setEmptyString(" ");
        $fields->insertAfter($dropdown, 'FilesHeading');

        return $fields;
    }
}

class FilePage_Controller extends Page_Controller
{
    
    public function init()
    {
        if (Director::fileExists(project() . "/css/files.css")) {
            Requirements::css(project() . "/css/files.css");
        } else {
            Requirements::css("file-listing/css/files.css");
        }
        parent::init();
    }
		
		// Gets the current folder ID from query string and validates it
		public function getCurrentFolderID()
		{
			$folderID = $this->request->getVar('fid');
			
			if ($folderID) {
				return filter_var($folderID, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
			} else {
				return false;
			}
		}
    
    // Returns files/folders for the current folder
    public function Listing($ParentID = null)
    {
        if (!$this->FolderID) {
            return false;
        }
        
        $currentFolderID = $this->getCurrentFolderID();
        
        if ($currentFolderID) {
            if (DataObject::get("File", "ID = ".$currentFolderID)) {
                $ParentID = $currentFolderID;
            }
        } else {
            $ParentID = $this->FolderID;
        }
        
        if ($ParentID == $this->FolderID) {
            $list = DataObject::get("File", "ParentID = ".$ParentID, "Title ASC");
        } else {
            $list = DataObject::get("File", "ParentID = ".$ParentID, "Created DESC");
        }
        
        if (class_exists('FileVersion')) {
            return $list->exclude("Filename:PartialMatch", "_versions");
        } else {
            return $list;
        }
    }
    
    // Checks if not at the root folder
    public function NotRoot()
    {
				$currentFolderID = $this->getCurrentFolderID();
			
				if ($currentFolderID) {
            if (DataObject::get("File", "ID = ".$currentFolderID)) {
                return true;
            }
        }
        return false;
    }
    
    // Gets current folder from $_GET['fid']
    public function CurrentFolder()
    {
				$currentFolderID = $this->getCurrentFolderID();
				
				if ($currentFolderID) {
            return DataObject::get_by_id("File", $currentFolderID);
        }
        return false;
    }
    
    // Creates link to go back to parent folder
    public function BackLink()
    {
        if ($this->CurrentFolder()) {
            if ($this->CurrentFolder()->ParentID != $this->FolderID) {
                return "?fid=".$this->CurrentFolder()->ParentID;
            } else {
                return "?";
            }
        } else {
            return false;
        }
    }
}
