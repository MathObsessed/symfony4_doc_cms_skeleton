### Authentication

- [x] if the user tries to access "/" without being authenticated, we should redirect him to "/login"
- [x] if the user is authenticated and tries to access "/login", we should redirect him to "/"
- [ ] if an Ajax call returns a 403 HTTP code, we should redirect the user to "/login"
- [x] if the user refreshes the page and is already authenticated, we should **not** redirect him to "/login"
- [x] authentication attempt for non-existing user shows 'Invalid credentials' error message
- [x] authentication attempt with invalid password shows 'Invalid credentials' error message
- [x] authentication attempt for existing non-approved user shows 'Account requires approval' error message
- [x] authentication attempt for existing approved user with correct password succeeds
- [x] if there is an error message on the login form and you click "register" - there is no error message on the registration form

### Registration

- [x] if the user is authenticated and tries to access "/register", we should redirect him to "/"
- [x] registration attempt with taken email shows 'Email is taken' error message
- [x] successful registration results in non-approved account created and a redirect to "/login"
- [x] if there is an error message on the registration form and you click "go back" - there is no error message on the login form
