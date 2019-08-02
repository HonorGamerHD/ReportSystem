# ReportSystem
simple and clean reportsystem with UI's for everyone!
<br>this plugin use [dktapps](https://github.com/dktapps) great [pmforms](https://github.com/dktapps-pm-pl/pmforms) API library

## Todo List

- [x] Commands
    - [x] /report
    - [ ] /reportlist
    - [ ] /reportadmin
- [ ] Admin
    - [ ] admin ui
    - [ ] direct ban
    - [ ] send report to all op's
- [ ] Missing Features
    - [ ] multilang
    - [x] config file
    - [x] customization
        - [x] prefix
        - [ ] messages
    - [ ] version checker
    - [ ] and more ;)
- [x] API for other plugins

## For plugin devs
`Report::getInstance()->getReportList();`
<br>returns array of all reports

`Report::getInstance()->saveReport($reportname, $reporter, $playername, $desc, $notizen)`
<br>save another report

## Where can i download ReportSystem?
### Download phar
You can download latest phar at [poggit](https://poggit.pmmp.io/ci/HonorGamerHD/ReportSystem/ReportSystem)

### Download zip
You can download this plugin as zip and run this as folder plugin(needs [Devtools](https://poggit.pmmp.io/p/DevTools/1.13.4))

### Clone repo into local repo
You can clone this plugin into your IDE(needs [Git](https://git-scm.com/))

## Help me to add more features!
create an new pull request and help me to develop this reportsystem!

## Collaborators
- [HonorGamerHD aka ImNotYourDev](https://github.com/honorgamerhd)