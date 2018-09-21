
Deploying Roots Bedrock via GIT on Shared Hosting Spaces that have SSH enabled.
----------------------------------------------------------------------------------------

###### Keys
`Package` = This Deployment Configuration Folder
`Project` = Project to be deployed

###### Pre-requisites
1. Bedrock project >= 1.3.0
2. Shared hosting server with:
	* FTP access
	* SSH access
	* PHP >= 5.6
	* MySQL Database and access to PHPMyAdmin
	* Apache (Not sure about NGINX, maybe someone could help?)
3. Bitbucket account (It's free)

*This package assumes that all assets coming from bower and npm are pre built and compiled into a dist folder inside of your theme. The .gitignore inside of web/app/themes/theme in `Package` includes `bower_components` and `node_modules`. `Assets` is not included as I feel it is safer including assets in the build incase they were to be accidently misplaced along the line. Obviously you can customise the `.gitignore` to how you like. Best not to include bower and npm modules however.*

<br>
---

### Deploying site to production

#### 1. Project init

1. Copy the `.htaccess` file from the root directory of `Package` to the
   bottom level directory of `Project`.

	(*The .htaccess file will set the root to /web/ but the path will need to be updated
	relative to the server it's deployed on. Use `phpInfo();` to find relative server path.*)

2. Set the server path in the bottom level `.htaccess` file.

3. Backup `Project` `.env` file and alter it to fit the live server config.
	I like to rename it to `.env-local` and then duplicate it, replacing the
	variables to fit the live site. We'll come back to this later.

4. Copy `.gitignore` from the root directory of `Package` to the
   bottom level directory of `Project`.

5. Navigate to web/ in `Package` and copy `.htaccess`to `Project` /web directory.

6. Navigate to web/app/themes/theme in `Package` & copy `.gitignore`into `Project` /web/app/themes/THEME directory.


#### 2. Push to Bitbucket repo with GIT

1. In the terminal, navigate to the `Project` root.

2. Login into BitBucket and setup a new repo. Select '*I have an existing project*'.

3. Copy the `git remote add origin https://repo@bitbucket.org/repo/test.git`
	from bitbucket and paste it into the terminal.

4. Add all files to the repo with `git add -A`.

5. Commit all files with `git commit -m 'First commit!'`

6. Push to the repo with `git push -u origin master`


#### 3. SSH into live server pull from Bitbucket repo

7. In a new terminal tab, ssh into the live server with:

	`ssh -p $port $username@$host`

	*Enter password when prompted*

8. Navigate into project root, usually `public_html`.

	***Note: This directory must be completely empty including all hidden files.***

9. Initialise directory to use GIT with `git init`.

10. Link the directory with the BitBucket repo using the same command we used locally:

	`git remote add origin https://repo@bitbucket.org/repo/test.git`

11. Pull from the repo with `git pull origin master`.

12. After the pull is successful, run `composer install` to build the application.

13. Done, no need to run `npm`, `bower` or `gulp` as the build was already set up locally.

---

### Post-Deploy Config

14. To avoid the repetitive task of replacing enviroment variables on each push,
use GIT to set the `.env` file and `.htaccess` file to untracked. This will
stop git from pushing and pulling the files in the future.

	`git update-index --assume-unchanged .env`
	`git update-index --assume-unchanged .htaccess`

	To undo this:

	`git update-index --no-assume-unchanged .env`
	`git update-index --no-assume-unchanged .htaccess`

15. Because wordpress stores and alters files dynamically on the server,
	do not assume that the files will stay the same. Make sure when working
	on the site locally that the local site is updated with the live site.
	SSH into the live site, navigate to the root and run:

	`git add -A`
	`git commit -m 'Client Changes'`
	`git push -u origin master`


	Then locally:

	`git pull origin master`




16. When updating the site locally and pushing to Bitbucket, to complete
	the push, a pull from the origin will have to happen on the server via SSH.