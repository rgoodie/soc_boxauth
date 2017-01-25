#soc Box Group
Drupal 7 module to sync user list between a box folder and an organic group. Depends on the parent module in this same repo. 

# How this module workds (kinda important)
Ensure that you have a Content Type already created (how about call it "Group") and that it is marked as an Organic Group. This is very important. When enabled, this module creates a field called `soc_boxgroup_folder` on any Content Type marked as an Organic Group (see `function soc_boxgroup_enable()` in [soc_boxgroup.install](soc_boxgroup.install). The remaining functionality of this module on this field. You can always add it later of course, but again, this field is important. 

# To install 
1. [Install parent module](../README.md) and get comfortable with it. 
2. Create a new group. Make sure you see a text field waiting for a Box Folder ID. 





# Depends on 
- [og](https://drupal.org/project/og)
- [og_ui](https://drupal.org/project/og_ui)
- soc_boxauth
