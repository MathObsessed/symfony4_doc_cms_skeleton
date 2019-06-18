### Authentication

- [x] if the user tries to access "/" without being authenticated, we should redirect him to "/login"
- [x] if the user is authenticated and tries to access "/login", we should redirect him to "/"
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

### Navigation bar

- [x] home icon leads to "/"
- [x] documents list is being loaded from the server
- [x] when the user selects a document it gets removed from the list and becomes "selected"
- [x] selected document is "remembered" on page reload
- [x] "logout" button logs the user out and redirects to "/login"

### Document view

- [x] when there is no selected document show "Select a document to show" message
- [x] when there is selected document show "{DOCUMENT_NAME}"
