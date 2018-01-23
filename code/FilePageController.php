<?php

namespace PurpleSpider\SilverStripe\FileListing;

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
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
        $filter = [];
        $sort = "Created DESC";
        
        if ($currentFolderID) {
            if (File::get()->byID($currentFolderID)) {
                $ParentID = $currentFolderID;
            }
        } else {
            $ParentID = $this->FolderID;
        }
        
        if ($ParentID == $this->FolderID) {
            $sort = "Title ASC";
        }

        return File::get()
            ->filter("ParentID", $ParentID)
            ->sort($sort);
    }
    
    /**
     * Checks if not at the root folder
     *
     * @return boolean
     */
    public function NotRoot()
    {
        $currentFolderID = $this->getCurrentFolderID();
			
        if ($currentFolderID) {
            if (File::get()->byID($currentFolderID)) {
                return true;
            }
        }

        return false;
    }
    
    /**
     * Gets current folder from $_GET['fid']
     *
     * @return void
     */
    public function CurrentFolder()
    {
        $currentFolderID = $this->getCurrentFolderID();
				
        if ($currentFolderID) {
            return File::get()->byID($currentFolderID);
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
