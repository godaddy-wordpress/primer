Primer has contains many built-in actions and filters that allow you to fine-tune the behavior of the theme.

**You should never edit theme files directly**, otherwise your customizations will be lost when the theme receives updates.

For that reason, it is important that code-level customizations to Primer (and/or its child themes) be done inside a [must-use plugin](https://codex.wordpress.org/Must_Use_Plugins).

> Must-use plugins (MU Plugins) are installed in a special directory inside the `wp-content` directory and are automatically activated on your WordPress site. Must-use plugins do not show in the default list of "Active" on the Plugins page of the WordPress Dashboard, and they can only be deactivated by removing the plugin file from the `mu-plugins` directory.

## How to create a must-use plugin

1. Use SFTP or SSH to access the filesystem of your WordPress install.
2. Inside the `wp-content` directory of your WordPress install, create a new directory named: `mu-plugins`
3. [Set the file permissions](https://codex.wordpress.org/Changing_File_Permissions) on `mu-plugins` to `0755`.
4. Inside the `mu-plugins` directory, create a new file named: `my-customizations.php`
5. Save a new file on your computer named `my-customizations.php` and open it in favorite code editor.
6. Place all the necessary PHP code for your hooks into the file and save it.
7. Upload the `my-customizations.php` to your web server inside the newly-created `wp-content/mu-plugins` directory.
8. Set the file permissions on `my-customizations.php` to `0644`.

### Example

```php
<?php
/**
 * Plugin Name: My Customizations
 * Description: Theme customizations and overrides.
 * Author: Your Name
 */

// Turn off the author credit in the site footer
add_filter( 'primer_author_credit', '__return_false' );
```

In the example above, we added a filter for [`primer_author_credit`](https://github.com/godaddy/wp-primer-theme/blob/f32e224ec0b67371be20db9a6ea94f1c99d92d9c/templates/parts/credit.php#L20-L27) (which returns `true` by default) to now return a value of `false`, thus removing the credit from the site footer.

In your WordPress Dashboard, navigate to **Plugins > Must-Use** and you will see your new plugin listed here. Notice that you cannot Deactivate or Delete a must-use plugin. Your plugin will be automatically loaded with WordPress _before_ themes or plugins are loaded, and will not be affected by other plugin, theme, or core updates.

![Must-Use Plugins UI](https://www.evernote.com/l/AAJCCEIURdNMgo-UJXWW2dRHpuM5o-HdyYkB/image.png)
