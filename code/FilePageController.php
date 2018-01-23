<?php

namespace PurpleSpider\SilverStripe\FileListing;

use SilverStripe\ORM\DataObject;
use PageController;

class FilePageController extends PageController
{

    /**
     * Gets the current folder ID from query string and validates
     * it
     * 
     * @return boolean 
     */
    public function getCurrentFolderID()
    {
        $folderID = $this->request->getVar('fid');
        
        if ($folderID) {
            return filter_var($folderID, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        }
        
        return false;
    }
    
    /**
     * Returns files/folders for the current folder
     * 
     * @return SS_List
     */
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
        
        return $list;
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
