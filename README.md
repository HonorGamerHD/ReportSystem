# ReportSystem
simple and clean reportsystem with UI's for everyone!
this plugin use [dktapps](https://github.com/dktapps) great [pmforms](https://github.com/dktapps-pm-pl/pmforms) API library

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

## Help me to add more features!
create an new pull request and help me to develop this reportsystem!

## Collaborators
- [HonorGamerHD aka ImNotYourDev](https://github.com/honorgamerhd)