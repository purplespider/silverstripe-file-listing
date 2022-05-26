<?php

namespace PurpleSpider\FileListing;

use Page;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Forms\TextField;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\AssetAdmin\Controller\AssetAdmin;

class FilePage extends Page
{

    private static $db = [
        "FilesHeading" => "Text",
        "SortTopLevel" => "Enum('Title ASC,Title DESC,Created ASC,Created DESC,LastEdited ASC,LastEdited DESC','Title ASC')",
        "SortSubFolders" => "Enum('Title ASC,Title DESC,Created ASC,Created DESC,LastEdited ASC,LastEdited DESC','Title ASC')",
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

    private static $icon_class = 'font-icon-p-download';


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($this->FolderID) {
            $filescount = File::get()
                ->filter("ParentID", $this->FolderID)
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
                    '<p><a href="' . $edit_link . '" target="_blank" class="btn btn-lg btn-primary">Manage Files (' . $filescount . ')</span></a></p>'
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

        $fields->insertAfter(
            $dropdown = TreeDropdownField::create(
                "FolderID",
                $this->fieldLabel("Folder"),
                Folder::class
            ),
            'FilesHeading'
        );

        $fields->insertAfter(
            DropdownField::create(
                'SortSubFolders',
                'Sub Folder Sort',
                FilePage::singleton()
                    ->dbObject('SortSubFolders')
                    ->enumValues()
            ),
            'FolderID'
        );

        $fields->insertAfter(
            DropdownField::create(
                'SortTopLevel',
                'Top Level Sort',
                FilePage::singleton()
                    ->dbObject('SortTopLevel')
                    ->enumValues()
            ),
            'FolderID'
        );
   
        
        if ($this->FolderID) {
            $dropdown->setEmptyString("Clear list");
        } else {
            $dropdown->setEmptyString(" ");
        }

        return $fields;
    }
}
