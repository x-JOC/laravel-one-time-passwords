---
title: Introducing one-time-passwords
weight: 1
---

Using this package, you can securely create and consume one-time passwords. By default, a one-time password is a number
of six digits long.

The package provides easy-to-use methods to build the one-time password login flow you want. It also provides a Livewire
component to allow users to login using a one-time password.

The package tries to make one-time passwords as secure as can be by:

- letting them expire in a short timeframe (2 minutes by default)
- only allowing to consume a one-time password on the same IP and user agent as it was generated
- time boxing the login attempt

