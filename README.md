### Stack

- Backend (PHP 7.1, Symfony 4 + Flex)

  - Doctrine ORM
  - Form
  - PHP CodeSniffer (dev dependency)
  - Security
  - Twig
  - Validator
  - Webpack Encore
  - Web-server (dev dependency to handle URLs containing dots, e.g.: "/path/with.dot")

- Frontend (VueJS 2.6)

  - Bootstrap 4
  - Router

### Notes

Each newly registered user has to be manually "approved" by executing the following SQL query:

```sql
UPDATE user SET approved = TRUE WHERE id = :id
```

after which a user may login.

There **is**:

  - "register"
  - "login"
  - "logout"
  - cookie-based "remember me"

There is **no**:

  - "forgot password"
  - "send email"
