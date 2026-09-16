# Pantry
A web app allowing for interactive, dynamic item list management. made specifically for grocery lists, but can be useful for other stuff as well

## stack
- front end: javascript, html, css
- back end: php
- database: mysql/innodb
- deployment: azure container app (two containers + azure file share) [Test it out](https://pantry.bravebeach-9e5b86d4.polandcentral.azurecontainerapps.io/index.php)

## shortcomings to fix
- item entry experience is lacking
- gui does not scale well with small screens
- the gui is kind of bad in general
- no options for modifying your account after registering
- the security is bad - this is definitely subject for upgrades. *if youre gonna try using this on any server (my deployment or your own) just make up a random email and name just in case. nothing is gonna be sent to your mailbox anyway, but having your email out there isnt fun*
- the usage of azure in general. you could probably selfhost this on a local but i dont have time for this rn
- ran out of time for my AI assistant gag :pensive: (50 predefined javascript strings that are chosen randomly and just say stuff like "i dont know" "have you tried thinking about it?" "i'm sure some guy on reddit had that exact problem 10 years ago". hilarious, i know)

## future plans
- do the thing where you can selfhost it with docker or just run as a local webpage on your machine
- react/angular rewrite because
- fix the security thing (duh)
- just general improvements
