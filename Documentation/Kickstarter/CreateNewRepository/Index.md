# Create a new repository

If you want to use the kickstarter to create a new project, you can use the "Use this template" button on github.com:

![Use the template](../Resources/use_template.png "Button who shows \"Use the template\"")

Create a new repository with all kickstarter files as initial commit.
After that, delete the following files because they are not used in a real customer project:

- setup-db.sql.gz
- Documentation/Kickstarter

Then adapt the following files for your real project values (WARNING: these are just hints and may be an incomplete list):

- .ddev/config.yaml
- Build/config/deployer/hosts.yaml
- config/sites/kickstarter
- packages/lf-site
    - search and replace for "lf-site", "lf_site", "LfSite" and "kickstarter"
- Build/assets.config.json
- Documentation/_Template/README.md
  - Move this file to the repository root folder and replace the existing README.md
  - Adapt the new README.md file with your real project values
  - Remove the directory Documentation/_Template
