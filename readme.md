# SnappShop Interview Project

to run this project and tests, make sure you have docker and docker-compose installed and running:
run `dcoker -v`

## Run Tests

to run tests, just run `make test` and wait till the end.

## Run Project

to run project, run `make up` and wail till the end.

project will be run on port 8080 your localhost. Also, a PhpMyAdmin dashboard will be run on port 8888 and ou can check
database entities.

There are 3 endpoints.

first: `/api/user/token` make a post request with following body to obtain token:

```
{
"email": "iamalibabaei@gmail.com",
"password": "password"
}
```

use token on Bearer Authorization header to be authorized.

second: `/api/transfer` make a post request to transfer money between source and destination cards with these params:

```
{
"source_card_number": "6037997551458913",   
"destination_card_number": "6037998199813964",
"amount": 10000 
}
```

if you try to use invalid amount or invalid card numbers or other people's card, or you don't have enough money, an
error will occur.

if you want to get SMS for your transaction, set your phone_number on `DatabaseSeeder.php`. also set `SMS_DRIVER`
on `.env` file to ghasedak or kavenegar and set appropriate sender number and API KEY.

third: `/api/users/most` make a get request to this endpoint, and you will get three users with most transaction in last
10 minutes with their 10 most recent transactions in user id order.

## Assumptions
- For sake of simplicity, users may have duplicated phone numbers.
- Every amount in project is in Rials.
- For making transactions, you should have transaction amount + transaction fee at the moment.
- For purpose of this project, I use database as queue provider. In production env, alternative solution might be better.
Also I forgot to mention that to avoid repeated transactions that happen because of network problems or user requesting for many times or ..., We should introduce a unique key for transaction for example an uuid that client sends and check even request is duplicated or not but this is not implemented but it is so easy.

---

To add new Sms Driver, Write a class that implements `SmsInterface` and provide instance on `getDriverInstance` method of class `SmsChannel.php`.
To change Sms message, Change message in `fa/messages.php`.
