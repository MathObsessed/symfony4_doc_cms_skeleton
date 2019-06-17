### Auth

- [x] if the user tries to access "/" without being authenticated, we should redirect him to "/login"
- [x] if the user is authenticated and tries to access the "/login", we should redirect him to "/"
- [ ] if an Ajax call returns a 403 HTTP code, we should redirect the user to "/login"
- [x] if the user refreshes the page and is already authenticated, we should **not** redirect him to "/login"
- [x] authentication attempt for non-existing user shows 'Invalid credentials' error message
- [x] authentication attempt with invalid password shows 'Invalid credentials' error message
- [x] authentication attempt for existing non-approved user shows 'Account requires approval' error message
- [x] authentication attempt for existing approved user with correct password succeeds
