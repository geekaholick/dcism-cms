# IT-01
The project ticket utilizes **axios**, **passport**, **mysql** and **vuex**. Where axios calls **AuthController.php**. **AuthController.php** then gets the user data from the database if the credentials sent by **axios** is correct and creates a token using passport and returns it to **axios**. **Axios** then puts the recieved user data's _role_id_, _access_token_ and _token_type_ to the local storage and a **vuex** store called **user**. I also created a **logout** feature that logs out a user thru **axios** and **AuthController.php** that deletes the localStorage's _access_token_ and _token_type_ and the access tokens in the database

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

# IT-02
The project ticket utilizes the "Forgot Password" feature that utilizes **axios**, **mysql** and **mailable**. Where axios calls **AuthController.php** where the funtions for sending a recovery email and updating the password are located. **AuthController.php** then gets the inputted email and checks the database if the email sent by **axios** is correct and then creates a token, then this creates an instance to be saved in _password_resets_ table (saves email and token) to document the attempt and then proceeds to send an automated email with an unique link (the unique link is created by utilizing the token) using **mailable** from laravel which then returns the token to be saved in local storage. After recieving the automated email, the user then clicks the link which will send him/her to a page form to create a password. After sending the new password to **AuthController.php** using **axios** the function in **AuthController.php** will then find the _password_reset_ instance using the token saved and if finds it successfully it will return the instance as an object and then finds the user in _users_ table using the email from the instance and if it finds it successfully it will then change the _user_password_ with the inputted password and if all run successfully it will return a 200 status message which the sender recieves and redirects to the log in page whilst deleting the _reset_password_token_. If some or all fails, it will send a 401 status message which **axios** will read it as an error.

## Database
- I addded _password_resets_ table to record instances which a user attempts to change his password using the **Forgot Password** feature
- This table can also be used for other purposes depending on the programmer

## ForgotPassword.vue
- Created a **sendRecovery()** method that recieves an input email from the user and sends it to **AuthController.php**, then recieves a token which saves it in the local storage and gives out an alert if the process was done successfully or has failed

## ResetPassword.vue
- Created a **changePassword()** method that recieves an inputted password and confirm password from the user and sends it to **AuthController.php** thru **axios**, then recieves a message. If the message returned is successful it will delete the _reset_password_token_ at the local storage and redirects back to the log in page 

## AuthController.php
- Created a public function called _send_token()_ that recieves an email send from **axios** which checks if such user exists basing from that email, it sends an error if fails to find, else it creates an automated email that will be sent to the user and creates an instance containing the email and a generated token and will be saved in _reset_passwords_ and returns a 200 status mesasge and the generated token if everything works out
- Created another public function called _resetPassword()_ that recieves the password, c_password and token from **axios** which checks if password match with c_password and then searches the _reset_passwords_ table using the token recieved from **axios** and if it finds the instance and finds the user using the email from the instance and if it successfully finds it then the received password will replace the data's user_password and returns a 200 status message if everything went succesfully.

## License

None