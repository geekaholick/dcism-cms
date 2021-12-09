# IT-01
The project ticket utilizes **axios**, **passport** and **vuex**. Where axios calls **AuthController.php**. **AuthController.php** then gets the user data from the database if the credentials sent by **axios** is correct and creates a token using passport and returns it to **axios**. **Axios** then puts the recieved user data's _role_id_, _access_token_ and _token_type_ to the local storage and a **vuex** store called **user**. I also created a **logout** feature that logs out a user thru **axios** and **AuthController.php** that deletes the localStorage's _access_token_ and _token_type_ and the access tokens in the database

## Database
- I addded _oauth_ related tables since it is required by **Passport**

## Login.vue

- Created a **login()** method that recieves the user's inputted credentials and uses an **axios** request post to call and send the credentials to **AuthController.php**
- Created **axios** post and get requests that receives the user data from the database, set a localStorage variable for _access_token_ and _token_type_ and save it in a **vuex** store
- Created a toastification as an alert to inform the user if he/she inputted the wrong credentials, logged out or successfully logged in

## Navbar.vue

- Created a **logout()** method that uses an **axios** get request calls the **AuthController.php** that removes the _access_token_ of the logged in user
- The same **axios** get request that removes the _access_token_ and _token_type_ from the localStorage

## AuthController.php 
- Created a controller php that accepts the requests coming from **axios** that checks the database for the user if credentials it accepted are correct and creates an _access_token_ that will be saved in **oauth_access_tokens** table and returns the _access_token_, _token_type_ and an expiry date **_(Login Function)_**, it also accepts an **axios** request that returns the user's credentials **_(User Function)_** and it accepts an **axios** request that removes the _access_token_ of the logged in user from the database **_(Logout Function)_**
- Also created a **_(Register Function)_** to test the other functions with a registered and hashed user. Comment it out if you need it
- 
## License

None