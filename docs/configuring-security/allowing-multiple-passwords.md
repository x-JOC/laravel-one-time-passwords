---
title: Allowing multiple passwords
weight: 4
---

By default, when a one-time password is created for a user, all old one-time passwords for that user will be deleted. This is to ensure that the user can only use one password at a time.

However, in some cases, you may want to allow multiple passwords. This can be done by setting the `allow_multiple_passwords` option to `true` in the `one-time-passwords` file.

When this is `true`, old one-time passwords will not be deleted when a new one is created.
