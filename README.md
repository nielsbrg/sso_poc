# Single sign on example with PHP 5.6

This example implementation will demonstrate the following concepts: 

- What an SSO database might look like
- A way to migrate users from various service provider databases to an SSO user database.
- The flow of a single sign on system
- A way to deal with multi domain session cookies
- An implementation of the federated identity pattern
- REST API authentication using one-time JSON Web Tokens

In this example there is one identity provider (sso_idp) and two service providers (sp1 and sp2). 
The service providers each have their own database with users. This example does not deal with multiple methods of authentication.