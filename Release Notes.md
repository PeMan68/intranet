# Release notes
## To-do
*Fixes*
* 210109-1 Fix rendering of navbar. If a big table is loaded(i.e. Issues), the page seems to wait for the table before the navbar is rendered correct.
* 210109-2 The side-menu is not handled well when window height gets smaller
* 210109-4 Demoproducts, primary key must be itemnumber!

*Features*
* 210109-5  Add status Pause, WaitingForInternal, WaitingForCustomer to Issues
* 210109-7  Add jobs for email reminders according to the status if Issue to have them closed asap. Automatic closing if emails ar enot responded upon.
* 210109-8  Add email-form from Issues to message directly to customer or internal support to be stored in Issue Comments History
* 210109-9  Add question of debit customer for supporttime when checking back Issue. When Issue is closed an report shall be created to be invoiced from.
* 210109-10 Ability to edit comments in Issues.
* 210109-11 Pickup incoming emails, automatic adding comments and notification to followers.
* 210111    Edit links in menu from Settings-db
* 210112-2  Save customer details for autofill

### ***Working on***
*Features:*
* Attachments stored in Issues
* 210112-1  Change to nicer layout of Issue Comments. 
    * Add fields for from/to, choose from customer contact and Internal/Enterprise contacts
    * Table for contactpersons outside office. Contacts outside Enterprise tagged with 'external' in contacts table.

*Bug fixes:*
## Finsihed for next release
*Features*
* 210109-3 Automatic selection for viewing all Issues or only the latest
    * Default should be less records, while search should include all
* 210109-6  Add email to customer for registered Issue
* All emailing is moved to queues and handled by workers
* Jobs created for reminders to First line and Second Line of unattended Issues
* Updated Email templates

*Bug fixes:*
* 2020-12-30 Fixed Cancel on calendar form from being validated
## **Release 2.3.3 (2020-09-09)**
*Features:*
* Added Ticket Number in search of Issues
* Added header to Issues. Showing latest comment as tooltip in Issues-list.
* Changed the column "senast" in issues index-view. Now calculated against latest comment.
* Removed Tooltip for column Skapat in Issues-list.

## **Release 2.3.2 (2020-08-21)**
* Fixed rule description of file-size (GB -> MB)
* B200821 Wrong file deleted from documents

## **Release 2.3.1 (2020-08-12)**
*Bug fixes:*
* Corrected info of file-size to 2MB
	
## **Release 2.3.0 (2020-08-11)**
*Features:*
* Added module documents
	
## **Release 2.1.1 (2020-02-19)**
*Features:*
* Added departments and sorts the calendar by it
