### Stack

- Backend (PHP, Symfony 4 + Flex)

  - Doctrine ORM
  - Form
  - Security
  - Twig
  - Validator
  - Webpack Encore
  - Web-server (dev dependency to handle URLs containing dots, e.g.: "/path/with.dot")

- Frontend (VueJS)

  - Bootstrap
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
  - and cookie-based "remember me"

functional implemented.

There is **no**:

  - "forgot password"
  - "send email"
  - etc

functional implemented.
