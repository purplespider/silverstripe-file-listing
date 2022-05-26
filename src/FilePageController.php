<?php

namespace PurpleSpider\FileListing;

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
        $sort = $this->SortSubFolders;

        if ($currentFolderID) {
            if (File::get()->byID($currentFolderID)) {
                $ParentID = $currentFolderID;
            }
        } else {
            $ParentID = $this->FolderID;
        }

        if ($ParentID == $this->FolderID) {
            $sort = $this->SortTopLevel;
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
     * @return mixed
     */
    public function CurrentFolder()
    {
        $currentFolderID = $this->getCurrentFolderID();

        if ($currentFolderID) {
            return File::get()->byID($currentFolderID);
        }

        return false;
    }

    /**
     * Creates link to go back to parent folder
     *
     * @return string
     */
    public function BackLink()
    {
        /** @var File */
        $curr_folder = $this->CurrentFolder();

        if (!empty($curr_folder)) {
            if ($curr_folder->ParentID != $this->FolderID) {
                return "?fid=".$this->CurrentFolder()->ParentID;
            } else {
                return "?";
            }
        } else {
            return "";
        }
    }
}
