# Release notes
## To-do
*Bugs*
* 210902.01 Adding visitors names doesnt work anymore
* 211102.01 Reminders can be sent several times, not just the set interval. I think when one toggle "answer from customer/collegue" it creates a job each time. A cache-key could prevent to sent the remaining mails if it has recently been sent?

*Fixes*
* 210109-2 The side-menu is not handled well when window height gets smaller
* 210214.01 When adding comment to Issue it is not shown until another page reload in production. In development is is shown after the save.
* 210314.01 nextWorkingDateTime not correct when today is weekend but inside working hours (for example sunday 10.30 gives Monday 10.30, while Sunday 21.30 gives Monday 08.00)
* 210822.01 Use the php helpers dateconversion for demoproducts instead of vue. (used in store demoproduct)
* 210829.01 Do something with settings, "if calendar-module && holidays-module is used". To handle modules in the future.

*Features*
* 210109-7  Add jobs for email reminders according to the status if Issue to have them closed asap. Automatic closing if emails are not responded upon.
* 210109-9  Add question of debit customer for supporttime when checking back Issue. When Issue is closed a report shall be created to be invoiced from.
* 210109-11 Pickup incoming emails, automatic adding comments and notification to followers.
* 210111    Edit links in menu from Settings-db
* 210112-2  Save customer details for autofill
* 210201.01 Handle Issues for sales. Every product range could be either support or sales related?
* 210109-10 Ability to edit comments in Issues. Links in popover would be nice...

### ***Working on***
## Finished for next release
* 211026.01 Changed look of form for issues. Add description for descriptions, to make it clear what's sent to customer and what's not.
* 211028.01 Highlight fields in issue that are visible for customer
## **Release 2.6.8 (2021-10-19)**
* 211019.01 and 02, small bugfixes
## **Release 2.6.7 (2021-10-18)**
* 210926-1 Add multiple products as batch into demoproducts
* 210109-8 Partly done. Link to create mail from email client added to Issue Comments.
* 211017.01 Selected options of demoproducts are not kept when adding a demoproduct and validation fails.
* 210109-8  Add email-form from Issues to message directly to customer or internal support to be stored in Issue Comments History
## **Release 2.6.6 (2021-09-23)**
* 210831.01 Adjusting columns for issues table

*Bugs*
* 210907.01 server 500 error when changing status in header of issues. When correcting the permissions of logfiles the error disappears
    * disabled some logging, wait and see if it works
## **Release 2.6.4 (2021-08-29)**
* 210813.03 Link from "Hantera Platser" to demoproducts loading the filter doesn't work anymore
* 210826.01 Make message show in front of instead of in between elements
* 210405.01 Show holidays in calendar
## **Release 2.6.3 (2021-08-25)**

*Fixes*
* 210813.01 Change input form of demoproducts to match the edit form

*Features*
* 210223.04 Add other users as followers manually, to have them notified automatically

## **Release 2.6.2 (2021-08-17)**
*Bugs*
* 210813.02 Saving status of demoproduct should not update invoice-date unless changed
## **Release 2.6.0 (2021-08-13)**
*Bugs*
210412.01 Cold-key blocks followers 2 and more. Only first follower gets the mail of cold issue.
   * Making new job structure
   * Moved add_followers to helper and initiates this when sending the emails, so it is most up-to-date. Previously followers where added before moving to jobs, so changes in followers after this point wheren't considered.
   * Adding user who makes comment to follower, by passing the user_id via the request. 

*Features:*
* 210211.01 Edit/delete demoproducts. Transactions of products between places or statuses, track this?
    * Protected statuses from being deleted if used

    * change indexview to show more relevant data and add details to row...
    
    * Formattering av datum, nytt package installerat,**run composer dump-autoload?**

    * Added table to track demoproducts **run migration**
*Fixes*
* 210430.01 Holidays-import. If a day is deleted from DB, mark it as deleted instead of delete it, so it is not imported again. (**run  migration**)
* 210504.01 Changing Issue status to "Väntar på kollega" writes log to wrong log-file(templog-job), change to templog-user
    Both users and jobs are using CreateNewReminder that causes the conflict. Removed all logging
* Changed text of elapsed time for latest update of Issues to more clear

## **Release 2.5.48 (2021-08-10)**
* Updated link to unifaun printer
## **Release 2.5.47 (2021-04-30)**
* Changed a debug-log to be sent to correct file
## **Release 2.5.46 (2021-04-28)**
*Fixes*
* 210419.01 Streamline the subject-text of emails. Shortest Template is ok: Issue#: Header
* 210428.01 Try to solve the permissionproblem of log-files. Split debuglogging, so that jobs write to one log and web-user writes to another.
## **Release 2.5.45 (2021-04-18)**
*Features:*
* Moved debug logging to private logfile, logs/templog.log
## **Release 2.5.44 (2021-04-11)**
*Fixes*
* 210331.02 Re-insert Cold cache key, because now multiple reminders of Cold is received.
## **Release 2.5.43 (2021-04-11)**
*Features:*
* 210405.02 Import holidays from https://date.nager.at/Api/v2/NextPublicHolidays/SE (will get swedish holidays for next 365 days)
    * Imports automatically when opening index-view for managing holidays
