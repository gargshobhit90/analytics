# Analytics Engine for hypothetical chatbot

## Goal
Analyze the number of users and their behavior for an imaginary chatbot application

## How to run code
Host the code on a webserver (or localhost!) and run index.html

## Tasks
* Task 1. Build a table that simulates chat bot user behavior
* Task 2. Build frontend framework that queries above table and build Analytics Dashboard. 

### Task 1: Build the table
* Refer to generateData.py
* Used python to populate table
* Over a 6-month period, 50K users use chatbots over various platforms performing anywhere between 1-100 actions a day.

### Task 2: Build the analytics dashboard
* Show user traffic statistics
* Make a sentiment graph comparing actual user actions with expected actions

## Steps

### Steps for task 1
* Write to a MySQL db from the python generateData.py code

### Steps for task 2
* Build frontend using bootstrap
* Use chartJS as graphing library
* Use PHP and AJAX to query the MySQL database created in task 1
