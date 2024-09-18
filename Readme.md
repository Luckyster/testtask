# Some Test Task
Creds: Wordpress / Wordpress
## Interesting pathes for you:
- /wp-content/themes/testtask/includes/shortcodes.php - shortcodes logic + filters handler logic
- /wp-content/themes/testtask/src/js/filters.js - js for filters
### Sortcodes examples:
- [albums count="10"]
- [albums_with_singles]
### Run the project
1. Copy the `wp-content` folder to a new WordPress setup.
2. Import the SQL file via phpMyAdmin.
3. Run the following SQL query to update the domain:
```sql
UPDATE wp_options SET option_value = replace(option_value, 'http://localhost:10003', 'YOUR NEW DOMAIN') WHERE option_name = 'home' OR option_name = 'siteurl';

UPDATE wp_posts SET guid = replace(guid, 'http://localhost:10003','YOUR NEW DOMAIN');

UPDATE wp_posts SET post_content = replace(post_content, 'http://localhost:10003', 'YOUR NEW DOMAIN');

UPDATE wp_postmeta SET meta_value = replace(meta_value,'http://localhost:10003','YOUR NEW DOMAIN');
```
That's all. If you want to compile JS and SCSS, follow these steps:

4. To compile the theme, navigate to the theme folder and run:
    ```bash
    npm install
    ```
   (Preferred Node.js version: 12 LTS). If you don’t have Gulp installed, run:
    ```bash
    npm install -g gulp
    ```

5. Use the following commands to compile:
    - For SCSS watching:
      ```bash
      gulp
      ```
    - For a production build:
      ```bash
      gulp --production
      ```