* 210325.01 Change item30 to numberOfDaysToShow and use the value 'days_show_closed_issues' from settings (default 1) (**run settings to update database with the settings**)
## **Release 2.5.42 (2021-04-05)**
*Features:*
* 210402.01 Possibility to block days, not only weekends for nextWorkingDay
    * Model for holidays, keeping 12 months back in time (**run migration**)
    * Views for index and adding holidays
    * Holidays are considered also in newWorkingDateTime
    * Sort holidays view in date order
    * Manage Holidays from main menu
*Fixes*
* 210331.01 When Issue is marked to wait for paused/customer/collegue, don't send reminders of Cold case.

## **Release 2.5.41 (2021-03-30)**
*Fixes:*
* Refined logging.
* Reworked the logic for sending reminders.
## **Release 2.5.40 (2021-03-28)**
*Fixes:*
* Tests added. Fixes in models and tables done, **run migration**
* Logs added to trace jobs
* All delays must use the algorithm nexWorkingDateTime to be synchronised. This fix should cover the delays that have been leftout previously.
## **Release 2.5.39 (2021-03-23)**
*Bugfix*
* 210323.01 Reminder of cold was still received multiple times (ex. S21025: 10:11, 11:13, 11:17, 11:17)
## **Release 2.5.38 (2021-03-18)**
*Bugfix*
* 210317.01 Multiple reminders sent for "cold" Issues.
## **Release 2.5.37 (2021-03-16)**
*Fixes*
* 210311.02 Spinner when uploading files in issues
* 210223.01 Collect more messages from issues, so if many posts are done in short time it will not generate separate emails
    * using the same Cache-key as for new Issue, when checked out immediatly. Using own setting for this delay. (**run settings to update database with the settings**)
* 210311.01 Add icon to links to open them in new window
## **Release 2.5.36 (2021-03-08)**
*Fixes*
* Wrong label for 'days_reminder_waiting_for_external' (was 'days_reminder_waiting_for_customer')

*Features:*
* 210223.03 Show the remindertime for the different options in Issues (eg. Pause (2 weeks))

## **Release 2.5.35 (2021-03-07)**
*Fixes*
* 210216.01 Saving new contacts sets "Intern" regardless of the checkbox status
* 210109-1 Fix rendering of navbar. If a big table is loaded(i.e. Issues), the page seems to wait for the table before the navbar is rendered correct.
    * navbar is not correct for users handling
    * navbar is not correct for page posten
* 210223.02 Add reminder for issues where we own the issue and a setting for this time.
    * New field in settings added: 'Fördröjning av notifiering av saknad kommentar (dagar)'
* 210215.01 Change reminders so it reloads jobs like emails for statuses
    * Changes in reminders:
        * Reminder-jobs are setup with independent intervalls for these situations:
            * Paused
            * Waiting for internal answer
            * Waiting for customer feedback
            * New Issue or new Comment (via event UpdatedIssue)
        * When the job executes:
            * Check if the Issue is closed -> return
            * Create a new job with the same interval
            * If there has been no comments since last check of this situation, an email is sent to all the followers notifying of this.
* Add workhours settings to settings field (**run settings to update database with the settings**)
* Improved algorithm for workinghours (**Change the hours in the table 'Priorities', it should reflect working hours rather that calendar hours**)

*Features:*
* F200214-4 Attachments stored in Issues (**requires migration**)

## **Release 2.5.32 (2021-02-15)**
*Features:*
* 210109-5  Add status Pause, WaitingForInternal, WaitingForCustomer to Issues (**requires migration**)
    * Added emails to followers for reminding of these statuses (**run settings to update database with the settings**)
* 210210.01 Auto checkin issues from inactive users, timeout set by settings (**run settings to update database with the settings**)

*Bug fixes:*
* 210109-4 Productimport updates items instead of truncating and import all from scratch (**requires migration**)

## **Release 2.5 (2021-01-31)**
* 210109-3 Automatic selection for viewing all Issues or only the latest
    * Default is latest records, while search should include all
* 210109-6  Add email to customer for registered Issue
* All emailing is moved to queues and handled by workers (**requires workers on server**)
* Jobs created for reminders to First line and Second Line of unattended Issues (**requires check of timers in Settings**)
* Updated Email templates
* 210112-1  Change to nicer layout of Issue Comments. (**requires migration**)
    * Add fields for from/to, choose from customer contact and Internal/Enterprise contacts
    * Table for contactpersons outside app-users. Contacts inside Enterprise tagged with 'internal' in contacts table.
* 210126-01 CRUD for contacts (**requires migration**)
* Added prefix for Issues numbers to Settings (default 'S-')
* Delay jobs for emails to be sent during working hours only

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
