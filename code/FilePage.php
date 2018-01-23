<?php

namespace PurpleSpider\SilverStripe\FileListing;

use SilverStripe\Assets\Folder;
use SilverStripe\Assets\File;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use Page;

class FilePage extends Page
{
        
    private static $db = [
        "FilesHeading" => "Text"
    ];
    
    private static $has_one = [
        "Folder" => Folder::class
    ];
    
    private static $defaults = [
        "FilesHeading" => "Downloads"
    ];
    
    private static $description = "Lists files contained within a specific assets folder, for downloading/viewing.";
    
    private static $singular_name = "File Download Page";
    
    private static $plural_name = "File Download Pages";
    
    private static $icon = "file-listing/images/download";
    
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        if ($this->FolderID) {
            $filescount = File::get()
                ->filter("ParentID",$this->FolderID)
                ->count();
            
            $fields->addFieldToTab(
                'Root.Main',
                LiteralField::create(
                    "addnew",
                    "<p><a href='/admin/assets/show/".$this->FolderID."' class='ss-ui-button ss-ui-action-constructive ui-button' style='font-size:130%' data-icon=add''>Manage Files (".$filescount.")</span></a></p>"
                ),
                'Title'
            );
        }
        
        $fields->insertAfter(
            TextField::create(
                "FilesHeading",
                "Files Heading"
            ),
            'Content'
        );
        
        $folders = Folder::get()
            ->map("ID", "Title");

        $fields->insertAfter(
            $dropdown = DropdownField::create(
                "FolderID",
                $this->fieldLabel("Folder"),
                $folders
            ),
            'FilesHeading'
        );
        
        if ($this->FolderID) {
            $dropdown->setEmptyString("Clear list");
        } else {
            $dropdown->setEmptyString(" ");
        }

        return $fields;
    }
}