# reMedia's custom modules for ActiveCollab
by Francesco Rosso for reMedia.it
## About
These repository is mantained by Francesco R. and these modules have been written as an internship project. The company wanted to customize its [ActiveCollab](https://www.activecollab.com/) installation.

## Installation
These modules are compatible with ActiveCollab > 3.2.0.

Copy them in the /custom folder of your AC3 installation.

# Milestone Task Assignee
**location:** modules/frosso_milestone_task_assignee

## About this module
This is the first custom module I wrote, it overwrites the "Tasks" tab in the Milestone view, adding:

* who the task is assigned to
* when the task has been updated

## Screenshot
![alt text](http://i.imgur.com/Inp4c.png "Milestone Task Assignee module screenshot")

# Frosso Authentication
**location:** 

* modules/frosso_authentication
* auth_providers/FrossoProvider.class.php

## About this module
This module is written to provide a Single Sign-On authentication. It doesn't work by itself. Configuration and embedding are required.

## How it works
You need to embed a page in an `<iframe>` in your system.

You have to send throu GET method a parameter called `params` to this page. `Params` contains the following informations:

* **email:** the email of the user you want to authenticate
* **password:** a password, shared by the page that embeds the `<iframe>` and the AC installation
* **timestamp**: the current timestamp, obtained in PHP throu the `time()` function

Everything is then assembled in a single string divided by ';', as it follows:
`email@domain.com;password;timestamp`

To provide a little bit of security, the following string is then encrypted with a public key, that is associated to your AC installation (you need to generate your own, I did it with [this PHP class](http://phpseclib.sourceforge.net/)).

You need then to encode the crypted string with the `urlencode()` PHP function.

The module I wrote will:

* decode the `params` string
* verify if the password is valid
* verify that the timestamp has been generated +- 10 minutes ago
* authenticate the user associated with the email provided

## Configuration

In your Administration page, you will find a new icon in the 'Others' section, called 'SSO Settings'. There, you will be able to set all the configuration needed by the module.

You will also find the url needed, the one you need to provide the `params` string throu GET method.

# Milestone ETA
**location:** * modules/frosso_estimated_cost

## About this module
This module adds the following features to the Milestone class:

* adds a custom field throu the AC3.2 custom field API.
* adds the time estimate to a milestone

You will also have a new report in the reports section and a new section one the side of the project page.

## How it works
As said before, this module uses the AC3 custom_fields and tracking API to customize the Milestone class.

ActiveCollab3 allows you to see the % completion of a milestone. This information is based on the number of tasks completed and the total number of tasks in that milestone. This is a wrong information. 

For example, you can have a shitton of little tasks that have already been completed, and a couple of large tasks that needs to be completed. ActiveCollab will say that you are on a good way to finish your milestone, without taking care of the obesity of the other tasks. 

Also, when you're creating a new milestone, if you have a large number of tasks, you should set for each task the time estimate. This is a lot of work to do.

Assuming that you're using the tracking module provided by ActiveCollab, this module could help you a little bit.

It will add to a Milestone a custom field, called "Percent value". The Milestone's assignee or the Project Manager can edit this field, setting a value between 0 or 100.

Also, you can see the sum of the tasks' estimates in a single milestone. Or, if you don't want to set all the estimates, you can overwrite this value with your own estimate. This value will be attributed to the Milestone. If you want to revert to the sum of the tasks estimates, you have to set the value to `0`.

With these values provided, this module will calculate how much it takes to complete the milestone. This information is based on the 'Percent complete' value described above and on the number of hours tracked in that milestone.

For example, if the 'Percent complete' value is set to 50% and you have logged one hour of time, this module will say that you presumably have to work another hour (so it takes 2 hours total) to complete this Milestone.

## Screenshots

![alt text](http://i.imgur.com/lmMOJ.png "Report screenshot")

# Gantt project
**location:** modules/frosso_gantt_chart

## About this module
This module uses [dhtmlx Gantt chart](http://dhtmlx.com/docs/products/dhtmlxGantt/index.shtml) to generate a Gantt Chart of your project.

You need to enable the tab 'Frosso GanttChart' from Administration > Project Settings.

This module has been deprecated because it's rendering slowliness and lack of clarity.

# Project Tab
**location:** modules/frosso_project_tab

## About this module
This is the second module I aver wrote. It's now deprecated, it's more a test than anything else.

This let you see all the active tasks grouped by milestones in a project, and let you sort these tasks by various parameters.

It was useful for my colleagues because you can save in your bookmarks the type of sorting you used and let you see the tasks at first glance.


# Tasks Tab Mod
**location:** modules/frosso_tasks_tab_mod

## About this module
My colleagues wanted a more rich overwiew in the tasks tab, so I added more filters and informations to it!

At first glance, you will see:

* task responsible
* if the tracked time is > of the estimate
* the task priority
* if the task has attachments

Also, it lets you filter tasks by:

* label
* attachments

This module is also compatible with TasksPlus!

## Screenshots
![alt text](http://i.imgur.com/ByPw6.png "Tasks Tab Mod screenshot")


# Tasks Tab Mod
**location:** modules/testing_environment_frosso

## About this module
Nothing to see here, move on!
