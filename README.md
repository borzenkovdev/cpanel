<h2>Application which realize interface for contorl panel</h2>

## Install

**database**

```
1.modify config/db.php for connect to mysql
2.create database 'weblab' by weblab.sql

```

## Usage

```
These are common commands used in various situations:
   add              Add new actions to buttons - Typical usage: 'php index.php add position/perform_on/perform_off/programClass'
   printCommands    Show all buttons bindings - Typical usage: 'php index.php printCommands'
   undo             Revert previous action - Typical usage: 'php index.php undo 3 (its revert last three operations, max 8)'
   performOn        Manual executing On action of programm - Typical usage: 'php index.php performOn n (where n = position of button row )'
   performOff       Manual executing Off some action of programm - Typical usage: 'php index.php performOff n (where n = position of button row )'

```
## Apllication structure

```
config
 - db.php   - config for connect 
core -  folder for core classs of app
 - Application.php   -  main class
 - ControlPanel.php   -  class for control of panel
 - Db.php   -  database class
programs - folder for programs, which binding to buttons
 - Door.php 
 - Garage.php 
 - Jalouse.php 
 ...
  - Macros.php  - class, which can bind many actions to one button
Autoloader.php - class for autoload classes
index.php - it is main script, point of entry
weblab.sql - database, its required for script
 
```
## Compatibility
```
PHP 5.4 + with PDO extension
```

## How to add new progrram to Cpanel

```
Just add new class to programm folder with tho methods for on action and for off action
```


