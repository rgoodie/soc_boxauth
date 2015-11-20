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


# Disclaimer 
This is as-is code. I'm doing my best, but I wouldn't use this on production servers just yet. I welcome pull requests, suggestions, patches, issues through github. I'm building this as part of a larger project at work. I'll push code as I have the chance to work on this project. But, we warned, it's not as polished as it could be. **Use at your own risk.**
