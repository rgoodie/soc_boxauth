Soc Boxauth
===========

A Drupal 7 module that helps with Box API Oauth. This will help get your user over to the Box.com login form,
complete OAuth2, and store the access_token to $_SESSION['box']['access_token']


# To use
- Install the module as normal and enable
- Configure YOURSERVER/admin/config/system/box-auth by adding your client_id, client_secret, redirect_url, and success/failure text (for the user).
- Set permissions
- Try it out at do/box/auth

If successful, the access_token will be saved to `$_SESSION['box']['access_token']`. From there you can build any Box
functionality that that access token allows.