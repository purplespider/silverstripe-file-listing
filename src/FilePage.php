<?php

namespace PurpleSpider\SilverStripe\FileListing;

use SilverStripe\Assets\Folder;
use SilverStripe\Assets\File;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Control\Controller;
use SilverStripe\AssetAdmin\Controller\AssetAdmin;
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

    private static $table_name = 'FilePage';
    
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
            
            $asset_admin = Injector::inst()->create(AssetAdmin::class);
            $edit_link = Controller::join_links(
                $asset_admin->Link("show"),
                $this->FolderID
            );
            
            $fields->addFieldToTab(
                'Root.Main',
                LiteralField::create(
                    "addnew",
                    '<p><a href="' . $edit_link . '" class="btn btn-lg btn-primary">Manage Files (' . $filescount . ')</span></a></p>'
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