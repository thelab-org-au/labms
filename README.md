## Set up dev environment:

### Install docker:

https://docs.docker.com/installation/

On Mac you need to install virtualbox and boot2docker also, then run `boot2docker up` and follow the instructions it gives you.

### Set up the docker container:

```bash
docker run -i -t -p "80:80" -p "3306:3306" -v ${PWD}:/app -v ${PWD}/application/cache/mysql:/var/lib/mysql --name labms -e CREATE_MYSQL_BASIC_USER_AND_DB="true" -e CI_ENV="development" dgraziotin/lamp
```

If this works you should see output to the effect that mysqld and apache httpd are running. Press `ctrl-c` to exit - wait for everything to clean up.

Now you can `docker start labms` and `docker stop labms`.

Run `docker start labms` to bring the environment up again. This time it should be pretty quick.

### Set up the database:

Run the migrations to create the development database:

`CI_ENV=development php index.php migrate`
