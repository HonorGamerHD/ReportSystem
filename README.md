# ReportSystem - modular Reportsystem
simple and clean reportsystem with UI's for everyone!
<br>this plugin use [dktapps](https://github.com/dktapps) great [pmforms](https://github.com/dktapps-pm-pl/pmforms) API library.
This Reportsystem is useable for one mc server network types like [Minehub](https://minehub.de) or [Server.pro](https://server.pro) servers and also for bigger networks with more than one mc server!

## Todo List

- [x] Commands
    - [x] /report
    - [x] /reportlist
    - [x] /reportadmin
- [x] Admin
    - [x] Admin ui
    - [ ] Direct ban
    - [x] Send report to all op's and permitted players
- [ ] Missing Features
    - [x] Modular system
    - [x] "back" and "exit" buttons
    - [ ] Multilang
    - [x] Review notification
        - [x] For new reports
        - [x] at join
    - [x] Visible review
    - [ ] Plugin ingame settings
    - [x] Config file
    - [x] Customization
        - [x] prefix
        - [ ] messages
    - [x] Deleteable reports
    - [x] Recycle Bin
    - [ ] and more ;)
- [x] API for other plugins

## Where can i download ReportSystem?
### Download phar
You can download latest phar at [poggit](https://poggit.pmmp.io/ci/HonorGamerHD/ReportSystem/ReportSystem)

### Download zip
You can download this plugin as zip and run this as folder plugin(needs [Devtools](https://poggit.pmmp.io/p/DevTools/1.13.4))

### Clone repo into local repo
You can clone this plugin into your IDE(needs [Git](https://git-scm.com/))

## Permissions
### /report
No permission needed - useable for everyone

### /reportadmin
Permission: `reportsystem.admin`
Permission to open admin ui

### /reportlist - !New Permission!
Permission: `reportsystem.list`
Permission to open report list

## For plugin devs
`Report::getInstance()`
<br>Get plugins instance

`Report::getInstance()->getReportList();`
<br>Returns array of all reports

`Report::getInstance()->getRecycleBinList();`
<br>Returns array of all reports in recycle bin

`Report::getInstance()->saveReport($reportname, $reporter, $playername, $desc, $notes)`
<br>Save another report

`Report::getInstance()->sendReportToMod()`
<br>Send "new report" mesage to all server mods

`Report::getInstance()->sendReportToMod()`
<br>Send "new report" mesage to all server mods

`Report::getInstance()->checkForUnreviewed()`
<br>Returns true if some reports are unreviewed
<br>and more API methods, just look into [main class](https://github.com/HonorGamerHD/ReportSystem/blob/master/src/ImNotYourDev/Report/Report.php). ;)

## Help me to add more features!
create an new pull request and help me to develop this reportsystem!

## Collaborators
- [HonorGamerHD aka ImNotYourDev](https://github.com/honorgamerhd)